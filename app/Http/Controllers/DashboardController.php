<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Chore;
use App\Models\Junior;
use App\Models\Schedule;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role_id === 2) {
            $user = auth()->user();
            $junior = Junior::where('name', $user->name)->first();

            $todayAssignments = collect();

            if ($junior) {
                $today = Carbon::now()->toDateString();

                $todayAssignments = Assignment::where('junior_id', $junior->id)
                    ->whereHas('schedule', function ($query) use ($today) {
                        $query->where('schedule_date', $today);
                    })
                    ->with(['chore', 'schedule', 'junior'])
                    ->get();
            }

            return view('junior.dashboard', compact('todayAssignments', 'junior'));
        }

        $currentWeek = Carbon::now()->startOfWeek();

        Assignment::whereHas('schedule', function ($query) use ($currentWeek) {
            $query->where('schedule_date', '<', $currentWeek->toDateString());
        })->delete();

        Schedule::where('schedule_date', '<', $currentWeek->toDateString())->delete();

        $weekHasAssignments = Assignment::whereHas('schedule', function ($query) use ($currentWeek) {
            $query->whereBetween('schedule_date', [$currentWeek->toDateString(), $currentWeek->copy()->endOfWeek()->toDateString()]);
        })->exists();

        if (! $weekHasAssignments) {
            $this->generateWeeklySchedule($currentWeek, 1);
        } else {
            Assignment::whereHas('schedule', function ($query) use ($currentWeek) {
                $query->whereBetween('schedule_date', [$currentWeek->toDateString(), $currentWeek->copy()->endOfWeek()->toDateString()]);
            })
                ->where('week', '!=', 1)
                ->update([
                    'week' => 1,
                ]);
            };

        $nextWeek = $currentWeek->copy()->addWeek();

        $nextWeekHasAssignments = Assignment::whereHas('schedule', function ($query) use ($nextWeek) {
            $query->whereBetween('schedule_date', [$nextWeek->toDateString(), $nextWeek->copy()->endOfWeek()->toDateString()]);
        })->exists();

        if (! $nextWeekHasAssignments) {
            $this->generateWeeklySchedule($nextWeek, 2);
        }

        $today = Carbon::now()->toDateString();
        $todayAssignments = Assignment::whereHas('schedule', function ($query) use ($today) {
            $query->where('schedule_date', $today);
        })
            ->with(['chore', 'schedule', 'junior'])
            ->get();

        return view('admin.dashboard', compact('todayAssignments'));
    }

    public function generateWeeklySchedule(Carbon|string $weekStartDate, int $week): void
    {
        $weekStart = $weekStartDate instanceof Carbon ? $weekStartDate : Carbon::parse($weekStartDate);
        $weekStart = $weekStart->copy()->startOfWeek();

        $juniors = Junior::where('status', 'Active')->orderBy('name')->get();
        $chores = Chore::where('is_operational', 1)->orderBy('id')->get();

        for ($dayOffset = 0; $dayOffset < 5; $dayOffset++) {
            $scheduleDate = $weekStart->copy()->addDays($dayOffset);
            $schedule = Schedule::firstOrCreate([
                'schedule_date' => $scheduleDate->toDateString(),
                'day' => $scheduleDate->translatedFormat('l'),
            ]);

            if ($schedule->assignments()->exists()) {
                continue;
            }

            $assignedJuniorIds = [];
            $weekAssignments = Assignment::where('week', $week)
                ->with('junior')
                ->get();

            foreach ($chores as $chore) {
                $availableJuniors = $juniors->filter(function ($junior) use ($assignedJuniorIds, $weekAssignments, $chore) {
                    if (in_array($junior->id, $assignedJuniorIds, true)) {
                        return false;
                    }

                    $alreadyAssignedForThisChoreThisWeek = $weekAssignments->contains(function ($assignment) use ($junior, $chore) {
                        return $assignment->junior_id === $junior->id && $assignment->chore_id === $chore->id;
                    });

                    return ! $alreadyAssignedForThisChoreThisWeek;
                });

                if ($availableJuniors->isEmpty()) {
                    $availableJuniors = $juniors->filter(fn ($junior) => ! in_array($junior->id, $assignedJuniorIds, true));
                }

                if ($availableJuniors->isEmpty()) {
                    continue;
                }

                $chosenJunior = $availableJuniors->random();

                Assignment::create([
                    'schedule_id' => $schedule->id,
                    'junior_id' => $chosenJunior->id,
                    'chore_id' => $chore->id,
                    'week' => $week,
                    'status' => 0,
                ]);

                $assignedJuniorIds[] = $chosenJunior->id;
            }
        }
    }
}
