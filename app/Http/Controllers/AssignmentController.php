<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Chore;
use App\Models\Junior;
use App\Models\Schedule;
use Illuminate\Support\Carbon;

class AssignmentController extends Controller
{
    public function master()
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

        $week1Close = Assignment::with('junior')
            ->where('chore_id', $closeShutterChoreId)
            ->where('week', 1)
            ->get();

        $week2Close = Assignment::with('junior')
            ->where('chore_id', $closeShutterChoreId)
            ->where('week', 2)
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

        return view('rubbish', compact(
            'week1',
            'week2',
        ));
    }

    public function markAsDone(Assignment $assignment)
    {
        $assignment->update(['status' => 1]);

        return redirect()->back()->with('success', 'Task marked as done.');
    }

    public function swapAssignment(Assignment $assignment)
    {
        $currentJuniorId = $assignment->junior_id;

        $availableJuniors = Junior::where('status', 'Active')
            ->where('id', '!=', $currentJuniorId)
            ->get();

        if ($availableJuniors->isEmpty()) {
            return redirect()->back()->with('error', 'No available juniors to swap with.');
        }

        return view('junior.swap', compact('assignment', 'availableJuniors'));
    }

    public function confirmSwap(Assignment $assignment)
    {
        $request = request();
        $newJuniorId = $request->input('junior_id');

        if (! $newJuniorId) {
            return redirect()->back()->with('error', 'Please select a junior.');
        }

        $assignment->update(['junior_id' => $newJuniorId]);

        return redirect()->route('dashboard')->with('success', 'Assignment swapped successfully.');
    }
}
