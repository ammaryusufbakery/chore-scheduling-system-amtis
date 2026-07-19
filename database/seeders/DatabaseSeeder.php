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
            ['chore_name' => 'Open Shutter', 'is_operational' => 1],
            ['chore_name' => 'Yasin Recital', 'is_operational' => 1],
            ['chore_name' => 'Throw Rubbish', 'is_operational' => 1],
            ['chore_name' => 'Close Shutter', 'is_operational' => 1],
            ['chore_name' => 'Off Duty', 'is_operational' => 0],
        ];

        foreach ($defaultChores as $chore) {
            Chore::firstOrCreate(['chore_name' => $chore['chore_name']], $chore);
        }

        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'email_verified_at' => now(), 'password' => bcrypt('password'), 'role_id' => Role::where('name', 'Admin')->first()->id]
        );

        foreach (range(1, 5) as $index) {
            Junior::firstOrCreate(
                ['name' => "Junior {$index}"],
                ['status' => 'Active']
            );

            User::firstOrCreate(
                ['email' => "test{$index}@example.com"],
                ['name' => "Junior {$index}", 'email_verified_at' => now(), 'password' => bcrypt('password'), 'role_id' => Role::where('name', 'Junior')->first()->id]
            );
        }
    }
}
