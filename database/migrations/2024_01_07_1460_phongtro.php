<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('phongtro', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->increments('phongtro_id');
            $table->string('name');
            $table->string('maphong')->unique();
            $table->integer('sophong');
            $table->string('gia');
            $table->longText('mota');
            $table->string('gia_nuoc',10);
            $table->string('gia_dien',10);
            $table->unsignedInteger('loai_phong');
            $table->string('dia_chi',100);
            $table->string('tinh');
            $table->string('huyen');
            $table->timestamps();
            $table->string('dientich',10);
            $table->foreign('loai_phong') //cột khóa ngoại là cột `l_ma` trong table `sanpham`
            ->references('id')->on('loaiphong') //cột sẽ tham chiếu đến là cột `l_ma` trong table `loai`
            ->onDelete('CASCADE')
            ->onUpdate('CASCADE');
           
        });
     
       
        
        

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phongtro');
    }
};