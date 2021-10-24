<?php

class funciones_utiles{

  //creamos una funcion para poder borrar sesion al recargar la pagina , pansdole por parametro el nombre de la sesion, asi nos vale para cualquier sesion que queramos borrar al recargar la pagina
  //esta funcion es llamada en la vista que queramos quitar la session cuando recargue la pagina
  public static function deleteSession($nombredeSesion){
    if (isset($_SESSION[$nombredeSesion])) {//si esta creada la sesion con ese nombre entra aqui

        unset($_SESSION[$nombredeSesion]);//borramos la sesion al regargar la pagina
    }
    return $nombredeSesion;
  }
  //funcion que nos muestra el numero total de productos que tenemos en el carrito y la cantidad que tenemos
  public static function numberCarrito(){
    //primero creamos una variable array con 2 valores cantidad y total y los inicializamos a 0
    $numerosDelcarrito = array("cantidad" => 0, "total" => 0);
    //si ha agregado cosas al carrito rellenamos el array que hemos creado $numerosDelcarrito
    if(isset($_SESSION["carrito"])) {
      // $numerosDelcarrito["cantidad"]= count($_SESSION["carrito"]); //esto contaria solo cada indice del array 1 vez, es decir que no contaria si pincha en un producto dos veces la segunda vez no la contaria. Para que cuente cada producto una vez , sea repetido o no lo hacemos dentro del foreach

      //ahora sacamos el total , recorriendo cada fila del producto mostrado en el carrito
      foreach ($_SESSION["carrito"] as $key => $value) {//recorre
        //cada vez que recorra cada fila del carrito multiplica el precio por las unidadesDelProducto y esto lo hacemos para calcular el total de la cantidad de ese producto comprado
        //y lo guardamos en la variable $numerosDelcarrito["total"] y le ponemos += para que me sume lo que ya habia en el carrito mas el siguiente producto y asi hasta que termine de recorrer el bucle
        $numerosDelcarrito["total"] += $value["precio"] * $value["unidadesDelProducto"];
        //guardamos en cantidad  la cantidad de veces que el usuario ha hecho click en Agregar al carro . Como unidadesDelProducto vale 1  , la vamos guardando en $numerosDelcarrito["cantidad"] y le ponemos += para que vaya acumulandose y no solo lo machaque cada vez que recorra el bucle
        //$_SESSION["carrito"][$key]<---seria el incide de cada array
        $numerosDelcarrito["cantidad"] += $_SESSION["carrito"][$key]["unidadesDelProducto"];
      }
    }


    //hacemos que nos devuelva el array $numerosDelcarrito para usarlo en cada vista de forma estatica
    return $numerosDelcarrito;
  }



}















 ?>
