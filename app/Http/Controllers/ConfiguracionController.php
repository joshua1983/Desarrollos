<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class ConfiguracionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Mostrar todas las aplicaciones
		$config = \App\Models\Configuracion::get();

		return response()->json([
				"msg" => "Success",
				"config" => $config->toArray()
			]
			);
	}
 
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$config = new \App\Models\Configuracion();

		$config->aplicacion_id = $request->aplicacion;
		$config->servidor = $request->servidor;
		$config->ip = $request->ip;
		$config->usuario = $request->usuario;
		$config->password = $request->password;
		$config->nota= $request->nota;

		$config->save();

		return response()->json([
				"msg" => "Success",
				"id" => $config->id
			]
			);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		$config = \App\Models\Configuracion::find($id);
		return response()->json([
				"msg" => "Success",
				"config" => $config
			]
			);
	}
	
	public function showConfig($id,$idApp){

		$config = \App\Models\Aplicacion::find($idApp);
		$config::with('configuraciones')->get();

		if ($config != null){
			return response()->json([
				"msg" => "Success",
				"config" => $config->configuraciones->toArray()
			]
			);
		}else{
			return response()->json([
				"msg" => "Fallo",
				"config" => $idApp
			]
			);
		}
		
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		//
		$config = \App\Models\Configuracion::find($id);

		$config->servidor = $request->servidor;
		$config->ip = $request->ip;
		$config->usuario = $request->usuario;
		$config->password = $request->password;
		$config->nota= $request->nota;

		$config->save();
		return response()->json([
				"msg" => "Success"
			],200
			);



	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
		$config = \App\Models\Configuracion::find($id);
		$config->delete();
		return response()->json([
				"msg" => "Success"
			],200
			);
	}

}
