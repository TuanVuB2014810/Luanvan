<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class loaiphong extends Model
{
    
    use HasFactory;
    protected $table  ='loaiphong';
    protected $primaryKey ='id';
    protected $timestaps = true;
    protected $fillable = ['name'];
}
