<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class AplicacionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Mostrar todas las aplicacion
		$aplicaciones = \App\Models\Aplicacion::get();

		return response()->json([
				"msg" => "Success",
				"apps" => $aplicaciones->toArray()
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
		$aplicacion = new \App\Models\Aplicacion();

		$aplicacion->codigo_aplicacion = $request->codigo_aplicacion;
		$aplicacion->nombre_aplicacion = $request->nombre_aplicacion;
		$aplicacion->dba_id = $request->dba_id;
		$aplicacion->tec_id = $request->tec_id;
		$aplicacion->estado = $request->estado;
		
		
		$aplicacion->save();

		return response()->json([
				"msg" => "Success",
				"id" => $aplicacion->id
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
		$aplicacion = \App\Models\Aplicacion::find($id);
		return response()->json([
				"msg" => "Success",
				"aplicacion" => $aplicacion
			]
			);
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
		$aplicacion = \App\Models\Aplicacion::find($id);

		$aplicacion->codigo_aplicacion = $request->codigo_aplicacion;
		$aplicacion->nombre_aplicacion = $request->nombre_aplicacion;
		$aplicacion->dba_id = $request->dba_id;
		$aplicacion->tec_id = $request->tec_id;
		$aplicacion->estado = $request->estado;

		$aplicacion->save();
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
		$aplicacion = \App\Models\Aplicacion::find($id);
		$aplicacion->delete();
		return response()->json([
				"msg" => "Success"
			],200
			);
	}

}
