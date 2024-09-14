<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class evaluate extends Model
{
    use HasFactory;
    protected $table  ='evaluates';
    protected $primaryKey ='id';
    protected $timestaps = true;
    protected $fillable = ['user_id','phongtro_id','rating','comment'];
}
