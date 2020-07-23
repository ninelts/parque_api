<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterAuthRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
/*use  JWTAuth;*/
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller {

	// public  $loginAfterSignUp = true;
	public function __construct()
	{
			$this->middleware('auth:api', ['except' => ['login', 'register']]);
	}

	public  function  register(Request  $request) {
		// $user = new  User();
		// $user->name = $request->name;
		// $user->email = $request->email;
		// $user->password = bcrypt($request->password);
		// $user->save();

		  $validator = Validator::make($request->all(), [
				'name' => ['required', 'string', 'max:255'],
				'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
				'password' => ['required', 'string', 'min:4'],
		]);



		if(!$validator->fails()){
			$user	= User::insert([
				
					'name' => $request->name,
					'email' => $request->email,
					'password' => bcrypt($request->password),
					'celular' =>$request->celular,
					'direccion'=>$request->direccion,
					'id_perfil' => 4,
					'desde_app' =>1,
				
				]);

				return  response()->json([
					'mensaje' => 'Registro exitoso',
					'estado' => true,
					'data' => $user
				], 200);
		}else{
			// VALIDACIONES MOMENTANEAS
			return response()->json($validator->errors(), 422);

		}
/*
		if ($this->loginAfterSignUp) {
			return  $this->login($request);
		}*/

	}

	public  function  login(Request  $request) {
		$input = $request->only('email', 'password');
		$jwt_token = null;
		$usuario = null;
// ----------------------------------------------------------validacion1
		// if (!$jwt_token = JWTAuth::attempt($input)) {
		// 	return  response()->json([
		// 		'estado' => false,
		// 		'mensaje' => 'Correo o contraseña no válidos.',
		// 	], 401);
		// }

		// ------------------------------------------------------ validacion2
		$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:4',
        ]);

				if ($validator->fails()) {
				 return response()->json($validator->errors(), 422);
		 }

		if (!$jwt_token = JWTAuth::attempt($validator->validated())) {
					return response()->json(['error' => 'Unauthorized'], 401);
			}
			// -----------------------------------------------------------
		$usuario = JWTAuth::setToken($jwt_token)->toUser();

		return  response()->json([
			'estado' => true,
			'token' => $jwt_token,
			'usuario' => $usuario
		]);
	}

	public  function  logout(Request  $request) {
		$this->validate($request, [
			'token' => 'required'
		]);

		try {
			JWTAuth::invalidate($request->token);
			return  response()->json([
				'estado' => true,
				'mensaje' => 'Cierre de sesión exitoso.'
			]);
		} catch (JWTException  $exception) {
			return  response()->json([
				'estado' => false,
				'mensaje' => 'Al usuario no se le pudo cerrar la sesión.'
			], 500);
		}
	}

	public  function  getAuthUser(Request  $request) {
		$this->validate($request, [
			'token' => 'required'
		]);

		$user = JWTAuth::authenticate($request->token);
		return  response()->json(['user' => $user]);
	}

	protected function jsonResponse($data, $code = 200)
	{
		return response()->json($data, $code,
			['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
	}
}
