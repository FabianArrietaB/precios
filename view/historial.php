<!-- Vista Admin y Supervisro -->
<?php
    include "header.php";
    include "navbar.php";
    if(isset($_SESSION['usuario']) &&
    include "permisos.php"){
    include "../model/conexion.php";
?>
<!-- inicio del contenido principal -->
<div class="container-fluid">
    <div class="page-content">
        <div class="card border-primary">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="card-header text-center">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="title">
                                    <h2>EVENTOS REALIZADOS</h2>
                                </div>
                            </div>
                        </div>
                        <form method="get">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="input-group mb-3">
                                        <input placeholder="Ingrese Valor a Buscar" type="text" id="Filtro" name="Filtro" class="form-control input-sm">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div id="tblhisprecios"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- fin del contenido principal -->
<!-- por ultimo se carga el footer -->
<?php
    include "footer.php";
?>
<!-- carga ficheros javascript -->
<script src="../public/js/bitacora.js"></script>
<?php
}
?>