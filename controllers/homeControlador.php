


<?php require_once 'models/productos.php';
/** controlador encargado de llevarnos a la pagina de inicio */
class homeControlador{

  //funcion que muestra por pantalla productos aleatorios traidos de la bd y también muestra la paginacion
  public function home(){

     $producto = new Productos();


     $miProducto = $producto->showLimitRandomProducts();//llamamos a la funcion para mostrar en la vista el nombre del producto, la descripcion y su imagen y precio


     $numerodePaginas = $producto->countRowProduct();//llamamos a la funcion que nos cuenta el numero total de paginas que tenemos de productos  (nos devulve un numero para usarlo abajo y sacar la paginacion)

     // para marcar siempre la primera pagina debemos preguntar , si no existe ese $_GET["pagina"] entonces mandame  a la pagina con el $_GET["pagina"] de la posicion 1
   if(!isset($_GET["pagina"])){
       header("Location:http://localhost/labotadenoel/?pagina=1");
     }
     //si el usuario colora por la url ?pagina=44 o  ?pagina=0  , entonces entraria en este if y volveria a la inicial
  //  if ($_GET["pagina"] > $numerodePaginas || $_GET["pagina"] <= 0) {
  //    header("Location:http://localhost/labotadenoel/?pagina=1");
  //  }
   //los requerimos asi por que el html no puede ir arriba del los header , osea no puede ir en el index.php(controlador frontal )sino daria un error y lo metemos aqui
    require_once 'views/layout/header_and_navbar.php';//requerimos el header y el navbar
    require_once 'views/home/carousel_and_main.php';//requerimos el carousel y el main
  }
  //funcion para mostrar la vista de la pagina views/home/preguntasFrecuentes.php
  public function preguntasFrecuentes(){
    require_once 'views/layout/header_and_navbar.php';//requerimos el header y el navbar
    require_once 'views/home/preguntasFrecuentes.php';
  }
//funcion para mostrar la vista de la pagina views/home/quienesSomos.php
  public function quienesSomos(){
    require_once 'views/layout/header_and_navbar.php';
    require_once 'views/home/quienesSomos.php';
  }
  //funcion que nos muestra solo los arboles en la pagina de /views/home/arboles.php
  public function arboles(){
    $producto = new Productos();
    $arboles = 1;  //para saber que numero es cada categoria nos vamos a la bd y vemos la tabla categoria

    $miProducto = $producto->getOneCategoria($arboles);//llamamos a la funcion para mostrar en la vista el nombre del producto, la descripcion y su imagen y precio


    $numerodePaginas = $producto->countRowProduct_Categoria($arboles);//llamamos a la funcion que nos cuenta el numero total de paginas que tenemos de productos  (nos devulve un numero para usarlo abajo y sacar la paginacion)

    // para marcar siempre la primera pagina debemos preguntar , si no existe ese $_GET["pagina"] entonces mandame  a la pagina con el $_GET["pagina"] de la posicion 1
   if(!isset($_GET["pagina"])){
      header("Location:http://localhost/labotadenoel/?nombre_del_controlador=home&action=arboles&pagina=1");
    }
    //si el usuario colora por la url ?pagina=44 o  ?pagina=0  , entonces entraria en este if y volveria a la inicial
   if ($_GET["pagina"] > $numerodePaginas || $_GET["pagina"] <= 0) {
     header("Location:http://localhost/labotadenoel/?nombre_del_controlador=home&action=arboles&pagina=1");
   }
    require_once 'views/layout/header_and_navbar.php';
    require_once 'views/home/arboles.php';

  }
  //funcion que nos muestra solo los belenes en la pagina de /views/home/belenes.php
  public function belenes(){
    $producto = new Productos();
    $belenes = 5;  //para saber que numero es cada categoria nos vamos a la bd y vemos la tabla categoria

    $miProducto = $producto->getOneCategoria($belenes);//llamamos a la funcion para mostrar en la vista el nombre del producto, la descripcion y su imagen y precio


    $numerodePaginas = $producto->countRowProduct_Categoria($belenes);//llamamos a la funcion que nos cuenta el numero total de paginas que tenemos de productos  (nos devulve un numero para usarlo abajo y sacar la paginacion)

    // para marcar siempre la primera pagina debemos preguntar , si no existe ese $_GET["pagina"] entonces mandame  a la pagina con el $_GET["pagina"] de la posicion 1
   if(!isset($_GET["pagina"])){
      header("Location:http://localhost/labotadenoel/?nombre_del_controlador=home&action=belenes&pagina=1");
    }
    //si el usuario colora por la url ?pagina=44 o  ?pagina=0  , entonces entraria en este if y volveria a la inicial
   if ($_GET["pagina"] > $numerodePaginas || $_GET["pagina"] <= 0) {
     header("Location:http://localhost/labotadenoel/?nombre_del_controlador=home&action=belenes&pagina=1");
   }
    require_once 'views/layout/header_and_navbar.php';
    require_once 'views/home/belenes.php';

  }
  //funcion que nos muestra solo llas luces en la pagina de /views/home/luces.php
  public function luces(){
    $producto = new Productos();
    $luces = 2;  //para saber que numero es cada categoria nos vamos a la bd y vemos la tabla categoria

    $miProducto = $producto->getOneCategoria($luces);//llamamos a la funcion para mostrar en la vista el nombre del producto, la descripcion y su imagen y precio


    $numerodePaginas = $producto->countRowProduct_Categoria($luces);//llamamos a la funcion que nos cuenta el numero total de paginas que tenemos de productos  (nos devulve un numero para usarlo abajo y sacar la paginacion)

    // para marcar siempre la primera pagina debemos preguntar , si no existe ese $_GET["pagina"] entonces mandame  a la pagina con el $_GET["pagina"] de la posicion 1
   if(!isset($_GET["pagina"])){
      header("Location:http://localhost/labotadenoel/?nombre_del_controlador=home&action=luces&pagina=1");
    }
    //si el usuario colora por la url ?pagina=44 o  ?pagina=0  , entonces entraria en este if y volveria a la inicial
   if ($_GET["pagina"] > $numerodePaginas || $_GET["pagina"] <= 0) {
     header("Location:http://localhost/labotadenoel/?nombre_del_controlador=home&action=luces&pagina=1");
   }
    require_once 'views/layout/header_and_navbar.php';
    require_once 'views/home/luces.php';

  }

//funcion que nos muestra solo las postales en la pagina de /views/home/postales.php
  public function postales(){

    $producto = new Productos();
    $postales = 4;  //para saber que numero es cada categoria nos vamos a la bd y vemos la tabla categoria

    $miProducto = $producto->getOneCategoria($postales);//llamamos a la funcion para mostrar en la vista el nombre del producto, la descripcion y su imagen y precio


    $numerodePaginas = $producto->countRowProduct_Categoria($postales);//llamamos a la funcion que nos cuenta el numero total de paginas que tenemos de productos  (nos devulve un numero para usarlo abajo y sacar la paginacion)

    // para marcar siempre la primera pagina debemos preguntar , si no existe ese $_GET["pagina"] entonces mandame  a la pagina con el $_GET["pagina"] de la posicion 1
   if(!isset($_GET["pagina"])){
      header("Location:http://localhost/labotadenoel/?nombre_del_controlador=home&action=postales&pagina=1");
    }
    //si el usuario colora por la url ?pagina=44 o  ?pagina=0  , entonces entraria en este if y volveria a la inicial
   if ($_GET["pagina"] > $numerodePaginas || $_GET["pagina"] <= 0) {
     header("Location:http://localhost/labotadenoel/?nombre_del_controlador=home&action=postales&pagina=1");
   }
    require_once 'views/layout/header_and_navbar.php';
    require_once 'views/home/postales.php';


  }

