<?php
    include "../../model/conexion.php";
    $refere  = "";
    if(isset($_GET['refere'])){
        $refere=$_GET["refere"];
    }
    $con = new Conexion();
        $sql = $con->conectarFomplus()->prepare('SELECT
        l.PRE_REFER   referencia,
        l.PRE_CODIGO  codigo,
        l.PRE_OBSERV  nombre,
        l.PRE_VALOR   valor,
        p.INV_NOMBRE  producto
    FROM METROCERAMICA.dbo.LISPRE l
    LEFT JOIN METROCERAMICA.dbo.MAEINV p ON p.INV_REFER = l.PRE_REFER
    WHERE l.PRE_REFER = ? AND l.PRE_CODIGO IN (0, 1, 2)');
    $sql->execute(array($refere));
    $precios = $sql->fetchAll(PDO::FETCH_OBJ);
    $data = array();
    foreach ($precios as $precios) {
        $data[] = array(
            "refere"   => $precios->referencia,
            "producto"   => $precios->producto,
            "codigo"   => $precios->codigo,
            "nombre"   => $precios->nombre,
            "valor" => $precios->valor,
        );
    }
    echo json_encode($data);
?>