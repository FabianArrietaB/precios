<?php
    session_start();
    include "../../model/conexion.php";
    $con = new Conexion();
    $conexion = $con->conectar();
    $idusuario = $_SESSION['usuario']['preid'];
    $sql = "SELECT
        u.id_usuario AS idusuario,
        p.per_nombre  AS nombre,
        u.user_nombre AS usuario,
        r.rol_nombre  AS rol,
        a.are_nombre  AS area,
        s.sed_nombre  AS sede,
        u.user_estado AS estado,
        u.user_fecope AS fecha
        FROM usuarios AS u
        INNER JOIN roles AS r ON u.id_rol = r.id_rol
        INNER JOIN personas AS p ON p.id_persona = u.id_persona
        INNER JOIN areas AS a ON a.id_area = u.id_area
        INNER JOIN sedes AS s ON s.id_sede = u.id_sede
        ORDER BY u.id_usuario ASC";
    $query = mysqli_query($conexion, $sql);
?>
<!-- inicio Tabla -->
<div class="table-responsive">
    <table class="table table-light text-center">
        <thead>
            <tr>
                <th scope="col" >Usuario</th>
                <th scope="col" >Nombres</th>
                <th scope="col" >Sede</th>
                <th scope="col" >Area</th>
                <th scope="col" >Rol</th>
                <th scope="col" >Fecha</th>
                <th scope="col" >Estado</th>
                <th>
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#create"><i class="fa-solid fa-square-plus fa-lg"></i></button>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
        <?php
            while ($usuarios = mysqli_fetch_array($query)){
        ?>
            <tr>
                <td><?php echo $usuarios['usuario'];?></td>
                <td><?php echo $usuarios['nombre']; ?></td>
                <td><?php echo $usuarios['sede']; ?></td>
                <td><?php echo $usuarios['area']; ?></td>
                <td><?php echo $usuarios['rol'];    ?></td>
                <td><?php echo $usuarios['fecha'];  ?></td>
                <td>
                    <?php
                    if ($usuarios['estado'] == 0) {
                    ?>
                        <button class="btn btn-danger btn-sm" onclick="activarusuario(
                        <?php echo $usuarios['idusuario'] ?>,
                        <?php echo $usuarios['estado'] ?>)">
                        INACTIVO
                        </button>
                        <?php
                    } else if ($usuarios['estado'] == 1) {
                        ?>
                        <button class="btn btn-success btn-sm" onclick="activarusuario(
                        <?php echo $usuarios['idusuario'] ?>,
                        <?php echo $usuarios['estado'] ?>)">
                        ACTIVO
                        </button>
                    <?php
                    }
                    ?>
                </td>
                <td>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editar" onclick="detalleusuario('<?php echo $usuarios['idusuario']?>')"><i class="fa-solid fa-pen-to-square fa-beat fa-xl"></i></button>
                    <button type="button" class="btn btn-danger"  onclick="eliminarusuario('<?php echo $usuarios['idusuario']?>')"><i class="fa-regular fa-trash-can fa-beat fa-xl"></i></button>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<!-- fin de la tabla -->
