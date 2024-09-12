<?php
    session_start();
    include "../../model/precios.php";
    $Precios = new Precios();
    $proveedor = $_GET['proveedor'];
    echo json_encode($Precios->productos($proveedor));
?>