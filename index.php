
<?php session_start();
//controlador frontal que maneja todos los controladores que son llamados por get
  include 'library/dompdf/autoload.inc.php'; //requerimos para poder usar la libreria, para la funcion to_print_invoice() del controlador pedidoControlador
  require_once 'autocarga_de_controladores.php';//cargamos todos los controladores para tener acceso a ellos
  //require_once 'config/database.php';
  require_once 'config/parameters.php';
  require_once 'helpers/funciones_utiles.php';//cargamos las funciones para usarlas en cualquier pagina
  //****IMPORTANTE**** No podemos hacer require antes que los header(location: ) de cada funcion del  controlador porque sino da error.
  //****IMPORTANTE**** La solucion seria meter los require en cada funcion del controlador justo al final debajo de todos los header(location:).
  //require_once 'views/layout/header_and_navbar.php';



  if (isset($_GET['nombre_del_controlador'])) { //preguntamos si existe ese parametro por get y si existe lo almacenamos en la variable $el_nombre_de_controlador

    $el_nombre_de_controlador = $_GET['nombre_del_controlador'] . 'Controlador'; //le concatenamos .'Controlador' porque cada clase de controllers va a tener seguido esa palabra y asi lo acortarmos la direccion url y hacemos que no sea tan larga

  }else if(!isset($_GET["nombre_del_controlador"]) && !isset($_GET["action"])) {  //si no tiene controlador creamos la variable el_controlador_por_defecto que almacena en ella una constante que hemos creado en la carpeta config parameters.php
    $el_nombre_de_controlador = controlador_por_defecto; //constante que tiene el nombre de un controlador llamado homeControlador y que ese controlador recibe el action para volver a al inicide de la pagina

  }else {
    echo "la pagina no existe";

    exit();

  }
  //si el nombre del controlador tiene una clase que existe creamos un objeto de ese nombre de controlador
  if (class_exists($el_nombre_de_controlador)) {

    $controlador = new $el_nombre_de_controlador();//creamos el objeto controlador

    if (isset($_GET["action"]) && method_exists($controlador, $_GET["action"])) {//si la accion esta seteada y el metodo de la accion existe en el objeto $controlador

      $accion = $_GET["action"]; //recogemos la accion por la url y la almacenamos en la variable para usarla abajo con el objeto $controlador

      $controlador->$accion(); //llamamos a la clase del controlador que se pida y a su metodo

    }else if(!isset($_GET["nombre_del_controlador"]) && !isset($_GET["action"])) {  //si no tiene controlador creamos la variable accion_por_defecto_home y almacenamos en ella accion_por_defecto que es una constante que hemos creado en la carpeta config parameters.php
       $accion_por_defecto_home = accion_por_defecto;  //almacenamos la constante de la carpeta parameters que tiene la accion index del controlador homeControlador que esta en la caperta

       $controlador->$accion_por_defecto_home(); //llamamos a la clase homeControlador y su metodo home  .Usando el objeto $controlador que hemos creado mas arriba y llamamos a la clase controlador y usamos la variable $accion_por_defecto_home que tiene la constante con el nombre del metodo home de la clase homeControlador
    }else {
      // code...
    }

  }else {
    echo "no se ha podido encontrar la clase del controlador";

  }

  require_once 'views/layout/footer.php';?>
