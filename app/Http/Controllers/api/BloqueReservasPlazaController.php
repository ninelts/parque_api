<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\modelos\BloqueReservaPlaza;
use App\modelos\BloqueHorario;
use App\modelos\Plaza;
use App\modelos\Precios;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\BloqueReservasPlazaResource;
use Carbon\Carbon;
class BloqueReservasPlazaController extends Controller
{
    public function obtener(Request $request){
      $fecha_formato = Carbon::parse($request->fecha)->format('Y-m-d');


      $validator = Validator::make($request->all(), ['fecha' => ['required']]);

      if(!$validator->fails()){
        // Se valida que la fecha ingresada se mayor o igual a la fecha actual
        if (Carbon::now()->format('Y-m-d') <= $fecha_formato) {

          $collection_bloque_Reservas = Plaza::with(['reservas' => function ($query) use($fecha_formato) {
            $query->where([
              ['fecha' ,$fecha_formato],
              ['estado' , 1],
              ['disponible' , 1],
              ['cantidad' , '>=' , 1],
            ]);}])->get();


         return BloqueReservasPlazaResource::collection($collection_bloque_Reservas);


       }else{
        	return response()->json([
            'estado' => false ,
            'mensaje' => 'La fecha de reserva ser mayor al dia actual',
          ],422);
       }
      }else{
        	return response()->json($validator->errors(), 422);
      }
    }

    public function crear(Request $request){
      // $mes = $request->mes;
      // $anio = $request->anio;
      // $dias = Carbon::now()->daysInMonth;
      try {

        $mes  = 8;
        $anio = 2020;
        $carbon = Carbon::now();
        $cantidad_dias = $carbon->year($anio)->month($mes)->daysInMonth;
         // $cantidad_dias= $carbon2::now()->day;


          $cantidad_bloque_horario = BloqueHorario::where('estado' ,1)->pluck('id');
          $plaza = Plaza::where('estado',1)->get();
          $precios_id = Precios::find(1);
       

         // Se Captura la cantidad de dias del mes para poder insertar el
         // bloque_horario a cada dia x cada plaza
         for ($i=1; $i <= $cantidad_dias ; $i++) {

          $fecha = Carbon::create(2020, $mes, $i);
          $fecha_formato = $fecha->format('d-m-Y');


           foreach ($plaza as $key => $valor) {
             foreach ($cantidad_bloque_horario as $key => $bloque_horario_id) {
                BloqueReservaPlaza::insert([
                  'estado' => 1,
                  'disponible' => 1,
                  'plaza_id' =>$valor->id,
                  'bloque_horario_id' => $bloque_horario_id,
                  'precios_id' => $precios_id->id,
                  'fecha' => $fecha,
                  'cantidad'=> $valor->cantidad,
                ]);
             }
           }

           // $table->tinyInteger('estado');
           // $table->tinyInteger('disponible');
           // $table->bigInteger('maquina_id');
           // $table->bigInteger('bloque_horario_id');
           // $table->dateTime('fecha');

         }
         return  response()->json([
   				'estado' => true,
   				'mensaje' => 'insert masivo completo',
   			], 200);

      } catch (\Exception $e) {
        return  response()->json([
          'estado' => false,
          'mensaje' => $e
        ], 500);
      }
    }
}
