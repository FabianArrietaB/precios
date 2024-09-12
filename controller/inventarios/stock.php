<?php
    include "../../model/inventarios.php";
    $inventario = new Inventario();
    echo json_encode($inventario->stock());
?>