<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Junior;
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

        $today = Carbon::now()->toDateString();
        $todayAssignments = Assignment::whereHas('schedule', function ($query) use ($today) {
            $query->where('schedule_date', $today);
        })
            ->with(['chore', 'schedule', 'junior'])
            ->get();

        return view('admin.dashboard', compact('todayAssignments'));
    }
}
