<?php

use Illuminate\Console\Command;
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
        Schema::create('users', function (Blueprint $table) {
            // $table->increments('user_id');
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->increments('user_id'); 
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('avt')->nullable();
            // $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('google_id')->nullable();
            $table->string('facebook_id')->nullable();
            $table->tinyInteger('role')->default('0');
            $table->dateTime('date_create');
            $table->rememberToken();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void

    {   
        Schema::dropIfExists('images');
        Schema::dropIfExists('listwish');
        Schema::dropIfExists('evaluates');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('phongtro');
        Schema::dropIfExists('loaiphong');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('users');
    }
};