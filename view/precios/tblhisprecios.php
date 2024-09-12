<?php
    session_start();
    include "../../model/conexion.php";
    $con = new Conexion();
    $conexion = $con->conectar();
    $idusuario = $_SESSION['usuario']['preid'];
    $sql = "SELECT
        h.id_precios idprecio,
        h.id_operador idoperador,
        u.user_nombre usuario,
        h.pre_refere referencia,
        h.pre_produc producto,
        h.pre_lista lista,
        FORMAT(h.pre_preant, 0) preant,
        FORMAT(h.pre_prenew, 0) prenew,
        h.pre_fecope fecha
        FROM histprecios AS h
        INNER JOIN usuarios u ON u.id_usuario = h.id_operador
        ORDER BY h.id_precios ASC";
    $query = mysqli_query($conexion, $sql);
?>
<!-- inicio Tabla -->
<div class="table-responsive">
    <table class="table table-light text-center">
        <thead>
            <tr>
                <th scope="col" ></th>
            </tr>
        </thead>
        <tbody id="tblhistorial">
        <?php
            while ($historial = mysqli_fetch_array($query)){
        ?>
            <tr>
                <td><?php echo 'El <strong>' . $historial['fecha'] . '</strong> Se actualizo el precio del producto <strong>' . $historial['producto'] . '</strong> con referencia <strong>' . $historial['referencia'] . '</strong> de <strong>' . $historial['preant'] . '</strong> a <strong>$' . $historial['prenew'] . '</strong> en la lista <strong>' . $historial['lista'] . '</strong> por el usuario <strong>' . $historial['usuario'] . '</strong>';?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<!-- fin de la tabla -->
