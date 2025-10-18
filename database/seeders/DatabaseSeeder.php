<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Counter;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(1)->create();
        Counter::create([
            'id' => 1,
            'count' => 0,
        ]);

        // 新增管理者帳號
        \App\Models\User::create([
            'name' => 'ADMIN',
            'email' => 'admin@cycuhealth.com',
            'username'=> 'admin',
            'password' => bcrypt('admin123'),
            'email_verified_at' => now(),
            'remember_token'=> 'sFbxrV4YeNmsnKEch9WpVv1it88tVWLH0SDApGLOtdvocuGmLg3cgKEjX8Ec',
        ]);
    }

}
