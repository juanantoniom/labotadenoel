<?php
//*****************requires para llamada al ayax que van por otra ruta****************//no funciona habria que cambiar todos los requires al index
//require_once "../config/database.php";

require_once 'config/database.php'; //requerimos el archivo que tiene el metodo estatico para la llamada a la base de datos, este require es la ruta con la que funciona todas las acciones de los controladores que van en medio de la pagina, se hace a traves de esta ruta porque es llamado desde el index y no hay que subir nivel
  class Usuario{
    //propiedades tabla cuenta_usuario

    private $nombre_usuario;
    private $email;
    private $contrasena;
    private $rol; //declaramos la variable y la iniciamos en el constructor.
    //propiedades tabla usario_info
    private $database;//declaramos la variable y la iniciamos en el constructor


    private $nombre;
    private $apellido;
    private $direccion;
    private $localidad;
    private $provincia;
    private $codigo_postal;
    private $telefono;
    private $telefono_movil;
    private $id_usuario; // la usamos para hacer el select de la otra tabla y usarlo en el insert primer.   Y tambien lo usamos para  la funcion guardar_usuario_info y coger el id_usuario por el get del formulario y pasarselo a la funcion guardar_usuario_info

    public function __construct(){
      $this->database = Database::conexion(); //decimos que la variable $database es igual al metodo estatico de la clase Database que hemos importado arriba del todo
      $this->rol = "usuario"; //la iniciamos usuario pero solo sera valido para el uso de inserciones de usuario
    }

    function getNombre_usuario(){
      return $this->nombre_usuario;
    }
    function setNombre_usuario($nombre_usuario){  //escapamos los valores que vengan del formulario para asi evitamos inyecciones sql
      $this->nombre_usuario = $this->database->real_escape_string($nombre_usuario);
    }
    function getEmail(){
      return $this->email;
    }
    function setEmail($email){
      $this->email = $this->database->real_escape_string($email);
    }
    function getContrasena(){
      //return $this->contrasena;           //ciframos la contraseña con el metodo password_hash  // cost use for find balance on security and performance
      return password_hash($this->database->real_escape_string($this->contrasena), PASSWORD_BCRYPT, ['cost' => 4]);
    }
    function setContrasena($contrasena){
      $this->contrasena = $contrasena;
    }



    function getId_usuario(){
      return $this->id_usuario;
    }
    function setId_usuario($id_usuario){ //lo usamos para recoger el id_usuario
      $this->id_usuario = $this->database->real_escape_string($id_usuario);
    }
    function getNombre(){
      return $this->nombre;
    }
    function setNombre($nombre){
      $this->nombre = $this->database->real_escape_string($nombre);
    }
    function getApellido(){
      return $this->apellido;
    }
    function setApellido($apellido){
      $this->apellido = $this->database->real_escape_string($apellido);
    }
    function getDireccion(){
      return $this->direccion;
    }
    function setDireccion($direccion){
      $this->direccion = $this->database->real_escape_string($direccion);
    }
    function getLocalidad(){
      return $this->localidad;
    }
    function setLocalidad($localidad){
      $this->localidad = $this->database->real_escape_string($localidad);
    }
    function getProvincia(){
      return $this->provincia;
    }
    function setProvincia($provincia){
      $this->provincia = $this->database->real_escape_string($provincia);
    }
    function getCodigo_postal(){
      return $this->codigo_postal;
    }
    function setCodigo_postal($codigo_postal){
      $this->codigo_postal = $this->database->real_escape_string($codigo_postal);
    }
    function getTelefono(){
      return $this->telefono;
    }
    function setTelefono($telefono){
      $this->telefono = $this->database->real_escape_string($telefono);
    }
    function getTelefono_movil(){
      return $this->telefono_movil;
    }
    function setTelefono_movil($telefono_movil){
      $this->telefono_movil = $this->database->real_escape_string($telefono_movil);
    }


    public function guardar_cuenta_usuario(){
        //insertamos en la tabla cuenta_usuario el usuario que se esta registrando
        //agregamos los {} para meter las variables dentro de las "" , esto se llama interpolacion de variable
        $sql = "INSERT INTO cuenta_usuario (nombre_usuario,email,contrasena,rol)
                VALUES('{$this->getNombre_usuario()}','{$this->getEmail()}','{$this->getContrasena()}','{$this->rol}')";

        $result1 = $this->database->query($sql); //ejecutamos la sql de insercion

        if ($result1) {//si la primera insercion ha sido ejecutada con exito nos devuelve true

          $select_id_usuario_tabla_cuenta_usuario = "SELECT id_usuario FROM cuenta_usuario ORDER BY  id_usuario  DESC LIMIT 1"; //hacemos un select para sacar el ultmo id_usuario de la tabla cuenta_usuario

          $result_select_id_usurio_tabla_cuenta_usuario = $this->database->query($select_id_usuario_tabla_cuenta_usuario);

          while ($row = $result_select_id_usurio_tabla_cuenta_usuario->fetch_assoc()) {//recorremos la tabla para sacar el campo que id_usuario y lo almacenamos en la variable $el_id_usuario_tabla_cuenta_usuario para poder usarla en el insert de usuario_info

              $el_id_usuario_tabla_cuenta_usuario = $row["id_usuario"];//seleccionamos la columna id_usuario de la tabla cuenta_usuario
          }
          if ($result_select_id_usurio_tabla_cuenta_usuario) { //insertamos en la tabla usuarios_info los campos vacios menos el campo id_usuario que es clave foranea y lo necesitamos porque nos sirve para comunicarnos con la tabla cuenta_usuario
            $sql2 = "INSERT INTO usuario_info (nombre,apellido,direccion, localidad,
                                  provincia, codigo_postal,telefono,telefono_movil,id_usuario)
                                  VALUES (null,null,null,null,null,null,null,null,'$el_id_usuario_tabla_cuenta_usuario')";

            $result2 = $this->database->query($sql2); //ejecutamos la segunda consulta
            } if ($result2) {
                return true; //le mandamos true al controlador

            } else {
                return false;

              }

          $this->database->close();
        }

      }
      //funcion para el resgistroNewUser para ver si existe nombre_usuario
      public static function existeUsuario($elusuario){

          $myDatabase = Database::conexion();

          $verificar_usuario = $myDatabase->query("SELECT nombre_usuario FROM cuenta_usuario WHERE nombre_usuario = '$elusuario'");

          $numRows = $verificar_usuario->num_rows;

          if ($numRows > 0) { //si es mayor a 0 significa que  hay un usuario con ese nombre de cuenta

            return true;
          }else {
            return false;
          }

      }
      //funcion para el resgistroNewUser para ver si existe correo
      public static function existeCorreo($email){

          $myDatabase = Database::conexion(); //llamamos a la funcion estatica para poder ser usada dentro de otra estatica

          $sqlCorreo = "SELECT email FROM cuenta_usuario WHERE email = '$email'";

          $verificar_correo = $myDatabase->query($sqlCorreo);

          $numRows = $verificar_correo->num_rows;

          if ($numRows > 0) { //si es mayor a 0 significa que  hay un usuario con ese nombre de cuenta

            return true;
          }else {
            return false;
          }

      }
      //funcion para hacer el login, nos devuleve todas las filas en forma de objeto
      public function compruebaUsuario(){
        $devuelveme = false; //variable para comprobar si no nos devulelve nada
        $correo = $this->email; //
        $pass = $this->contrasena; //no la llamamos por el get porque sino repetiriamos la encriptacion de la password, tenermos que llamarla por el campo de clase

        $sql = "SELECT * FROM cuenta_usuario WHERE email = '$correo'"; //selec del campo contrasena que tiene igual al email pasado

        $result = $this->database->query($sql);

        if ($result && $result->num_rows == 1) { // si la consulta result es correcta y  ademas si equivale a 1 fila  entra aqui

          $usuario = $result->fetch_object(); //llamamos al metodo fetch_assoc para recorrer solo una linea
          //para que funcione password_verify hay que poner el campo contraseña de la tabla en varchar(255) ejemplo ALTER TABLE cuenta_usuario MODIFY contrasena VARCHAR(255)
          $verificamos = password_verify($pass,$usuario->contrasena);// comparamos la $contrasena metida con parametro con la fila del campo contrasena de la bd


           if ($verificamos) { // si es true la password nos devuelve el objeto entero del usuario , osea la fila entera de la bd con cada campo
             $devuelveme = $usuario;

           }
         }

        return $devuelveme;
      }

      //funcion que nos retorna el nombre de usuario. Para usarla dentro de compruebaUsuario() del modelo user.php
      // public function userLogin($email){
      //
      //
      //   $sql = "SELECT nombre_usuario FROM cuenta_usuario WHERE email ='$email'"; //sacamos el nombre_usuario que conincide con el $email del parametro
      //
      //   $result = $this->database->query($sql); //ejecutamos la segunda consulta
      //
      //   if ($result) {
      //     $row = $result->fetch_object();
      //
      //     return $row->nombre_usuario; //imprimimos nombre_usuario
      //   }
      //
      //   //$this->database->close();
      //
      // }


      //funcion para activar el boton de administrar en el header , si es admin le lleva a la vista layout/view/administrar.php
      public function loadRol($email){
                    //si es 0 es usuario, pero si es 1 nos devulve admin y en el cont
        $sql = "SELECT IF( rol = 1 ,'usuario', 'admin')as rol FROM cuenta_usuario WHERE email='$email'";

        $result = $this->database->query($sql);

        if ($result) {//nos devulve 1 si es admin y 0 es usuario , lo llamamos en el controlador en su funcion loadRol
            return $result;
          //
          // $row = $result->fetch_assoc();
          //
          // return $row['rol'];

        }
      }

      //funcion que se encarga de guarda la informacion en la tabla usuario_info   si coincide con el $_POST pasado por parametro que recibe de la vista
      public function guardar_usuario_info(){


        //actualizamos la informacion del usuario  pasandole en el where el parametro por $_POST por el formulario de la vista  al comprar un producto por primera vez , rellena los datos
        $sql = "UPDATE usuario_info SET nombre = '{$this->getNombre()}', apellido = '{$this->getApellido()}', direccion = '{$this->getDireccion()}', localidad = '{$this->getLocalidad()}' ,
                provincia = '{$this->getProvincia()}', codigo_postal = {$this->getCodigo_postal()} ,telefono = {$this->getTelefono()}, telefono_movil = {$this->getTelefono_movil()} WHERE id_usuario = {$this->getId_usuario()}";

        $result = $this->database->query($sql);

        if ($result) {
          return true;
        }else return false;

      }

      //funcion que nos muestra la informacion de la tabla cuenta_usuario y la tabla usuario_info uniendolas con NATURAl JOIN y con la condicion del WHERE que el campo que tienen en comun ambas tablas id_usuario sea igual al $id_usuario que le pasamos por parametro
      //**********IMPORTANTE el NATURAL JOIN hay que tener cuidado y usarlo solo cuando NO se repite el nombre de alguna columna en la otra tabla. Si se repitiera deberiamos usar USING
      public function mostrar_Un_usuarioInfo(){

        $sql = "SELECT * FROM cuenta_usuario NATURAL JOIN usuario_info WHERE id_usuario = {$this->getId_usuario()}";

        $result = $this->database->query($sql);

        $dato_Un_Usuario = $result->fetch_assoc(); //recorremos el resultado en forma asociativa

        return $dato_Un_Usuario; //hacemos que nos devulva el array asociativo
      }





  }

















 ?>
