<?php

namespace App\modelos;

use Illuminate\Database\Eloquent\Model;

class BloqueReservaPlaza extends Model
{
  protected $connection = 'mysql';
  protected $table = 'bloque_reservas_plaza';
  protected $primaryKey = 'id';
  protected $guarded = ['id'];
  public $with = ['bloque_horario' , 'precio' , 'plaza'];


public function plaza()
{
    return $this->hasOne(Plaza::class, 'id' , 'plaza_id');
}

public function bloque_horario()
{
    return $this->belongsTo('\App\modelos\BloqueHorario', 'bloque_horario_id', 'id');
}

public function precio()
{
    return $this->belongsTo('\App\modelos\Precios', 'precios_id', 'id');
}

}
