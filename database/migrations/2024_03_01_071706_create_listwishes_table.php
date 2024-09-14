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
        Schema::create('listwish', function(Blueprint $table){
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->increments('id');
                $table->unsignedInteger('post_id');
                $table->unsignedInteger('user_id');
                $table->boolean('yeuthich')->default('0'); // Thuộc tính yêu thích
                $table->timestamps();
    
                // Foreign keys
                $table->foreign('post_id')->references('id')->on('posts')->onDelete('CASCADE')
                ->onUpdate('CASCADE');
                $table->foreign('user_id')->references('user_id')->on('users')->onDelete('CASCADE')
                ->onUpdate('CASCADE');
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lishwishes');
    }
};
