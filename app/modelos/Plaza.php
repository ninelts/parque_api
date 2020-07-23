<?php

namespace App\modelos;

use Illuminate\Database\Eloquent\Model;

class Plaza extends Model
{
	protected $connection = 'mysql';
	protected $table = 'plaza';
	protected $primaryKey = 'id';
	protected $guarded = ['id'];
	// public $timestamps = false;

	public function reservas()
{
		return $this->hasMany('App\modelos\BloqueReservaPlaza');
}
// public function bloqueReservas()
// 	{
// 			return $this->hasOneThrough('App\modelos\BloqueReservaPlaza','App\modelos\BloqueHorario' , 'id', 'bloque_horario_id', 'id');
// 	}
}
