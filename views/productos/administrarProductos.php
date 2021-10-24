


  <!-- IMPORTANTE -->
  <!-- este enlace es creado mediante formulario para hacer la paginación en forma de post asi el modelo puede coger la variable $_POST["paginaActual"] -->
  <form class="" action="http://localhost/labotadenoel/?nombre_del_controlador=pedido&action=showAllPedidosandUser_controller" method="post">
      <input type="text" name="paginaActual" value="1" readonly style="width:20px;visibility:hidden"> <!--le ponemos valor 1 para que lo coga la funcion showAllPedidosandUser() del modelo pedidos-->
    <button type="submit" name="button" class="btn btn-info">Mostrar pedidos</button>
  </form>



  <div class="row d-flex justify-content-center">
    <form class="myInsert" action="http://localhost/labotadenoel/?nombre_del_controlador=administrarProductos&action=insertNewproduct" method="post" enctype="multipart/form-data">
      <input class="form-control col-xs-12 col-sm-6 col-md-8" type="text" name="nombre" value="" placeholder="nombre">
      <input class="form-control col-xs-12 col-sm-6 col-md-8" type="text" name="descripcion"  placeholder="descripcion">
      <input class="form-control col-xs-12 col-sm-6 col-md-8" type="text" name="precio" placeholder="precio">
      <input class="form-control col-xs-12 col-sm-6 col-md-8" type="number" name="stock"  placeholder="stock">
      <input class="form-control col-xs-12 col-sm-6 col-md-8" type="file" name="imagen">
      <?php $categoria = productos::showAllcategorias() // llamamos a la funcion estatica para usarla en el select de abajo para mostrar las option ?>
      <select  name="categoria_id">
        <?php
            while ($micategoria = $categoria->fetch_object()  ): //recorremos la funcion static y mostramos en cada option ?>
            <!-- le pasamos en value el id de la categoria_id para que luego en el controlador lo coga y lo usemos para guardar en la funcion insertNewproduct() -->
              <option value="<?php echo $micategoria->categoria_id ?>"> <?php echo $micategoria->nombre_categoria ?> </option>

        <?php endwhile; ?>

      </select><br>

      <!-- la fecha la insertarmos automaticamente en el la clase insertar del modelo -->
      <button type="submit" class="btn btn-success" name="insertar">Insertar</button>
      <span><?php echo isset($_SESSION['messageInsert']) ? $_SESSION['messageInsert'] : $_SESSION['messageInsert'] ="" ?></span>
      <?php funciones_utiles::deleteSession("messageInsert") //borramos el mensage de sesion para cuando recarge la pagina no aparezca ?>
    </form>
  </div>



<div class="table-responsive">


    <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">nombre</th>
        <th scope="col">precio</th>
        <th scope="col">stock</th>
        <th scope="col">fecha</th>
        <th scope="col">borrar</th>
        <th scope="col">modificar</th>
      </tr>
    </thead>
    <tbody>

      <?php //utilizamos el resultado de la consulta recobido en el controlador $misProductos, hecha en showAllproducts del modelo productos.php
         while ($elProducto = $misProductos->fetch_object()): ?>   <!--mientras sea true recorre las filas-->
           <tr>

             <td><?php echo $elProducto->nombre; ?></td>
             <td><?php echo $elProducto->precio; ?></td>
             <td><?php echo $elProducto->stock;?></td>
             <td><?php echo $elProducto->fecha;?></td>     <!--el boton borrar y modificar apuntan a un metodo del controlador que necesita recibir el id mandado por GET por la url -->
             <td><a href="http://localhost/labotadenoel/?nombre_del_controlador=administrarProductos&action=delete&id_producto=<?php echo $elProducto->id_productos ?>" class="btn btn-danger">borrar</a></td>
             <td> <a href="http://localhost/labotadenoel/?nombre_del_controlador=administrarProductos&action=showOneProduct&id_producto=<?php echo $elProducto->id_productos ?>" class="btn btn-primary">editar</a></td>
           </tr>



      <?php endwhile; ?>


    </tbody>
  </table>
</div>
<!-- se encarga de la paginacion este form -->
<form action="http://localhost/labotadenoel/?nombre_del_controlador=administrarProductos&action=button_Next_and_back_pagination" method="post">
  <button type="submit" name="anterior" class="btn btn-outline-dark" id="anterior" >Anterior</button>
                                                        <?php //$_POST["paginaActual"] imprime el valor dado en el controlador pedidoControlador su funcion showAllPedidosandUser_controller ?>
  pagina <input type="text" name="paginaActual" value="<?php echo $_POST["paginaActual"] ?>" readonly size="1" style=" border: 0;"> de <?php echo $numerodePaginas ?>

  <button type="submit" name="siguiente" class="btn btn-outline-dark" id="siguiente">Siguiente</button>

</form>
