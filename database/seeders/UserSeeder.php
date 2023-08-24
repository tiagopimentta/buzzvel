<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        \DB::table('users')->insert(
//            [
//                'name' => 'teste',
//                'email' => 'teste@admin.com',
//                'password' => Hash::make('123456'),
//                'remember_token' => Str::uuid()->toString(),
//            ]
//        );
        User::factory(10)->create();
    }
}
