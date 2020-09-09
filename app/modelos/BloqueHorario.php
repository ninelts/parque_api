<?php

namespace App\modelos;

use Illuminate\Database\Eloquent\Model;

class BloqueHorario extends Model
{
	protected $connection = 'mysql';
	protected $table = 'bloque_horario';
	protected $primaryKey = 'id';
	protected $guarded = ['id'];
	// public $timestamps = false;
}
