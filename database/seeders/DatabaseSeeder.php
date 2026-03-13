<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            RoleSeeder::class,
            PlanSeeder::class,
            CategorySeeder::class,
        ]);

        $adminRole = Role::where('name', 'admin')->first();
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'admin123',
                'password'   => bcrypt('password'),
                'role_id'    => $adminRole->id,
                'status'     => 'active',
            ],
        );
        User::factory(1)->create();
    }
}
