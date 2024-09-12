<?php
   session_start();
   $datos = array(
   'idoperador' => $_SESSION['usuario']['preid'],
   "idpersona"  => $_POST['idpersona'],
   "usuario"    => $_POST['usuario'],
   "password"   => md5($_POST['password']),
   "idrol"      => $_POST['idrol'],
   "idarea"     => $_POST['idarea'],
   "idsede"     => $_POST['idsede'],
   );

   include "../../model/usuarios.php";
   $Usuarios = new Usuarios();
   echo $Usuarios->agregarusuario($datos);
?>