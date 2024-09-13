<!-- Vista Admin-->
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
            <div class="card-header text-center">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-10">
                        <div class="title">
                            <h2>PRODUCTOS PROVEEDOR</h2>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-2">
                        <div class="d-grid gap-2">
                            <a  href="actualizados.php" class="btn btn-outline-primary" type="button">Actualizados</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row student text-center" style="align-items: center">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="input-group mb-3">
                            <input placeholder="Ingrese Nombre Proveedor" type="text" id="proveedor" name="proveedor" class="form-control input-sm">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="input-group mb-3">
                            <input placeholder="Ingrese Nombre referencia" type="text" id="FiltrarContenido" name="FiltrarContenido" class="form-control input-sm">
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="row student text-center" style="align-items: center">
                            <div class="row student text-center" style="align-items: center">
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped font-small" id="productos">
                                        <thead>
                                            <tr>
                                                <th scope="col" >PRODUCTO</th>
                                                <th scope="col" >MARCA</th>
                                                <th scope="col" >PROVEEDOR</th>
                                                <th scope="col" >ESTADO</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tblproductos" class="BusquedaRapida">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="row student text-center" style="align-items: center">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped font-small">
                                    <thead>
                                        <tr>
                                            <th scope="col" >ID LISTA</th>
                                            <th scope="col" >NOMBRE</th>
                                            <th scope="col" >PRECIO</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tblprecios">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-2">
                        <div class="row student text-center" style="align-items: center">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped font-small">
                                    <thead>
                                        <tr>
                                            <th scope="col" >BODEGA</th>
                                            <th scope="col" >STOCK</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tblstock">
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
<div class="modal fade" id="modalupdateprecio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="frmupdateprecio" method="post" onsubmit="return updateprecio()">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div id="title"></div>
                    <button  type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
    </form>
</div>
<!-- fin del contenido principal -->
<!-- por ultimo se carga el footer -->
<?php
    include "footer.php";
?>
<!-- carga ficheros javascript -->
<script src="../public/js/precio.js"></script>

<?php }else{
        header("../index.php");
    }
?>