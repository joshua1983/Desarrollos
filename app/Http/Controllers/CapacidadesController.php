<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;


class CapacidadesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Mostrar todas las capacidades
		$capacidades = \App\Models\Capacidad::get();
		$ly_capacidades = $capacidades->toArray();
		$str_retorno = '{';
		$str_retorno = $str_retorno . ' "msg": "Success","caps": [';

		foreach($ly_capacidades as $cap){
			
			$id = $cap["id"];
			$nombre = $cap["nombre"];
			$ly_apps = $this->aplicaciones($id);
			$ly_mods = $this->modulos($id);
			
			$str_retorno = $str_retorno . ' {
				"id": '.$id.',
				"nombre": "'. $nombre .'",
				"apps": '.json_encode($ly_apps).',
				"mods": '.json_encode($ly_mods).'
				},';
			
		}
		$str_retorno = substr($str_retorno, 0, -1);
		$str_retorno = $str_retorno . ']}';
		
		return response($str_retorno);
	}

	public function modulos($idCap){
		$capacidad = \App\Models\Capacidad::find($idCap);
		$ly_retorno = array();
		if($capacidad != null){
			$capacidad::with('modulos')->get();
			if ($capacidad->modulos != null){
				$ly_retorno = $capacidad->modulos->toArray();
				return $ly_retorno;
			}else{
				return 'modulos no encontradados';
			}
			
		}else{
			return 'capacidad no encontrada';
		}
	}
	
	public function aplicaciones($idCap){
		$capacidad = \App\Models\Capacidad::find($idCap);
		$ly_retorno = array();
		if($capacidad != null){
			$capacidad::with('aplicaciones')->get();
			if ($capacidad->aplicaciones != null){
				$ly_retorno = $capacidad->aplicaciones->toArray();
				return $ly_retorno;
			}else{
				return 'aplicaciones no encontradados';
			}
			
		}else{
			return 'capacidad no encontrada';
		}
	}

	public function asignarApp($idApp, Request $request){
		
		DB::statement(
				DB::raw(
						"insert into capacidades_aplicaciones (capacidades_id, aplicacion_id, nivel) values(?,?,?)"
					), array($request->caracteriza, $idApp, $request->nivel)
			);
		
		return '{"msg": 1}';
	}

	
	public function updateApp($idApp, Request $request){
		
		DB::statement(
				DB::raw(
						"update capacidades_aplicaciones set nivel = ? where capacidades_id = ? and aplicacion_id = ?"
					), array($request->nivel,$request->capacidad,$idApp)
			);
		
		return '{"msg": 1}';
	}


	public function delApp($idApp, $idCap){
		
		DB::statement(
				DB::raw(
						"delete from capacidades_aplicaciones where capacidades_id = ? and aplicacion_id = ?"
					), array($idCap,$idApp)
			);
		
		return '{"msg": 1}';
	}


}
