<?php

namespace Database\Seeders;

use App\Models\Chore;
use App\Models\Junior;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Junior']);

        $defaultChores = [
            ['chore_name' => 'Open Shutter', 'is_operational' => 1, 'start_time' => '07:45', 'end_time' => '08:30'],
            ['chore_name' => 'Yasin Recital', 'is_operational' => 1, 'start_time' => '09:30', 'end_time' => '10:00'],
            ['chore_name' => 'Throw Rubbish', 'is_operational' => 1, 'start_time' => '17:50', 'end_time' => '18:00'],
            ['chore_name' => 'Close Shutter', 'is_operational' => 1, 'start_time' => '17:50', 'end_time' => '18:00'],
            ['chore_name' => 'Off Duty', 'is_operational' => 0, 'start_time' => null, 'end_time' => null],
        ];

        foreach ($defaultChores as $chore) {
            Chore::firstOrCreate(['chore_name' => $chore['chore_name']], $chore);
        }

        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'email_verified_at' => now(), 'password' => bcrypt('password'), 'role_id' => Role::where('name', 'Admin')->first()->id, 'junior_id' => null]
        );

        foreach (range(1, 5) as $index) {
            $junior = Junior::firstOrCreate(
                ['name' => "Junior {$index}"],
                [
                    'gender' => 'Male',
                    'start_date' => '2026-01-01',
                    'end_date' => '2027-01-01',
                    'preferences' => ['Open Shutter', 'Yasin Recital', 'Throw Rubbish', 'Close Shutter'],
                    'status' => 'Active'
                ]
            );

            User::firstOrCreate(
                ['email' => "test{$index}@example.com"],
                ['name' => "Junior {$index}", 'email_verified_at' => now(), 'password' => bcrypt('password'), 'role_id' => Role::where('name', 'Junior')->first()->id, 'junior_id' => $junior->id]
            );
        }
    }
}
