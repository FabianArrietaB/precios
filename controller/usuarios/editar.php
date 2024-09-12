<?php
    session_start();
    $datos = Array(
        'idoperador' => $_SESSION['usuario']['preid'],
        "idusuario"  => $_POST['idusuario'],
        "idrol"      => $_POST['idrolu'],
        "idarea"     => $_POST['idareau'],
        "idsede"     => $_POST['idsedeu'],
        "usuario"    => $_POST['usuariou'],
        "password"   => md5($_POST['passwordu']),
    );
    include "../../model/usuarios.php";
    $Usuarios = new Usuarios();
    echo $Usuarios->editarusuario($datos);
?>