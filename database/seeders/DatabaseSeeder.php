<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            QmsPermissionSeeder::class,
        ]);

        $user = User::where(
            'email',
            'admin@lvbwb.go.tz'
        )->first();

        if (! $user) {
            $user = User::create([
                'name' => 'QMS System Administrator',
                'email' => 'admin@lvbwb.go.tz',
                'password' => 'ChangeMe@12345',
                'is_active' => true,
            ]);
        }

        $user->assignRole('Super Admin');
    }
}
