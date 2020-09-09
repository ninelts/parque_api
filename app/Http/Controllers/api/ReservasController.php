<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use QrCode;
use SimpleSoftwareIO\QrCode\Generator;
use Illuminate\Support\Facades\Storage;
use App\modelos\Reservas;
use App\modelos\BloqueReservaPlaza;
use App\modelos\Plaza;
use App\modelos\CodigoQr;
use App\User;
use App\modelos\CarritoCompra;
use App\modelos\OrdenCompra;
use App\modelos\Productos;
use App\modelos\OrdenCompraProductos;
use Carbon\Carbon;
use DateTime;
use App\Jobs\QrActivacionJob;
use App\Jobs\QrDesabilitarJob;
use App\Http\Resources\ListarReservasResource;

class ReservasController extends Controller
{

    public function crearReservas(Request $request)
    {
        $pagoWebpay = true;
        // $ordenCompra = $request->ordenCompra;
        $id_usuario = 44;
        $ordenCompra = 422;
        $collectionOrdenCompra = OrdenCompra::find($ordenCompra);
        $collectionCarrito = CarritoCompra::find($collectionOrdenCompra->id_orden_compra_app);
        $collectionProductos = Productos::where('carrito_de_compra_id', $collectionOrdenCompra->id_orden_compra_app)->get();


        $collection_usuario = User::find($id_usuario);



        if ($collectionCarrito->estado == 0 && $collectionOrdenCompra->estado_pago == 1) {

            // return response()->json([
            //     'estado' => true,
            //     'prueba' => $collectionCarrito,

            // ]);
            foreach ($collectionProductos as $productos) {

                // $QrCode = new Generator;
                $collectionBloqueReservaPlaza = BloqueReservaPlaza::find($productos['bloque_plaza_reserva_id'])->decrement('cantidad', 1);


                $bytes = random_bytes(20);
                $token  = bin2hex($bytes);
                $qr = QrCode::format('png')       // Sintaxis para generar QR
                    ->size(250)                   // tamaño en px
                    ->errorCorrection('H')        //Nivel de detalle de Codigo QR
                    ->generate($token);
                // ->merge($merge)                // Se incrusta una imagen al QR
                $unique_id =  uniqid() . uniqid();
                $url = 'qr/' . $collection_usuario->email . '/' . $unique_id . '.png';
                $storage_img = Storage::disk('public')->put($url, $qr);

                $collectionCodigoQr = CodigoQr::create([
                    'codigo_token_qr' => $token,
                    'estado' => 0,
                    'img_url_qr' => $url,
                    'nombre_qr' => $unique_id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                $carbon_fecha = Carbon::parse($productos['fecha_reserva']);
                $carbon_fecha_inicio  = new DateTime($carbon_fecha->subMinutes(5));
                $carbon_fecha_termino = new DateTime($carbon_fecha->addMinutes(60));

                $collectionReservas = Reservas::create([
                    'estado_reserva' => 1,
                    'carrito_de_compra_id' => $collectionCarrito->id,
                    'usuario_id' => $id_usuario,
                    'codigo_qr_id' => $collectionCodigoQr->id,
                    'productos_id' => $productos['id'],
                    'fecha_de_reserva' => $productos['fecha_reserva'],
                    'activacion_reserva' => $carbon_fecha_inicio,
                    'expiracion_reserva' => $carbon_fecha_termino,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                // QrActivacionJob::dispatch($collectionReservas)->onQueue('qrActivar')->onConnection('database');
                QrActivacionJob::dispatch($collectionReservas)->delay($carbon_fecha_inicio)->onQueue('qrActivar')->onConnection('database');
                QrDesabilitarJob::dispatch($collectionReservas)->delay($carbon_fecha_termino)->onQueue('qrDesabilitar')->onConnection('database');

                $collectionCarrito->update(['estado' => 1]);
            }
            return response()->json([
                'estado' => true
            ]);
        } else {
            return response()->json([
                'estado' => false
            ]);
        }
    }



    // public function obtenerReservas(Request $request)
    // {

    //     $plaza = Plaza::where('estado', 1)->get();
    //     $bloque_horario = BloqueHorario::where('estado', 1)->get();

    //     $reservas[0]['plaza']     = $plaza;
    //     $reservas[0]['bloque_horario']     = $bloque_horario;
    //     // dd($reservas);


    // }

    public function crearResevar(Request $request)
    {
        Reservas::insert([
            'estado_reserva' => $request->estado_reserva,
            'plaza_id' => $request->plaza_id,
            'usuario_id' => $request->usuario_id,
            'bloque_horario_id' => $request->bloque_horario_id,
            'codigo_qr_id' => $request->codigo_qr_id,
            'fecha_de_reserva' => $request->fecha_de_reserva,
            'expiracion_reserva' => $request->expiracion_reserva,
            'activacion_reserva' => $request->activacion_reserva,
        ]);
    }


    public function qrActivar($datos)
    {
        $collectionCodigoQr = CodigoQr::find($datos['codigo_qr_id']);
        $collectionCodigoQr->update(['estado' => 1]);
    }

    public function qrDesabilitar($datos)
    {


        $collectionReservas = Reservas::find($datos['id']);
        $collectionReservas->update(['estado_reserva' => 0]);

        $collectionCodigoQr = CodigoQr::find($datos['codigo_qr_id']);
        $collectionCodigoQr->update(['estado' => 0]);
    }

    public function listarReservas(Request $request)
    {

        $collectionReservas = Reservas::with(['producto' => function ($producto) {
            $producto->with('bloqueReservaPlaza');
        }])->where('usuario_id', (int)$request->usuario_id)->get();
        $url = 'http://localhost:8090/public/storage/app/';
        foreach ($collectionReservas as $qr) {
            $collectionCodigoQr = CodigoQr::find($qr['codigo_qr_id']);


            $array_qr[] = array(
                'nombre_plaza' => $qr->producto->bloqueReservaPlaza->plaza->nombre,
                'estado_qr' => $collectionCodigoQr->estado,
                'precio' => $qr->producto->bloqueReservaPlaza->precio->precio,
                'horario_inicio' => $qr->producto->bloqueReservaPlaza->bloque_horario->hora_inicio,
                'horario_fin' => $qr->producto->bloqueReservaPlaza->bloque_horario->hora_fin,
                'url_qr' => $collectionCodigoQr->img_url_qr,
                'nombre_qr' => $collectionCodigoQr->nombre_qr,
                'fecha_reserva' => $qr->fecha_de_reserva,
                'activacion_reserva' => $qr->activacion_reserva,
                'estado_reserva' => $qr->estado_reserva
            );
        }

        return new ListarReservasResource($array_qr);
    }

    public function leerCodigoQr(Request $request)
    {


        $codigo_qr = CodigoQr::where('codigo_token_qr', $request->token)->first();

        if ($codigo_qr == null) return response()->json(['estado' => false]);

        if ($codigo_qr->estado == 1) {
            $collection_reservas = Reservas::where('codigo_qr_id' , $codigo_qr->id)->first();
            $collection_usuario  = User::find($collection_reservas->usuario_id);
            $collection_productos = Productos::with('bloqueReservaPlaza')->find($collection_reservas->productos_id);

            $datos = Array(
                'nombre' => $collection_usuario->name .' '. $collection_usuario->a_paterno,
                'fecha_reserva' => $collection_reservas->fecha_de_reserva,
                'precio' => $collection_productos->bloqueReservaPlaza->precio->precio,

            );
            return response()->json([
                'estado' => true,
                'datos' => $datos,
            ]);
        } else {
            return response()->json([
                'estado' => false
            ]);
        }
    }
}
