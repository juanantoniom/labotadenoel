//*****Comprobación formulario de registroNewUser******



function validarNombre(){
  var ok = true; // variable para comprobar los if
  var nombre = document.getElementById("exampleInputName1").value;
  var expresionNombre = /([a-zA-Z0-9Á-ÿ\u00f1\u00d1][\s]*)+$/; //expresion regular para que acepte minusculas de la a-z , mayusculas de A-Z , numeros del 0-9,Palabras con acento y dieresis Tanto mayusculas como minusculas por eso combinamos Mayuscula la A y minuscula la ÿ, y que acepte el caracter ñ minuscula y acepte Ñ mayuscula, [\s] puede tener espacios en blanco, * los espacios en blanco se puede repetir 0 o mas veces, + se puede repetir 1 o mas veces

  if (nombre.length == 0) { //pregutamos si esta vacia

    ok = false;
    document.getElementById("spanNombre").classList.add("alertasRegistro");
    document.getElementById("spanNombre").innerHTML="no puede estar vacio";
  }else if (/^\s+$/.test(nombre)) { //preguntamos si solo hay espacios en blanco
    ok = false;

    document.getElementById("spanNombre").classList.add("alertasRegistro");
    document.getElementById("spanNombre").innerHTML="no puede tener solo espacios";

  }else if (/^\d+$/.test(nombre)) { //preguntamos si solo esta compuesto de numeros
    ok = false;


    document.getElementById("spanNombre").classList.add("alertasRegistro");
    document.getElementById("spanNombre").innerHTML="no puede tener solo numeros";
  }else if (expresionNombre.test(nombre)) {
    ok = true;
    document.getElementById("spanNombre").innerHTML="";
  }
  return ok; // devolvemos el booleano que nos hace falta para el if de la funcion validarRegistro
};

function validarCorreo(){
  var ok = true; // variable para comprobar los if
  var correo = document.getElementById("exampleInputEmail1").value;
  var expresionCorreo = /[a-zA-ZÁ-ÿ0-9!#$%&'*+/=?^`{|}~._-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9]+)*$/; //expresion regular captura una serie de caracteres, + una o mas veces, le sigue un arroba, le sigue minusculas o mayusculas o numeros, + una o mas veces, un grupo de multiples carecetes alfanumericos, que pueden ser uno o mas, Cero o más repeticiones de lo que precede

  if (correo.length == 0) {
    ok = false;

    document.getElementById("spanCorreo").classList.add("alertasRegistro");
    document.getElementById("spanCorreo").innerHTML="no puede estar vacio";
  }else if (/^\s+$/.test(correo)) {

      ok = false;
      document.getElementById("spanCorreo").classList.add("alertasRegistro");
      document.getElementById("spanCorreo").innerHTML="no puede tener solo espacios";

  }else if (/^\d+$/.test(correo)) {
      ok = false;
      document.getElementById("spanCorreo").classList.add("alertasRegistro");
      document.getElementById("spanCorreo").innerHTML="no puede tener solo numeros";
  }else if (expresionCorreo.test(correo)) {
    ok = true;
    document.getElementById("spanCorreo").innerHTML="";
  }
  return ok; // devolvemos el booleano que nos hace falta para el if de la funcion validarRegistro

};

function validarPassword(){
  var ok = true; // variable para comprobar los if
  var password = document.getElementById("exampleInputPassword1").value;
  var expresionPassword = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{3,}$/; //debe tener un minimo de 3 carateces una mayuscula, una minuscula y digitos

  if (expresionPassword.test(password)) { //si coincide con la expresion regula devolvemos true
    document.getElementById("spanPassword").innerHTML="";
    ok = true;
  }else{ //si no coincide con la expresion regular creamos los atributos y devolvemos false

    ok = false;
    document.getElementById("spanPassword").classList.add("alertasRegistro");
    document.getElementById("spanPassword").innerHTML="debe tener un minimo de 3 carateces una mayuscula, una minuscula y numeros";
  }
  return ok; // devolvemos el booleano que nos hace falta para el if de la funcion validarRegistro


};

function validarCaptcha(){
  var ok = true;
  var captcha = document.getElementById("el_captcha").value;

  if(captcha.length == 0){
    document.getElementById("spanCaptcha").classList.add("alertasRegistro");
    document.getElementById("spanCaptcha").innerHTML="no puede estar vacio";
    ok = false;
  }else {
    ok = true;
    document.getElementById("spanCaptcha").innerHTML="";
  }
  return ok;// devolvemos el booleano que nos hace falta para el if de la funcion validarRegistro
}

function validarRegistro(event){ //comprobamos las 4 funciones y devolvemos true si coinciden las tres

   var okNombre = validarNombre(); //almacenamos el booleano que nos devuelve la funcion en okNombre
   var okCorreo = validarCorreo();  //almacenamos el booleano que nos devuelve la funcion en okCorreo
   var okPassword = validarPassword(); //almacenamos el booleano que nos devuelve la funcion en okPassword
   var okCaptcha = validarCaptcha();



  if (okNombre && okCorreo && okPassword && okCaptcha) { //si cada funcion nos devuelte true entra y nos devuelve true , permitiendo validar el formulario

      return true;


  }else {

    event.preventDefault();  //paramos la ejecucion para que no se vaya al servidor
    return false;

  }
};
