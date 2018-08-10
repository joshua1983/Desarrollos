<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

	/**
	 *
	 * Autenticacion y registro de usuario
	 */
	
	public function __construct(){
		parent::__construct();
		$this->load->library('conexionldap');
		$this->load->library('utilidades');
		$this->load->library('encryption');
		$this->load->model('usuario_model');
	}

//-------------------------------------------------------------------------------	

	public function index()
	{
		if ( ! empty($_SESSION["nombre"])){
			redirect('/usuario/bienvenido');
		}

		$data = array("title" => "Iniciar sesión");

		$this->load->view('layout/header', $data);
		$this->load->view('login');
		$this->load->view('layout/footer');
	}

	//-------------------------------------------------------------------------------	

	public function listar()
	{
		if (empty($_SESSION["nombre"])){
			redirect('/usuario/logout');
		}

		if($_SESSION["rol"] != ROL_ADMINISTRADOR){
			redirect('/usuario/bienvenido');
		}	

		$data = array("title" => "Administrador de usuarios");

		$this->load->view('layout/header', $data);
		$this->load->view('usuarios/listar');
		$this->load->view('layout/footer');
	}



//-------------------------------------------------------------------------------	

public function olvido()
{

	/*
	Vista para pedir el correo electronico registrado del usuario 
	al cual enviarle la nueva contraseña
	*/

	$data = array("title" => "Restablecer contraseña");
	$this->load->view('layout/header', $data);	
	$this->load->view('olvido');
	$this->load->view('layout/footer');
}


//-------------------------------------------------------------------------------	


public function actualizar_datos(){
	// formulario de actualizacion de datos
	if (isset($_SESSION["cedula"])){
		$data = array("title" => "Modificar datos");
		$this->load->view('layout/header', $data);	
		$this->load->view('user_update');
		$this->load->view('layout/footer');

	}else{
		$this->load->view('layout/header');
		$this->load->view('login');
		$this->load->view('layout/footeradm');
	}
}

public function guardar_datos(){
	$nombre = $this->input->post('nombre');
	$apellidos = $this->input->post('apellidos');
	$correo = $this->input->post('correo');
	$modificar_admin = $this->input->post('modificar_admin');

	$cedula = $_SESSION["cedula"];

	if($_SESSION["rol"]==ROL_ADMINISTRADOR){

		if( ! empty( $modificar_admin ) ) {

			$cedula  = $this->input->post('id_cedula_admin');
		
		}

	}

	if(empty($correo)){
		die( json_encode( array( "data" =>array(), 'res' => 0, 'msg' => "Por favor ingrese el correo", "url" => "" ) ) );
	}

	if(empty($nombre)){
		die( json_encode( array( "data" =>array(), 'res' => 0, 'msg' => "Por favor ingrese el nombre", "url" => "" ) ) );
	}

	if(empty($apellidos)){
		die( json_encode( array( "data" =>array(), 'res' => 0, 'msg' => "Por favor ingrese los apellidos" , "url" => "" ) ) );
	}

	if(empty($cedula)){
		die( json_encode( array( "data" =>array(), 'res' => 0, 'msg' => "Por favor ingrese la cedula" , "url" => base_url("usuario/logout") ) ) );
	}

	$consultar_usuario = $this->usuario_model->buscar_usuario($cedula);

	if(empty($consultar_usuario)){
		die( json_encode( array( "data" =>array(), 'res' => 0, 'msg' => "El usuario no existe" , "url" => base_url("usuario/logout") ) ) );
	}

	$consultar_correo = $this->usuario_model->buscar_correo($correo);

	if( ! empty($consultar_correo)){

		if( ! empty($modificar_admin)){

			if($consultar_correo->correo!=$consultar_usuario->correo){
	            die( json_encode( array( "data" =>array(), 'res' => 0, 'msg' =>  "Este correo ya existe", "url" => "" ) ) );
	        }   

		}else{

			if($consultar_correo->correo!=$_SESSION["correo"]){
	            die( json_encode( array( "data" =>array(), 'res' => 0, 'msg' => "Este correo ya existe", "url" => "" ) ) );
	        }    
	    }
	}

	$retorno_ldap = $this->conexionldap->actualizar_usuario($cedula, $correo, $nombre, $apellidos);

	if(empty($retorno_ldap)){
		die( json_encode( array( "data" =>array(), 'res' => 0, 'msg' => "No existe ningun datos" , "url" => "" ) ) );
	}

	if(!isset($retorno_ldap["res"])){
		die( json_encode( array( "data" =>array(), 'res' => 0, 'msg' => "La respuesta del ldap no existe" , "url" => "" ) ) );	
	}

	if(!isset($retorno_ldap["msg"])){
		die( json_encode( array( "data" =>array(), 'res' => 0, 'msg' => "El mensaje del ldap no existe" , "url" => "" ) ) );	
	}

	if($retorno_ldap["res"] == 0){
		die( json_encode( array( "data" =>array(), 'res' => 0, 'msg' =>$retorno_ldap["msg"]  , "url" => "" ) ) );
	}

	$data = array("nombre" => $nombre, "apellidos"=>$apellidos, "correo" =>$correo);

	$resultado = $this->usuario_model->actualizar_usuario($cedula,$data);

	$_SESSION["nombre"] = $nombre;
	$_SESSION["apellidos"] = $apellidos;
	$_SESSION["correo"] = $correo;

	//$this->output->set_content_type('text/json');

	echo json_encode( array( "data" =>$data, 'res' => 1, 'msg' => "El usuario se modifico correctamente" , "url" => "" ));


}

