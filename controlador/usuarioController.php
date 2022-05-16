<?php
require_once  "../modelo/database.php";
require_once  "../modelo/usuario.php";
require_once  "../controlador/Tipousuariocontroller.php";

class usuarioController{
    private $usuario;
    public function __construct()
    {
        
    }
   
    public function ConexionDB(){
        $this->conexion = conectar();
        if($this->conexion == NULL){
            die('connected failed: ');
    	}
	}
	public function foto($uss){
		$this->ConexionDB();
		$query = $this->conexion->prepare("SELECT Foto FROM usuarios WHERE usuario = '$uss'");
		$query->execute();
		$mostrar = $query->fetch(PDO::FETCH_ASSOC);
		$foto = base64_encode($mostrar['Foto']);
			echo '<img alt="image" src="data:image/jpg;base64,'.$foto.'">';
		
	}
	public function saberTipoU($uss){
		$query = $this->conexion->prepare("SELECT Tipo_Usuario FROM tipo_usuario where nombre_usuario = '$uss'");
		$query->execute();
		$mostrar = $query->fetch(PDO::FETCH_ASSOC);
		//echo $mostrar['Tipo_Usuario'];
		echo $mostrar['Tipo_Usuario'];
	}
	
    public function datosRegistro(){
        if(isset($_POST['registro'])){
            if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['nombre']) && 
                isset($_POST['pass']) && isset($_POST['telefono']) && isset($_POST['identificacion']) 
				&& isset($_POST['sexo']))
            {				
				
                $info_usuario = [];
                array_push($info_usuario,$_POST['username']);
				array_push($info_usuario,$_POST['pass']);
                array_push($info_usuario,$_POST['nombre']);
				array_push($info_usuario,$_POST['email']);
				array_push($info_usuario,$_POST['telefono']);
				array_push($info_usuario,$_POST['sexo']);
				array_push($info_usuario,$_POST['identificacion']);
                $this->Registrar($info_usuario);
            }
        }
    }

    public function Registrar($informacion){
		require 'phpqrcode/qrlib.php';
        $username= $informacion[0];
        $clave = $informacion[1];
		$nombre = $informacion[2];
		$email = $informacion[3];
		$telefono = $informacion[4];
		$sexo = $informacion[5];
		$identificacion = $informacion[6];
		
		

            $query = "Select * from usuarios where usuario = ?";
            $query = $this->conexion->prepare($query);
            $query->execute(array($username));

            if($query->rowCount() >= 1){
               echo "<script>window.onload = function(){
					MensajeError('el Usuario ya existe');
					}</script>";
            }
            else{
                
                $query = "insert into usuarios(usuario,password,nombre,Correo,Telefono,Sexo,Identificacion,Profesiones_IDprofesion)
				 values ('$username','$clave','$nombre','$email','$telefono','$sexo','$identificacion','2')";
                $this->conexion->exec($query);
                $user='USUARIO';
				$query1 = $this->conexion->prepare("insert into tipo_usuario(Tipo_usuario,nombre_usuario) values('$user','$username')");
				$query1->execute();
				
				
				echo "<script>window.onload = function(){
					  MensajeCorrecto('El Usuario ha sido Registrado');
					 }</script>";
            	}
    }
	
	public function enviarqr($correo,$nombre){
		
		require("class.phpmailer.php");
		require("class.smtp.php");
		$mail = new PHPMailer();
		$mail->Host = "smtp.gmail.com";
		$mail->SMTPAuth= true;
		$mail->SMTPSecure = "tls";
		$mail->Port = "587";
		
		$mail->Username = "proyectosobjetosperdidos@gmail.com";
		$mail->Password = "1083040640";
		
		$mail->From = "proyectosobjetosperdidos@gmail.com";
		$mail->FromName = "Andres Brieva";
		$mail->addAddress($correo,$nombre);
		$mail->Subject = "Codigo QR para Iniciar Sesion Web Objetos perdidos";
		$mail->IsHTML(false);
		$mail->AltBody = "en este correo estara adjunto el Codigo QR para iniciar en la pagina Web Objetos perdidos ";
		$mail->Body = "en este correo estara adjunto el Codigo QR para iniciar en la pagina Web Objetos perdidos ";
		
		$mail->addAttachment('images/qrcode.png','qrcode.png');
		
		$mail->send();
		
		
	}

    public function logeado(){
        if(!isset($_SESSION['user']) )
            return true;
        return false;
    }

    public function datosLogin(){
        if(isset($_POST['login'])){
            if(isset($_POST['username']) && isset($_POST['pass']))
            $info_usuario = [];
            array_push($info_usuario,$_POST['username']);
            array_push($info_usuario,$_POST['pass']);
            $this->iniciarSesion($info_usuario);
        }
    }

	
	public function mostrarPerfl($perfil){
		
		$query = $this->conexion->prepare("SELECT * FROM usuarios WHERE usuario = '$perfil' ");
		$query->execute();
		$mostrar = $query->fetch(PDO::FETCH_ASSOC);
			if($query->rowCount() >= 1){
						echo '<strong> Usuario: </strong>'.$mostrar['usuario'].'<br>';
						echo '<strong> Nombre: </strong>'.$mostrar['nombre'].'<br>';
						echo '<strong> Correo: </strong>'.$mostrar['correo'].'<br>';
						echo '<strong> Estatus: </strong>'.$mostrar['estatus'].'<br>';
			}
	}

	public function cambiarcontra(){
			
		 if(isset($_POST['ccontra'])){
			 
		 		if(isset($_POST['passv']) && isset($_POST['passn']) && isset($_POST['confirm']) ){
                	$info_usuario = [];
               		$passv=$_POST['passv'];
                	$passn=$_POST['passn'];
                	$confirm=$_POST['confirm'];
					$us = $_SESSION["user"];
					
					if($passv != $passn){
						
					if($passn === $confirm){
            			
						$query = "select usuario,password from usuarios where usuario = '$us' and password = '$passv'";
						$query = $this->conexion->prepare($query);
						$query->execute();
						
						
						 if($query->rowCount() >= 1){
               				try{
								$query = "UPDATE usuarios SET password = '$passn' WHERE usuario = '$us' and  password = '$passv'";
            					$query = $this->conexion->prepare($query);
            					$query->execute();
								echo "<script>window.onload = function(){
									Cambioc('la Contraseña ha sido cambiada exitosamente');
					  				}</script>";
							}catch(PDOException $error){
								print 'error:'.$error->getMessage();
								echo 'error';
								
							}
            			}else{
							
							 echo "<script>window.onload = function(){
									MensajeError('la Contraseña actual es incorrecta');
					  				}</script>";
						 }
					}else{
						echo "<script>window.onload = function(){
						MensajeError('la contraseña nueva no coincide');
					  }</script>";
					}
					}else{
						echo "<script>window.onload = function(){
						MensajeError('la contraseña nueva no puede ser igual a la actual');
					  }</script>";
					}
				}
		 }
		
	}
	
	public function tipouser($username){
			$t = new Tipousuariocontroller();
			$t->ConexionDB();
			$tipo = $t->inicioTipo($username);
		return $tipo;
	}
	
    public function iniciarSesion($informacion){
        $username = $informacion[0];
        $clave =$informacion[1];
       // $usuario = new Usuario();
        if(!empty($usuario) || !empty($clave)){
            $query = $this->conexion->prepare("SELECT usuario,password FROM usuarios WHERE usuario=:username and password= :password");
			$query->bindParam(':username', $username);
			$query->bindParam(':password',$clave);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
			
            //$usuario->LlenarUsuario($result['nombre_usuario'],$result['clave'],$result['email'],$result['sexo'],$result['nombre_usuario']);
            

			if($query->rowCount() >= 1){
					
				$tipo=$this->tipouser($username);
				
				if($tipo===1){
					session_start();
                	$_SESSION['user'] = $username;
					//$_SESSION['nombre'] = $result;
                	$_SESSION['time_start_login'] = time();
                	header('Location: ../vista/index.php');
				}
			}
            else{
				//$error="usuario o contraseña incorrecta";
				echo "<script>window.onload = function(){
						MensajeError('usuario o contraseña incorrecta');
					  }</script>";
            }
        
        } 
    }     
    
    public function cerrarSesion($nombreBoton){
        if(isset($_POST[$nombreBoton]))
        {
            // remove all session variables
            session_unset();

            // destroy the session
            session_destroy();
            header('Location: ../vista/login.php');
        }
    }
	
	
	public function editar($dato){
		
		$query = $this->conexion->prepare("SELECT * From usuarios where usuario = '$dato'");
        $query->execute();
		$mostrar = $query->fetch(PDO::FETCH_ASSOC);
			if($query->rowCount() >= 1){
					echo '<div class="form-group col-6">
                      		<label for="frist_name">Usuario</label>
						<input class="form-control" type="text" name="username" placeholder="Usuario" value="'.$mostrar['usuario'].'">
						</div>

					<div class="form-group col-6">
                      		<label for="frist_name">Nombre y Apellidos</label>
						<input class="form-control" type="text" name="nombre" placeholder="Nombre Completo"
						value="'.$mostrar['nombre'].'">
					</div>
					
					<div class="form-group col-6">
                      		<label for="frist_name">Correo</label>
						<input class="form-control" type="email" name="email" placeholder="Correo"
						value="'.$mostrar['correo'].'">
					</div>
							
					<div class="form-group col-6">
                      		<label for="frist_name">Estatus</label>
							<select class="form-control" name="estatus">
  								<option value="'.$mostrar['estatus'].'">ACTIVO</option>
  								<option value="INACTIVO">INACTIVO</option>
							</select>
					</div>
					
					<input style="visibility: hidden" name="editar" value = "'.$dato.'">'
					;
					
			}
	}
	
	function edit($dato){
		
		$this->ConexionDB();
		if(isset($_POST['edita'])){
			
			
			$uss=$_POST['username'];
			$name=$_POST['nombre'];
			$emeil=$_POST['email'];
			$edad=$_POST['estatus'];
			
			
			$query = $this->conexion->prepare("SELECT * From usuarios where usuario = '$uss'");
        	$query->execute();
			if($query->rowCount() >= 1){
				echo "<script>window.onload = function(){
					MensajeError('el Usuario ya existe');
					}</script>";
			}else{
				
				$query1=$this->conexion->prepare("UPDATE usuarios SET usuario='$uss',nombre='$name',correo='$emeil',estatus='$edad' WHERE usuario = '$dato' ");
				$query1->execute();
				$query2=$this->conexion->prepare("UPDATE tipo_usuario SET nombre_usuario='$uss' where nombre_usuario= '$dato' ");
				$query2->execute();	
				$_SESSION['user']=$uss;
				echo "<script>window.onload = function(){
									EditarU('los datos han sido actualizados exitosamente');
					  			}
					 </script>";
			}
			
		}
		
	}
	
	function mostrarObjetos(){
		$query = $this->conexion->prepare("SELECT * FROM objetos,tipo_objeto,estado_objeto WHERE objetos.tipo = tipo_objeto.tipo_id and objetos.estado = estado_objeto.estado_id and tipo_estado!='tramite' && tipo_estado!='entregado'");
		$query->execute();
		if($query->rowCount() >= 1){
		while($row = $query->fetch(PDO::FETCH_ASSOC)){
			echo '<tr>';
			echo '<td>'.$row['id'].'</td>';
			echo '<td>'.$row['tipo_objeto'].'</td>';
			echo '<td>'.$row['nombre'].'</td>';
			echo '<td>'.$row['descripcion'].'</td>';
			echo '<td>'.$row['tipo_estado'].'</td>';
			$foto = base64_encode($row['foto']);
			echo '<td><img height="50px" src="data:image/jpg;base64,'.$foto.'" >';
			echo '</td>';
			echo '<td>'.$row['fecha_reporte'].'</td>';
			if($row['tipo_estado']=='pendiente'){
				echo '<td><form action="tramiteU.php" method="post"><button name="tramite" class="btn btn-default" value="'.$row['id'].'"><em class="dropdown-item has-icon" >Solicitar</em></button></form></td>';
			}
			echo '</tr>';
		}
			
		}else{
			
		}
	}
	
	
	function RegistrarObjeto(){
		if(isset($_POST['registrarO'])){
			
			if( isset($_POST['nombre']) && isset($_POST['descrip'])&& isset($_POST['tipoO']) && isset($_POST['contacto']) ){
				//isset($_POST['fecha'])
				$image = $_FILES['foto']['tmp_name'];
        		$imgContent = addslashes(file_get_contents($image));
				
				$nombre = $_POST['nombre'];
				$descrip = $_POST['descrip'];
				$tipoO = $_POST['tipoO'];
				$contacto = $_POST['contacto'];
				//$fecha = $_POST['fecha'];
				$this->ConexionDB();
				$query = $this->conexion->prepare("INSERT INTO objetos(nombre,descripcion,tipo,foto,estado,contacto,fecha_reporte) values('$nombre','$descrip','$tipoO','$imgContent','1','$contacto',NOW() )");
				
				$query->execute();
				
				echo "<script>window.onload = function(){
					  MensajeCorrecto('El objeto ha sido Registrado');
					 }</script>";
				
				
			}
		}
	}
	
	function recordar(){
		if(isset($_POST['recordar'])){
			
			$usr= $_POST['username'];
			$mail = $_POST['Email'];
			
			
			$query= $this->conexion->prepare("SELECT * FROM usuarios WHERE usuario = '$usr'");
			$query->execute();
			if($query->rowCount() >= 1){
				
				$query1= $this->conexion->prepare("SELECT * FROM usuarios WHERE usuario = '$usr' and correo = '$mail'");
				$query1->execute();
				$mostrar = $query1->fetch(PDO::FETCH_ASSOC);
				if($query1->rowCount() >= 1){
					
				$asunto = "Recordar Contraseña Pagina Objetos Perdidos";
				
			    $contenido = "el Usuario ".$usr." Ha solicitado recordar su contraseña. \nSu Contraseña es: ".$mostrar['password'];
					mail($mail,$asunto,$contenido);
					echo "<script>window.onload = function(){
						MensajeCorrecto('Se ha enviado su contraseña Correctamente');
					  }</script>";
				}else{
					echo "<script>window.onload = function(){
						MensajeError('el Correo Ingresado no concuerda con el Usuario ');
					  }</script>";
				}
				
			}else{
				echo "<script>window.onload = function(){
						MensajeError('el Usuario ingresado no existe');
					  }</script>";
			}
		
		}
    
	}
	
	public function Cambiarfoto(){
		if(isset($_POST['cfoto'])){
			$usr = $_SESSION['user'];
			$image = $_FILES['foto']['tmp_name'];
        	$imgContent = addslashes(file_get_contents($image));
			
			$query= $this->conexion->prepare("UPDATE usuarios SET Foto = '$imgContent' WHERE usuario = '$usr'");
			$query->execute();
			echo "<script>window.onload = function(){
						EditarU('Se ha cambiado la Foto de perfil');
			    }</script>";
			
		}
	}
	
	public function tramite(){
		
		if(isset($_POST['Tramite'])){
			
			$b=$_SESSION['objeto'];
			$n=$_SESSION['nombre'];
			$this->ConexionDB();
	
			$query = $this->conexion->prepare("UPDATE objetos SET estado = '2',fecha_reporte= NOW() WHERE id = '$b' ");
			$query->execute();
	
			$query2 = $this->conexion->prepare("INSERT INTO tramite(id_objeto,id_usuario,fecha) values('$b','$n',NOW())");
			$query2->execute();

			if(isset($_SESSION['userT'])){
				echo "<script>window.onload = function(){
						MensajetA('El objeto ha sido puesto en tramite');
					}</script>";
			}else{
				echo "<script>window.onload = function(){
					MensajetU('El objeto ha sido puesto en tramite');
				}</script>";
			}
		}
	}

	public function mostrarNombre($nu){
		$this->ConexionDB();
		$query = $this->conexion->prepare("SELECT nombre FROM usuarios WHERE usuario = '$nu'");
		$query->execute();
		$mostrar = $query->fetch(PDO::FETCH_ASSOC);
		echo $mostrar['nombre'];
	
	}

}

?>