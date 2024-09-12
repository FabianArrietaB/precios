<!-- Vista Admin-->
<?php
    include "header.php";
    include "navbar.php";
    if(isset($_SESSION['usuario']) &&
    $_SESSION['usuario']['prerol'] == 4 ||
    $_SESSION['usuario']['prerol'] == 3 ||
    $_SESSION['usuario']['prerol'] == 2 ||
    $_SESSION['usuario']['prerol'] == 1){
    include "../model/conexion.php";
?>
<!-- inicio del contenido principal -->
<div class="container-fluid">
    <div class="page-content">
        <div class="card border-primary">
            <div class="card-header text-center">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-10">
                        <div class="title">
                            <h3>LISTA ARTICULOS</h3>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-2">
                        <div class="d-grid gap-2">
                            <a  href="actualizados.php" class="btn btn-outline-primary" type="button">Actualizados</a>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <form action="" method="GET">
                            <input class="form-control me-xl-2" type="search" placeholder="Ingrese Datos para Busqueda" name="filtro" id="filtro">
                        </form>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="row student text-center" style="align-items: center">
                        <div class="row student text-center" style="align-items: center">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped font-small" id="productos">
                                    <thead>
                                        <tr>
                                            <th scope="col" >#</th>
                                            <th scope="col" >REFERENCIA</th>
                                            <th scope="col" >PRODUCTO</th>
                                            <th scope="col" >BODEGA</th>
                                            <th scope="col" >STOCK</th>
                                            <th scope="col" >COSTO</th>
                                            <th scope="col" >IVA</th>
                                            <th scope="col" >COSTO_IVA</th>
                                            <th scope="col" >FECHA ULTCOMPRA</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tblreferencias" class="BusquedaRapida">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modallistaprecios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div id="title"></div>
                <button onclick="tblreferencias()" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row text-center">
                    <div class="col-12">
                        <div id="body"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalupdateprecio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <form id="frmupdateprecio" method="post" onsubmit="return updateprecio()">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div id="title_update"></div>
                    <button  type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row text-center">
                        <div class="col-12">
                            <div id="body_update"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- fin del contenido principal -->
<!-- por ultimo se carga el footer -->
<?php
    include "footer.php";
?>
<!-- carga ficheros javascript -->
<script src="../public/js/update.js"></script>

<?php }else{
        header("../index.php");
    }
?>