//-------------------------------------------------------------------------------	

public function restaurar()
{
	/*
	Enviar una nueva contraseña generada al correo electronico
	*/

	$correo = $this->input->post('email');

	if(empty($correo)){
		$data["error"] = "El correo electronico no existe.";
		$this->load->view('layout/header');
		$this->load->view('olvido', $data);
		$this->load->view('layout/footer');
		return false;
	}

	$consultar_datos_by_correo = $this->usuario_model->buscar_correo($correo);
	

	if ( ! empty($consultar_datos_by_correo) ) {

		$psswd = substr( md5(microtime()), 1, 8);
		
		$this->conexionldap->actualizar_clave($consultar_datos_by_correo->cedula,$psswd);		

		$html = "Su clave de recuperacion es: ".$psswd;
		
		$psswd = $this->password_hash($psswd);
		$data = array("clave" => $psswd);
		$resultado = $this->usuario_model->actualizar_usuario($consultar_datos_by_correo->cedula,$data);

		$this->load->library('email');

		$this->email->from('noresponder@vanguardia.com', 'Vanguardia');
		$this->email->to($correo);
		
		$this->email->subject('Recuperacion de clave Vanguardia');
		$this->email->message($html);
		
		$this->email->send();

		$data["mensaje"] = "Se ha enviado una nueva contraseña a su correo electronico.";
		$this->load->view('layout/header');
		$this->load->view('login', $data);
		$this->load->view('layout/footer');

	}else{

		$data["error"] = "El correo electronico no esta registrado.";
		$this->load->view('layout/header');
		$this->load->view('olvido', $data);
		$this->load->view('layout/footer');
	}

}



//-------------------------------------------------------------------------------

	public function login(){

		if ( ! empty($_SESSION["nombre"])){
			redirect('/usuario/bienvenido');
		}

		$cedula = $this->input->post('email');
		// tomar solamente el usuario del correo como identificador uid del LDAP
		//$correo = explode('@',$correo)[0];
		$clave = $this->input->post('password');
		// busca y autentica el usuario en el LDAP
		$resultado = $this->conexionldap->validar_usuario($cedula, $clave);



		if($resultado != 1){
			$data["error"] = "Error: El usuario no existe";
			$this->load->view('layout/header');
			$this->load->view('login', $data);
			$this->load->view('layout/footer');
			return false;
		}

		$usuario = $this->usuario_model->buscar_usuario($cedula);

		if(empty($usuario)){
			$data["error"] = "Error: El usuario no existe";
			$this->load->view('layout/header');
			$this->load->view('login', $data);
			$this->load->view('layout/footer');
			return false;
		}

		if( ! password_verify( $clave , $usuario->clave ) ){
			$data["error"] = "Error: La contraseña es incorrecta";
			$this->load->view('layout/header');
			$this->load->view('login', $data);
			$this->load->view('layout/footer');
			return false;
		}
		
		// registra la sesion y genera un token en la bd con el id de usuario
		$this->utilidades->crear_sesion($correo);

		// consulta la url_retorno de la tabla aplicaciones que depende de la 
		// relacion con la tabla aplicaciones_usuario

		$aplicacion = ($this->input->post('app') != null) ? $this->input->post('app') : $this->input->get('app');
		
		/*
		* guardar en sesion los datos del usuario
		*/

		$_SESSION["nombre"] = $usuario->nombre;
		$_SESSION["apellidos"] = $usuario->apellidos;
		$_SESSION["correo"] = $usuario->correo;
		$_SESSION["estado"] = $usuario->suscripcion;
		$_SESSION["uid"] = $usuario->cedula;
		$_SESSION["cedula"] = $usuario->cedula;
		$_SESSION["rol"] = $usuario->rol_id;
		
		/*
		* Encriptar la contraseña del usuario para autologin
		*/

		$algorithm = MCRYPT_BLOWFISH;
		$key = 'V@nguadiaLiberal2018';
		$data = $clave;
		$mode = MCRYPT_MODE_CBC;
		$iv = mcrypt_create_iv(mcrypt_get_iv_size($algorithm, $mode),
			   MCRYPT_DEV_URANDOM);
		$clave_data = mcrypt_encrypt($algorithm, $key, $data, $mode, $iv);
		$clave_cifrada = base64_encode($clave_data);
		$_SESSION["usrpass"] = $clave;

		//-------------------------------------------------


		if ($this->input->post('app') !=null || $this->input->get('app') !=null){
			//busqueda de la aplicacion asociada al usuario
			$query = $this->db->query('select a.url_retorno from aplicaciones a, aplicaciones_usuario b where a.id = ? and a.id = b.id_app and b.id_usuario = ?', array($aplicacion, $usuario->id))->row();
			$url_redirect = $query->url_retorno;
			redirect($url_redirect);
		

		}else{
			
			redirect('usuario/bienvenido');
		}

			
	}

