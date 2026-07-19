<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Chore;
use App\Models\Junior;
use App\Models\Schedule;
use Illuminate\Support\Carbon;

class AssignmentController extends Controller
{
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

    public function index()
    {
        if (auth()->user()->role_id === 2) {
            $assignments = Assignment::with(['schedule', 'junior', 'chore'])
                ->orderBy('week')
                ->orderBy('schedule_id')
                ->orderBy('chore_id')
                ->get();

            $weeklyAssignments = $assignments->groupBy('week');

            return view('master', compact(
                'assignments',
                'weeklyAssignments',
            ));
        }

        $currentWeek = Carbon::now()->startOfWeek();

        $weekHasAssignments = Assignment::whereHas('schedule', function ($query) use ($currentWeek) {
            $query->whereBetween('schedule_date', [$currentWeek->toDateString(), $currentWeek->copy()->endOfWeek()->toDateString()]);
        })->exists();

        if (! $weekHasAssignments) {
            $this->generateWeeklySchedule($currentWeek, 1);
        } else {
            $weekHasAssignments = Assignment::whereHas('schedule', function ($query) use ($currentWeek) {
                $query->whereBetween('schedule_date', [$currentWeek->toDateString(), $currentWeek->copy()->endOfWeek()->toDateString()]);
            })->update([
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

        $assignments = Assignment::with(['schedule', 'junior', 'chore'])
            ->orderBy('week')
            ->orderBy('schedule_id')
            ->orderBy('chore_id')
            ->get();

        $weeklyAssignments = $assignments->groupBy('week');

        return view('master', compact('assignments', 'weeklyAssignments'));
    }

    public function shutter()
    {
        $openShutterChoreId = Chore::where('chore_name', 'Open Shutter')->value('id');
        $closeShutterChoreId = Chore::where('chore_name', 'Close Shutter')->value('id');
        $offDutyChoreId = Chore::where('chore_name', 'Off Duty')->value('id');

        $week1Open = Assignment::with('junior')
            ->where('chore_id', $openShutterChoreId)
            ->where('week', 1)
            ->get();

        $week2Open = Assignment::with('junior')
            ->where('chore_id', $openShutterChoreId)
            ->where('week', 2)
            ->get();

        $week3Open = Assignment::with('junior')
            ->where('chore_id', $openShutterChoreId)
            ->where('week', 3)
            ->get();

        $week4Open = Assignment::with('junior')
            ->where('chore_id', $openShutterChoreId)
            ->where('week', 4)
            ->get();

        $week1Close = Assignment::with('junior')
            ->where('chore_id', $closeShutterChoreId)
            ->where('week', 1)
            ->get();

        $week2Close = Assignment::with('junior')
            ->where('chore_id', $closeShutterChoreId)
            ->where('week', 2)
            ->get();

        $week3Close = Assignment::with('junior')
            ->where('chore_id', $closeShutterChoreId)
            ->where('week', 3)
            ->get();

        $week4Close = Assignment::with('junior')
            ->where('chore_id', $closeShutterChoreId)
            ->where('week', 4)
            ->get();

        return view('shutter', compact(
            'week1Open',
            'week2Open',
            'week1Close',
            'week2Close',
        ));
    }

    public function recital()
    {
        $recitalChoreId = Chore::where('chore_name', 'Yasin Recital')->value('id');

        $week1 = Assignment::with('junior')
            ->where('chore_id', $recitalChoreId)
            ->where('week', 1)
            ->get();

        $week2 = Assignment::with('junior')
            ->where('chore_id', $recitalChoreId)
            ->where('week', 2)
            ->get();

        $week3 = Assignment::with('junior')
            ->where('chore_id', $recitalChoreId)
            ->where('week', 3)
            ->get();

        $week4 = Assignment::with('junior')
            ->where('chore_id', $recitalChoreId)
            ->where('week', 4)
            ->get();

        return view('recital', compact(
            'week1',
            'week2',
        ));
    }

    public function rubbish()
    {
        $rubbishChoreId = Chore::where('chore_name', 'Throw Rubbish')->value('id');

        $week1 = Assignment::with('junior')
            ->where('chore_id', $rubbishChoreId)
            ->where('week', 1)
            ->get();

        $week2 = Assignment::with('junior')
            ->where('chore_id', $rubbishChoreId)
            ->where('week', 2)
            ->get();

        $week3 = Assignment::with('junior')
            ->where('chore_id', $rubbishChoreId)
            ->where('week', 3)
            ->get();

        $week4 = Assignment::with('junior')
            ->where('chore_id', $rubbishChoreId)
            ->where('week', 4)
            ->get();

        return view('rubbish', compact(
            'week1',
            'week2',
        ));
    }
}
