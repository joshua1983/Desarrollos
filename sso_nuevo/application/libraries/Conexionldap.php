<?php


class Conexionldap{

    /*
    * Libreria para el manejo de las conexiones 
    * al LDAP de VerioWeb
    */


    var $DN = 'ou=users,dc=vanguardia,dc=com';
    var $ADMIN_USER = 'cn=Manager,dc=vanguardia,dc=com';
    var $SERVIDOR = '209.207.216.68';

    /*
    * Busca un usuario en el LDAP en el arbol base
    * con el uid especificado
    */

    public function buscar_usuario($uid){
        $ds = ldap_connect($this->SERVIDOR);
        if ($ds){
            ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
            $r = ldap_bind($ds);
            $filtro = '(uid='.$uid.')';
            $sr = ldap_search($ds, $this->DN, $filtro );
            $info = ldap_get_entries($ds, $sr);
            return ($info["count"] > 0);
        }else{
            return false;
        }       
    }

    /*
    * Valida un usuario contra el LDAP
    * Recibe usuario y contraseña en texto plano
    */
    public function validar_usuario($usuario, $clave){
        $ds = ldap_connect($this->SERVIDOR);
        if ($ds){
            ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
            $r = ldap_bind($ds);
            $filtro = '(cn='.$usuario.')';
            $sr = ldap_search($ds, $this->DN, $filtro );
            $info = ldap_get_entries($ds, $sr);
            if ($info["count"] > 0){
                $usuario = 'cn='.$usuario.','.$this->DN;
                $r2 = @ldap_bind($ds,$usuario,$clave);
                if ($r2){
                    ldap_close($ds);
                    return 1;
                }else{
                    ldap_close($ds);
                    return "Usuario y contraseña no valido";
                }
            }else{
                ldap_close($ds);
                return "Usuario no encontrado";
            }
        }else{
            return "No se pudo conectar";
        }     
    }

    /**
    * Funcion para registrar un usuario en el LDAP.
    * Primero se registra en la base de datos MySQL
    * y se le manda el identificador y la clave para que
    * sea creado en el LDAP
    * @return int
    */
    public function registrar_usuario($usuario, $correo, $clave, $nombre, $apellidos){
        
        $ds = ldap_connect($this->SERVIDOR);  
        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
        if ($ds) {

            // buscar el usuario antes de agregarlo
            
            if (!$this->buscar_usuario($usuario)){
                // Asociar con el dn apropiado para dar acceso de actualización
                $r = ldap_bind($ds, $this->ADMIN_USER, "secret");

                

                // Preparar los datos
                $info["cn"] = $usuario;
                $info["sn"] = $apellidos;
                $info["displayName"] = $nombre . " ". $apellidos;
                $info["objectclass"] = "inetOrgPerson";
                $info["mail"] = $correo;
                //$info['userPassword'] = "123";
                $info['userPassword'] = '{MD5}' . base64_encode(pack('H*',md5($clave)));

                // Agregar datos al directorio
                $r = ldap_add($ds, "cn=".$usuario.", ou=users, dc=vanguardia, dc=com", $info);

                ldap_close($ds);
                return 1;
            }else{
                $this->borrar_usuario($usuario);
                return "El usuario ya existe";
            }
            
        } else {
            return "No se pudo conectar al servidor LDAP";
        }
    }

    /*
    * Actualiza la clave del usuario en LDAP, se necesita
    * el uid del usuario en el ldap, usualmente es el 
    * correo
    */
    public function actualizar_usuario($uid, $correo, $nombre, $apellidos){
        $ds = ldap_connect($this->SERVIDOR);  
        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
        if ($ds) {
            // Asociar con el dn apropiado para dar acceso de actualización

            $r = ldap_bind($ds);
            $filtro = '(cn='.$uid.')';
            $sr = ldap_search($ds, $this->DN, $filtro );
            $info = ldap_get_entries($ds, $sr);
            if ($info["count"] > 0){
                
                $usuario = 'cn='.$uid.','.$this->DN;
                $r = ldap_bind($ds, $this->ADMIN_USER, "secret");

                $nombre_completo = $nombre . " " . $apellidos;

                // encriptar la clave
                $newEntry = array('sn' => $nombre, "displayName"=> $nombre_completo, "mail"=>$correo );
                // Modificar datos del directorio
                
                $r2 = ldap_mod_replace($ds,$usuario,$newEntry);
                if ($r2){

                    $data_resultado = array("msg" => "El usuario si existe", "res" => 1);
                    return $data_resultado;
                }else{
                    ldap_close($ds);
                    $data_resultado = array("msg" => "No se ingreso los datos", "res" => 0);
                    return $data_resultado;
                }

            }else{
                ldap_close($ds);
                $data_resultado = array("msg" => "Usuario no encontrado", "res" => 0);
                return $data_resultado;
            }            
            
        } else {
            $data_resultado = array("msg" => "No se pudo conectar al servidor LDAP", "res" => 0);
            return $data_resultado;
        }
    }


    public function actualizar_clave($uid, $clave){
        $ds = ldap_connect($this->SERVIDOR);  
        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
        if ($ds) {
            // Asociar con el dn apropiado para dar acceso de actualización

            $r = ldap_bind($ds);
            $filtro = '(cn='.$uid.')';
            $sr = ldap_search($ds, $this->DN, $filtro );
            $info = ldap_get_entries($ds, $sr);
            if ($info["count"] > 0){
                $usuario = 'cn='.$uid.','.$this->DN;
                $r = ldap_bind($ds, $this->ADMIN_USER, "secret");

                // encriptar la clave
                $newEntry = array('userpassword' => "{MD5}".base64_encode(pack("H*",md5($clave))));
                // Modificar datos del directorio
                
                $r2 = ldap_mod_replace($ds,$usuario,$newEntry);
                if ($r2){
                    ldap_close($ds);
                    return 1;
                }else{
                    ldap_close($ds);
                    return "Usuario y contraseña no valido";
                }
            }else{
                ldap_close($ds);
                return "Usuario no encontrado";
            }            
            
        } else {
            return "No se pudo conectar al servidor LDAP";
        }
    }

    public function borrar_usuario($uid){
        $ds = ldap_connect($this->SERVIDOR);  
        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
        if ($ds) {
            // Asociar con el dn apropiado para dar acceso de actualización
            $r = ldap_bind($ds, $this->ADMIN_USER, "secret");
            // Agregar datos al directorio
            $r = ldap_delete($ds, "cn=".$uid.", ".$this->DN);
            
            ldap_close($ds);
            return 1;
        } else {
            return "No se pudo conectar al servidor LDAP";
        }
    }
}

?>