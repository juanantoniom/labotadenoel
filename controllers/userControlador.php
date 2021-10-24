

<?php require_once 'models/user.php'; // no subimos de nivel de carpeta por que estamos llamado a l controlador en el index que esta a fuera con acceso a todas las carpetas

class userControlador{

  //nos redirecciona a la vista para que se registre el nuevo usuario
  public function registroNewUser(){
    require_once "views/layout/header_and_navbar.php";
    require_once 'views/user/registro.php';
  }

  public function saveNewUser(){
    if(isset($_POST)){//recibimos los campos si estan seteados del formulario
      $nombre_usuario = $_POST["nameUser"];
      $email = $_POST["emailUser"];
      $password = $_POST["namePassword"];
      $myCaptcha = $_POST["nameCaptcha"];


      $errores = array(); //creamos un array llamado $errores para almacenar los mensajes de error de cada input

      //Validamos el nombre si es correcto
      $expresionNombre = "/([a-zA-Z0-9Á-ÿ][\s]*)+$/"; //expresion regular para que acepte minusculas de la a-z , mayusculas de A-Z , numeros del 0-9,Palabras con acento y dieresis Tanto mayusculas como minusculas por eso combinamos Mayuscula la A y minuscula la ÿ, y que acepte el caracter ñ minuscula y acepte Ñ mayuscula, [\s] puede tener espacios en blanco, * los espacios en blanco se puede repetir 0 o mas veces, + se puede repetir 1 o mas veces

      if (empty($nombre_usuario)) {
          $errores['nombre'] = "el nombre no puede estar vacio";

      }else if (is_numeric($nombre_usuario)) {
          $errores['nombre'] = "no puede tener solo numeros";

      }else if (preg_match('/^\s+$/',$nombre_usuario )) {
          $errores['nombre'] = "no puede tener solo espacios";

      }else if (Usuario::existeUsuario($nombre_usuario)) { // llamamos a la funcion del modelo si nos devuelve true esque el usuario ya existe
          $errores['nombre'] = "el nombre ya existe";

      }else if (preg_match($expresionNombre,$nombre_usuario )) {//si conincide con la expresion regular , nos devuelve true
          $errores['nombre'] = "";

      }




      //Validamos el correo si es correcto
      $expresionCorreo = "/[a-zA-ZÁ-ÿ0-9!#$%&'*+{|}~._-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9]+)*$/"; //expresion regular captura una serie de caracteres, + una o mas veces, le sigue un arroba, le sigue minusculas o mayusculas o numeros, + una o mas veces, un grupo de multiples carecetes alfanumericos, que pueden ser uno o mas, Cero o más repeticiones de lo que precede

      if (empty($email)) {
          $errores['correo'] = "el nombre no puede estar vacio";

      }else if (is_numeric($email)) {
          $errores['correo'] = "no puede tener solo numeros";

      }else if (preg_match('/^\s+$/',$expresionCorreo)) {
          $errores['correo'] = "no puede tener solo espacios";

      }else if (Usuario::existeCorreo($email)) {
          $errores['correo'] = "el correo ya existe";

      }else if (preg_match($expresionCorreo,$email )) { //si conincide con la expresion regular , nos devuelve true
          $errores['correo'] = "";
      }



    //Validamos la password si es correcta

      $expresionPassword = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{3,}$/"; //debe tener un minimo de 3 carateces una mayuscula, una minuscula y digitos

      if (preg_match($expresionPassword,$password)) {
          $errores['password'] = "";

      }else {
          $errores['password'] = "debe tener un minimo de 3 carateces una mayuscula, una minuscula y digitos";

      }



      //Validamos el captcha si es correcto

      if ($myCaptcha == $_SESSION['captcha'] ) { // si captcha correcto
          $errores['captcha'] = "";

      }else {
          $errores['captcha'] = "rellena el captcha correctamente";

      }


  }

  //Comprobamos que no haya ningun error en el array de errores y si es asi guardamos los campos
  if ($errores['nombre'] == "" && $errores['correo'] == "" && $errores['password'] == "" && $errores['captcha'] == "") {

      $usuario = new Usuario(); //creamos la clase Usuario del modelo para poder usar los setter y trabar con ellos

      $usuario->setNombre_usuario($nombre_usuario);
      $usuario->setEmail($email);
      $usuario->setContrasena($password);

      $guardar_el_usuario = $usuario->guardar_cuenta_usuario();

      if ($guardar_el_usuario) {
        require_once 'views/layout/header_and_navbar.php';//requerimos el header y el navbar
        require_once 'views/user/registroCompletado.php';
      }else {
        echo "error al guardar el usuario";
      }

  }else {
    // echo "ha habido un error";
    // var_dump($errores);
    //mostramos los errores de cada campo en el formulario
    require_once "views/layout/header_and_navbar.php";
    require_once 'views/user/registro.php';
  }

}

//este metodo verifica el login del usuario si es correcto inicia session  y nos muestra el nombre_usuario del usuario ya sea usuario o admin
//explicacion: para hacer uso de todas las columnas de la tabla en la session , la guardamos como el objeto entero en $_SESSION["usuario"]
  public function loginUsuario(){

    if (isset($_POST)) {

      $correo = $_POST["correo"];
      $pass = $_POST["pass"];

      $usuario = new Usuario();
      $usuario->setEmail($correo);
      $usuario->setContrasena($pass);


      $objetoUsuario = $usuario->compruebaUsuario();

      if (is_object($objetoUsuario)) { //preguntamos si es un objeto lo que nos devuelve la funcion compruebaUsuario() del modelo user.php
        //creamos la sesion usuario y almacenamos el $objetoUsuario  para llamarlarlo en la vista del header views/,ayout/header_and_navbar.php
        $_SESSION["usuario"] = $objetoUsuario; //al tratarlo como objeto usamos la sesion asi $_SESSION["usuario"]->nombre; el de la bd

        if ($objetoUsuario->rol == "admin") { //consultamos si el rol del objeto es admin y entonces creamos la sesion admin
          $_SESSION["admin"] = true;
        }

        header("Location:http://localhost/labotadenoel/?pagina=1"); //si se logea correctamente nos redirige al index


      }else {
        $_SESSION["errorLogin"] = "usuario o contraseña erroneo"; //creamos la sesion $_SESSION["errorLogin"] para mostrar el error en  views/user/login.php
      }
    }

     require_once "views/layout/header_and_navbar.php";
     require_once "views/user/login.php"; //cargamos la vista

 }

