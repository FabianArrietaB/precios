<?php
    session_start();
    include "../../model/existencias.php";
    $Bodega = new Bodega();
    $referencia = $_GET['referencia'];
    echo json_encode($Bodega->entradas($referencia));
?>