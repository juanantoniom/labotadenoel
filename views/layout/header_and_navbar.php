<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>La bota de Noel</title>

    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

    <script type="text/javascript" src="assets/css/bootstrap/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="assets/css/bootstrap/js/bootstrap.min.js"></script>


  </head>
  <body>

    <header>

      <div class="logo">
        <a href="http://localhost/labotadenoel/?pagina=1">La bota de Noel</a>
      </div>
        <!--si tenemos la sesion iniciada mostramos el carrito y su enlace sino no lo mostramos--->
        <div style="<?php echo isset($_SESSION['carrito']) ? 'visibility:visible' : 'visibility:hidden'?>">
           <?php $misNumerosdelCarrito = funciones_utiles::numberCarrito() ?><!---llamamos a la clase static para poder usarla aqui en la vista y la usamos para mostrar la cantidad de productos que hay en el carrito $misNumerosdelCarrito["cantidad"]---->
          <img src="assets\img\iconfinder_carrito.png" alt="carrito">
          <div class="miClearRight"></div>  <!--lo usamos para limpiar a la derecha y poner justo debajo del carro el texto Ver Carrito-->
          <a class="verCarrito"href="http://localhost/labotadenoel/?nombre_del_controlador=carro&action=VerCarrito">Ver Carrito</a>
          <p><?php echo $misNumerosdelCarrito["cantidad"] ?></p>

        </div>






      <!-- explicacion imagen muñeco , El atributo href si no esta seteada la sesion["usuario"] nos manda al index y si esta seteada cambiamos la imagen a el muñeco con una x y si pinchamos en el nos manda a la funcion del controlador que nos cierra la sesion que tenemos abierta -->
      <!-- explicacion atributo src , Si no esta seteada la sesion["usuario"] nos muesta al muñeco sin la x , Y si esta creada la sesion["usuario"]  nos muestra al muñeco con la x para cuando pinchemos podamos cerrar la sesion -->
      <a href="<?php echo !isset($_SESSION['usuario']) ?  'http://localhost/labotadenoel' : 'http://localhost/labotadenoel/?nombre_del_controlador=user&action=logout' ?>" class="cerrar_sesion"><img class ="imagen_usuario"src="<?php echo !isset($_SESSION["usuario"]) ? 'assets\img\icons/person.svg' : 'assets\img\icons/person-x.svg' ?>" alt="imagen_iniciar_session"></a>
      <!-- si esta creada la sesion isAdmin mostramos el formulario que nos llevaa la pagina de administrar -->
      <!-- creamos este formulario porque hay que pasarle la el name del input para la paginacion -->
      <?php if (isset($_SESSION["admin"])): ?>
        <form class="administrarForm" action="http://localhost/labotadenoel/?nombre_del_controlador=administrarProductos&action=administrar_Paginacion" method="post">
          <input type="text" name="paginaActual" value="1" readonly  style="width:15px;visibility:hidden"><!--le ponemos valor 1 para que lo coga la funcion showAllproducts() del modelo pedidos-->

          <button type="submit" name="button" class="btn btn-warning administrar">Administrar</button>
        </form>
        <!-- <a href="http://localhost/labotadenoel/?nombre_del_controlador=administrarProductos&action=adminProductos"class="btn btn-warning administrar">Administrar</a> -->
      <?php endif; ?>



        <div class="container_inicia">
          <!-- explicacion del boton inicia sesion.  Si no esta seteada la sesion usuario , muestrame incia sesion . Si no quiere decir que esta creada entonces muestrame la sesion usuario  -->
          <a id="iniciaSlideToggle" href="http://localhost/labotadenoel/?nombre_del_controlador=user&action=buttonIniciarSesion"><?php echo !isset($_SESSION['usuario']) ? "Inicia sesion"  : $_SESSION['usuario']->nombre_usuario ?></a>
        </div>

      <div class="miClear"></div>
    </header>
    <!-- assets/img/logo_navbar/pngegg.png -->
      <div class="container">
        <nav>
          <ul class=" navbar justify-content-center list-unstyled">
            <li class="nav-item">
              <a href="http://localhost/labotadenoel/?nombre_del_controlador=home&action=arboles&pagina=1" class="nav-link"><img src="assets/img/icons/tree-fill.svg" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">Árboles</a>
            </li>
            <li class="nav-item">
              <a href="http://localhost/labotadenoel/?nombre_del_controlador=home&action=luces&pagina=1" class="nav-link"><img src="assets/img/icons/star.svg" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">Luces</a>
            </li>
            <li class="nav-item">
              <a href="http://localhost/labotadenoel/?nombre_del_controlador=home&action=adornos&pagina=1" class="nav-link"><img src="assets/img/icons/gift.svg" width="30" height="30" class="d-inline-block align-top mr-1" alt="" loading="lazy">Adornos</a>
            </li>
            <li class="nav-item">
              <a href="http://localhost/labotadenoel/?nombre_del_controlador=home&action=postales&pagina=1" class="nav-link"><img src="assets/img/icons/envelope-fill.svg" width="30" height="30" class="d-inline-block align-top mr-1" alt="" loading="lazy">Postales</a>
            </li>
            <li class="nav-item">
              <a href="http://localhost/labotadenoel/?nombre_del_controlador=home&action=belenes&pagina=1" class="nav-link"><img src="assets/img/icons/house-door-fill.svg" width="30" height="30" class="d-inline-block align-top mr-1" alt="" loading="lazy">Belenes</a>
              <!-- <a href="#" class="nav-link"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-phone" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M11 1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z"/>
                <path fill-rule="evenodd" d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
              </svg>Fundas</a> -->
            </li>
          </ul>
        </nav>
      </div>
