<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    use HasFactory,HasFactory;
    protected $table  ='images';
    protected $primaryKey ='id';
    protected $timestaps = true;
    protected $fillable = ['phongtro_id','image',];

}
