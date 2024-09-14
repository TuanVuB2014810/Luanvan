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
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('phongtro_id');
            $table->string('image');
            $table->timestamps();
            $table->foreign('phongtro_id') //cột khóa ngoại là cột `l_ma` trong table `sanpham`
                 ->references('phongtro_id')->on('phongtro') //cột sẽ tham chiếu đến là cột `l_ma` trong table `loai`
                 ->onDelete('CASCADE')
                 ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
