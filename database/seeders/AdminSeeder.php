<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
             'name' => 'ADMIN',
            'email' => 'admin@cycuhealth.com',
            'username'=> 'admin',
            'password' => bcrypt('admin123'),
            'email_verified_at' => now(),
            'remember_token'=> 'sFbxrV4YeNmsnKEch9WpVv1it88tVWLH0SDApGLOtdvocuGmLg3cgKEjX8Ec',
        ]);
    }
}
