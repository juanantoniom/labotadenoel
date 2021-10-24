
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" >
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <a href="http://localhost/labotadenoel/?nombre_del_controlador=home&action=arboles&pagina=1"><img src="assets/img/slider1.jpg" class="d-block w-100 " alt="..."></a>
    </div>
    <div class="carousel-item">
      <a href="http://localhost/labotadenoel/?nombre_del_controlador=home&action=adornos&pagina=1"><img src="assets/img/slider2.jpg" class="d-block w-100 " alt="..."></a>
    </div>
    <div class="carousel-item">
      <a href="http://localhost/labotadenoel/?nombre_del_controlador=home&action=luces&pagina=1"><img src="assets/img/slider3.jpg" class="d-block w-100 " alt="..."></a>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon"  aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>


<main class="main">
<section> <!--recorremos la base de datos y mostramos de manera aleatoria cada producto-->

  <?php foreach ($miProducto as $elProducto): ?>
    <!-- style="width: 18rem;" -->
     <div class="card" ><!---IMPORTANTE para ir al enlace detalles.php lo que hacemos es pasar por parametro en la url del enlace el id_productos y en en controlador home metodo detailsProduct lo comparamos con el que tenemos guardado en la base de datos y si es asi lo mostramos-->
       <a href="http://localhost/labotadenoel/?nombre_del_controlador=home&action=detailsProduct&id_producto=<?php echo $elProducto['id_productos'] ?>">
         <img src="http://localhost/labotadenoel/subidas/imagenes/<?php echo $elProducto["imagen"]; ?>" class="card-img-top" alt="...">
         <div class="card-body">
           <h5 class="card-title"><?php echo $elProducto["nombre"]; ?></h5>
           <p class="card-text"><?php echo $elProducto["precio"]."€"; ?></p>
       </a>
         <a href="http://localhost/labotadenoel/?nombre_del_controlador=Carro&action=addProduct&id_producto=<?php echo $elProducto['id_productos'] ?>" class="btn btn-primary agregarAlcarrito">Agregar al carrito</a>
       </div>
     </div>
  <?php endforeach; ?>

</section>
</main>
<div class="miClear">

</div>


<div class="mipaginacion">


  <nav aria-label="Page navigation example ">
    <ul class="pagination">
      <!--definiendo la class disable, cuando el $_GET numero de pagina en la que estemos sea menor o = 1 que es la primera pagina entonces pintame disable --->
      <li class="page-item <?php echo $_GET["pagina"]<=1 ? 'disabled': '' ?>"><a class="page-link" href="http://localhost/labotadenoel/?pagina=<?php echo $_GET["pagina"]-1 ?>">Anterior</a></li><!--usamos un url para restasle el GET["pagina"]-1 y asi nos envia a una pagina anterior a la actual--->
      <?php for ($i=0; $i <$numerodePaginas ; $i++) :?> <!---mientras que $i sea menor que el numero de paginas creamos un boton de numero de pagina---->
        <!---añadimos con php la clase active preguntandolo por ternario y decimos si el $_GET["pagina"] es igual al numero de pagina que recibe por el bucle entonces entra y pintamos -->
        <li class="page-item <?php echo $_GET["pagina"]==$i+1 ? 'active': '' ?>"><a class="page-link" href="http://localhost/labotadenoel/?pagina=<?php echo $i+1 ?>"> <!--en el href le creamos una variable $_GET pagina para detectar en que pagina estamos del bucle y asi poder utilizar ese GET para poder sumar o restar en el boton Anterior y Siguiente-->
          <?php echo $i+1 ?></a></li> <!--imprimimos el numero de pagina por el que vamos y le sumamos 1 para que no empiece en 0 y quede feo en la numeracion de la paginacion-->

      <?php endfor ?>

      <!--deficiendo la class disable cuando el $_GET numero de pagina en la que estamos sea mayor o igual al numero de paginas total que le pasamos del el controlador, entonces pintame disable-->
      <li class="page-item <?php echo $_GET["pagina"]>=$numerodePaginas ? 'disabled': '' ?>"><a class="page-link " href="http://localhost/labotadenoel/?pagina=<?php echo $_GET["pagina"]+1 ?>">Siguiente</a></li><!--usamos un url para sumarle el GET["pagina"]+1 y asi nos envia a una pagina siguiente a la actual--->
    </ul>
  </nav>
</div>


<div class="miClear">

</div>
