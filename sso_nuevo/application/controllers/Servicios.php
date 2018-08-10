<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicios extends CI_Controller {

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

    public function decript(){
        $clave_secreta = "AA8BsDkrAEPa3Ldh";
        $iv = '12345678';
        $txt = $this->input->post('txt');
        $texto = mcrypt_decrypt (MCRYPT_BLOWFISH, $clave_secreta, base64_decode($txt), MCRYPT_MODE_CBC, $iv );
        print_r($texto);
    }
    
    public function getentitlements($user = null, $password=null, $device=null){

        $usuarioInvalido = false;

        $usuario = $this->usuario_model->buscar_usuario($user);
        $usuarioInvalido = ($usuario == null);
        $validacion = $this->conexionldap->validar_usuario($user, $password);
        


        $this->output->set_content_type('text/xml');

        $mensaje = '-';


        $encabezado = '<?xml version="1.0" encoding="UTF-8" ?> <!DOCTYPE plist PUBLIC "" "http://www.apple.com/DTDs/PropertyList-1.0.dtd"> ';
        $respuesta = '<plist version="1.0"> <dict> ';

        $cedula = "830509981";

        $client = new SoapClient("http://200.6.167.186:8086/WSVerificarSuscriptor/SuscripcionPremium.asmx?WSDL");
        $something =  $client->RevisarEstadoClienteCedulaXDoc (array("usuarioAcceso" => "ldap", "claveAcceso" => "p-%{@t85", "DocIdSuscriptor" => $cedula));
        $cadena_datos =  $something->RevisarEstadoClienteCedulaXDocResult->string[0];

        $datos = new SimpleXMLElement($cadena_datos);
        $verificacion = $datos->Verificacion;

        
        if (isset($verificacion->BeneficioDigital ) && $validacion==1 && $usuarioInvalido == false){
            // Tiene epaper y es usuario valido
            $beneficio = $verificacion->BeneficioDigital;
            $mensaje = 'Suscripcion activa a '.$beneficio;

            if ($beneficio == 'EPAPER'){
                $respuesta .= '<key>code</key> <string>OK</string> ';
                $respuesta .= '<key>msg</key> <string>'.$mensaje.'</string> ';
                $productos =  '<array>';
                $productos .= '<string>Vanguardia</string>';
                $productos .= '</array>';
                $respuesta .= '<key>output</key> '. $productos;
            }
        }else{
            if ($validacion==1 && usuarioInvalido == false){
                $mensaje = 'Su suscripción a caducado. Llame al SAT para renovar su suscripción';
            }else{
                $mensaje = 'Usuario o contraseña invalida. Intente de nuevo';
            }
            
            $respuesta .= '<key>code</key> <string>KO</string> ';
            $respuesta .= '<key>msg</key> <string>'.$mensaje.'</string> ';
        }

        $respuesta .= ' </dict></plist>';

        $xml = $encabezado . $respuesta;

        if ($usuarioInvalido == false){

            /*
            * Crear la Cookie para el e-paper
            Nombre_valor|Apellidos_valor|idusuario_valor|nombre_publicacion1_valor=fecha_caducidad1;
            nombre_publicacion2_valor=fecha_caducidad2;nombre_publicación3_valor=fecha_caducidad3;
            nombre_publicación4_valor=fecha_caducidad4|Redireccion_URL|Firma_valor
            */
            $clave_secreta = "AA8BsDkrAEPa3Ldh";

            $cadena_cookie = $usuario->nombre;
            $cadena_cookie .= "|".$usuario->apellidos;
            $cadena_cookie .= "|".$user;
            $cadena_cookie .= "|vanguardia=01012020";
            $cadena_cookie .= "|http://digitales.vanguardia.com";

            $firma_cookie = md5($cadena_cookie);

            $datos_firma = $cadena_cookie ."|". $firma_cookie. "|". time();
            
            $iv = '12345678'; 

            $enc = mcrypt_encrypt(MCRYPT_TRIPLEDES , $clave_secreta, $datos_firma, MCRYPT_MODE_CBC, $iv); 

            setrawcookie ("evanguardia",  base64_encode( $enc )  ,0);
            setcookie("evanguardiaPlano", $cadena_cookie ,0);
            
            
        }


        echo $xml;
    }


			


}
