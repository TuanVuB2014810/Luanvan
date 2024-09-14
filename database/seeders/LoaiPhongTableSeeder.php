<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoaiPhongTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $loaiphong = [
            [
            'name' => 'Chung cư',
          
            ],
            [
            'name' => 'Nhà ở',
            
            ],
            [
            'name' => 'Phòng trọ',
              
            ],
            [
            'name' => 'Văn phòng',
                
            ],
            // Thêm các bản ghi khác nếu cần
        ];

        DB::table('loaiphong')->insert($loaiphong);
    }
}