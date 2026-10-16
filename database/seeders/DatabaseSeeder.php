<?php

namespace Database\Seeders;

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
        // User::factory(10)->create();

        $adminEmail = config('admin.email');
        $adminPassword = config('admin.password');

        if (is_string($adminEmail) && $adminEmail !== '' && is_string($adminPassword) && $adminPassword !== '') {
            User::query()->updateOrCreate(
                ['email' => $adminEmail],
                [
                    'name' => config('admin.name', 'Smart Illam Admin'),
                    'password' => $adminPassword,
                    'is_admin' => true,
                ],
            );
        }
    }
}
