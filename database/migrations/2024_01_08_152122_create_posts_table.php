<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('maphong')->unique();
            $table->string('content');
            $table->string('errMess')->nullable();
            $table->tinyInteger('status')->default('0');
            // $table->boolean('yeuthich')->default(false);
            $table->dateTime('date_create');
            $table->dateTime('date_update');
            $table->timestamps();


            $table->foreign('user_id') //cột khóa ngoại là cột `l_ma` trong table `sanpham`
                 ->references('user_id')->on('users') //cột sẽ tham chiếu đến là cột `l_ma` trong table `loai`
                 ->onDelete('CASCADE')
                 ->onUpdate('CASCADE');
           
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->foreign('maphong') //cột khóa ngoại là cột `l_ma` trong table `sanpham`
                 ->references('maphong')->on('phongtro') //cột sẽ tham chiếu đến là cột `l_ma` trong table `loai`
                 ->onDelete('CASCADE')
                 ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
