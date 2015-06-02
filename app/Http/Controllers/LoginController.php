<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class LoginController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function login()
	{
		
		$str_retorno = '{"user":{
			"id": 1
			"tipo" : 1
		}}'

		return ($str_retorno);
	}
 
}
