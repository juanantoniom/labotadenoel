<div class="miClear"></div>


<h2 class="carritoh2">Tu carrito</h2>

<div class=" cajaCarrito">


    <table class="table">
      <thead>
        <tr>
          <th scope="col">Imagen</th>
          <th scope="col">Nombre</th>
          <th scope="col">Precio</th>
          <th scope="col">Unidades</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($miCarritoSesion as $key => $value):
              $producto = $value["productoTodoelObjeto"];

           ?>
        <tr>

          <td> <img class="imagenCarrito" src="http://localhost/labotadenoel/subidas/imagenes/<?php echo $producto->imagen ?>"></td>
          <td><?php echo $producto->nombre ?> </td>
          <td><?php echo $producto->precio ?> </td>
          <td><?php echo $value['unidadesDelProducto'] ?></td><!--unidadesDelProducto hay que sacarlo asi porque es un array-->
        </tr>
        <?php endforeach; ?>

      </tbody>
    </table>

    <div class="totalCarrito">


      <?php $losnumeros = funciones_utiles::numberCarrito(); ?> <!---llamamos a la funcion estatica para usar el total--->
      <h3>Total: <?php echo $losnumeros["total"]  ?> €</h3>
      <!-- creamos este formulario oculto para enviar por post al metodo button_continuar_pedido del controlador userControlador. y usamos la session donde teniamos guardado el objeto entero del usuario para pasarle por post el id_usuario del usuario para usarlo en el metodo button_continuar_pedido de userControlador y comparar con la bd que estamos ante el usuario que no tiene o tiene la usuarioInfo rellena -->
      <form  action="http://localhost/labotadenoel/?nombre_del_controlador=user&action=button_continuar_pedido" method="post">

          <button class="btn btn-success" type="submit">Realizar pedido</button>
          <!-- le mandamos por post el id_usuario al la funcion button_continuar_pedido() del userControlador -->
          <!-- mandamos en el input para que lo recoga por post y desabilitamos el input con la propiedad
           readonly y lo ocultamos para que no pueda usarlo el usuario con style="visibility:hidden"-->
          <input size="5px" style="visibility:hidden" readonly type="text" name="id_usuario" value="<?php echo $_SESSION["usuario"]->id_usuario ?>">
      </form>

    </div>
    <a href="http://localhost/labotadenoel/?nombre_del_controlador=carro&action=deleteSessionCarrito" class="borrarCarrito btn btn-danger">Borrar Carrito</a>


</div>
<div class="miClear"></div> <!---hacemos un clear:both para crear un espacio y limpe y que se vea todo el div de arriba y no suba el footer y lo tape--->
