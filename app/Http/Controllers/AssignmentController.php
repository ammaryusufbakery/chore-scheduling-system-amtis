<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Chore;
use App\Models\Junior;
use App\Models\Schedule;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function generateAssignment($date, $week)
    {
        $juniors = Junior::where('status', 'Active')
            ->get();

        $chores = Chore::where('is_operational', 1)
            ->get();

        $schedules = Schedule::firstOrCreate([
            'schedule_date' => $date,
            'day' => $date //recheck
        ]);

        foreach ($chores as $chore) {
            // Find the intern who has done this specific task the LEAST number of times
            // and hasn't been assigned a task yet TODAY
            $chosenJunior = $juniors->sortBy(function ($junior) use ($chore) {
                return $junior->assignments()->where('chore_id', $chore->id)->count();
            })->first();

            Assignment::create([
                'schedule_id' => $schedules->id,
                'junior_id' => $chosenJunior->id,
                'chore_id' => $chore->id,
                'week' => $week
            ]);

            // Remove this intern from the daily pool so they don't get double-booked
            $juniors = $juniors->reject(fn($i) => $i->id === $chosenJunior->id);
        }

        // Anyone left over gets "Off-Duty" automatically
        $offDuty = Chore::where('is_operational', 0)->first();

        foreach ($juniors as $remainingJunior) {
            Assignment::create([
                'schedule_id' => $schedules->id,
                'junior_id' => $remainingJunior->id,
                'chore_id' => $offDuty->id,
                'week' => $week
            ]);
        }
    }

    public function index()
    {
        // $date = Schedule::orderByDesc('schedule_date')
        //     ->value('schedule_date');

        // $date = $date ? $date->nextWeekday():today()->startOfWeek();

        // for($week=1; $week<5; $week++){
        //     for($i=0; $i<5; $i++){
        //         $this->generateAssignment($date, $week);
        //         $date->nextWeekday();
        //     }
        // }

        return view('home', compact('assignments'));
    }

    public function shutter()
    {
        $week1Open = Assignment::with('junior')
            ->where('chore_id', 1)
            ->where('week', 1)
            ->get();
        
        $week2Open = Assignment::with('junior')
            ->where('chore_id', 1)
            ->where('week', 2)
            ->get();

        $week3Open = Assignment::with('junior')
            ->where('chore_id', 1)
            ->where('week', 3)
            ->get();

        $week4Open = Assignment::with('junior')
            ->where('chore_id', 1)
            ->where('week', 4)
            ->get();

        $week1Close = Assignment::with('junior')
            ->where('chore_id', 4)
            ->where('week', 1)
            ->get();
        
        $week2Close = Assignment::with('junior')
            ->where('chore_id', 4)
            ->where('week', 2)
            ->get();

        $week3Close = Assignment::with('junior')
            ->where('chore_id', 4)
            ->where('week', 3)
            ->get();

        $week4Close = Assignment::with('junior')
            ->where('chore_id', 4)
            ->where('week', 4)
            ->get();

        return view('shutter', compact(
            'week1Open',
            'week2Open',
            'week3Open',
            'week4Open',
            'week1Close',
            'week2Close',
            'week3Close',
            'week4Close',
        ));
    }

    public function recital()
    {
        $week1 = Assignment::with('junior')
            ->where('chore_id', 2)
            ->where('week', 1)
            ->get();
        
        $week2 = Assignment::with('junior')
            ->where('chore_id', 2)
            ->where('week', 2)
            ->get();

        $week3 = Assignment::with('junior')
            ->where('chore_id', 2)
            ->where('week', 3)
            ->get();

        $week4 = Assignment::with('junior')
            ->where('chore_id', 2)
            ->where('week', 4)
            ->get();

        return view('recital', compact(
            'week1',
            'week2',
            'week3',
            'week4',
        ));
    }

    public function rubbish()
    {
        $week1 = Assignment::with('junior')
            ->where('chore_id', 3)
            ->where('week', 1)
            ->get();
        
        $week2 = Assignment::with('junior')
            ->where('chore_id', 3)
            ->where('week', 2)
            ->get();

        $week3 = Assignment::with('junior')
            ->where('chore_id', 3)
            ->where('week', 3)
            ->get();

        $week4 = Assignment::with('junior')
            ->where('chore_id', 3)
            ->where('week', 4)
            ->get();

        return view('rubbish', compact(
            'week1',
            'week2',
            'week3',
            'week4',
        ));
    }
}
