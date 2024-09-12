<?php
    include "../../model/conexion.php";
    $con = new Conexion();
    $codigo =    $_POST['liscod'];
    $refere =    $_POST['refere'];
    $lista =     $_POST['lista'];
    $precio =    $_POST['precio'];
    $newprecio = $_POST['newprecio'];
    $sql = $con->conectarFomplus()->prepare('UPDATE METROCERAMICA.dbo.LISPRE SET PRE_VALOR = ? WHERE PRE_REFER = ? AND PRE_CODIGO = ?');
    $sql->execute(array($newprecio, $refere, $codigo));
    return $sql;
?>