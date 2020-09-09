<?php

namespace App\modelos;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $connection = 'mysql';
	protected $table = 'productos';
	protected $primaryKey = 'id';
	protected $guarded = ['id'];


	public function bloqueReservaPlaza()
	{
			return $this->hasOne(BloqueReservaPlaza::class , 'id',  'bloque_plaza_reserva_id');
	}	
}
