<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::factory(1)->create()->each(function ($user){
             Task::factory(20)->create([
                 'user_id' => $user->id,
                 'uuid' => Str::uuid()->toString()
             ]);
         });
    }
}
