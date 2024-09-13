<?php
    session_start();
    include "../../model/inventarios.php";
    $Inventario = new Inventario();
    $desde = $_GET['desde'];
    $hasta = $_GET['hasta'];
    $bodega = $_GET['bodega'];
    echo json_encode($Inventario->stock($desde,$hasta,$bodega));
?>