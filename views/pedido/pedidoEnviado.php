<h5 class="pedidoEnviado">Su pedido ha sido enviado, lo recibira en unos días</h5>

<img class="imagenEnviado"src="assets/img/pedido_enviado.jpg" alt="">

<a href="http://localhost/labotadenoel/?nombre_del_controlador=pedido&action=to_print_invoice" class="btn btn-primary imprimirFactura">Imprimir factura</a>

<!-- cerramos la sesion del carrtio para que vuelva a estar a 0  -->
<?php //cerramos la sesion llamando al metodo estatico deleteSession($nombredeSesion) de la clase funciones_utiles de la carpeta helpers.Para cuando el usuario recargue la pagina no le salte el mensaje de error otra vez
      // funciones_utiles::deleteSession('carrito');
      //if($_SERVER['REQUEST_URI'];


           ?>
