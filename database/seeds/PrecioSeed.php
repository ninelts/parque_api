<?php

use Illuminate\Database\Seeder;

class PrecioSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
    	$precio = [
    		 ['id' => 1 , 'precio' => 4999],
    	];


        DB::connection('mysql')->table('precios')->insert($precio);
    }
}
