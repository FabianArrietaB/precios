<?php
    include "../../model/conexion.php";
    $con = new Conexion();
    $conexion = $con->conectar();
    $search = strip_tags(trim($_GET['persona']));
    // Do Prepared Query
    $query = "SELECT * FROM personas WHERE per_nombre LIKE '%$search%' || per_docume LIKE '%$search%' LIMIT 40";
    // Do a quick fetchall on the results
    $respuesta = mysqli_query($conexion, $query);
    $list = array();
    while ($list=mysqli_fetch_array($respuesta)){
        $data[] = array(
            'id' => $list['id_persona'],
            'text' => $list['per_nombre'],
            'docume' => $list['per_docume']
        );
    }
    // return the result in json
    echo json_encode($data);
?>