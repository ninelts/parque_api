<?php

namespace App\modelos;

use Illuminate\Database\Eloquent\Model;

class Precios extends Model
{
	protected $connection = 'mysql';
	protected $table = 'precios';
	protected $primaryKey = 'id';
	protected $guarded = ['id'];
	public $timestamps = false;
}
