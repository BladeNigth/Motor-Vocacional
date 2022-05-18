<?php


	require '../controlador/Tipousuariocontroller.php';
	session_start();
	$tipo_usuario = new Tipousuariocontroller();
	if(!$tipo_usuario->logeado()){
		$tipo_usuario->cerrarSesion('cerrarSesion');		
	}else{
		header('Location: login.php');
	}
	$perf = "";
	$perf =$_SESSION['userT'];
	
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" name="viewport">
  <title>Inicio</title>
  <link rel="stylesheet" href="css/local.css">

  <link rel="stylesheet" href="dist/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="dist/modules/ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/modules/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css">

  <link rel="stylesheet" href="dist/modules/summernote/summernote-lite.css">
  <link rel="stylesheet" href="dist/modules/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="dist/css/demo.css">
  <link rel="stylesheet" href="dist/css/style.css">
	
	
</head>

<body>
<div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          
        </form>
        <ul class="navbar-nav navbar-right">
          
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg">
            <i class="ion ion-android-person d-lg-none"></i>
            <div class="d-sm-none d-lg-inline-block"><?php echo $perf;?></div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="profileA.php" class="dropdown-item has-icon">
                <i class="ion ion-android-person"></i> Perfil
              </a>
				
				<form method="post">
              <button class="dropdown-item has-icon" name="cerrarSesion" id="cerrarSesion" type="submit" value="send" >
                <i class="ion ion-log-out"></i> Cerrar Sesion
              </button>
				</form>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="indexA.php">Motor Vocacional</a>
          </div>
          <div class="sidebar-user">
            <div class="sidebar-user-picture">
             <?php
					//$tipo_usuario->foto($perf);
            	?>
            </div>
            <div class="sidebar-user-details">
              <div class="user-name"><?php 
              $tipo_usuario->mostrarNombre($perf);
              //echo $perf;?></div>
              <div class="user-role">
               <?php
				  $tipo_usuario->ConexionDB();
				  $tipo_usuario->saberTipoU($perf); 
			   ?>
              </div>
            </div>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Principal</li>
            <li id = "indexA">
              <a href="indexA.php"><i class="ion ion-home"></i><span>Guia Vocacional</span></a>
            </li>
            <li  id = "procesoA">
              <a href="procesoA.php"><i class="ion ion-pause"></i><span>Proceso Vocacional</span></a>
            </li>
            <li class="menu-header">Opciones</li>
            <li id = "listauA">
            <a href="listauA.php" ><i class="ion ion-ios-albums-outline"></i><span>Lista De Usuarios</span></a>
            </li>
          </ul>
        </aside>
      </div>
      <div class="main-content">
            <section class = "section">
                <h1 class="section-header">
            	    <div>Lista de Usuarios</div>
         	    </h1>
                <div class="card-body">
                    <div class="card" >
                        <div class="col-md-12">
                            <div class="tile">
                                <div class="tile-body">
                                    <table class="table table-hover table-bordered" id="sampleTable">
                                        <thead>
                                        <tr>
                                            <th>Tipo Usuario</th>
                                            <th>Usuario</th>
                                            <th>Nombre</th>
                                            <th>Correo</th>
                                            <th>Identificacion</th>
                                            <th>Telefono</th>
                                            <th>Sexo</th>
                                            <th>Creacion</th>
                                            <!--<th> <i class="ion ion-gear-b"></i></th>Eliminar Editar-->
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                      $tipo_usuario->Mostrarusuarios();

                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2022 <div class="bullet"></div> Design By <a>Andres Brieva/Jose Cantillo</a>
        </div>
        <div class="footer-right"></div>
      </footer>
    </div>
  </div>

  <script src="dist/modules/jquery.min.js"></script>
  <script src="dist/modules/popper.js"></script>
  <script src="dist/modules/tooltip.js"></script>
  <script src="dist/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="dist/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="dist/modules/scroll-up-bar/dist/scroll-up-bar.min.js"></script>
  <script src="dist/js/sa-functions.js"></script>
  
  <script src="dist/modules/chart.min.js"></script>
  <script src="dist/modules/summernote/summernote-lite.js"></script>
  <script>


    let url = window.location.href;

//Elementos de li
  const tabs = ["indexA","procesoA","listauA"];
  tabs.forEach(e => {
    // Agregar .php y ver si lo contiene en la url
   if (url.indexOf(e+".php") !== -1) {
       /// Agregar tab- para hacer que coincida la Id
       setActive(e);
    }

  });

  /// Funcion que asigna la clase active
  function setActive(id) {
     document.getElementById(id).setAttribute("class", "active");
  }
 
 </script>
</body>
</html>