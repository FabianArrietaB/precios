<?php
    $datos = array(
        "nombre"      => $_POST['nombre'],
        "referencia"  => $_POST['referencia'],
    );

    include "../../model/inventarios.php";
    $Inventario = new Inventario();
    echo $Inventario->rename($datos);
?>