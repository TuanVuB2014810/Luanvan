<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class listwish extends Model
{
    use HasFactory;
    protected $table  ='listwish';
    protected $primaryKey ='id';
    protected $timestaps = true;
    protected $fillable = ['post_id','user_id','yeuthich',];
}
