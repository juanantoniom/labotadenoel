<?php //funcion que carga todos los controladores de golpe asi no hay que poner en el index cada controlador uno a uno
      //entra a la carpeta de controllers y carga el nombre de cada clase del controlador almacenado ahi.
  function autocarga_de_controladores($nombredelaClase){
    include 'controllers/' . $nombredelaClase .'.php';
  }

  spl_autoload_register('autocarga_de_controladores');


 ?>
