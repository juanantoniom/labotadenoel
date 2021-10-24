<?php
require_once 'models/productos.php';//llamos al modelo para poder usar su clase y sus metodos
//En esta clase vamos a crear el carrito por sesiones

class CarroControlador{
  //funcion para ver el carrito , nos carga la vista del carrito
  public function VerCarrito(){

    $miCarritoSesion = $_SESSION["carrito"];

    require_once 'views/layout/header_and_navbar.php';
    require_once "views/carrito/carrito.php";
  }



  //funcion para agregar productos al carro
  public function addProduct(){
    //comprobamos que existe el id elegido
    if (isset($_GET["id_producto"])) {
      $elidtraido = $_GET["id_producto"]; //lo guardamos en una variable para usarlo mas abajo y compararlo con el del producto
    }



    //si esta creada la sesion carrito , la recorremos con el foreach para poder sumarle unidades a cada producto y al contador
    if (isset($_SESSION["carrito"])) {


      //recorremos el array con el foreach clave valor y preguntamos en el if si el valor id_producto es igual al idtraido por la url y si es asi le ponemos ++ alas unidades de la $_SESSION["carrito"][$value]["unidadesDelProducto"]
        $condadorIndicesdelArray = 0; //creamos la variable contadorIndicesdelArray para usarla como forma de ver si ese indice del array $_SESSION["carrito"] el indice 0 , 1 , 2 ya ha sido creado o no . Si ha sido creado entra aqui y le sumamos para que luego cuando le preguntemos en el if de abajo por un nuevo indice que no se haya creado baje abajo y cree el array primero y luego si pulsa en el mismo producto suba aqui
        foreach ($_SESSION["carrito"] as $key => $value) {//recorremos el array $_SESSION["carrito"][] en forma clave valor
                                        //$key es el indice de ese array
          if ($value["id_producto"] == $elidtraido) { //si el valor id_producto es igual al id traido por la url , osea por el get que hemos hecho arriba

            $_SESSION["carrito"][$key]["unidadesDelProducto"]++;//seleccionamos el indice llamado $key del array en el que este recorrendiendo en ese momento, ya sea 0 o 1 o 2 , y luego seleccionamos el valor y le sumamos uno
            $condadorIndicesdelArray++;
          }
        }



    }
    //usamos la variable de Session"contador" para ver si ese indice del array $_SESSION esta ya creado o solo hay que amentar las unidadesDelProducto, si solo hay que aumentar las unidadesDelProducto significa que no entra aqui y entra en el if de arriba donde le aumentamos las unidadesDelProducto . Y comparamos la variable $_SESSION["contador"] a 0 o !isset porque como ese indice no ha sido creado no esta
    //si no esta creada la sesion contador que hubieramos creado en el if anterior arriba
    if ($condadorIndicesdelArray == 0 || !isset($condadorIndicesdelArray)) {

      $producto = new Productos();

      $producto->setId_productos($elidtraido);//seteamos el id traido para que lo use la funcion del modelo y nos traiga el producto elegido por el get que esta dentro de la funcion showOneProduct del modelo producto.php

      $producto = $producto->showOneProduct(); //llamamos a la funcion y nos saca ese producto en un objeto


      if (is_object($producto)) {//comprobamos que nos trae e un objeto
      //AVISO no la creamos asi porque la funcion showOneProduct nos retorna ya el resultado para llamarlo con flecha porque nos manda ya un recorrido de la fila de la base de datos , OSEa asi no se haria :   $_SESSION["carrito"][] = array( "id_producto" => $miProducto->getId_productos() , "precio" => $miProducto->getPrecio(), "unidadesDelProducto" => 1 );
      //creamos la sesion carrito , pero como un array de sesion y asi almacenamos en la sesion varios datos
      //
      //le ponemos unidades 1 porque es cada vez que clikea en el boton agregar al carro es 1 vez , osea lo agrega una vez.
      $_SESSION["carrito"][] = array( "id_producto" => $producto->id_productos ,
                                                  "precio" => $producto->precio,
                                                   "unidadesDelProducto" => 1,
                                                   "productoTodoelObjeto" => $producto);
      //Le agregamos un Indice productoTodoelObjeto que llama a todo el objeto y asi podemos llamar en la vista a todo el objeto , osea a la imagen el nombre etc.
      //para poder usar $productoTodoelObjeto lo metemos en una variable en la vista views/carrito/carrito.php
      /* una vez definido el foreach ($miCarritoSesion as $key => $value) {
          $miProducto = $value["productoTodoelObjeto"]

      }
      y de esta forma lo podemos usar como objeto  ejmplo: $miProducto->imagen

      */
      }


    }
    if ($_GET["pagina_detalles"]) { //si el usuario ha pulsado el boton de la pagina detalles que esta en views/home/detalles.php
      header("Location:http://localhost/labotadenoel/?nombre_del_controlador=carro&action=VerCarrito");//nos redirige al carrito directamente
    }else {

      //redirigimos al home para que el usuario vea arriba en el numerito como aumenta su carrito
      header("Location:http://localhost/labotadenoel/?nombre_del_controlador=home&action=home");
    }



    //redirgimos a la vista del carrito
    //header("Location:http://localhost/labotadenoel/?nombre_del_controlador=carro&action=VerCarrito");

  }




  //funcion para borrar los datos del array $_SESSION["carrito"][];
  public function deleteSessionCarrito(){
    unset($_SESSION["carrito"]);

    //redirigimos al home 
    header("Location:http://localhost/labotadenoel/?nombre_del_controlador=home&action=home");
  }
}

















 ?>