  //funcion que nos muestra solo los adornos en la pagina de /views/home/adornos.php
    public function adornos(){

      $producto = new Productos();
      $adornos = 3;  //para saber que numero es cada categoria nos vamos a la bd y vemos la tabla categoria

      $miProducto = $producto->getOneCategoria($adornos);//llamamos a la funcion para mostrar en la vista el nombre del producto, la descripcion y su imagen y precio


      $numerodePaginas = $producto->countRowProduct_Categoria($adornos);//llamamos a la funcion que nos cuenta el numero total de paginas que tenemos de productos  (nos devulve un numero para usarlo abajo y sacar la paginacion)

      // para marcar siempre la primera pagina debemos preguntar , si no existe ese $_GET["pagina"] entonces mandame  a la pagina con el $_GET["pagina"] de la posicion 1
     if(!isset($_GET["pagina"])){
        header("Location:http://localhost/labotadenoel/?nombre_del_controlador=home&action=adornos&pagina=1");
      }
      //si el usuario colora por la url ?pagina=44 o  ?pagina=0  , entonces entraria en este if y volveria a la inicial
     if ($_GET["pagina"] > $numerodePaginas || $_GET["pagina"] <= 0) {
       header("Location:http://localhost/labotadenoel/?nombre_del_controlador=home&action=adornos&pagina=1");
     }
      require_once 'views/layout/header_and_navbar.php';
      require_once 'views/home/postales.php';


    }

    //funcion para ver solo un producto , detalles del producto , en una vista
    public function detailsProduct(){

        if (isset($_GET["id_producto"])) {
          $elidtraido = $_GET["id_producto"];
          $producto = new Productos();

          $producto->setId_productos($elidtraido);

          $miProducto = $producto->showOneProduct();

        }


        require_once 'views/layout/header_and_navbar.php';
        require_once 'views/home/detalles.php';//vista para mostrar los detalles del producto seleccionado
    }


}?>
