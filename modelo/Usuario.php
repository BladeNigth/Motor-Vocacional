<?php
class Usuario{
   
    private $usuario;
    private $nombre;
    private $correo;
    private $foto;
    private $id_tipo;


    public function __construct()
    {

    }

    public function cargarUsuario($usuario){
        $this->nombre = $usuario["nombre"];
        $this->usuario = $usuario["usuario"];
        $this->correo = $usuario["correo"];
        $this->foto = $usuario["foto"];
        $this->id_tipo = $usuario["id_tipo"];

    }

    public function getNombre(){
		return $this->nombre;
	}

	public function setNombre($nombre){
		$this->nombre = $nombre;
	}

	public function getUsuario(){
		return $this->usuario;
	}

	public function setUsuario($usuario){
		$this->usuario = $usuario;
	}

	public function getCorreo(){
		return $this->correo;
	}

	public function setCorreo($correo){
		$this->correo = $correo;
	}

	public function getFoto(){
		return $this->foto;
	}

	public function setEdad($foto){
		$this->edad = $foto;
	}
	
	public function getId_tipo(){
		return $this->id_tipo;
	}
	public function setId_tipo($id_tipo){
		$this->id_tipo=$id_tipo;
	}
}
