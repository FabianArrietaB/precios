<!-- Vista Admin y Supervisor -->
<?php
    include "header.php";
    include "navbar.php";
    if(isset($_SESSION['usuario']) &&
    include "permisos.php"){
    include "../model/conexion.php";
    $con = new Conexion();
    $conexion = $con->conectar();
?>
<!-- inicio del contenido principal -->
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="card border-primary">
                <div class="card-header text-center">
                    <div class="title">
                        <h2>LISTA USUARIOS</h2>
                    </div>
                    <form method="GET">
                        <input class="form-control me-3" type="search" placeholder="Buscar" id="filtro" name="filtro">
                    </form>
                </div>
                <div class="card-body">
                    <div id="tablalistausuarios"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- fin del contenido principal -->
<!-- por ultimo se carga el footer -->
<?php
    include "../view/usuarios/editarusuario.php";
    include "../view/usuarios/crearusuario.php";
    include "footer.php";
?>
<!-- carga ficheros javascript -->
<script src="../public/js/usuarios/funciones.js"></script>
<?php
}
?>