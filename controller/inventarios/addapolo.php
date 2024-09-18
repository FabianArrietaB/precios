<?php
    $datos = array(
        "codigo"      => $_POST['codigo'],
        "nombre"      => $_POST['nombre'],
        "referencia"  => $_POST['referencia'],
    );

    include "../../model/inventarios.php";
    $Inventario = new Inventario();
    echo $Inventario->addapolo($datos);
?>