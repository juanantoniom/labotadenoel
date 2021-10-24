<?php
require_once 'config/database.php';


  class Pedidos{
    private $id_productos; //usada en la funcion pedidos_has_productos , porque ya esta creada de manera autoincremental en la tabla pedidos ,
    private $id_pedido; //usada en la funcion pedidos_has_productos , porque ya esta creada de manera autoincremental en la tabla pedidos ,
    private $precioTotal; //total
    private $unidades;
    private $id_usuarioInfo;

    private $database;

    public function __construct(){
      $this->database = Database::conexion();
    }

    function getId_pedido(){
      return $this->id_pedido;
    }
    function setId_pedido($id_pedido){
      $this->id_pedido = $this->database->real_escape_string($id_pedido);
    }
  
    function getId_usuarioInfo(){
      return $this->id_usuarioInfo;
    }
    function setId_usuarioInfo($id_usuarioInfo){
      $this->id_usuarioInfo = $this->database->real_escape_string($id_usuarioInfo);
    }

    //funcion que nos guarda los datos del pedido confirmado y esta funcion se ejecuta en el controlador antes que la funcion pedidos_has_productos para asi que pueda usar la funcion pedidos_has_productos esta funcion savePedido
    public function savePedido(){


        //para guardar el precioTotal lo sacamos de la funcion static de helper  de funciones_utiles.php
        //que nos devuelve el array con los el total y las unidades del carrito
        $numerosDelcarrito  = funciones_utiles::numberCarrito();

        $precioTotal = $numerosDelcarrito["total"]; //guardamos el total que nos devuelve la funcion numberCarrito en la variable $precioTotal para setarla y usarla en el modelo para guardar




      $sql = "INSERT INTO pedidos  (fecha , hora, coste ,  id_usuarioInfo)VALUES( CURDATE(), CURTIME() ,$precioTotal, {$this->getId_usuarioInfo()} )";

      $result = $this->database->query($sql);




      if ($result) {
        return true;
      }else {
        return false;
      }


    }
    //esta funcion se ejecuta despues de savePedido porque necesita rellenarse con un campo de esa tabla(id_pedido) y otro campo de la tabla productos (id_productos)
    public function save_pedidos_has_productos(){

      $sql = "SELECT LAST_INSERT_ID() AS 'id_pedido'";  //la utilizamos para sarcar ultimo id del insert que se acaba de ejecutar, osea el de la funcion savePedido

      $result = $this->database->query($sql);

      $pedido_id = $result->fetch_object()->id_pedido; //con fetch_object accedemos al sql que hemos llamado id_pedido

      foreach ($_SESSION["carrito"] as $value) {

        $elProducto = $value["productoTodoelObjeto"]; //en esta variable metemos todo el objeto traido de la base de datos para llamarlo en forma de objeto $elProducto->id_productos

        $sql2 = "INSERT INTO pedidos_has_productos (id_pedido , id_producto , unidades) VALUES ( {$pedido_id} , {$elProducto->id_productos} , {$value['unidadesDelProducto']} )";

        $result2 = $this->database->query($sql2);

        //echo $this->database->error;   para ver el error que daba en la base de datos
      }

      if ($result2) {
        return true;
      }else {
        return false;
      }

    }

    //funcion que nos muestra todos los pedidos que ha hecho el usuario y su informacion relevante para enviar el pedido
    public function showAllPedidosandUser(){
      $producto_x_pagina = 6; //articulos que queremos por pagina
      //explicacion: Para hacer dinamico el $iniciarLimit que establece el incio de los productos a mostrar, cogemos el $_POST["paginaActual"]que empieca en 1 y le restamos 1 porque empiza a leer los productos desde 0,
      //ahora si 0 lo multiplicamos por el $producto_x_pagina 0*6 es igual a 0 , entoneces iniciamos el limit en 0 , y con esto establecemos el limit de la consulta de inicio en 0.
      //ahora si al cambiar de pagina  a la pagina 2 ,volvemos a usar el  $_POST["paginaActual"] para calcular el inicio del Limit, $_POST["paginaActual"] nos vale 2 ques lo que tiene en el input, entonces si a 2 le restamos 1 , nos da 1 y entonces esa pagina 1 la multimplicamos por 6 $producto_x_pagina entonces nos da 6 .Esto quiere decir que cambia el limit de la consulta de 0 que estaba antes a 6
      //ahora si volvemos a usar el $_POST["paginaActual"] para calcular el inicio , al cambiar de pagina estariamos en $_POST["paginaActual"] 3 si le restamos 1  nos vale 2, entonces si ese 2 lo multimplicamos por 6 $producto_x_pagina no da igual a 12. Esto quiere decir que cambia el limit de la consulta de 0 que estaba antes a 12

      //en este caso usamos la variable $_POST["paginaActual"] viene valiendo 1 entonces no hay que restarle 1
      $iniciarLimit = ($_POST["paginaActual"]-1)*$producto_x_pagina;

      $sql = "SELECT pe.id_pedido AS 'id_pedido',pe.fecha AS'Fecha', pe.hora AS'Hora', pe.coste AS'Coste_total', pro.nombre AS'Nombre_producto',php.unidades AS'unidades', cu.email AS'Correo', uf.nombre AS'Nombre', uf.direccion AS'Direccion', uf.localidad AS'Localidad', uf.provincia AS'Provincia', uf.telefono AS'Telefono' FROM pedidos pe JOIN usuario_info uf ON uf.id_usuarioInfo = pe.id_usuarioInfo JOIN cuenta_usuario cu ON cu.id_usuario = uf.id_usuario JOIN pedidos_has_productos php ON  php.id_pedido = pe.id_pedido JOIN productos pro ON pro.id_productos = php.id_producto LIMIT $iniciarLimit,$producto_x_pagina";

      $result = $this->database->query($sql);


      return $result;



    }
    //funcion que borra el pedido seleccionado
    public function deletePedido(){

      $sql = "DELETE FROM pedidos WHERE id_pedido = {$this->id_pedido}";

      $result = $this->database->query($sql);

      if ($result) {
        $ok = true;
      }else {
        $ok = false;
      }
      return $ok;

    }

    //esta funcion se divide en 2 paso paso uno la consulta para sacar el total_pedidos y paso 2 el calculo de cuantos ariticulos por pagina queremos
    //funcion que usamos para la paginacion necesitamos que nos devuelva las paginas totales y para ello hay que contar los total_pedidos con la funcion COUNT(id_pedido)
    //Luego a esa consulta hay que ponerle un alias porque hay que utilizarlo total_pedidos.
    //esta consulta se ejecuta y la tenemos que recorrer con fetch_assoc() para poder utilizarla en la
    //en el PASO 2 establecemos el numero de paginas que queremos y ese numero lo dividimos por los total_pedidos que tenemos y con esa division sacamos el numero total de paginas que tenemos
    public function countRowPedidos(){
      //*****PASO 1
        $sql = "SELECT COUNT(id_pedido) as total_pedidos FROM pedidos"; //le ponemos el alias total_pedidos para poder usarlo

        $result = $this->database->query($sql);

        $cuenta_pedido = $result->fetch_assoc(); //la amacenamos para poder usarla en una operacion matematica
      //*** PASO 2
        $articulo_x_pagina = 6;//definmos los articulos por pagina que queremos
        //Calculamos las paginas que van a ser igual al total de elementos que nos vengan de nuestra base de datos $cuentaProductos dividido entre los $articulo_x_pagina que queremos mostrar
        $paginas = $cuenta_pedido["total_pedidos"]/$articulo_x_pagina;
        //redondemos para arriba arriba para que nos de un numero exacto y no se quede ningun producto fuera
        $paginas = ceil($paginas);//redondemos para arriba arriba


        return $paginas;
    }














  }






















 ?>
