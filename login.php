<?php
session_start();
if (!empty($_SESSION['active']) == true) {
  header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,800;1,100&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="recursos/js/jquery-ui-1.12.1/jquery-ui.min.css" />
  <script language="javascript" src="recursos/js/jquery-3.4.1.min.js"></script>
  <script language="javascript" src="recursos/js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="recursos/css/estilos.css" />
  <script src="https://kit.fontawesome.com/47b4aaa3bf.js" crossorigin="anonymous"></script>
  <title>LOGIN</title>
  <link rel="icon" type="image/png" href="recursos/img/favicon.png" />
</head>

<body>
  <div class="wrapper-login">
    <div class="cont-login">
      <div class="cont-logo">
        <img src="recursos/img/logoPlano-colores.png" alt="">
      </div>
      <form class="formlogin" id="frmlogin" method="post" autocomplete="off">
        <h2>INICIO DE SESIÓN</h2>
        <input type="hidden" name="accion" value="VALIDAR_LOGIN">
        <div class="form-control cont-user">
          <i class="fa-solid fa-user"></i>
          <input type="text" name="user" id="user" placeholder="Username" />
        </div>
        <div class="form-control user">
          <i class="fa-solid fa-unlock-keyhole"></i>
          <input type="password" name="pass" id="pass" placeholder="Contraseña" />
        </div>
        <button type="submit">Ingresar</button>
      </form>
    </div>

  </div>
  <script language="javascript" src="recursos/js/functions.js"></script>
</body>

</html>