<?php if (isset($miProducto)):?>
<div class="cajaDetalle">
  <h2><?php echo $miProducto->nombre ?></h2>
  <img src="http://localhost/labotadenoel/subidas/imagenes/<?php echo $miProducto->imagen; ?>" class="imagenDetalle"  alt="...">
  <p><?php echo $miProducto->descripcion ?></p>
  <p><?php echo $miProducto->precio . " €" ?></p>

<!---IMPORTANTE en esta url le pasamos por parametro $_GET["pagina_detalles"]     pagina_detalles=detalle    para usarlo en la funcion addProduct() de controllers/carroControlador.php ---->
  <a  class="btn btn-primary" href="http://localhost/labotadenoel/?nombre_del_controlador=Carro&action=addProduct&pagina_detalles=detalle&id_producto=<?php echo $miProducto->id_productos ?>">Agregar al carrito</a>
</div>



<?php endif ?>
