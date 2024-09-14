<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    
    use HasFactory;
    protected $table  ='posts';
    protected $primaryKey ='id';
    protected $timestaps = true;
    protected $fillable = ['user_id','maphong','content','status','errMess','yeuthich','data_create','date_update'];
}
