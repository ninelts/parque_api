<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use QrCode;
use SimpleSoftwareIO\QrCode\Generator;
use Illuminate\Support\Facades\Storage;
use App\modelos\Reservas;
use App\modelos\BloqueHorario;
use App\modelos\Plaza;
use App\modelos\ReservasMaquinas;

class ReservasController extends Controller
{

    public function reservas(){


      // $QrCode = new Generator;

      // dd(QrCode::generate('Embed me into an e-mail!'));

    $qr = QrCode::format('png')       // Sintaxis para generar QR
        ->size(250)                   // tamaño en px
        ->errorCorrection('H')          //Nivel de detalle de Codigo QR
        ->generate('Hola');
        // ->merge($merge)                 // Se incrusta una imagen al QR

        Storage::put('10/qr.png', $qr);
        Storage::setVisibility('10/qr.png' , 'private');
        $visibility = Storage::getVisibility('10/qr.png');
        $imagen     = Storage::get('10/qr.png');
        dd($imagen);
        return View('welcome');
    }



    public function obtenerReservas(Request $request){

        $plaza = Plaza::where('estado' , 1)->get();
        $bloque_horario = BloqueHorario::where('estado' , 1)->get();

        $reservas[0]['plaza'] 	= $plaza;
        $reservas[0]['bloque_horario'] 	= $bloque_horario;
        // dd($reservas);


    }

    public function crearResevar(Request $request){



ReservasMaquinas::insert([
'estado_reserva' => $request->estado_reserva ,
'plaza_id' => $request->plaza_id ,
'usuario_id' => $request->usuario_id ,
'bloque_horario_id' => $request->bloque_horario_id ,
'codigo_qr_id' => $request->codigo_qr_id ,
'fecha_de_reserva' => $request->fecha_de_reserva ,
'expiracion_reserva' => $request->expiracion_reserva ,
'activacion_reserva' => $request->activacion_reserva ,
      ]);

    }
}
