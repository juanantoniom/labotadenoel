<form class="miRegistro" action="http://localhost/labotadenoel/?nombre_del_controlador=pedido&action=savePedidoController" method="post"> <!--Apuntamos en el acction a la funcion savePedido del controlador pedidoControlador-->

  <div class="miClear"></div>


  <h2 class="carritoh2">Tu pedido</h2>

  <div class="cajaCarrito">


      <table class="table">
        <thead>
          <tr>
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


      </div>


  </div>
  <div class="miClear"></div> <!---hacemos un clear:both para crear un espacio y limpe y que se vea todo el div de arriba y no suba el footer y lo tape--->













  <!-- este boton nos guardara el pedido llamando a la funcion savePedido del pedidoControlador.php -->
  <button type="submit" name="hacerPedido" class="btn btn-primary" >Confirmar pedido</button>


</form>
