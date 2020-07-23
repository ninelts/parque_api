<?php

use Illuminate\Database\Seeder;
class BloqueHorarioSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $bloques = 	[
        ['id' => 1 ,'hora_inicio' => '00:00','hora_fin' => '01:00', 'estado' => 0],
    		['id' => 2 ,'hora_inicio' => '01:00','hora_fin' => '02:00', 'estado' => 0],
    		['id' => 3 ,'hora_inicio' => '02:00','hora_fin' => '03:00', 'estado' => 0],
    		['id' => 4 ,'hora_inicio' => '03:00','hora_fin' => '04:00', 'estado' => 0],
    		['id' => 5 ,'hora_inicio' => '04:00','hora_fin' => '05:00', 'estado' => 0],
    		['id' => 6 ,'hora_inicio' => '06:00','hora_fin' => '07:00', 'estado' => 0],
    		['id' => 7 ,'hora_inicio' => '07:00','hora_fin' => '08:00', 'estado' => 0],
    		['id' => 8 ,'hora_inicio' => '08:00','hora_fin' => '09:00', 'estado' => 0],
    		['id' => 9 ,'hora_inicio' => '09:00','hora_fin' => '10:00', 'estado' => 1],
    		['id' => 10 ,'hora_inicio' => '10:00','hora_fin' => '11:00', 'estado' => 1],
    		['id' => 11 ,'hora_inicio' => '11:00','hora_fin' => '12:00', 'estado' => 1],
    		['id' => 12 ,'hora_inicio' => '12:00','hora_fin' => '13:00', 'estado' => 1],
    		['id' => 13 ,'hora_inicio' => '13:00','hora_fin' => '14:00', 'estado' => 1],
    		['id' => 14 ,'hora_inicio' => '14:00','hora_fin' => '15:00', 'estado' => 1],
    		['id' => 15 ,'hora_inicio' => '15:00','hora_fin' => '16:00', 'estado' => 1],
    		['id' => 16 ,'hora_inicio' => '16:00','hora_fin' => '17:00', 'estado' => 1],
    		['id' => 17 ,'hora_inicio' => '17:00','hora_fin' => '18:00', 'estado' => 1],
    		['id' => 18 ,'hora_inicio' => '18:00','hora_fin' => '19:00', 'estado' => 1],
    		['id' => 19 ,'hora_inicio' => '19:00','hora_fin' => '20:00', 'estado' => 0],
    		['id' => 20 ,'hora_inicio' => '20:00','hora_fin' => '21:00', 'estado' => 0],
    		['id' => 21 ,'hora_inicio' => '21:00','hora_fin' => '22:00', 'estado' => 0],
    		['id' => 22 ,'hora_inicio' => '22:00','hora_fin' => '23:00', 'estado' => 0],
    		['id' => 23 ,'hora_inicio' => '23:00','hora_fin' => '00:00', 'estado' => 0]
      ];

    	DB::connection('mysql')->table('bloque_horario')->insert($bloques);
    }
}
