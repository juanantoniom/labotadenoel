
<?php if (!isset($_SESSION["usuario"] , $_SESSION["carrito"])): ?>
  <h5 class="debes">Debes iniciar sesion y comprar para poder entrar aqui</h5>



<?php else: ?>
  <h3>Ingresa datos de envio</h3>
  <form class="miRegistro" action="http://localhost/labotadenoel/?nombre_del_controlador=user&action=button_guardar_usuarioInfo" method="post">
    <div class="form-group">
      <label for="nombre">nombre</label><br>
      <input  class="form-control"type="text"  name="nombre">
      <span><?php echo !isset($errores_usuario_info)  ?  '': $errores_usuario_info ?></span>
    </div>
    <div class="form-group">
      <label for="apellido">apellido</label><br>
      <input class="form-control" type="text" name="apellido" >
      <span><?php echo !isset($errores_usuario_info)  ?  '': $errores_usuario_info ?></span>
    </div>
    <div class="form-group">
      <label for="direccion">direccion</label><br>
      <input class="form-control" type="text" name="direccion" >
      <span><?php echo !isset($errores_usuario_info)  ?  '': $errores_usuario_info ?></span>
    </div>
    <div class="form-group">
      <label for="localidad">localidad</label><br>
      <input class="form-control" type="text" name="localidad" >
      <span><?php echo !isset($errores_usuario_info)  ?  '': $errores_usuario_info ?></span>
    </div>
    <div class="form-group">
      <label for="provincia">provincia</label><br>
      <input class="form-control" type="text" name="provincia" >
      <span><?php echo !isset($errores_usuario_info)  ?  '': $errores_usuario_info ?></span>
    </div>
    <div class="form-group">
      <label for="codigo_postal">codigo postal</label><br>
      <input class="form-control" type="number" name="codigo_postal" >
      <span><?php echo !isset($errores_usuario_info)  ?  '': $errores_usuario_info ?></span>
    </div>
    <div class="form-group">
      <label for="telefono">telefono</label><br>
      <input class="form-control" type="number" name="telefono" >
      <span><?php echo !isset($errores_usuario_info)  ?  '': $errores_usuario_info ?></span>
    </div>
    <div class="form-group">
      <label for="telefono_movil">telefono movil</label><br>
      <input class="form-control" type="number" name="telefono_movil" >
      <span><?php echo !isset($errores_usuario_info)  ?  '': $errores_usuario_info ?></span>
    </div>
    <div class="form-group">
      <!-- creamos un input para alamacenar el valor del id_usuario que estamos gracias a la Sesion que fue guardada como objeto accedemos al id_usuario y se le pasamos a la funcion button_guardar_usuarioInfo para que pueda ser seteada y utilizada en la clase  guardar_usuario_info del modelo user.php y asi pueda ser cogido ese parametro por getId_usuario() -->
      <input class="form-control" type="number" name="id_usuario" value="<?php echo $_SESSION["usuario"]->id_usuario ?>"  readonly style="visibility:hidden">

    </div>

    <button type="submit" class="btn btn-primary" name="guardar">guardar</button>


  </form>

<?php endif; ?>
