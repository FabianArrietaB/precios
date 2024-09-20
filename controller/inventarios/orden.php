<?php
    session_start();
    include "../../model/inventarios.php";
    $Inventario = new Inventario();
    $prefijo = $_GET['prefijo'];
    $numero = $_GET['numero'];
    echo json_encode($Inventario->orden($prefijo, $numero));
?>