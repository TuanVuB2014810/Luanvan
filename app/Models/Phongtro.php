<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Phongtro extends Model
{
    public $timestamps = false;
    use HasFactory,HasFactory, Notifiable;
    protected $table  ='phongtro';
    protected $primaryKey ='phongtro_id';
    protected $timestaps = true;
    protected $fillable = ['name','so_cho','mota','gia','loai_phong','gia_nuoc','gia_dien','dientich','yeuthich','diachi','huyen','tinh'];
    // protected $dateFormat  = 'h:m:s';
}
