<?php

namespace App\Http\Controllers;

use App\Models\Chore;
use App\Models\Junior;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JuniorController extends Controller
{
    public function index()
    {
        $juniors = Junior::get();

        return view('junior.index', compact('juniors'));
    }

    public function create()
    {
        $preferences = Chore::where('is_operational', 1)
            ->pluck('chore_name');

        return view('junior.create', compact('preferences'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:Male,Female'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'preferences' => ['nullable', 'array'],
            'preferences.*' => ['string'],
            'status' => ['required', 'in:Active,Inactive'],
            'email' => ['required', 'email', 'unique:users,email'],
        ]);

        $junior = Junior::create([
            'name' => $validated['name'],
            'gender' => $validated['gender'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'preferences' => $validated['preferences'] ?? [],
            'status' => $validated['status'],
        ]);

        User::create([
            'junior_id' => $junior->id,
            'role_id' => 2,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        return redirect()
            ->route('juniors.index')
            ->with('success', 'Junior created successfully.');
    }

    public function show(Junior $junior)
    {
        $preferences = Chore::where('is_operational', 1)
            ->pluck('chore_name');
        
        return view('junior.show', compact('junior', 'preferences'));
    }

    public function edit(Junior $junior)
    {
        $preferences = Chore::where('is_operational', 1)
            ->pluck('chore_name');

        return view('junior.edit', compact('junior', 'preferences'));
    }

    public function update(Request $request, Junior $junior)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:Male,Female'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'preferences' => ['nullable', 'array'],
            'preferences.*' => ['string'],
            'status' => ['required', 'in:Active,Inactive'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($junior->user->id)],
        ]);

        $junior->update([
            'name' => $validated['name'],
            'gender' => $validated['gender'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'preferences' => $validated['preferences'] ?? [],
            'status' => $validated['status'],
        ]);

        $user = User::where('name', $junior->name);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        return redirect()
            ->route('juniors.show', $junior)
            ->with('success', 'Junior updated successfully.');
    }

    public function destroy(Junior $junior)
    {
        User::where('junior_id', $junior->id)->delete();

        $junior->delete();
        
        return redirect()
            ->route('juniors.index')
            ->with('success', 'Junior deleted successfully.');
    }
}
