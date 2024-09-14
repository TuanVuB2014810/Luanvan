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
        Schema::create('evaluates', function(Blueprint $table){
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->increments('id');
                $table->unsignedInteger('phongtro_id');
                $table->unsignedInteger('user_id');
                $table->string('rating');
                $table->string('comment'); 
                $table->timestamps();
    
                // Foreign keys
                $table->foreign('phongtro_id')->references('phongtro_id')->on('phongtro')->onDelete('CASCADE')
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
        Schema::dropIfExists('evaluates');
    }
};
