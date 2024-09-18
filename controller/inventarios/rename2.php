<?php
    include "../../model/inventarios.php";
    $Inventario = new Inventario();
    $nombre = $_POST['nombre'];
    $referencia = $_POST['referencia'];
    echo $Inventario->rename2($nombre, $referencia);
?>