//-------------------------------------------------------------------------------	

	public function bienvenido(){
		if (empty($_SESSION["nombre"])){
			redirect('/usuario/login');
		}
		
		/*
		* Crear la Cookie para el e-paper
		Nombre_valor|Apellidos_valor|idusuario_valor|nombre_publicacion1_valor=fecha_caducidad1;
		nombre_publicacion2_valor=fecha_caducidad2;nombre_publicación3_valor=fecha_caducidad3;
		nombre_publicación4_valor=fecha_caducidad4|Redireccion_URL|Firma_valor
		*/
		$clave_secreta = "j4V8EPwwW34r3PoyM2CYiQ98";

		$cadena_cookie = $_SESSION["nombre"];
		$cadena_cookie .= "|".$_SESSION["apellidos"];
		$cadena_cookie .= "|".$_SESSION["correo"];
		$cadena_cookie .= "|vanguardia=01012020";
		$cadena_cookie .= "|http://digitales.vanguardia.com";

		$firma_cookie = md5($cadena_cookie);

		$datos_firma = $cadena_cookie ."|". $firma_cookie. "|". time();
		
		$iv = '12345678'; 

		$enc = mcrypt_encrypt(MCRYPT_TRIPLEDES , $clave_secreta, $datos_firma, MCRYPT_MODE_CBC, $iv); 

		setrawcookie ("evanguardia",  base64_encode( $enc )  ,0);
		setcookie("evanguardiaPlano", $cadena_cookie ,0);

		$data = array("title" => "Bienvenido");
		$this->load->view('layout/header', $data);	
		$this->load->view('bienvenido');
		$this->load->view('layout/footer');
	}

//-------------------------------------------------------------------------------	

	public function logout(){
		$this->session->sess_destroy();
		redirect('usuario/index');
	}

//-------------------------------------------------------------------------------	

	public function nuevo(){
		if ( ! empty($_SESSION["nombre"])){
			redirect('/usuario/bienvenido');
		}
		$data = array("title" => "Registrarse");
		$this->load->view('layout/header', $data);	
		
		$this->load->view('new');
		$this->load->view('layout/footer');
	}

