

<!---IMPORTANTE LE PASAMOS El id_producto por el action del formulario para que lo recoga el metodo del controlador editProduct sino no funciona------>
<div class="row d-flex justify-content-center">
  <form class="myInsert" action="http://localhost/labotadenoel/?nombre_del_controlador=administrarProductos&action=editProduct&id_producto=<?php echo $unProducto->id_productos ?>" method="post" enctype="multipart/form-data">
    <label for="nombre">nombre</label>                                                   <!--Pregutamos si esta creado y si ademas es unu objeto imprimerlo en el value--->
    <input class="form-control col-xs-12 col-sm-6 col-md-8" type="text" name="nombre" value="<?php echo isset($unProducto) && is_object($unProducto) ? $unProducto->nombre : ''; ?>">
    <label for="descripcion">descripcion</label>                                       <!--Pregutamos si esta creado y si ademas es unu objeto imprimerlo en el value--->
    <input class="form-control col-xs-12 col-sm-6 col-md-8" type="text" name="descripcion" value="<?php echo isset($unProducto) && is_object($unProducto) ? $unProducto->descripcion : ''; ?>" >
    <label for="precio">precio</label>                                                <!--Pregutamos si esta creado y si ademas es unu objeto imprimerlo en el value--->
    <input class="form-control col-xs-12 col-sm-6 col-md-8" type="text" name="precio" value="<?php echo isset($unProducto) && is_object($unProducto) ? $unProducto->precio : ''; ?>">
    <label for="stock">stock</label>                                                  <!--Pregutamos si esta creado y si ademas es unu objeto imprimerlo en el value--->
    <input class="form-control col-xs-12 col-sm-6 col-md-8" type="number" name="stock" value="<?php echo isset($unProducto) && is_object($unProducto) ? $unProducto->stock : ''; ?>" >
    <label for="imagen">imagen</label>
    <!---si esta isset $unProducto y es un objeto y no esta vacio , nos muestra la imagen------>
      <?php if (isset($unProducto) && is_object($unProducto) && !empty($unProducto->imagen)): ?>

        <img src="http://localhost/labotadenoel/subidas/imagenes/<?php echo $unProducto->imagen ?>" width="200px">

      <?php endif; ?>

    <input class="form-control col-xs-12 col-sm-6 col-md-8" type="file" name="imagen" >
    <?php $categoria = productos::showAllcategorias() // llamamos a la funcion estatica para usarla en el select de abajo para mostrar las option ?>
    <select  name="categoria_id">
      <?php
          while ($micategoria = $categoria->fetch_object()  ): //recorremos la funcion static y mostramos en cada option ?>
          <!-- le pasamos en value el id de la categoria_id para que luego en el controlador lo coga y lo usemos para guardar en la funcion insertNewproduct() -->

                                                                     <!--Le agregamos el atributo selected si esta isset el $unProducto y si es un objeto y si el nombre de categoria es igual que el nombre de categoria de un producto--->
            <option value="<?php echo $micategoria->categoria_id ?>"<?php echo isset($unProducto) && is_object($unProducto) && $micategoria->categoria_id == $unProducto->categoria_id ? 'selected' : '' ?>>
              <?php echo $micategoria->nombre_categoria ?>
             </option>

      <?php endwhile; ?>

    </select><br>

    <!-- la fecha la insertarmos automaticamente en el la clase insertar del modelo -->
    <button type="submit" class="btn btn-success" name="insertar">Insertar edición</button>
    <span><?php echo isset($_SESSION['messageInsert']) ? $_SESSION['messageInsert'] : $_SESSION['messageInsert'] ="" ?></span>
    <?php funciones_utiles::deleteSession("messageInsert") //borramos el mensage de sesion para cuando recarge la pagina no aparezca ?>
  </form>
</div>
