<?php

namespace App\modelos;

use Illuminate\Database\Eloquent\Model;

class CarritoCompra extends Model
{

	protected $connection = 'mysql';
	protected $table = 'carrito_de_compra';
	protected $primaryKey = 'id';
	protected $guarded = ['id'];
	// public $with = ['bloque_horario' , 'precio'];
	public function Productos()
	{

		return $this->hasMany(Productos::class, 'carrito_de_compra_id', 'id');
	}

}
