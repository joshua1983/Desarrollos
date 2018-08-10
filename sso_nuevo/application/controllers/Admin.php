<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('conexionldap');
		$this->load->model('usuario_model');

	}

	/**
	 *
	 * Administracion de los sistemas conexos
	 */
	public function index()
	{
		$this->load->view('layout/header');
		$this->load->view('welcome_admin');
		$this->load->view('layout/footeradm');
	}

	
	public function borrar_usuario($id){
		echo $resultado = $this->conexionldap->borrar_usuario($id);
	}

	

	
	
}
