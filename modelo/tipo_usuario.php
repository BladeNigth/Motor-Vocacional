<?php
class Tipo_usuario{
    private $nombre_user;
    private $tipo_user;

    public function __construct()
    {
        $this->nombre_user = "";
        $this->tipo_user = "";
    }
    
    public function LlenarTipousuario($nombre_user,$tipo_user){
        $this->tipo_user = $tipo_user;
        $this->user = $nombre_user;  
    }
    
    public function getTipo_user(){
        return $this->tipo_user;
    }
}

?>