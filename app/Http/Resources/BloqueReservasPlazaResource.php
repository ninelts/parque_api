<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BloqueReservasPlazaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);


      //    return [
      //
      //
      //   "plaza_id"        => $this->id,
      //   "nombre"          => $this->nombre,
      //   "estado_plaza"    => $this->estado,
      //   "fecha"           => $this->reservas->fecha,
      //   "disponible"      => $this->reservas->disponible,
      //     "bloque_horario"    => [
      //         "hora_inicio"     => $this->bloque_horario->hora_inicio,
      //         "hora_fin"        => $this->bloque_horario->hora_fin,
      //         "estado_bloque"   => $this->bloque_horario->estado,
      //   ],
      // ];

    }
}
