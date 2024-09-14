<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class phongtro extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phongtro = [
           
            [
                'name' => 'Phòng trọ Trí Đức',
                'maphong' => '8570',
                'sophong' =>'2',
                'gia' => '900000',
                'mota' => 'Cần thơ',
                'gia_nuoc' => 12000,
                'gia_dien' => 4000,
                'loai_phong' => 1,
                'dia_chi' =>'Hảm 12 lê hồng phong',
                'tinh' =>'An Giang',
                'huyen'=>'Thành phố Châu Đốc',
                'created_at' => '2024-01-26 15:14:42',
                'updated_at' => '2024-01-26 15:36:35',
                'dientich' => 35,
            ],

            [
                'name' => 'Phòng trọ sinh viên',
                'maphong' => '6344',
                'sophong' =>'2',
                'gia' => '1200000',
                'mota' => 'Cần thơ',
                'gia_nuoc' => 12000,
                'gia_dien' => 4000,
                'dia_chi' =>'Hảm 12 lê hồng phong',
                'tinh' =>'An Giang',
                'huyen'=>'Thành phố Châu Đốc',
                'loai_phong' => 1,
                'created_at' => '2024-01-26 15:14:42',
                'updated_at' => '2024-01-26 15:36:35',
                'dientich' => 35,
            ],

            [
                'name' => 'Mặt bằng cho thuê',
                'maphong' => '3012',
                'sophong' =>'0',
                'gia' => '1200000',
                'mota' => 'Cần thơ',
                'gia_nuoc' => 12000,
                'gia_dien' => 4000,
                'dia_chi' =>'Hảm 12 lê hồng phong',
                'tinh' =>'An Giang',
                'huyen'=>'Thành phố Châu Đốc',
                'loai_phong' => 1,
                'created_at' => '2024-01-26 15:14:42',
                'updated_at' => '2024-01-26 15:36:35',
                'dientich' => 65,
            ],
            [
                'name' => 'Phòng troj ninh kiều',
                'maphong' => '0004',
                'sophong' =>'0',
                'gia' => '1200000',
                'mota' => 'Cần thơ',
                'gia_nuoc' => 12000,
                'gia_dien' => 4000,
                'dia_chi' =>'Hảm 12 lê hồng phong',
                'tinh' =>'An Giang',
                'huyen'=>'Thành phố Châu Đốc',
                'loai_phong' => 1,
                'created_at' => '2024-01-26 15:14:42',
                'updated_at' => '2024-01-26 15:36:35',
                'dientich' => 65,
            ],
             [
                'name' => 'Phòng trọ ninh kiều',
                'maphong' => '0005',
                'sophong' =>'0',
                'gia' => '1200000',
                'mota' => 'Cần thơ',
                'gia_nuoc' => 12000,
                'gia_dien' => 4000,
                'dia_chi' =>'Hảm 12 lê hồng phong',
                'tinh' =>'An Giang',
                'huyen'=>'Thành phố Châu Đốc',
                'loai_phong' => 1,
                'created_at' => '2024-01-26 15:14:42',
                'updated_at' => '2024-01-26 15:36:35',
                'dientich' => 65,
            ],

           
        ];
        DB::table('phongtro')->insert($phongtro);
    }
}