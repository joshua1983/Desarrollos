<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario_model extends CI_Model {

    public $id;
    public $cedula;
    public $nombre;
    public $apellidos;
    public $correo;
    public $suscripcion;
    public $clave;

    public function __construct()
    {
        parent::__construct();
    }

    public function buscar_usuario($cedula){
        $this->db->where('cedula', $cedula);
        $query = $this->db->get('usuario')->row();
        return $query;
    }

    public function buscar_correo($correo){
        $this->db->where('correo', $correo);
        $query = $this->db->get('usuario')->row();
        return $query;
    }

    public function crear_usuario($cedula, $nombre, $apellidos, $correo, $suscripcion, $clave){
        $this->cedula = $cedula;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->correo = $correo;
        $this->suscripcion = $suscripcion;
        $this->clave = $clave;

        $this->db->insert('usuario', $this);
    }

    public function get_productos($uid){
        
    }

    public function actualizar_usuario($cedula,$data)
    {
        $this->db->where('cedula', $cedula);
        return $this->db->update('usuario', $data);
    }

    //-----------------------------------------------------------------------------
    /**
     * Consultar el conteo de los usuarios con o sin filtro.
     * @param  string  $busqueda Almacena la busqueda del usuario
     * @return integer          El número de filas contadas.
     */
    public function consultar_conteo_by_filtro($busqueda){

        $consulta = "select u.* from usuario as u ";
        if( ! empty($busqueda)){
            $consulta .= "where (u.nombre LIKE '%".$busqueda."%' or u.apellidos LIKE '%".$busqueda."%' or u.correo LIKE '%".$busqueda."%' or u.cedula LIKE '%".$busqueda."%')";
        }

        $query = $this->db->query($consulta);            
        return $query->num_rows();
    }

    //-----------------------------------------------------------------------------
    /**
     * Consultar los usuarios registrados
     * @return array           con el resultado de los usuarios
     */
    public function consultar_by_filtros(){
        $query = '';
        $output = array();
        $query .= "select u.* from usuario as u ";
        if(isset($_POST["search"]["value"]))
        {
            if($_POST["search"]["value"]!=""){
                $query .= 'where (u.nombre LIKE "%'.$_POST["search"]["value"].'%" ';
                $query .= 'or u.apellidos LIKE "%'.$_POST["search"]["value"].'%" ';
                $query .= 'or u.correo LIKE "%'.$_POST["search"]["value"].'%" ';
                $query .= 'or u.cedula LIKE "%'.$_POST["search"]["value"].'%") ';
            }
        }

        
        $query .= 'ORDER BY id DESC ';
    
        if($_POST["length"] != -1)
        {
            $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
        }

        $result = $this->db->query($query);
        return $result->result();
    }

    public function eliminar($cedula){
        return $this->db->delete('usuario', array('cedula' => $cedula));           
    }

     public function cambiar_contrasenia_by_cedula($cedula,$data){
        $this->db->where('cedula', $cedula);
        return $this->db->update('usuario', $data);
    }

}

?>