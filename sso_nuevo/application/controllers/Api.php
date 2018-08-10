<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	/**
	 *
	 * Api V1 para redireccion y consulta
	 */

	 public function buscar(){
		$id = $this->input->get('q');
		$resultado = $this->conexionldap->buscar_usuario($id);
		echo ($resultado > 0) ? '{"estado": 1, "mensaje": "Usuario existe"}': '{"estado": 0, "mensaje": "Usuario NO existe"}';
	 }
	
	
}
