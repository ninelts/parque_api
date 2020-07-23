<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\modelos\CarritoCompra;
use App\modelos\CantidadProductos;
use App\modelos\OrdenCompra;
use App\modelos\OrdenCompraProductos;
use App\modelos\BloqueReservaPlaza;

class CarritoCompraController extends Controller
{


	public function insertCarritoCompra(Request $request){


		$array_productos = $request->resultado;
		$cantidadTotal = count($array_productos);
		$precioTotal = 0;



		foreach ($array_productos as $value) {

			$precioTotal = $precioTotal + $value['precio'];

		}

		try {

			CarritoCompra::insert([
				'estado' => 0,
				'cod_carrito_compra' => null,
				'precio_total' => $precioTotal,
				'cantidad_productos' => $cantidadTotal,
				'user_id' => $request->id_usuario,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s')
			]);

			$collectionCarritoCompra = CarritoCompra::where('user_id' , $request->id_usuario)->latest()->first();

			foreach ($array_productos as $value) {

				CantidadProductos::insert([
					'bloque_plaza_reserva_id' => $value['id'],
					'carrito_de_compra_id' => $collectionCarritoCompra->id,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				]);

			}

			CarritoCompra::where('id' , $collectionCarritoCompra->id)->update(['cod_carrito_compra' => 'ccp'.$collectionCarritoCompra->id]);
			
			$collectionCantidadProductos = CantidadProductos::where('carrito_de_compra_id', $collectionCarritoCompra->id)->get()->pluck('bloque_plaza_reserva_id');
			$collectionProductosDetalle = BloqueReservaPlaza::whereIn('id', $collectionCantidadProductos)->get()->toArray();

			$parametros = array(

				'id_carrito' => $collectionCarritoCompra->id,
				'precio_total' => $collectionCarritoCompra->precio_total,
				'cantidad' => $collectionCarritoCompra->cantidad_productos,
				'cod_carrito_compra' => $collectionCarritoCompra->cod_carrito_compra,
				'user_id' => $collectionCarritoCompra->user_id,
				'productos_detalle' => $collectionProductosDetalle

			);
			OrdenCompra::insert([

				'id_usuario' => $collectionCarritoCompra->user_id,
				'id_metodo_entrega' => 0,
				'id_forma_pago' => 1,
				'estado_pago' => 0,
				'monto_total' => $collectionCarritoCompra->precio_total,
				'id_orden_compra_app' => $collectionCarritoCompra->id,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s') 

			]);

			$collectionOrdenCompra = OrdenCompra::where('id_usuario' , $request->id_usuario)->latest()->first();
			OrdenCompraProductos::insert([
				'id_orden_compra' => $collectionOrdenCompra->id,
				'id_producto' => $collectionCarritoCompra->id,
				'cantidad' => 1,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s') 

			]);

			return response()->json([
				'estado' => true
			]);




			// return redirect()->route('details', array('id' => $id, 'name' => $name));
		

		} catch (Exception $e) {
			return $e;
		}



	}


}
