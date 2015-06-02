<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class ModulosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Mostrar todas los modulos
		$modulos = \App\Models\Modulo::get();
		return response()->json([
			"msg" => "Modulos",
			"mods" => $modulos->toArray()
		]
		);
	}
	
	public function indexApp($id)
	{
		// Mostrar todas los modulos
		
		$aplicacion = \App\Models\Aplicacion::find($id);
		if ($aplicacion != null){
			$aplicacion::with('modulos')->get();
		
			return response()->json([
				"msg" => "Success",
				"modulos" => $aplicacion->modulos->toArray()
			]
			);
		}else{
			return response()->json([
				"msg" => "App No Encontrada",
				"mods" => ""
			]
			);
		}
		
	}
 
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$mod = new \App\Models\Modulo();

		$mod->nombre_modulo = $request->nombre_modulo;
		$mod->formularios = $request->formularios;
		$mod->procesos = $request->procesos;
		$mod->reportes = $request->reportes;
		$mod->tablas = $request->tablas;
		$mod->estado= $request->estado;
		$mod->tipomodulo= $request->tipomodulo;
		$mod->aplicacion_id = $request->aplicacion_id;
		
		$mod->save();

		return response()->json([
				"msg" => "Success",
				"id" => $mod->id
			]
			);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id,$idApp)
	{
		//
		$mod = \App\Models\Modulo::find($idApp);
		return response()->json([
				"msg" => "Success",
				"modulo" => $mod
			]
			);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request)
	{
		//
		$mod = \App\Models\Modulo::find($request->id);

		$mod->nombre_modulo = $request->nombre_modulo;
		$mod->formularios = $request->formularios;
		$mod->procesos = $request->procesos;
		$mod->reportes = $request->reportes;
		$mod->tablas = $request->tablas;
		$mod->estado= $request->estado;
		$mod->tipomodulo= $request->tipomodulo;
		
		$mod->save();

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
		$mod = \App\Models\Modulo::find($id);
		$mod->delete();
		return response()->json([
				"msg" => "Success"
			],200
			);
	}

}
