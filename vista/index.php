<?php


	require '../controlador/usuarioController.php';
	session_start();
	$usuario = new usuarioController();
	if(!$usuario->logeado()){
   		 $usuario->cerrarSesion('cerrarSesion');
	}
	else{
   	 	header('Location: login.php');
	}
	$perf = "";
	$perf =$_SESSION["user"];
	
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" name="viewport">
  <title>Inicio</title>

  <link rel="stylesheet" href="dist/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="dist/modules/ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/modules/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css">

  <link rel="stylesheet" href="dist/modules/summernote/summernote-lite.css">
  <link rel="stylesheet" href="dist/modules/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="dist/css/demo.css">
  <link rel="stylesheet" href="dist/css/style.css">
  <link rel="stylesheet" href="css/local.css">
	
	
</head>

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
            	?>
            </div>
            <div class="sidebar-user-details">
              <div class="user-name"><?php 
              $usuario->mostrarNombre($perf);
              //echo $perf;?></div>
              <div class="user-role">
               <?php
				  $usuario->ConexionDB();
				  $usuario->saberTipoU($perf); 
			   ?>
              </div>
            </div>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Principal</li>
            <li id = "index">
              <a href="index.php"><i class="ion ion-home"></i><span>Guia Vocacional</span></a>
            </li>
            <li  id = "proceso">
              <a href="proceso.php"><i class="ion ion-pause"></i><span>Proceso Vocacional</span></a>
            </li>
          </ul>
        </aside>
      </div>
      <div class="main-content">
          <section class = "section">
          <h1 class="section-header">
            	<div>Guia Vocacional</div>
         	</h1>  
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
  const tabs = ["index","proceso"];

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