<?php
    session_start();
    include "../../model/existencias.php";
    $Bodega = new Bodega();
    $referencia = $_GET['refere'];
    $desde = $_GET['desde'];
    $hasta = $_GET['hasta'];
    $bodega = $_GET['bodega'];
    echo json_encode($Bodega->moventradas($referencia,$desde,$hasta,$bodega));
?>