 //funcion que carga la vista para rellenar el login
  public function buttonIniciarSesion(){
    require_once "views/layout/header_and_navbar.php";
    require_once "views/user/login.php";
  }

  //funcion para cerrar sesion
  public function logout(){
    if (isset($_SESSION["usuario"])) { //si esta isset la variable session usuario entonces la terminamos
      unset($_SESSION["usuario"]);
    }
    if (isset($_SESSION["admin"])) {//si esta isset la variable session admin entonces la terminamos
      unset($_SESSION["admin"]);
    }

    header("Location:http://localhost/labotadenoel/");

  }

  //funcion que nos trae de la bd si el id_usuario traido por $_SESSION["usuario"] , tiene usuarioInfo o no tiene rellena, si la tiene la muestra , sino debe rellenarla y guardar
  //esta funcion se ejecunta cuando se pulsa el boton Realizar pedido de la vista /views/carrito/carrito.php
  public function button_continuar_pedido(){

    if (isset( $_SESSION["usuario"] , $_SESSION["carrito"])){  //para concatear varios isset usamos la coma ,


       //si al pulsar el boton Realizar pedido de la vista /views/carrito/carrito.php  , recibimos del input  name="id_usuario"
       if ($_POST["id_usuario"]) {
         $elId_usuario_traido = $_POST["id_usuario"];
         $usuario = new Usuario();
         $usuario->setId_usuario($elId_usuario_traido); //seteamos el $elId_usuario_traido para que lo pueda coger por getId_usuario() la funcion mostrar_Un_usuarioInfo() del modelo user.php
         //recuerda $dato_Un_Usuario hay que recorrerlo en la vista como asociativo por que asi lo hemos definido en el modelo
         $dato_Un_Usuario = $usuario->mostrar_Un_usuarioInfo(); //usamos funcion en la vista views/user/usuarioInfo.php

         $nombre = $dato_Un_Usuario['nombre'];
         $apellido = $dato_Un_Usuario['apellido'];
         $direccion = $dato_Un_Usuario['direccion'];
         $localidad = $dato_Un_Usuario['localidad'];
         $provincia = $dato_Un_Usuario['provincia'];
         $codigo_postal = $dato_Un_Usuario['codigo_postal'];
         $telefono = $dato_Un_Usuario['telefono'];
         $telefono_movil = $dato_Un_Usuario['telefono_movil'];
         //si vienen vacios o estan null los datos traidos de la bd mostramos una vista con el boton guardar que apunta a la funcion guardar_usuario_info del userControlador , para guardar los datos que meta el usuario
         if ($nombre == '' && $apellido == '' && $direccion == '' && $localidad == '' && $provincia == '' && $codigo_postal == '' && $telefono == '' && $telefono_movil == '') {

           require_once "views/layout/header_and_navbar.php";
           require_once "views/user/usuarioInfo_necesitaRellenarDatosEnvio.php";//esta vista en su action de formulario apuntara al boton button_guardar_usuarioInfo()  para guardar la informacion del usuario
         }else {//si vienen los datos rellenos le mostramos la vista que muestra en cada value los datos del usuario llamando a la variable $dato_Un_Usuario
           require_once "views/layout/header_and_navbar.php";
           require_once "views/user/usuarioInfo_muestraDatosEnvio.php";
         }




       }

    }else {

      require_once "views/layout/header_and_navbar.php";
      require_once "views/user/usuarioInfo_necesitaRellenarDatosEnvio.php";
    }

  }


