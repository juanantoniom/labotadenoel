$(document).ready(function(e){


  //*********Captcha formulario de registroNewUser********

  var refreshCaptcha = $(".reloadMyCaptcha");

    $(refreshCaptcha).click(function(e){
      $("#elcaptcha").attr("src","http://localhost/labotadenoel/assets/img/imagen_captcha/mycaptcha.php?" + Date.now()); // hacemos uso de la funcion static Date.now() para que nos devuelva en milisegundos la hora actual en la que hacemos click y solicitamos la imagen en la hora actual.

      e.preventDefault(); //paramos la ejecucion para que no nos mande a otra pagina

    });


  //********** slideToggle de la views/home/preguntasFrecuentes.php *************//

  var open = false; //creamos la varibale booleana open en falso . Fuera de la funcion click para que asi cada vez que de click empiece en false la variable open

  $(".container_pregunta").click(function(){

    $(".acordeon").slideToggle("slow");

    open = !open; //cambiamos el valor de open a true, es decir si open no es falso , encontes sera true para el primer if
                  //cuando vuelva a clickar para escoder el arcodeon, la variable open de fuera valdra true y aqui la volvemos false y entra en el else ahora para esconder el acordeon
    if (open) { //si open es true , como lo es entra aqui

              $(".flecha_pregunta").removeClass("animacion_flecha_down"); //borramos la clase que se superpone a este porque solo puede haber 1 a la vez
              $(".flecha_pregunta").addClass("animacion_flecha_up"); //añadimos la clase css que queremos mostrar osea la flecha hacia arriba

    }else { //el segundo click vale false porque vuelve a leer la variable open de fuera que hemos declarado

         $(".flecha_pregunta").removeClass("animacion_flecha_up");//borramos la clase que se superpone a este porque solo puede haber 1 a la vez
         $(".flecha_pregunta").addClass("animacion_flecha_down"); //añadimos la clase css que queremos mostrar osea la flecha hacia abajo

    }


  });






});
