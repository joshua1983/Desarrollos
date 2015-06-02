<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class IngenierosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Mostrar todas los ingenieros
		$ingenieros = \App\Models\Ingeniero::get();

		return response()->json([
				"msg" => "Success",
				"ings" => $ingenieros->toArray()
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
		$ingeniero = new \App\Models\Ingeniero();

		$ingeniero->nombres = $request->nombres;
		$ingeniero->apellidos = $request->apellidos;
		$ingeniero->correo = $request->correo;
		$ingeniero->telefono = $request->telefono;
		$ingeniero->celular = $request->celular;
		$ingeniero->extension = $request->extension;
		$ingeniero->trabajasi = $request->trabajasi;
		$ingeniero->trabajati = $request->trabajati;
		
		$ingeniero->save();

		return response()->json([
				"msg" => "Success",
				"id" => $ingeniero->id
			]
			);

	}
	
	public function storeMod($id, $idApp)
	{
		$ing_mod = new \App\Models\Ingeniero_Modulo();

		$ing_mod->ingenieros_id = $id;
		$ing_mod->modulos_id = $idApp;
		$ing_mod->save();

		return response()->json([
				"msg" => "Success",
				"id" => $ing_mod->id
			]
			);

	}
	
	public function removeMod($id, $idApp)
	{
		$ing_mod = \App\Models\Ingeniero_Modulo::whereRaw('ingenieros_id = ? and modulos_id = ?',[$id,$idApp]);
		
		$ing_mod->delete();

		return response()->json([
				"msg" => "Success"
			]
			);

	}
	
	public function showMod($id,$idApp)
	{
		//
		$modulo = \App\Models\Modulo::find($idApp);
		if ($modulo != null){
			$modulo::with('ingenieros')->get();
			
			return response()->json([
				"msg" => "Success",
				"ingeniero" => $modulo->ingenieros->toArray()
			]
			);
		}else{
			return response()->json([
				"msg" => "No hay datos",
				"ingeniero" => ""
			]
			);
		}
		
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
		$ingeniero = \App\Models\Ingeniero::find($id);
		return response()->json([
				"msg" => "Success",
				"ingeniero" => $ingeniero
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
		$ingeniero = \App\Models\Ingeniero::find($id);

		$ingeniero->nombres = $request->nombres;
		$ingeniero->apellidos = $request->apellidos;
		$ingeniero->correo = $request->correo;
		$ingeniero->telefono = $request->telefono;
		$ingeniero->celular = $request->celular;
		$ingeniero->extension = $request->extension;
		$ingeniero->trabajasi = $request->trabajasi;
		$ingeniero->trabajati = $request->trabajati;

		$ingeniero->save();
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
		$ingeniero = \App\Models\Ingeniero::find($id);
		$ingeniero->delete();
		return response()->json([
				"msg" => "Success"
			],200
			);
	}

}
