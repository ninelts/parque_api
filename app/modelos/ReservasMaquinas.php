<?php

namespace App\modelos;

use Illuminate\Database\Eloquent\Model;

class ReservasMaquinas extends Model
{
	protected $connection = 'mysql';
	protected $table = 'reservas';
	protected $primaryKey = 'id';
	protected $guarded = ['id'];
	// public $timestamps = false;
}
