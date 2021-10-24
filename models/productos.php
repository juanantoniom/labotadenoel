<?php
require_once 'config/database.php';
  class Productos{

    private $id_productos;
    private $nombre;
    private $descripcion;
    private $precio;
    private $stock;
    private $fecha;
    private $categoria_id;
    private $imagen;
    //private imagen;
    private $database;

    public function __construct(){
      $this->database = Database::conexion();
    }

    function getId_productos(){
      return $this->id_productos;
    }
    function setId_productos($id_productos){
      $this->id_productos = $this->database->real_escape_string($id_productos);
    }
    function getNombre(){
      return $this->nombre;
    }
    function setNombre($nombre){
      $this->nombre = $this->database->real_escape_string($nombre);
    }
    function getDescripcion(){
      return $this->descripcion;
    }
    function setDescripcion($descripcion){
      $this->descripcion = $this->database->real_escape_string($descripcion);
    }
    function getPrecio(){
      return $this->precio;
    }
    function setPrecio($precio){
      $this->precio = $this->database->real_escape_string($precio);
    }
    function getStock(){
      return $this->stock;
    }
    function setStock($stock){
      $this->stock = $this->database->real_escape_string($stock);
    }
    function getFecha(){
      return $this->fecha;
    }
    function setFecha($fecha){
      $this->fecha = $this->database->real_escape_string($fecha);
    }
    function getCategoria_id(){
      return $this->categoria_id;
    }
    function setCategoria_id($categoria_id){
      $this->categoria_id = $this->database->real_escape_string($categoria_id);
    }
    function getImagen(){
      return $this->imagen;
    }
    function setImagen($imagen){
      $this->imagen = $this->database->real_escape_string($imagen);
    }


    //muestra todos los productos limitado a 10 por pagina esta funcion la usamos junto con la que esta abajo
    public function showAllproducts(){


      $producto_x_pagina = 6; //articulos que queremos por pagina
      //explicacion: Para hacer dinamico el $iniciarLimit que establece el incio de los productos a mostrar, cogemos el $_POST["paginaActual"]que empieca en 1 y le restamos 1 porque empiza a leer los productos desde 0,
      //ahora si 0 lo multiplicamos por el $producto_x_pagina 0*6 es igual a 0 , entoneces iniciamos el limit en 0 , y con esto establecemos el limit de la consulta de inicio en 0.
      //ahora si al cambiar de pagina  a la pagina 2 ,volvemos a usar el  $_POST["paginaActual"] para calcular el inicio del Limit, $_POST["paginaActual"] nos vale 2 ques lo que tiene en el input, entonces si a 2 le restamos 1 , nos da 1 y entonces esa pagina 1 la multimplicamos por 6 $producto_x_pagina entonces nos da 6 .Esto quiere decir que cambia el limit de la consulta de 0 que estaba antes a 6
      //ahora si volvemos a usar el $_POST["paginaActual"] para calcular el inicio , al cambiar de pagina estariamos en $_POST["paginaActual"] 3 si le restamos 1  nos vale 2, entonces si ese 2 lo multimplicamos por 6 $producto_x_pagina no da igual a 12. Esto quiere decir que cambia el limit de la consulta de 0 que estaba antes a 12

      //en este caso usamos la variable $_POST["paginaActual"] viene valiendo 1 entonces no hay que restarle 1
      $iniciarLimit = ($_POST["paginaActual"]-1)*$producto_x_pagina;

      $sql = "SELECT * FROM productos  ORDER BY id_productos DESC LIMIT $iniciarLimit,$producto_x_pagina";

      $result = $this->database->query($sql); //ejecutamos la consulta

      return $result; //devolvemos todos los productos ----haciendo el $result->fetch_object en la vista para mostrar todas las filas
    }

    //funcion para insertar nuevo producto
    public function InsertNewProduct(){
      if(isset($_SESSION["admin"])){

              //en la insercion al ser numeros no se pone con ' ' en getStock() y getCategoria_id()
              $sql = "INSERT INTO productos (nombre,descripcion,precio,stock,fecha,categoria_id,imagen)
                      VALUES('{$this->getNombre()}','{$this->getDescripcion()}',{$this->getPrecio()},{$this->getStock()},CURDATE(),{$this->getCategoria_id()},'{$this->getImagen()}')";

              $result = $this->database->query($sql);

              if ($result) {
                return true;
              }else {
                return false;
              }


      }

    }
    //funcion para usarla en la vista "views/productos/administrarProductos.php";
    //y asi poder mostrar sin tener que instanciar la clase en la vista , mostramos el nombre de cada categoria
    public static function showAllcategorias(){
      $myDatabase = Database::conexion();
      $sql = "SELECT * FROM categoria ORDER BY categoria_id";

      $result = $myDatabase->query($sql);

      return $result; //devolvemos todas las categorias ----haciendo el $result->fetch_object en la vista para mostrar todas las filas "views/productos/administrarProductos.php";

    }
    //funcion para borrar producto segun el id que ha recibido
    public function deleteProduct(){

      $sql = "DELETE FROM productos WHERE id_productos ={$this->id_productos}";

      $result = $this->database->query($sql);

      if ($result) {
        return true;
      }else {
        return false;
      }
    }
    //funcion para editar un producto ya creado
    public function editProduct(){

      $sql ="UPDATE productos SET nombre ='{$this->getNombre()}', descripcion = '{$this->getDescripcion()}', precio = {$this->getPrecio()}, stock = {$this->getStock()}, categoria_id = {$this->getCategoria_id()},imagen = '{$this->getImagen()}' WHERE id_productos = {$this->getId_productos()}";


      $result = $this->database->query($sql);

      if ($result) {
        return true;

      }else {
        return false;
      }



    }
    //funcion que muestra solo un producto y con el id que se le ha pasado
    public function showOneProduct(){
                                                //lo compara con el id traido por parametro
      $sql = "SELECT * FROM productos WHERE id_productos = {$this->getId_productos()}";

      $result = $this->database->query($sql);

      $miObjetoedit = $result->fetch_object(); //usamos fetch_object para poder usarlo como objeto

      return $miObjetoedit; //nos retorna el resultado ya para usarlo como objeto
    }

    //muestra todos los productos de forma RANDOM aleatoria la usamos en homeControlador metodo home()
    public function showLimitRandomProducts(){
      $producto_x_pagina = 6; //articulos que queremos por pagina
      //explicacion: Para hacer dinamico el $iniciarLimit que establece el incio de los productos a mostrar, cogemos el $_GET["pagina"]que empieca en 1 y le restamos 1 porque empiza a leer los productos desde 0,
      //ahora si 0 lo multiplicamos por el $producto_x_pagina 0*6 es igual a 0 , entoneces iniciamos el limit en 0 , y con esto establecemos el limit de la consulta de inicio en 0.
      //ahora si al cambiar de pagina  a la pagina 2 ,volvemos a usar el  $_GET["pagina"] para calcular el inicio del Limit, $_GET["pagina"]  nos vale 2 , entonces si a 2 le restamos 1 , nos da 1 y entonces esa pagina 1 la multimplicamos por 6 $producto_x_pagina entonces nos da 6 .Esto quiere decir que cambia el limit de la consulta de 0 que estaba antes a 6
      //ahora si volvemos a usar el $_GET["pagina"] para calcular el inicio , al cambiar de pagina estariamos en $_GET["pagina"] 3 si le restamos 1  nos vale 2, entonces si ese 2 lo multimplicamos por 6 $producto_x_pagina no da igual a 12. Esto quiere decir que cambia el limit de la consulta de 0 que estaba antes a 12
      $iniciarLimit = ($_GET["pagina"]-1)*$producto_x_pagina;

      $sql = "SELECT * FROM productos ORDER BY RAND() LIMIT $iniciarLimit,$producto_x_pagina";

      $result = $this->database->query($sql); //ejecutamos la consulta

      return $result; //devolvemos todos los productos ----haciendo el foreach en la vista para mostrar todas las filas
    }
    //funcion para calcular el numero total de paginas , primero hay que contar los productos que tenemos y segundo hay que dividirlos por el numero de paginas que queremos
    //funcion para usarla en homeControlador metodo home() , nos cuenta las filas de la base de datos que tenemos en total  y gracias a eso obtenemos el numero total de productos.
    //Con el numero total de producto lo podemos dividir por el numero de productos que desemamos que se muestren y asi nos ayuda en la paginacion en homeControlador metodo home()
    public function countRowProduct(){
      $sql = "SELECT COUNT(id_productos) as total_productos FROM productos";

      $result = $this->database->query($sql); //ejecutamos la consulta

      $cuentaProductos = $result->fetch_assoc(); //la amacenamos para poder usarla en una operacion matematica

        $articulo_x_pagina = 6;//definmos los articulos por pagina que queremos
        //Calculamos las paginas que van a ser igual al total de elementos que nos vengan de nuestra base de datos $cuentaProductos dividido entre los $articulo_x_pagina que queremos mostrar
        $paginas = $cuentaProductos["total_productos"]/6;
        //redondemos para arriba arriba para que nos de un numero exacto y no se quede ningun producto fuera
        $paginas = ceil($paginas);//redondemos para arriba arriba

      return $paginas;
    }
    //funcion para usarla en homeControlador arboles(), postales(),luces(),belenes() y adornos .Nos muestra todas las categorias de ese tipo dependiendo del parametro de categoria que le pasemos, debe ser un numero ya que en la bd esta regsitrado como numero
    public function getOneCategoria($miCategoria){

      $producto_x_pagina = 6; //articulos que queremos por pagina
      //explicacion: Para hacer dinamico el $iniciarLimit que establece el incio de los productos a mostrar, cogemos el $_GET["pagina"]que empieca en 1 y le restamos 1 porque empiza a leer los productos desde 0,
      //ahora si 0 lo multiplicamos por el $producto_x_pagina 0*6 es igual a 0 , entoneces iniciamos el limit en 0 , y con esto establecemos el limit de la consulta de inicio en 0.
      //ahora si al cambiar de pagina  a la pagina 2 ,volvemos a usar el  $_GET["pagina"] para calcular el inicio del Limit, $_GET["pagina"]  nos vale 2 , entonces si a 2 le restamos 1 , nos da 1 y entonces esa pagina 1 la multimplicamos por 6 $producto_x_pagina entonces nos da 6 .Esto quiere decir que cambia el limit de la consulta de 0 que estaba antes a 6
      //ahora si volvemos a usar el $_GET["pagina"] para calcular el inicio , al cambiar de pagina estariamos en $_GET["pagina"] 3 si le restamos 1  nos vale 2, entonces si ese 2 lo multimplicamos por 6 $producto_x_pagina no da igual a 12. Esto quiere decir que cambia el limit de la consulta de 0 que estaba antes a 12
      $iniciarLimit = ($_GET["pagina"]-1)*$producto_x_pagina;

      $sql = "SELECT * FROM productos WHERE categoria_id = $miCategoria LIMIT $iniciarLimit,$producto_x_pagina";

      $result = $this->database->query($sql); //ejecutamos la consulta

      return $result; //devolvemos todos los productos ----haciendo el foreach en la vista para mostrar todas las filas



    }
    //funcion que cuenta el numero de productos de la categoria dependiendo si estamos en arboles(cuenta todos los arboles),luces(cuenta todas las luces) y asi dependiendo del numero de categoria que le pasemos por parametro
    public function countRowProduct_Categoria($numeroCategoria){
      $sql = "SELECT COUNT(id_productos) as total_productos FROM productos WHERE categoria_id = $numeroCategoria";

      $result = $this->database->query($sql); //ejecutamos la consulta

      $cuentaProductos = $result->fetch_assoc(); //la amacenamos para poder usarla en una operacion matematica

        $articulo_x_pagina = 6;//definmos los articulos por pagina que queremos
        //Calculamos las paginas que van a ser igual al total de elementos que nos vengan de nuestra base de datos $cuentaProductos dividido entre los $articulo_x_pagina que queremos mostrar
        $paginas = $cuentaProductos["total_productos"]/6;
        //redondemos para arriba arriba para que nos de un numero exacto y no se quede ningun producto fuera
        $paginas = ceil($paginas);//redondemos para arriba arriba

      return $paginas;
    }



  }















 ?>
