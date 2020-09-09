<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\modelos\Plaza;

class PlazaController extends Controller
{
    public function crearPlaza(Request $request){

try {

  $validator = Validator::make($request->all(), [
          'nombre' => 'required|string|min:4',
          'estado' => 'required|number',
          // 'tipo' => 'string',
          // 'descripcion'=> 'string',
          // 'img'=> 'string',
      ]);

      if ($validator->fails()) {
       return response()->json($validator->errors(), 422);
   }else{

     $plaza = Plaza::insert([
       'nombre' => $request->nombre,
       'estado' => $request->estado ,
       // 'tipo' => $request->tipo,
       // 'descripcion' => $request->descripcion ,
       // 'img' => $request->img]);
   }

} catch (Exception $e) {
 return response()->json($e, 422);
}





    }
}
