<?php
    include "../../model/inventarios.php";
    $Inventario = new Inventario();
    $referencia  = $_GET['referencia'];
    echo $Inventario->consulta($referencia);
?>