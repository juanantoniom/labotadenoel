<?php
  require_once 'models/pedidos.php'; //cargamos el modelo pedido
  //include 'library/dompdf/autoload.inc.php'; //requerimos para poder usar la libreria

  // reference the Dompdf namespace
  use Dompdf\Dompdf;

  class PedidoControlador{

    //funcion que nos muestra la vista del formulario para hacer el pedido
    public function placeOrder(){
      if (isset($_SESSION["usuario"])) {
          $miCarritoSesion = $_SESSION["carrito"]; //llamamos a la variable $_SESSION["carrito"] para poder usarla y recorrerla en la vista con foreach y que el usuario pueda ver su confirmacion de compra
          require_once 'views/layout/header_and_navbar.php';
          require_once "views/pedido/hacerPedido.php";
      }else {
        require_once 'views/layout/header_and_navbar.php';
        echo "acceso denegado";
      }

    }
    //funcion que recoge los datos por los value del form "views/pedido/hacerPedido.php"; y nos lo envia por post para poder setearlos y usuarlo en la funcion savePedido del modelo pedido.php
    public function savePedidoController(){
      if (isset($_SESSION["usuario"] , $_POST["hacerPedido"])) {
        $id_usuarioInfo = $_SESSION["usuario"]->id_usuario; //al haber creado la sesion que nos almacene el objeto entero , podemos acceder a cada campo de la bd con la flecha ->


         $pedido = new Pedidos();
         // $pedido->setPrecioTotal($precioTotal);
         $pedido->setId_usuarioInfo($id_usuarioInfo);



         $guardarPedido = $pedido->savePedido(); //guardamos en una variable la llamada al metodo para guardar que nos devolvera true o false

         $guardar_pedidos_has_productos = $pedido->save_pedidos_has_productos();//guardamos en una variable la llamada al metodo para guardar en la otra tabla que nos devolvera true o false

         //si los dos insert son true lo ha guardado y redirgimos a la pagina de pagar y envio recibido
         if ($guardarPedido && $guardar_pedidos_has_productos) {
           // echo "pedido guardado";
           require_once 'views/layout/header_and_navbar.php';
           // mostramos el mensage de que hemos guardado su pedido y le ponemos el boton para simular que va a pagar y este boton lo redirige a la funcion SendPedido() que tenemos abajo
           require_once "views/pedido/pedidoGuardado.php"; //le cargamos esta vista
           // header("Location:http://localhost/labotadenoel/?nombre_del_controlador=pedido&action=showMessageInfoSavePedido");
         }else echo "fallo al guardar";

       }
    }


    //funcion que nos imprime la imagen del pedido ha sido enviado
    //si somos usuario y hemos pulsado el boton buttonPay
    public function SendPedido(){

      if (isset($_SESSION["usuario"] , $_POST["buttonPay"])) {
        require_once 'views/layout/header_and_navbar.php';
        require_once "views/pedido/pedidoEnviado.php";

          $_SESSION["imprimirCarrito"] = $_SESSION["carrito"];  //guardamos la session carrito en otra sesion $_SESSION["imprimirCarrito"] y asi poder cerrar la sesion carrito  $_SESSION["carrito"]
          //llamamos a la funcion static para poder borrar cualquier sesion que le pasemos por parametro
          funciones_utiles::deleteSession('carrito');           //para asi poder cerrar la sesion del carrito y que se borre los productos que tengamos ene l carrito arriba a la derecha


      }

    }
    //funcion para imprimir factura al pulsar el enlace imprimir factura
    //incluimos en el index.php include 'library/dompdf/autoload.inc.php';  para poder usar la libreria
    //incluimos use Dompdf\Dompdf; al principio de este codigo para poder usar la clase.
    public function to_print_invoice(){

      if (isset($_SESSION["usuario"] )) {
          $mifactura ="<!DOCTYPE html>
                        <html>
                        <head>
                        <style>
                        table, th, td {
                          border: 1px solid black;
                        }

                        .total{
                          float:right;
                          font-weight: bold;

                        }

                        </style>
                        </head>
                        <body>

                        <h1>La bota de noel</h1>

                        <table style='width:100%'>
                          <tr>
                            <th style='text-align:left'>Nombre</th>
                            <th style='text-align:left'>Precio</th>
                            <th style='text-align:left'>Unidades</th>
                          </tr>
                          <tbody>";
                          $TotalDelcarrito =  0; //declaramos una variable a 0 para guardar el total
                             foreach ( $_SESSION["imprimirCarrito"] as $key => $value){   //$miCarritoSesion
                                  $producto = $value['productoTodoelObjeto'];
                                  $misUnidadesProducto = $value['unidadesDelProducto']; // $value['unidadesDelProducto'] hay que meterlo en una variable sin las comillas simples del corchete porque sino da fallo $value['unidadesDelProducto']

                    $mifactura .= "<tr>";
                    $mifactura .=         " <td>$producto->nombre</td>";
                    $mifactura .=         " <td> $producto->precio</td>";
                    $mifactura .=         " <td>$misUnidadesProducto</td>"; // $value['unidadesDelProducto']; //unidadesDelProducto hay que sacarlo asi porque es un array
                    $mifactura .= "</tr>";

                    $TotalDelcarrito += $producto->precio * $misUnidadesProducto;


                  }// endforeach;
                   // $losnumeros = funciones_utiles::numberCarrito();  //llamamos a la funcion estatica para usar el total
                   // $total = $losnumeros['total'];
                   $mifactura .=         "      </tbody>";
                   $mifactura .=         "     </table>";

                   $mifactura .= "<p class='total'>Total: $TotalDelcarrito €</p>";



                    $mifactura .=         "     </body>";
                    $mifactura .=         "     </html>";
          // instantiate and use the dompdf class   llamamos a la clase
          $dompdf = new Dompdf();
          $dompdf->loadHtml($mifactura);

          // (Optional) Setup the paper size and orientation
          $dompdf->setPaper('A4', 'landscape');

          // Render the HTML as PDF
          $dompdf->render();

          // Output the generated PDF to Browser
          $dompdf->stream();
      }

    }
    //ATENCION esta funcion se complenta con la funcion que tiene abajo button_Next_and_back_pagination por que modifica osea machaca el $_POST["paginaActual"] y le cambia el valor
    //funcion para el administrador  que recibe del modelo pedido.php de su funcion showAllPedidosandUser la consulta para mostrar los pedidos
    public function showAllPedidosandUser_controller(){
      $pedidos = new Pedidos(); //llaamos a la clase del modelo  models/pedidos.php
      $_POST["paginaActual"] = 1; // esta variable la va a usar el modelo pedidos.php su funcion showAllPedidosandUser() para poner un valor dinamido al  LIMIT de la consulta
      //es decir $_POST["paginaActual"] es para hacer dinamico el inicio del LIMIT de la consulta
      //$_POST["paginaActual"] = 1 la iniciamos a 1 pero luego en el modelo pedido.php la funcion showAllPedidosandUser() le restamos el 1 para que empieze desde 0
      $misPedidos = $pedidos->showAllPedidosandUser(); //almacenamos en $misPedidos la llamada al metodo para mostrar todos los pedidos.  Y la usamos en la vista que incluimos abajo

      $numerodePaginas = $pedidos->countRowPedidos();




      require_once 'views/layout/header_and_navbar.php';
      require_once "views/pedido/administrarPedidos.php";//aqui usamos el return result de la funcion showAllPedidosandUser

      if ($_POST["paginaActual"]<=1) { //si el numero del input que recibimos de la paginaActual es menor o = a 1 le agregamos el atributo disabled al boton para que no pueda ir para atras mas veces y de error

        echo '<script type="text/javascript">' .
        'document.getElementById("anterior").setAttribute("disabled","true")' .
        '</script>';
      }



    }
    //funcio de paginacion boton Siguiente y Atras gracias al form de la paginacion de pedidos
    public function button_Next_and_back_pagination(){

      if (isset($_POST["siguiente"])) { //si ha pulsado el boton siguiente
        $pedidos = new Pedidos(); //llaamos a la clase del modelo  models/pedidos.php
        $_POST["paginaActual"]++;//le sumamos 1 al campo input y este dato va a la bbdd modelo pedidos.php funcion showAllPedidosandUser() para que pueda operar con el

        $misPedidos = $pedidos->showAllPedidosandUser(); //almacenamos en $misPedidos la llamada al metodo para mostrar todos los pedidos.  Y la usamos en la vista que incluimos abajo

        $numerodePaginas = $pedidos->countRowPedidos();


      }

      if (isset($_POST["anterior"])) {
        $pedidos = new Pedidos(); //llaamos a la clase del modelo  models/pedidos.php
        $_POST["paginaActual"]--;//le restamos 1 al campo input de la pagina actual y este dato va a la bbdd modelo pedidos.php funcion showAllPedidosandUser() para que pueda operar con el

        $misPedidos = $pedidos->showAllPedidosandUser(); //almacenamos en $misPedidos la llamada al metodo para mostrar todos los pedidos.  Y la usamos en la vista que incluimos abajo

        $numerodePaginas = $pedidos->countRowPedidos();
      }



      require_once 'views/layout/header_and_navbar.php';
      require_once "views/pedido/administrarPedidos.php";

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
    public function deletePedido(){

      if (isset($_SESSION["admin"], $_GET["id_pedido"])) {

          $elid_traido = $_GET["id_pedido"]; //almacenamos el get dentro de una variable $elid_traido

          $pedido = new Pedidos();

          $pedido->setId_pedido($elid_traido);

          $miPedido = $pedido->deletePedido();

          if ($miPedido) {
            echo "pedido borrado";
          }else {
            echo "error al borrar pedido";
          }
       header("Location:http://localhost/labotadenoel/?nombre_del_controlador=pedido&action=showAllPedidosandUser_controller");
      }
    }


  }











 ?>
