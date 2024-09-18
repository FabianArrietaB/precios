<?php
    session_start();
    $datos = Array(
        "codigo"       => $_POST['codigo'],
        "producto"     => $_POST['nombre'],
        "referencia"   => $_POST['referencia'],
        );
    include "../../model/inventarios.php";
    $inventario = new inventario();
    echo $inventario->addreferencia($datos);
?>