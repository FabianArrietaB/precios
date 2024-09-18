<?php
    include "../../model/inventarios.php";
    $Inventario = new Inventario();
    $codigo = $_POST['codigo'];
    $producto = $_POST['nombre'];
    $referencia = $_POST['referencia'];
    echo $Inventario->addreferencia($codigo, $producto, $referencia);
?>