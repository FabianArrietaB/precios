<?php
    session_start();
    if ($_SESSION['usuario']['prerol'] == 4 ||
        $_SESSION['usuario']['prerol'] == 3 ||
        $_SESSION['usuario']['prerol'] == 1) {
        include "../../model/conexion.php";
        $con = new Conexion();
        $sql = $con->conectarFomplus()->prepare('SELECT
        pr.CLI_CEDULA  nit,
        pr.CLI_NOMBRE proveedor
        FROM METROCERAMICA.dbo.MAEINV p
        LEFT JOIN METROCERAMICA.dbo.MAECXP pr ON p.INV_PROVEE = pr.CLI_CEDULA
        GROUP BY pr.CLI_CEDULA, pr.CLI_NOMBRE');
        $sql->execute();
        $proveedores = $sql->fetchAll(PDO::FETCH_OBJ);
    }
?>
<!-- inicio Tabla -->
<div class="table-responsive">
    <table class="table table-light text-center">
        <thead>
            <tr>
                <th scope="col" >NIT</th>
                <th scope="col" >NOMBRE</th>
            </tr>
        </thead>
        <tbody id="tblproveedore">
        <?php
            foreach($proveedores as $proveedore){
        ?>
            <tr>
                <td><?= $proveedore->nit ?></td>
                <td><?= $proveedore->proveedor ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<!-- fin de la tabla -->
