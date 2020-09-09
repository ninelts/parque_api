<?php

namespace App\modelos;

use Illuminate\Database\Eloquent\Model;

class CodigoQr extends Model
{
    /*public $table ='codigo_qr';*/

   	protected $connection = 'mysql';
	protected $table = 'codigo_qr';
	protected $primaryKey = 'id';
	protected $guarded = ['id'];
	// public $timestamps = false;
}
