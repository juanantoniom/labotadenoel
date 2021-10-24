<form class="" action="http://localhost/labotadenoel/?nombre_del_controlador=administrarProductos&action=administrar_Paginacion" method="post">
  <input type="text" name="paginaActual" value="1" readonly style="width:20px;visibility:hidden"> <!--le ponemos valor 1 para que lo coga la funcion showAllproduct() del modelo productos-->
  <button type="submit" name="button" class="btn btn-info">Insertar nuevo producto</button>
</form>

<div class="table-responsive">
  <table class="table table-striped tablePedidos ">
  <thead>
    <tr>
      <th scope="col">Fecha</th>
      <th scope="col">Hora</th>
      <th scope="col">Coste total</th>
      <th scope="col">Nombre producto</th>
      <th scope="col">Unidades</th>
      <th scope="col">Correo</th>
      <th scope="col">Nombre</th>
      <th scope="col">Dirección</th>
      <th scope="col">Localidad</th>
      <th scope="col">Provincia</th>
      <th scope="col">Telefono</th>
    </tr>
  </thead>
  <tbody>

    <?php //utilizamos el resultado de la consulta recobido en el controlador $misPedidos, hecha en showAllPedidosandUser del modelo productos.php
       while ($elPedido = $misPedidos->fetch_object()): ?>   <!--mientras sea true recorre las filas-->
         <tr>

           <td><?php echo $elPedido->Fecha; ?></td>
           <td><?php echo $elPedido->Hora; ?></td>
           <td><?php echo $elPedido->Coste_total; ?></td>
           <td><?php echo $elPedido->Nombre_producto;?></td>
           <td><?php echo $elPedido->unidades;?></td>
           <td><?php echo $elPedido->Correo;?></td>
           <td><?php echo $elPedido->Nombre;?></td>
           <td><?php echo $elPedido->Direccion;?></td>
           <td><?php echo $elPedido->Localidad;?></td>
           <td><?php echo $elPedido->Provincia;?></td>
           <td><?php echo $elPedido->Telefono;?></td>

               <!--el boton borrar  apuntan a un metodo del controlador que necesita recibir el id mandado por GET por la url -->
           <td><a href="http://localhost/labotadenoel/?nombre_del_controlador=pedido&action=deletePedido&id_pedido=<?php echo $elPedido->id_pedido ?>" class="btn btn-danger">borrar</a></td>

         </tr>



    <?php endwhile; ?>


  </tbody>
  </table>
</div>
<form action="http://localhost/labotadenoel/?nombre_del_controlador=pedido&action=button_Next_and_back_pagination" method="post">
  <button type="submit" name="anterior" class="btn btn-outline-dark" id="anterior" >Anterior</button>
                                                        <?php //$_POST["paginaActual"] imprime el valor dado en el controlador pedidoControlador su funcion showAllPedidosandUser_controller ?>
  pagina <input type="text" name="paginaActual" value="<?php echo $_POST["paginaActual"] ?>" readonly size="1" style=" border: 0;"> de <?php echo $numerodePaginas ?>

  <button type="submit" name="siguiente" class="btn btn-outline-dark" id="siguiente">Siguiente</button>

</form>
