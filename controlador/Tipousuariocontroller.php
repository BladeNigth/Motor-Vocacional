<?php


require_once '../modelo/database.php';
require_once '../modelo/tipo_usuario.php';

class Tipousuariocontroller{
	
	private $tipo_usuario;
	
	public function _contruct(){
		
	}
	
	public function ConexionDB(){
        
		$this->conexion = conectar();
        
		if($this->conexion == NULL){
            die('connected failed: ');
    	}
	}
	
	public function logeado(){
        if(!isset($_SESSION['tipo_user']) )
            return true;
        return false;
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
		echo $mostrar['Tipo_Usuario'];
	}
	
	
	public function Mostrarusuarios(){

		$query = $this->conexion->prepare("SELECT * FROM usuarios,tipo_usuario WHERE usuarios.usuario = tipo_usuario.nombre_usuario 
        AND Tipo_usuario != 'ADMINISTRADOR' ");
		$query->execute();
		if($query->rowCount() >= 1){
		while($row = $query->fetch(PDO::FETCH_ASSOC)){
			echo '<tr>';
			echo '<td>'.$row['Tipo_Usuario'].'</td>';
			echo '<td>'.$row['usuario'].'</td>';
			echo '<td>'.$row['nombre'].'</td>';
			echo '<td>'.$row['Correo'].'</td>';
            echo '<td>'.$row['Identificacion'].'</td>';
            echo '<td>'.$row['Telefono'].'</td>';
            echo '<td>'.$row['Sexo'].'</td>';
            echo '<td>'.$row['Fecha_de_Creacion'].'</td>';
			echo '<td align="center">';
            //echo '<form action="EditarUsuarioA.php" method="post"><button name="editar"  value="'.$row['usuario'].'"><i class="ion ion-android-create"></i></button></form>';
            //echo '<button name="eliminar"  onclick=eliminarU("'.$row['usuario'].'")><i class="ion ion-android-delete"></i></button>';
            echo '</td>';
			
			
			echo '</tr>';
		}
			
		}else{
			echo '<tr>No hay Usuario Registrados</tr>';
		}
		
	}
	public function eliminarUsuario($dato){
		$query = $this->conexion->prepare("DELETE  FROM usuarios WHERE usuario ='$dato'");
		$query->execute();
		$query1 = $this->conexion->prepare("DELETE  FROM tipo_usuario WHERE nombre_usuario ='$dato'");
		$query1->execute();
	}
	
	public function inicioTipo($username){
	
        $tipo_usuario = new Tipo_usuario();
        if(!empty($username)){
            $query = $this->conexion->prepare("SELECT tipo_usuario,nombre_usuario From tipo_usuario where nombre_usuario = '$username' and tipo_usuario = 'ADMINISTRADOR'");
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $tipo_usuario->LlenarTipousuario($result['tipo_usuario'],$result['tipo_user']);
             if($query->rowCount() >= 1){
                session_start();
                $_SESSION['tipo_user'] = $result['tipo_usuario'];
				$_SESSION['userT'] = $result['nombre_usuario'];
                $_SESSION['time_start_login'] = time();
                header('Location: ../vista/indexA.php');
             }else{
				return 1;
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
				$_SESSION['userT']=$uss;
				echo "<script>window.onload = function(){
									EditarA('los datos han sido actualizados exitosamente');
					  			}
					 </script>";
			}
			
		}
		
	}
	
