<?php
    session_start();
    if ($_SESSION['usuario']['prerol'] == 4) {
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
    } else {
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
            WHERE h.id_operador = $idusuario
            ORDER BY h.id_precios ASC";
        $query = mysqli_query($conexion, $sql);
    }
?>
<!-- inicio Tabla -->
<div class="table-responsive">
    <table class="table table-light text-center">
        <thead>
            <tr>
                <?php if ($_SESSION['usuario']['prerol'] == 4) { ?>
                    <th scope="col" >USUARIO</th>
                <?php } ?>
                <th scope="col" >NOMBRE PRODUCTO</th>
                <th scope="col" >NOMBRE LISTA</th>
                <th scope="col" >PRECIO ANTERIOR</th>
                <th scope="col" >NUEVO PRECIO</th>
                <th scope="col" >FECHA</th>
            </tr>
        </thead>
        <tbody id="tblpreciosactualizados">
        <?php
            while ($historial = mysqli_fetch_array($query)){
        ?>
            <tr>
                <?php if ($_SESSION['usuario']['prerol'] == 4) { ?>
                <td><?= $historial["usuario"] ?></td>
                <?php } ?>
                <td><?= $historial["referencia"] . ' - ' . $historial["producto"] ?></td>
                <td><?= $historial["lista"] ?></td>
                <td><?= $historial["preant"] ?></td>
                <td><?= $historial["prenew"] ?></td>
                <td><?= $historial["fecha"] ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<!-- fin de la tabla -->
