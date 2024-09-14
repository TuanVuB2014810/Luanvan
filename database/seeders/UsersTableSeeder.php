<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $users = [
           
            [
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'avt' =>'image1706281575_1853.jpg',
            'password' => Hash::make('admin'),
            'phone' => '0984848343',
            'city' => 'Cần thơ',
            'date_create' =>'2024-03-11 15:47:59',
            'role' => 1,
            ],
            [
            'name' => 'Tuan Vu',
            'email' => 'tuanvu19042002@gmail.com',
            'avt' =>'image1706281575_1853.jpg',
            'password' => Hash::make('123456'),
            'phone' => '0984848484',
            'date_create' =>'2024-03-11 15:47:59',
            'city' => 'Vinh',
            'role' =>0,
                ],
           
        ];
        DB::table('users')->insert($users);


       
        
       
    }
}
