<?php

namespace App\modelos;

use Illuminate\Database\Eloquent\Model;

class OrdenCompraProductos extends Model
{
	protected $connection = 'mysql2';
	protected $table ='orden_compra_productos';
	public $timestamps = false;
	protected $guarded = ['id'];
}
