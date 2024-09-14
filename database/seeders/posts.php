<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class posts extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
           
            [
                'user_id' => '1',
                'maphong' => '8570',
                'content' => 'Phòng trọ đường Nguyễn Tri Phương, gần đại học Kinh Tế CSB',
                'date_create' => '2024-01-26 15:06:15',
                'date_update' => '2024-01-26 15:33:52',
                'status' => '1',
            ],
            [
                'user_id' => '2',
                'maphong' => '6344',
                'content' => 'Phòng trọ 15 m có gác',
                'date_create' => '2024-01-26 15:06:15',
                'date_update' => '2024-01-26 15:33:52',
                'status' => '1',
            ],
            [
                'user_id' => '1',
                'maphong' => '3012',
                'content' => 'Nhà Mặt tiền kinh doanh TRẦN MAI NINH P11 SÁT CHỢ BÀ HOA 4X22M 1 LẦU',
                'date_create' => '2024-02-26 15:06:15',
                'date_update' => '2024-02-26 15:33:52',
                'status' => '1',
            ],
            [
                'user_id' => '1',
                'maphong' => '0004',
                'content' => 'Nhà trọ giá rẻ, gần trường Đại học Cần thơ',
                'date_create' => '2024-02-26 15:06:15',
                'date_update' => '2024-02-26 15:33:52',
                'status' => '1',
            ],
            [
            'user_id' => '1',
            'maphong' => '0005',
            'content' => 'Mặt bằng ninh kiều',
            'date_create' => '2024-02-26 15:06:15',
            'date_update' => '2024-02-26 15:33:52',
            'status' => '1',
            ],
           
        ];
        DB::table('posts')->insert($posts);
    }
}