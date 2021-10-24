
<?php require_once 'models/productos.php';


  class administrarProductosControlador{
    //muestra todos los productos si eres admin
    public function adminProductos(){

      $productos = new Productos(); //llaamos a la clase del modelo  models/productos.php

      $misProductos = $productos->showAllproducts(); //almacenamos en $misProductos la llamada al metodo para mostrar todos los productos.  Y la usamos en la vista que incluimos abajo
      //también llamamos al metodo static showAllcategorias() y lo llamamos directamente en la vista en el select para que aparezca en sus option cada nombre de categoria
      require_once 'views/layout/header_and_navbar.php';
      require_once "views/productos/administrarProductos.php";//aqui usamos el return result de la funcion showAllproducts
    }
    //inserta producto si eres admin
    public function insertNewproduct(){

      if (isset($_SESSION["admin"])) {

        if (isset($_POST)) {
          //validamos cada campo y comprobamos si cada campo es true
          $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : false;
          $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : false;
          $precio = isset($_POST["precio"]) ? $_POST["precio"] : false;
          $stock = isset($_POST["stock"]) ? $_POST["stock"] : false;
          $categoria = isset($_POST["categoria_id"]) ? $_POST["categoria_id"] : false;
          //$imagen = isset($_POST["imagen"]) ? $_POST["imagen"] : false;

          //si todos son true entra
          if ($nombre && $descripcion && $precio && $stock && $categoria) {

            $producto = new Productos(); //llamamos a la clase y seteamos todos los campos
            $producto->setNombre($nombre);
            $producto->setDescripcion($descripcion);
            $producto->setPrecio($precio);
            $producto->setStock($stock);
            $producto->setCategoria_id($categoria);

            if (isset($_FILES["imagen"])) { //si nos viene el campo $_FILES["imagen"] entra y procece a crear la imagen
              //explicacion guardar de guardar imagen. Tenemos que usar la variable super global $_FILES
              $archivo = $_FILES["imagen"]; //cogemos la variable super global $_FILES y le asignamos el nombre que recogemos en el formulario
              $archivo_nombre = $archivo["name"]; //usamos la variable super global para coger el nombre del archivo y guardarlo en la basde de datos
              $archivo_mimetype = $archivo["type"];
              //comprobamos si el tipo de mimetype es el adecuado entonces entra en el if y creamos una carpeta para guarda la imagen
              if ($archivo_mimetype == "image/jpg" || $archivo_mimetype == "image/jpeg" || $archivo_mimetype == "image/png" || $archivo_mimetype == "image/gif") {
                //comprobamos que no existe el directorio y si es asi lo creamos para guardar dentro la imagen
                if (!is_dir('subidas')) {
                  //creamos el directorio con permisos de lectura y escritura y borrado
                  mkdir('subidas/imagenes',0777, true); //le pasamos true para poder crear directorio recursuvo, uno dentro de otro
                }
                //llamamos la funcion move_uploaded_file que se usa para subir archivos, le pasamos el nombre temporal de archivo (que esto nos llega desde el array $archivo que hemos creado arriba llamado al array super global $FILES["imagen"]),
                //y de segundo parametro le pasamos el nombre del destino a la que lo vamos a mover, es decir el directorio junto con el nombre del archivo.
                move_uploaded_file($archivo['tmp_name'], 'subidas/imagenes/'.$archivo_nombre);
                //guardamos la imagen en el setter
                $producto->setImagen($archivo_nombre);
              }
            }


            //llamamos al metodo InsertNewProduct y comprobamos que nos envia true
            $saveNewProduct = $producto->InsertNewProduct();
            if ($saveNewProduct) { //si $saveNewProduct es true entra y nos crea una sesion con mensage de exito

              $_SESSION["messageInsert"] = "insercion con exito";
            }else {
              $_SESSION["messageInsert"] = "algun campo esta mal la imagen debe ser en formato jpg jpeg png gif";
            }


          }else {
            $_SESSION["messageInsert"] = "rellena todos los campos";
          }

        }
        header("Location:http://localhost/labotadenoel/?nombre_del_controlador=administrarProductos&action=administrar_Paginacion");
      }


    //  header("Location:http://localhost/labotadenoel/?nombre_del_controlador=administrarProductos&action=adminProductos");
      //require_once 'views/productos/administrarProductos.php';

    }
    //funcion que borra un producto ya guardado
    public function delete(){

      if (isset($_SESSION["admin"])) { //verificamos si somos admin
        if (isset($_GET["id_producto"])) { //verificamos si nos ha llegado el get llamado id_producto por la url
          $elid_traido = $_GET["id_producto"]; //almacenamos el get dentro de una variable $elid_traido
          //llamamos a la clase del modelo productos.php
          $producto = new Productos();
          //seteamos el id_producto traido por el get
          $producto->setId_productos($elid_traido);
          //llamamos a la funcion para borrar
          $deleteProduct = $producto->deleteProduct();
          if ($deleteProduct) {
            echo "producto borrado";
          }else {
            echo "error al borrar producto";
          }

        }
      }
      header("Location:http://localhost/labotadenoel/?nombre_del_controlador=administrarProductos&action=administrar_Paginacion");
    }

    //funcion para mostrar un producto en el formulario editarProductos en cada campo autorrellena
    public function showOneProduct(){
      if ($_SESSION["admin"]) {
        if (isset($_GET["id_producto"])) {
          $elidtraido = $_GET["id_producto"];
          $producto = new Productos();

          $producto->setId_productos($elidtraido);

          $unProducto = $producto->showOneProduct();


        }

      }
      require_once 'views/layout/header_and_navbar.php';//llamamos al header y navbar
      //llamamos a la vista para mostrar los datos en cada campo del formulario
      require_once "views/productos/editarProductos.php";

    }
   //funcion para editar producto , IMPORTANTE esta funcion recibe el $_GET["id_producto"] pasado por la url del action del formulario
   //para hacer uso de ese get cuando hacemos la llamada a la funcion $producto->editProduct()
    public function editProduct(){

      if (isset($_SESSION["admin"])) {
        if ($_POST) {
          ///////////////
          //validamos cada campo y comprobamos si cada campo es true
          $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : false;
          $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : false;
          $precio = isset($_POST["precio"]) ? $_POST["precio"] : false;
          $stock = isset($_POST["stock"]) ? $_POST["stock"] : false;
          $categoria = isset($_POST["categoria_id"]) ? $_POST["categoria_id"] : false;

          //////////////////*********
          if ($nombre && $descripcion && $precio && $stock && $categoria) {

            $producto = new Productos(); //llamamos a la clase y seteamos todos los campos
            $producto->setNombre($nombre);
            $producto->setDescripcion($descripcion);
            $producto->setPrecio($precio);
            $producto->setStock($stock);
            $producto->setCategoria_id($categoria);

            if (isset($_FILES["imagen"])) { //si nos viene el campo $_FILES["imagen"] entra y procece a crear la imagen
              //explicacion guardar de guardar imagen. Tenemos que usar la variable super global $_FILES
              $archivo = $_FILES["imagen"]; //cogemos la variable super global $_FILES y le asignamos el nombre que recogemos en el formulario
              $archivo_nombre = $archivo["name"]; //usamos la variable super global para coger el nombre del archivo y guardarlo en la basde de datos
              $archivo_mimetype = $archivo["type"];
              //comprobamos si el tipo de mimetype es el adecuado entonces entra en el if y creamos una carpeta para guarda la imagen
              if ($archivo_mimetype == "image/jpg" || $archivo_mimetype == "image/jpeg" || $archivo_mimetype == "image/png" || $archivo_mimetype == "image/gif") {
                //comprobamos que no existe el directorio y si es asi lo creamos para guardar dentro la imagen
                if (!is_dir('subidas')) {
                  //creamos el directorio con permisos de lectura y escritura y borrado
                  mkdir('subidas/imagenes',0777, true); //le pasamos true para poder crear directorio recursuvo, uno dentro de otro
                }
                //llamamos la funcion move_uploaded_file que se usa para subir archivos, le pasamos el nombre temporal de archivo (que esto nos llega desde el array $archivo que hemos creado arriba llamado al array super global $FILES["imagen"]),
                //y de segundo parametro le pasamos el nombre del destino a la que lo vamos a mover, es decir el directorio junto con el nombre del archivo.
                move_uploaded_file($archivo['tmp_name'], 'subidas/imagenes/'.$archivo_nombre);
                //guardamos la imagen en el setter
                $producto->setImagen($archivo_nombre);
              }
            }

            if (isset($_GET["id_producto"])) {

              $elidtraido = $_GET["id_producto"];
              $producto->setId_productos($elidtraido);
              //llamamos al metodo editProduct y comprobamos que nos envia true

              $saveNewProduct = $producto->editProduct();
            }

            if ($saveNewProduct){ //si $saveNewProduct es true entra y nos crea una sesion con mensage de exito

              $_SESSION["messageInsert"] = "insercion con exito";
                            
              header("Location:http://localhost/labotadenoel/?nombre_del_controlador=administrarProductos&action=administrar_Paginacion&paginaActual=1");
            }else {
              $_SESSION["messageInsert"] = "algun campo esta mal la imagen debe se en formato jpg jpeg png gif";
            }


          }else {
            $_SESSION["messageInsert"] = "rellena todos los campos";
          }
          ///////////////
        }//end isset POST
      }//end isset admin
      require_once 'views/layout/header_and_navbar.php';
      require_once "views/productos/editarProductos.php";

    }//end class


    public function administrar_Paginacion(){

      $productos = new Productos(); //llaamos a la clase del modelo  models/productos.php

      $_POST["paginaActual"] = 1; // esta variable la va a usar el modelo productos.php su funcion showAllproducts() para poner un valor dinamido al  LIMIT de la consulta
      //es decir $_POST["paginaActual"] es para hacer dinamico el inicio del LIMIT de la consulta
      //$_POST["paginaActual"] = 1 la iniciamos a 1 pero luego en el modelo productos.php la funcion showAllproducts() le restamos el 1 para que empieze desde 0
      $misProductos = $productos->showAllproducts(); //almacenamos en $misPedidos la llamada al metodo para mostrar todos los pedidos.  Y la usamos en la vista que incluimos abajo

      $numerodePaginas = $productos->countRowProduct(); //funcion que se encarga de sacar el numero de paginas




      require_once 'views/layout/header_and_navbar.php';
      require_once "views/productos/administrarProductos.php";//aqui usamos el return result de la funcion showAllproduct

      if ($_POST["paginaActual"]<=1) { //si el numero del input que recibimos de la paginaActual es menor o = a 1 le agregamos el atributo disabled al boton para que no pueda ir para atras mas veces y de error

        echo '<script type="text/javascript">' .
        'document.getElementById("anterior").setAttribute("disabled","true")' .
        '</script>';
      }

    }

    //funcio de paginacion boton Siguiente y Atras gracias al form de la paginacion de administrarProductos
    public function button_Next_and_back_pagination(){

      if (isset($_POST["siguiente"])) { //si ha pulsado el boton siguiente
        $productos = new Productos(); //llaamos a la clase del modelo  models/productos.php
        $_POST["paginaActual"]++;//le sumamos 1 al campo input y este dato va a la bbdd modelo pedidos.php funcion showAllproduct() para que pueda operar con el

        $misProductos = $productos->showAllproducts(); //almacenamos en $misProductos la llamada al metodo para mostrar todos los productos.  Y la usamos en la vista que incluimos abajo

        $numerodePaginas = $productos->countRowProduct(); //funcion que se encarga de sacar el numero de paginas


      }

      if (isset($_POST["anterior"])) {
        $productos = new Productos(); //llaamos a la clase del modelo  models/productos.php
        $_POST["paginaActual"]--;//le restamos 1 al campo input de la pagina actual y este dato va a la bbdd modelo pedidos.php funcion showAllPedidosandUser() para que pueda operar con el

          $misProductos = $productos->showAllproducts(); //almacenamos en $misPedidos la llamada al metodo para mostrar todos los pedidos.  Y la usamos en la vista que incluimos abajo

          $numerodePaginas = $productos->countRowProduct(); //funcion que se encarga de sacar el numero de paginas

      }



      require_once 'views/layout/header_and_navbar.php';
      require_once "views/productos/administrarProductos.php";

      if ($_POST["paginaActual"]<=1) { //si el numero del input que recibimos de la paginaActual es menor o = a 1 le agregamos el atributo disabled al boton para que no pueda ir para atras mas veces y de error

        echo '<script type="text/javascript">' .
        'document.getElementById("anterior").setAttribute("disabled","true")' .
        '</script>';
      }

      if ($_POST["paginaActual"]>=$numerodePaginas) {//si el numero del input que recibimos de la paginaActual es mayor o = al $numerodePaginas le agregamos el atributo disabled al boton para que no pueda ir para siguiente mas veces y de error

        echo '<script type="text/javascript">' .
        'document.getElementById("siguiente").setAttribute("disabled","true")' .
        '</script>';
      }


    }










} ?>