	function edita($dato){
		
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
				echo "<script>window.onload = function(){
									EditarUA('los datos han sido actualizados exitosamente');
					  			}
					 </script>";
			}
			
		}
		
	}
	
	function mostrarObjetos(){
		$query = $this->conexion->prepare("SELECT * FROM objetos,tipo_objeto,estado_objeto WHERE objetos.tipo = tipo_objeto.tipo_id and objetos.estado = estado_objeto.estado_id");
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
			if($row['tipo_estado']=='tramite'){
				echo '<td><form action="Entrega.php" method="post"><button name="entrega" class="btn btn-default" value="'.$row['id'].'"><em class="dropdown-item has-icon" >Entrega</em></button></form></td>';
				
			}else if($row['tipo_estado']=='pendiente'){
				echo '<td><form action="tramite.php" method="post"><button name="tramite" class="btn btn-default" value="'.$row['id'].'"><em class="dropdown-item has-icon" >Solicitar</em></button></form></td>';
			}else{
				echo'<td>';
			}
			echo '</tr>';
		}
			
		}else{
			
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
					$us = $_SESSION["userT"];
					
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
									CambiocA('la Contraseña ha sido cambiada exitosamente');
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
	
	function RegistrarObjeto(){
		if(isset($_POST['registrarO'])){
			
			if( isset($_POST['nombre']) && isset($_POST['descrip'])&& isset($_POST['tipoO']) && isset($_POST['contacto']) ){
				//&& isset($_POST['fecha'])
				$image = $_FILES['foto']['tmp_name'];
        		$imgContent = addslashes(file_get_contents($image));
				
				$nombre = $_POST['nombre'];
				$descrip = $_POST['descrip'];
				$tipoO = $_POST['tipoO'];
				$contacto = $_POST['contacto'];
				//$fecha = $_POST['fecha'];
				
				$this->ConexionDB();
				$query = $this->conexion->prepare("INSERT INTO objetos(nombre,descripcion,tipo,foto,estado,contacto,fecha_reporte) values('$nombre','$descrip','$tipoO','$imgContent','1','$contacto',NOW())");
				
				$query->execute();
				
				echo "<script>window.onload = function(){
					  MensajeCorrecto('El Objeto ha sido Registrado');
					 }</script>";
				
				
			}
		}
	}
	
	public function Cambiarfoto(){
		if(isset($_POST['cfoto'])){
			$usr = $_SESSION['userT'];
			$image = $_FILES['foto']['tmp_name'];
        	$imgContent = addslashes(file_get_contents($image));
			
			$query= $this->conexion->prepare("UPDATE usuarios SET Foto = '$imgContent' WHERE usuario = '$usr'");
			$query->execute();
			echo "<script>window.onload = function(){
						EditarA('Se ha cambiado la Foto de perfil');
			    }</script>";
			
		}
	}
	
	public function Entregar(){
		if(isset($_POST['Entregar'])){
			$b=$_SESSION['objeto'];
			$n=$_SESSION['nombre'];
			$perf =$_SESSION['userT'];
			$t = $_SESSION['trami'];
			
			$this->ConexionDB();
	
			$query3=$this->conexion->prepare("select * from usuarios where usuario = '$perf'");
			$query3->execute();
	
			$row = $query3->fetch(PDO::FETCH_ASSOC);
			$name = $row['id_usuario'];
			$query = $this->conexion->prepare("INSERT INTO entrega(id_objeto,entregado_a,entregado_por,fecha_entrega) values('$b','$n','$name',NOW())");
			$query->execute();

			$query2 = $this->conexion->prepare("Delete FROM tramite WHERE id = '$t'");
			$query2->execute();
	
			$estado = '3';
			$query1 = $this->conexion->prepare("UPDATE objetos set estado = '$estado',fecha_reporte = NOW() WHERE id = '$b' ");
			$query1->execute();
			echo "<script>window.onload = function(){
				Mensajeo('El objeto ha Sido Entregado');
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
	
	public function reporte(){
		
		if(isset($_POST['tipoO'])){
		
		require_once('lib/pdf1/mpdf.php');
			
		$tipo = $_POST['tipoO'];
		$this->ConexionDB();
				$query = $this->conexion->prepare("SELECT * FROM objetos,tipo_objeto,estado_objeto WHERE objetos.tipo = tipo_objeto.tipo_id and objetos.estado = estado_objeto.estado_id and estado_id = '$tipo'");
				$query->execute();
				if($query->rowCount() >= 1){
				



			$html = ' 
				<main>
		
			 	
                    <h3 class="panel-title" style="center">Objetos Perdidos</h3>
              
                <table class="table table-striped table-bordered table-list">
                  <thead>
                    <tr>
                        		<th>Tipo Objeto</th>
								<th>Nombre</th>
								<th>Descripcion</th>
								<th>Estado</th>
								<th>Foto</th>
								<th>Fecha</th>
								
                    </tr> 
                  </thead>
                  <tbody>
				  
				  
				  ';

				while($row = $query->fetch(PDO::FETCH_ASSOC)){
				 $foto = base64_encode($row['foto']);			
		$html .= '
                          <tr>
							 <td>'.$row['tipo_objeto'].'</td>
							 <td>'.$row['nombre'].'</td>
							 <td>'.$row['descripcion'].'</td>
							 <td>'.$row['tipo_estado'].' </td>
							 <td><img height="50px" src="data:image/jpg;base64,'.$foto.'" ></td>
                            <td>'.$row['fecha_reporte'].'</td>
                          </tr>
						   
						   
				';	
				
				}
            $html .= '            </tbody>
                </table>
            
             
         
			</main>';


			$mpdf = new mPDF('c', 'A4');
			$css = file_get_contents('css/pdf.css');
			$mpdf->WriteHTML($css,1);
			$mpdf->WriteHTML($html);
			$mpdf->Output('reporte.pdf', 'I');
			
					}else{
						echo 		"<script>window.onload = function(){
									MensajeErrorR('no hay objetos perdidos para generar un reporte');
					  				}</script>";
					}
		}
	}
	
	public function graficasP(){
		
		if(isset($_POST['grafico'])){
		$fecha_inicial=$_POST['fechai'];
		$fecha_final=$_POST['fechaf'];
		
		$query = $this->conexion->prepare("SELECT COUNT(id) as cantidad ,estado FROM objetos WHERE  fecha_reporte BETWEEN '$fecha_inicial' AND '$fecha_final' group by estado");
		$query->execute();
		
		 while($row = $query->fetch(PDO::FETCH_ASSOC)){
			 
			 if($row['estado']=='1'){
				$info_usuario = [];
                array_push($info_usuario,$row['cantidad']);
                array_push($info_usuario,'pendiente');
			 }
		 }
			return $info_usuario;
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