//-------------------------------------------------------------------------------	

	public function registrar(){
		$response = $this->input->post('g-recaptcha-response');
		$remoteip = $this->input->ip_address();
		
		// validacion del capcha en la libreria utilidades
		//if ($this->utilidades->validate_captcha($response, $remoteip)){
			
		//cargue de datos del form
		$correo = $this->input->post('email');
		$usuario = explode('@',$correo)[0];
		$clave = $this->input->post('password');
		$nombre = $this->input->post('nombre');
		$apellidos = $this->input->post('apellidos');
		$cedula = $this->input->post('cedula');
		$ingreso_admin = $this->input->post('ingreso_admin');

		if(empty($correo)){
			die( json_encode( array( 'res' => 0, 'msg' => "Por favor ingrese el correo", "url" => "" ) ) );
		}

		if(empty($usuario)){
			die( json_encode( array( 'res' => 0, 'msg' => "Por favor ingrese el usuario", "url" => "" ) ) );
		}

		if(empty($clave)){
			die( json_encode( array( 'res' => 0, 'msg' => "Por favor ingrese la clave", "url" => "" ) ) );
		}

		if(empty($nombre)){
			die( json_encode( array( 'res' => 0, 'msg' => "Por favor ingrese el nombre", "url" => "" ) ) );
		}

		if(empty($apellidos)){
			die( json_encode( array( 'res' => 0, 'msg' => "Por favor ingrese los apellidos" , "url" => "" ) ) );
		}

		if(empty($cedula)){
			die( json_encode( array( 'res' => 0, 'msg' => "Por favor ingrese la cedula" , "url" => "" ) ) );
		}

		$consultar_correo = $this->usuario_model->buscar_correo( $correo );
	
		if( ! empty($consultar_correo)){
			die( json_encode( array( 'res' => 0, 'msg' => "El correo ya se encuentra registrado", "url" => "") ) );
		}

		$consultar_cedula = $this->usuario_model->buscar_usuario( $cedula );
	
		if( ! empty($consultar_cedula)){
			die( json_encode( array( 'res' => 0, 'msg' => "La cédula ya se encuentra registrado", "url" => "") ) );
		}

		// creacion de la entrada en LDAP con la libreria conexionldap
		$retorno = $this->conexionldap->registrar_usuario($cedula, $correo, $clave, $nombre, $apellidos);

		if($retorno != 1){
			die( json_encode( array( 'res' => 0, 'msg' => "No se ingreso el usuario") ) );

		}

		$clave = $this->password_hash($clave);

		$this->usuario_model->crear_usuario(
			$cedula,
			$nombre,
			$apellidos,
			$correo,
			0,
			$clave
		);


		$this->utilidades->crear_sesion($correo);

		$_SESSION["nombre"] = $nombre;
		$_SESSION["apellidos"] = $apellidos;
		$_SESSION["correo"] = $correo;
		$_SESSION["estado"] = 0;
		$_SESSION["uid"] = $cedula;
		$_SESSION["cedula"] = $cedula;
		$_SESSION["usrpass"] = $clave;
		$_SESSION["rol"] = ROL_VISITANTE;

		if(empty($ingreso_admin)){
			echo json_encode( array( 'res' => 1, 'msg' => "Bienvenido !", "url" => base_url("usuario/nuevo") ) );

		}else{
			echo json_encode( array( 'res' => 2, 'msg' => "El usuario se ingreso correctamente", "url" => ""));			
		}

	}

	//-----------------------------------------------------------------------------
	/**	
	 * Recorrer todos los datos y almacenar en un array para enviarlos
	 * @param  array $data     Almacena los datos de los usuarios
	 * @return array      	   Datos de los usuarios	
	 */
	public function recorrer_datos( $data ){
		 	$datos =  array();
            $filtered_rows = count($data);
            foreach($data as $row)
            {
                $sub_array = array();
                $sub_array[] = $row->cedula;
                $sub_array[] = $row->nombre;                
                $sub_array[] = $row->apellidos;
                $sub_array[] = $row->correo;


                $sub_array[] = '<button type="button" name="update" id="'.$row->cedula.'" class="btn btn-success btn-xs update glyphicon glyphicon-edit" title="Modificar" data-tooltip="tooltip"></button>
                   <button type="button" name="delete" id="'.$row->cedula.'" class="btn btn-danger btn-xs delete glyphicon glyphicon-trash" title="Eliminar" data-tooltip="tooltip"></button> 
                   
                   <button type="button" name="change_password" id="'.$row->cedula.'" class="btn btn-primary btn-xs change_password glyphicon glyphicon-lock" title="Cambiar contraseña" data-tooltip="tooltip"></button>';
                
                $datos[] = $sub_array;
                
            }

            $busqueda="";
	        if(isset($_POST["search"]["value"]))
	        {
	            if($_POST["search"]["value"]!=""){
	            	$busqueda = $_POST["search"]["value"];
	            }
	        }

            $output = array(
                "draw"              =>  intval($this->input->post("draw")),
                "recordsTotal"      =>  $filtered_rows,
                "recordsFiltered"   =>  $this->usuario_model->consultar_conteo_by_filtro($busqueda),
                "data"              =>  $datos
            );
            return $output;
	}

	//-----------------------------------------------------------------------------
	
	/**
	 * Lista de usuarios
	 * @return json
	 */
	public function listar_usuarios(){
		$data = $this->usuario_model->consultar_by_filtros();
		$output = $this->recorrer_datos($data);
		echo json_encode($output);
	}

	public function listar_id(){
		$cedula = $this->input->post("id", TRUE );
		
		if( empty( $cedula ) ){
			die( json_encode( array( 'res' => EXIT_ERROR, 'msg' => "El identificador no existe" ) ) );
		}

		$data = $this->usuario_model->buscar_usuario( $cedula );

		if( empty($data) ){
			die( json_encode( array( 'res' => EXIT_ERROR, 'msg' => "El usuario no existe" ) ) );
		}
		
		$output = array();
		$output["cedula"] = $data->cedula;
        $output["nombre"] = $data->nombre;                
        $output["apellidos"] = $data->apellidos;
        $output["correo"] = $data->correo;
		
		echo json_encode($output);
	}


	public function eliminar(){
		$cedula = $this->input->post("id", TRUE);

		if(empty($cedula)){
			die( json_encode( array( 'res' => 0, 'msg' => "El identificador no existe") ) );
		}

		$usuario_eliminado_estado = $this->usuario_model->buscar_usuario($cedula);

		if( ! $usuario_eliminado_estado){
			die( json_encode( array( 'res' => 0, 'msg' => "El usuario no existe en la base de datos") ) );
		}

		$retorno_ldap = $this->conexionldap->borrar_usuario($cedula);

		if(empty($retorno_ldap)){
			die( json_encode( array( "data" =>array(), 'res' => 0, 'msg' => "No existe ningun datos" ) ) );
		}

		$usuario_eliminado = $this->usuario_model->eliminar($cedula);

		if( empty($usuario_eliminado)){
			die( json_encode( array( 'res' => 0, 'msg' => "El usuario no se elimino de la base de datos") ) );
		}
		echo json_encode( array( 'res' => 1, 'msg' => "El usuario fue eliminado correctamente") );
	}

	protected function password_hash( $pass ){
		return password_hash($pass,PASSWORD_BCRYPT,array('cost'=>9));
	}


	public function cambiar_contrasena_general(){

		if(empty($_SESSION["cedula"])){
			die( json_encode( array( 'res' => 0, 'msg' => "Inicia sesión" ) ) );
		}

		$password_actual = $this->input->post("password_actual", TRUE);
		$password_nueva = $this->input->post("password", TRUE);

		if(empty($password_actual)){
			die( json_encode( array( 'res' => 0, 'msg' => "Por favor ingrese la contraseña actual" ) ) );
		}

		if(empty($password_nueva)){
			die( json_encode( array( 'res' => 0, 'msg' => "Por favor ingrese la nueva contraseña" ) ) );
		}

		$usuario = $this->usuario_model->buscar_usuario($_SESSION["cedula"]);

		if(empty($usuario)){
			die( json_encode( array( 'res' => 0, 'msg' => "El usuario no existe" ) ) );
		}		

		if( ! password_verify( $password_actual , $usuario->clave ) ){
			die( json_encode( array( 'res' => 0, 'msg' => "La contraseña no coincide" ) ) );	
		}

		$this->conexionldap->actualizar_clave($usuario->cedula,$password_nueva);	
		
		$password = $this->password_hash($password_nueva);

		$data = array("clave"=>$password);
		$result = $this->usuario_model->cambiar_contrasenia_by_cedula($_SESSION["cedula"],$data);
		
		if(empty($result)){
			die( json_encode( array( 'res' => 0, 'msg' => "La contraseña no se modifico de la base de datos" ) ) );
		}
		echo json_encode( array( 'res' => 1, 'msg' => "La contraseña fue modificada correctamente" ) );

	}

	public function cambiar_contrasena(){
		$cedula = $this->input->post("cedula", TRUE);
		$password = $this->input->post("password", TRUE);
		
		if( empty( $cedula ) ){
			die( json_encode( array( 'res' => 0, 'msg' => "Por favor ingrese el identificador" ) ) );
		}

		if(empty($password)){
			die( json_encode( array( 'res' => 0, 'msg' => "Por favor ingrese la contraseña" ) ) );
		}

		$usuario = $this->usuario_model->buscar_usuario($cedula);

		if(empty($usuario)){
			die( json_encode( array( 'res' => 0, 'msg' => "El usuario no existe" ) ) );
		}		


		$this->conexionldap->actualizar_clave($usuario->cedula,$password);

		$password = $this->password_hash($password);

		$data = array("clave"=>$password);
		$result = $this->usuario_model->cambiar_contrasenia_by_cedula($cedula,$data);
		
		if(empty($result)){
			die( json_encode( array( 'res' => 0, 'msg' => "La contraseña no se modifico de la base de datos" ) ) );
		}
		echo json_encode( array( 'res' => 1, 'msg' => "La contraseña fue modificada correctamente" ) );

	}

}
