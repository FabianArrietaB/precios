<?php
   session_start();
   $datos = array(
   'idoperador'  => $_SESSION['usuario']['preid'],
   "usuarioid"   => $_POST['usuarioid'],
   "newpassword" => md5($_POST['newpassword']),
   );

   include "../../model/usuarios.php";
   $Usuarios = new Usuarios();
   echo $Usuarios->cambiocontraseña($datos);
?>