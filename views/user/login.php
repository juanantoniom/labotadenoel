

<form class="miRegistro" action="http://localhost/labotadenoel/?nombre_del_controlador=user&action=loginUsuario" method="post">
  <div class="form-group">
    <label for="correo">Correo</label><br>
    <input  class="form-control"type="email"  id="correo" name="correo" placeholder="correo">

  </div>
  <div class="form-group">
    <label for="contrasena">Contraseña</label><br>
    <input class="form-control" type="password" id="contrasena" name="pass" placeholder="contraseña">
  </div>
  <div class="form-group">
    <span class="spanError"><?php  echo !isset($_SESSION["errorLogin"]) ? $_SESSION["errorLogin"] =""  :  $_SESSION["errorLogin"] ?></span>

  </div>

  <button type="submit" class="btn btn-primary">Entrar</button>
  <br>
  <p>¿No tienes cuenta?</p><a href="http://localhost/labotadenoel/?nombre_del_controlador=user&action=registroNewUser" class="btn btn-warning">Registrate</a>
</form>
<?php //cerramos la sesion llamando al metodo estatico deleteSession($nombredeSesion) de la clase funciones_utiles de la carpeta helpers.Para cuando el usuario recargue la pagina no le salte el mensaje de error otra vez
      funciones_utiles::deleteSession('errorLogin');          ?>
