<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Role::insert([
            [
                'id'   => Role::ROLE_ADMIN_ID,
                'name' => 'Администратор',
            ],
            [
                'id'   => Role::ROLE_USER_ID,
                'name' => 'Пользователь'
            ],
        ]);

        User::updateOrCreate(['email' => 'admin@mail.ru'],[
            'first_name' => "Admin",
            'password' => bcrypt('123'),
            'role_id' => Role::ROLE_ADMIN_ID,
        ]);

        User::updateOrCreate(['email' => 'user@mail.ru'],[
            'first_name' => "Test user",
            'password' => bcrypt('123'),
            'role_id' => Role::ROLE_USER_ID,
        ]);

    }
}
