<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class images extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $img = [
           
            [
            'phongtro_id' =>'1',
            'image' =>'anh_tro_1_1.jpg'
            ],
            [
            'phongtro_id' =>'1',
            'image' =>'anh_tro_1_2.jpg'
                ],
            [
            'phongtro_id' =>'1',
            'image' =>'anh_tro_1_3.jpg'
            ],
            [
            'phongtro_id' =>'1',
            'image' =>'anh_tro_1_4.jpg'
            ],

            [
            'phongtro_id' =>'2',
            'image' =>'anh_tro_2_1.jpg'
            ],
            [
            'phongtro_id' =>'2',
            'image' =>'anh_tro_2_2.jpg'
                ],
            [
            'phongtro_id' =>'2',
            'image' =>'anh_tro_2_3.jpg'
            ],
            [
            'phongtro_id' =>'2',
            'image' =>'anh_tro_2_4.jpg'
            ],

            [
                'phongtro_id' =>'3',
                'image' =>'anh_tro_3_1.jpg'
                ],
                [
                'phongtro_id' =>'3',
                'image' =>'anh_tro_3_2.jpg'
                    ],
                [
                'phongtro_id' =>'3',
                'image' =>'anh_tro_3_3.jpg'
                ],
                [
                'phongtro_id' =>'3',
                'image' =>'anh_tro_3_4.jpg'
                ],


                [
                'phongtro_id' =>'4',
                'image' =>'anh_tro_4_1.jpg'
                ],
                [
                'phongtro_id' =>'4',
                'image' =>'anh_tro_4_2.jpg'
                    ],
                [
                'phongtro_id' =>'4',
                'image' =>'anh_tro_4_3.jpg'
                ],
                [
                'phongtro_id' =>'4',
                'image' =>'anh_tro_4_4.jpg'
                ],


                 [
                'phongtro_id' =>'5',
                'image' =>'anh_tro_5_1.jpg'
                ],
                [
                'phongtro_id' =>'5',
                'image' =>'anh_tro_5_2.jpg'
                    ],
                [
                'phongtro_id' =>'5',
                'image' =>'anh_tro_5_3.jpg'
                ],
                [
                'phongtro_id' =>'5',
                'image' =>'anh_tro_5_4.jpg'
                ],
        
        ];
        DB::table('images')->insert($img);
    }
}