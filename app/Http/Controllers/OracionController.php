<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class OracionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Mostrar todas las oraciones
		$oraciones = \App\Models\Oracion::get();

		return response()->json([
				"msg" => "Success",
				"orac" => $oraciones->toArray()
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
		$oracion = new \App\Models\Oracion();

		$oracion->titulo = $request->titulo;
		$oracion->categoria = $request->categoria;
		$oracion->oracion = $request->oracion;

		$oracion->save();

		return response()->json([
				"msg" => "Success",
				"id" => $oracion->id
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
		$oracion = \App\Models\Oracion::find($id);
		return response()->json([
				"msg" => "Success",
				"oracion" => $oracion
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
		$oracion = \App\Models\Oracion::find($id);

		$oracion->titulo = $request->titulo;
		$oracion->categoria = $request->categoria;
		$oracion->oracion = $request->oracion;

		$oracion->save();
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
		$oracion = \App\Models\Oracion::find($id);
		$oracion->delete();
		return response()->json([
				"msg" => "Success"
			],200
			);
	}

}
