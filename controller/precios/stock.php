<?php
    include "../../model/conexion.php";
    $refere  = "";
    if(isset($_GET['refere'])){
        $refere=$_GET["refere"];
    }
    $con = new Conexion();
    $sql = $con->conectarFomplus()->prepare('SELECT 
        spb.referencia referencia,
        spb.codigo_bodega codbodega,
        a.ALM_NOMBRE bodega,
        spb.stock stock
    FROM METROPOLIS_EXT.dbo.[_stock_por_bodegas] spb
    INNER JOIN METROCERAMICA.dbo.MAEALM a ON a.ALM_CODIGO = spb.codigo_bodega
    WHERE spb.referencia = ?');
    $sql->execute(array($refere));
    $precios = $sql->fetchAll(PDO::FETCH_OBJ);
    $data = array();
    foreach ($precios as $precios) {
        $data[] = array(
            "refere"   => $precios->referencia,
            "bodega"   => $precios->bodega,
            "stock"   => $precios->stock,
        );
    }
    echo json_encode($data);
?>