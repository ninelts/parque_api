<?php

namespace App\modelos;

use Illuminate\Database\Eloquent\Model;

class OrdenCompra extends Model
{
    protected $connection = 'mysql2';
    protected $table ='orden_compra';
    public $timestamps = false;
    protected $guarded = ['id'];
}
