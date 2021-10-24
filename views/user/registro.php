
<h2 class="registernewuser">Registro de nuevo usuario</h2>
<form class="miRegistro"  action="http://localhost/labotadenoel/?nombre_del_controlador=user&action=saveNewUser"  method="post"  onsubmit="validarRegistro(event)"> <!--Si no ponemos return el formulario enviará y no esperara ninguna respuesta de javascript. Con la palabra return Es como si el formulario pidiese permiso a la función validarRegistro()  para poder ser enviado. Precisa que la función le devuelva true, en caso contrario el formulario no se enviará-->
  <div class="form-group">
    <label for="exampleInputName1">Nombre de usuario</label>
    <input type="text" class="form-control" id="exampleInputName1" name="nameUser" placeholder="Nombre de usuario" value="<?php if(isset($_POST['nameUser'])){ echo $_POST['nameUser'];  } ?>">

      <span id="spanNombre"></span>
      <span class="alertasRegistro"><?php  echo empty($errores['nombre']) ?  $errores['nombre'] = ""  :    $errores['nombre'] ?></span>
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Correo electronico</label>
    <input type="email" class="form-control" id="exampleInputEmail1" name="emailUser" aria-describedby="emailHelp" placeholder="Correo electronico" value="<?php if(isset($_POST['emailUser'])){ echo $_POST['emailUser'];  } ?>">

      <span id="spanCorreo"></span>
      <span class="alertasRegistro"><?php  echo empty($errores['correo']) ?  $errores['correo'] = ""  :    $errores['correo'] ?></span>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Contraseña</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="namePassword" placeholder="Contraseña" value="<?php if(isset($_POST['namePassword'])){ echo $_POST['namePassword'];  } ?>">

      <span id="spanPassword"></span>
     <span class="alertasRegistro"><?php  echo empty($errores['password']) ?  $errores['password'] = ""  :    $errores['password'] ?></span>
  </div>

  <div class="form-group">
    <label for="textCaptcha">Comprobación captcha</label><br>
    <img  id="elcaptcha" class="captcha" src="http://localhost/labotadenoel/assets/img/imagen_captcha/mycaptcha.php" alt="imagen_captcha">
    <button type="btn btn-info" class="reloadMyCaptcha"><span><img src="http://localhost/labotadenoel/assets/img/reload.svg">Recarga</span></button>

    <input type="text" class="form-control" id="el_captcha" name="nameCaptcha" placeholder="introduce el catpcha">

      <span id="spanCaptcha"></span>
      <span class="alertasRegistro"><?php  echo empty($errores['captcha']) ?  $errores['captcha'] = ""  :    $errores['captcha'] ?></span>

  </div>

  <button type="submit" class="btn btn-primary ">Registrarse</button>
</form>
<!-- onsubmit="validarRegistro(event)" -->
