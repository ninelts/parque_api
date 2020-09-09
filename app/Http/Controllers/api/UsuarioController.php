<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\Usuario;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;
use  JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
class UsuarioController extends Controller
{

	/*perfil*/
	protected $validaciones = [

		'name' => ['required', 'string', 'max:255'],
		'email' => ['required', 'string', 'email', 'max:255', 'unique:pgsql.users'],
		'password' => ['required', 'string', 'min:6'],
	];
	protected $validaciones_msj = [

		'name.required' => 'el nombre es obligatorio',
		'name.string' => 'el nombre debe ser de tipo caracter',
		'name.max' => 'el nombre debe ser menor a 255 caracteres',
		'email.name' => 'el email es obligatorio',
		'name.string' => 'el email debe ser de tipo caracter',
		'email.max' => 'el emal debe ser menor a 255 caracteres',
		'password.required' => 'la password es obligatoria',
		'password.string' => 'la password debe ser de tipo caracter',
		'password.min' => 'la password debe tener un minimo de 6 caracteres',

	];

	protected $validator;

	public function crearUsuario (Request $request){

		try {

			$this->validator = Validator::make($request->all(),$this->validaciones,$this->validaciones_msj);

			


			if ($this->validator->fails()) {
				throw new HttpResponseException(response()->json([
					'codigo' => 400,
					'estado' => false,
					'error' => $this->validator,
				]));
			}else{
				Usuario::create([

					'name' => $request->name,
					'email' => $request->email,
					'password' => Hash::make($request->password),
					'telefono' =>$request->telefono.
					'direccion'=>$request->direccion

				]);
			}

			return response()->json([
				'mensaje' => "Solicitud con exito",
				'estado' => true,
				'codigo' => 200,
			]);


		} catch (Exception $e) {
			if ($this->validator->fails()) {
				throw new HttpResponseException(response()->json([
					'error' => $e,
					'estado' => false,
					'codigo' => 400,
				]));
			}
		}


	}

	public function login(Request $request){

		try {
			$collection_usuario = Usuario::where('email' , $request->email)->first();
			
			if ($collection_usuario == null) {
					return response()->json([
					'mensaje' => 'Email o clave incorrecta',
					'estado' => false,
					'codigo' => 402,
				]);
				
			}
			
			if (Hash::check($request->password, $collection_usuario->password)) {

				return response()->json([
					'mensaje' => 'login exitoso',
					'estado' => true,
					'codigo' => 200,
				]);
			}else{

				return response()->json([
					'mensaje' => 'Email o clave incorrecta',
					'estado' => false,
					'codigo' => 402,
				]);

			}



		} catch (Exception $e) {
			throw new HttpResponseException(response()->json([
				'error' => $e,
				'estado' => false,
				'codigo' => 400,
			]));
		}

	}


}
