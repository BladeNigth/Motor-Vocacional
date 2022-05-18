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

  <link rel="stylesheet" href="dist/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="dist/modules/ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/modules/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css">

  <link rel="stylesheet" href="dist/modules/summernote/summernote-lite.css">
  <link rel="stylesheet" href="dist/modules/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="dist/css/demo.css">
  <link rel="stylesheet" href="dist/css/style.css">	
  <!--<link rel="stylesheet" href="css/local.css">-->

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
          <div class="sidebar-brand" >
            <a href="indexA.php" >Motor Vocacional</a>
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
            <li  id = "indexA">
              <a   ><i class="ion ion-home"></i><span>Guia Vocacional</span></a>
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
              <h4 class="section-header">
            	   Guia Vocacional
         	  </h4>
          </section>
      <!--
          <div class="card-body" id="tabla-1">
            <div class="card" >
                <Grid container spacing={gridSpacing} item lg={4} md={6} sm={6} xs={12}>
                  <iframe width="560" height="315" src="https://www.youtube.com/embed/_4oOr0DDrZw" title="YouTube video player" frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                  </iframe> 
                </Grid>
            </div>
          </div>
                  -->
          <div class="container">
              <div id="accordion">
                  <div class="card">
                      <div class="card-header">
                          <a class="card-link" data-toggle="collapse" href="#collapseOne">
                              Profesiones
                          </a>
                      </div>
                      <div id="collapseOne" class="collapse show" data-parent="#accordion">
                          <div class="card-body">

                          </div>
                      </div>
                  </div>
                  <div class="card">
                      <div class="card-header">
                          <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
                             Video Tutoriales
                          </a>
                      </div>
                      <div id="collapseTwo" class="collapse" data-parent="#accordion">
                          <div class="row">

                              <div class="col-12 col-md-6 col-lg-6">
                                  <div class="card">
                                      <div class="card-header">
                                          <div class="card-body">
                                              <div>
                                                  <iframe width="450" height="315" src="https://www.youtube.com/embed/_4oOr0DDrZw" title="YouTube video player"
                                                          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                                                  </iframe>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-12 col-md-6 col-lg-6">
                                  <div class="card">
                                      <div class="card-header">
                                          <div class="card-body">
                                              <div>
                                                  <iframe width="450" height="315" src="https://www.youtube.com/embed/_4oOr0DDrZw" title="YouTube video player"
                                                          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                                                  </iframe>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-12 col-md-6 col-lg-6">
                                  <div class="card">
                                      <div class="card-header">
                                          <div class="card-body">
                                              <div>
                                                  <iframe width="450" height="315" src="https://www.youtube.com/embed/_4oOr0DDrZw" title="YouTube video player"
                                                          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                                                  </iframe>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                          </div>
                      </div>
                  </div>
                  <div class="card">
                      <div class="card-header">
                          <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
                              Collapsible Group Item #3
                          </a>
                      </div>
                      <div id="collapseThree" class="collapse" data-parent="#accordion">
                          <div class="card-body">
                              Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                              sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                              Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi
                              ut aliquip ex ea commodo consequat.
                          </div>
                      </div>
                  </div>
              </div>
          </div>


          <!--
          <div class="row">
            
            <div class="col-12 col-md-6 col-lg-6">
					    <div class="card">
						    <div class="card-header">
							    <div class="card-body"> 
                      <div>
                        <iframe width="450" height="315" src="https://www.youtube.com/embed/_4oOr0DDrZw" title="YouTube video player"
                              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                        </iframe> 
                      </div>
                  </div>
						    </div>
					    </div>
			      </div>
            <div class="col-12 col-md-6 col-lg-6">
					    <div class="card">
						    <div class="card-header">
							    <div class="card-body"> 
                      <div>
                        <iframe width="450" height="315" src="https://www.youtube.com/embed/_4oOr0DDrZw" title="YouTube video player"
                              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                        </iframe> 
                      </div>
                  </div>
						    </div>
					    </div>
			      </div>
            <div class="col-12 col-md-6 col-lg-6">
					    <div class="card">
						    <div class="card-header">
							    <div class="card-body"> 
                      <div>
                        <iframe width="450" height="315" src="https://www.youtube.com/embed/_4oOr0DDrZw" title="YouTube video player"
                              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                        </iframe> 
                      </div>
                  </div>
						    </div>
					    </div>
			      </div>
              
          </div>
          -->

      </div><!-- no elimanar-->
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


