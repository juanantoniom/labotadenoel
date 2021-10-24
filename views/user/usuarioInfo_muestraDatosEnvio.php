<?php if (!isset($_SESSION["usuario"] , $_SESSION["carrito"])): ?>
  <h5 class="debes">Debes iniciar sesion y comprar para poder entrar aqui</h5>

<?php else: ?>
<h3 class="datosEnvio">Datos de envio</h3>
<div class="miClear"></div>


  <form class="miRegistro" action="http://localhost/labotadenoel/?nombre_del_controlador=pedido&action=placeOrder" method="post"> <!--Apuntamos en el acction a la vista que nos muestra el formulario para guardar el pedido .La funcion placeOrder de pedidoControlador-->
    <div class="form-group">
      <label for="nombre">nombre</label><br>
      <input  class="form-control"type="text"  name="nombre" value="<?php echo $dato_Un_Usuario['nombre'] ?>" readonly><!--Le ponemos readonly para que el usuario no pueda modificarlo--->
    </div>
    <div class="form-group">
      <label for="apellido">apellido</label><br>
      <input class="form-control" type="text" name="apellido" value="<?php echo $dato_Un_Usuario['apellido'] ?>" readonly>
    </div>
    <div class="form-group">
      <label for="direccion">direccion</label><br>
      <input class="form-control" type="text" name="direccion" value="<?php echo $dato_Un_Usuario['direccion'] ?>" readonly>
    </div>
    <div class="form-group">
      <label for="localidad">localidad</label><br>
      <input class="form-control" type="text" name="localidad" value="<?php echo $dato_Un_Usuario['localidad'] ?>" readonly>
    </div>
    <div class="form-group">
      <label for="provincia">provincia</label><br>
      <input class="form-control" type="text" name="provincia" value="<?php echo $dato_Un_Usuario['provincia'] ?>" readonly>
    </div>
    <div class="form-group">
      <label for="codigo_postal">codigo postal</label><br>
      <input class="form-control" type="text" name="codigo_postal" value="<?php echo $dato_Un_Usuario['codigo_postal'] ?>" readonly>
    </div>
    <div class="form-group">
      <label for="telefono">telefono</label><br>
      <input class="form-control" type="text" name="telefono" value="<?php echo $dato_Un_Usuario['telefono'] ?>" readonly>
    </div>
    <div class="form-group">
      <label for="telefono_movil">telefono movil</label><br>
      <input class="form-control" type="text" name="telefono_movil" value="<?php echo $dato_Un_Usuario['telefono_movil'] ?>" readonly>
    </div>

    <!-- este boton nos enviara a la funcion placeOrder del pedidoControlador.php -->
    <button type="submit" class="btn btn-primary">Continuar con el pedido</button>


  </form>

<?php endif; ?>
