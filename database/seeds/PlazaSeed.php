<?php

use Illuminate\Database\Seeder;

class PlazaSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $plaza = [
        ['id' => 1 , 'nombre' => 'Salón de Baile', 'estado' => 1 , 'cantidad' => 10  ],
        ['id' => 2 , 'nombre' => 'Espacio Cafetería', 'estado' => 1 ,  'cantidad' => 10  ],
        ['id' => 3 , 'nombre' => 'Salón de Musculación', 'estado' => 1 ,  'cantidad' => 10 ],
        ['id' => 4 , 'nombre' => 'Salon Cycling', 'estado' => 1 ,'cantidad' => 8 ],
        ['id' => 5 , 'nombre' => 'Cancha', 'estado' => 1 ,  'cantidad' => 10 ],
      ];
      DB::connection('mysql')->table('plaza')->insert($plaza);
    }
}
