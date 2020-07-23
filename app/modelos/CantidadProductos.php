<?php

namespace App\modelos;

use Illuminate\Database\Eloquent\Model;

class CantidadProductos extends Model
{
    protected $connection = 'mysql';
	protected $table = 'cantidad_productos';
	protected $primaryKey = 'id';
	protected $guarded = ['id'];
}
