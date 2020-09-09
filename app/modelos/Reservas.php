<?php

namespace App\modelos;

use Illuminate\Database\Eloquent\Model;

class Reservas extends Model
{
	protected $connection = 'mysql';
	protected $table = 'reservas';
	protected $primaryKey = 'id';
	protected $guarded = ['id'];
	// public $timestamps = false;

	public function producto()
	{
			return $this->hasOne(Productos::class , 'id',  'productos_id');
	}	
}
