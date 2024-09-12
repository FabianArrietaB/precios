<?php
    $idusuario = $_POST['idusuario'];
    include "../../model/usuarios.php";
    $Usuarios = new Usuarios();
    echo $Usuarios->eliminarusuario($idusuario);
?>