  public function button_guardar_usuarioInfo(){

    $errores_usuario_info = ''; //creamos una variable para rellenar abajo si algun campo esta vacio

    if (isset($_POST["guardar"])) {
      $id_usuario = $_POST["id_usuario"];
      $nombre = $_POST['nombre'];
      $apellido = $_POST['apellido'];
      $direccion = $_POST['direccion'];
      $localidad = $_POST['localidad'];
      $provincia = $_POST['provincia'];
      $codigo_postal = $_POST['codigo_postal'];
      $telefono = $_POST['telefono'];
      $telefono_movil = $_POST['telefono_movil'];

      if (empty($nombre) || empty($apellido) || empty($direccion) || empty($localidad) || empty($provincia)  || empty($codigo_postal) || empty($telefono) || empty($telefono_movil)) {
          $errores_usuario_info = "no puede estar vacio";

          require_once "views/layout/header_and_navbar.php";
          require_once "views/user/usuarioInfo_necesitaRellenarDatosEnvio.php";//esta vista en su action de formulario apuntara al boton button_guardar_usuarioInfo()  para guardar la informacion del usuario
      }else {
        $usuario = new Usuario(); //llamamos a la clase
        //para poder hacer uso de los seter y seteamos cada campo para pasarle por get a la funcion guardar_usuario_info
        $usuario->setId_usuario($id_usuario);
        $usuario->setNombre($nombre);
        $usuario->setApellido($apellido);
        $usuario->setDireccion($direccion);
        $usuario->setLocalidad($localidad);
        $usuario->setProvincia($provincia);
        $usuario->setCodigo_postal($codigo_postal);
        $usuario->setTelefono($telefono);
        $usuario->setTelefono_movil($telefono_movil);

        $guardar_usuario =  $usuario->guardar_usuario_info();  //almacenamos la funcion guardar del modelo user.php que nos guarda en  la tabla usuarioInfo

        if ($guardar_usuario) {
          require_once "views/layout/header_and_navbar.php";
          require_once "views/user/usuarioInfo_guardadoConexito.php";
        }else {
          echo "fallo al guardar";

        }

      }

    }

      // require_once "views/user/usuarioInfo_necesitaRellenarDatosEnvio.php";



  }



} ?>
