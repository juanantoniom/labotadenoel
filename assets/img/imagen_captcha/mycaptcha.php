<?php


  session_start(); //iniciamos el session_start para poder crear la session que utilizamos en el validador del captcha

  $imagen1direccion =  'imagen_captcha.jpg';

  $imagen2direccion =  'imagen_captcha2.jpg';

  $imagen3direccion =  'imagen_captcha3.jpg';


  $imagenArraydeCaptcha = array( $imagen1direccion,$imagen2direccion, $imagen3direccion);//creamos un array de los ficheros

  $imagenCaptchaRandom = array_rand($imagenArraydeCaptcha,1); //creamos una variable que con la funcion array_rand nos devuelve un numero aleatorio del array

  //para que reconozca esta funcion imagecreatefromjpeg, hay que meterse en c:\xampp\php\php.ini y vendra comentado ;extension=gd , pues hay que descomentarlo y quitandole el punto y coma ;
  $imagen = imagecreatefromjpeg($imagenArraydeCaptcha[$imagenCaptchaRandom]); //creamos imagen jpg que cogemos del array $imagenArraydeCaptcha y llamamos a un numero indice aleatorio

  $colorimage = imagecolorallocate($imagen,0,0,0); //color de la imagen

  $alfanumerico_random = md5(rand()); //creamos un alfanumerico random

  $codigo_captcha = substr($alfanumerico_random,0,6); // creamos variable que recoga el codigo random que vaya del 0 al 6

  $_SESSION['captcha'] = $codigo_captcha; //almacenamos el codigo en una variable de session

  $fuente_texto = dirname(__FILE__ , 4 ) . '/assets/css/fuentes/OpenSans/OpenSans-SemiBold.ttf'; //accedemos a la snmp_get_valueretrieval

  imagettftext($imagen, 20, rand(-10,10), 80, 30, $colorimage, $fuente_texto, $codigo_captcha);
	header('Content-type: image/jpg');

	 imagejpeg($imagen);

   imagedestroy($imagen);



 ?>
