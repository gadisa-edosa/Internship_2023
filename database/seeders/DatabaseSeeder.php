<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        $roles = ['Teacher', 'student'];
        foreach ($roles as $role) {
            Role::create(['name'->$role]);
        }
        foreach (User::all() as $user) {
            foreach (Role::all() as $role) {
                $user->roles()->attach($role->id);
            }
        }

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
