<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $table  ='Admin';
    protected $primaryKey ='admin_id';
    protected $fillable = ['admin_name','password','phone','address','email'];
}
