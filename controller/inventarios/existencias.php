<?php
    session_start();
    include "../../model/existencias.php";
    $Bodega = new Bodega();
    $desde = $_GET['desde'];
    $hasta = $_GET['hasta'];
    $bodega = $_GET['bodega'];
    echo json_encode($Bodega->productos($desde,$hasta,$bodega));
?>