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
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="title">
                            <h3>LISTA ARTICULOS</h3>
                        </div>
                        <div class="row">
                        <div class="col-xs-12 col-sm-4 col-md-3 mb-2">
                            <div class="input-group ">
                                <span class="input-group-text" id="inputGroup-sizing-default">FECHA INCIAL</span>
                                <input type="date" class="form-control" id="desde" name="desde" tabindex="2" maxlength="10" size="20">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-3 mb-2">
                            <div class="input-group ">
                                <span class="input-group-text" id="inputGroup-sizing-default">FECHA FINAL</span>
                                <input type="date" class="form-control" id="hasta" name="hasta" tabindex="2" maxlength="10" size="20">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-3 mb-2">
                            <div class="input-group ">
                                <span class="input-group-text" id="inputGroup-sizing-default">SEDE</span>
                                <select name="sede" id="sede" class="form-control input-sm" require>
                                    <option value="">SELECCIONE SEDE</option>
                                    <option value="0001">METROPOLIS</option>
                                    <option value="0018">MAYORISTA</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-3 mb-2">
                            <div class="d-grid gap-2">
                                <div class="btn-group" role="group" aria-label="Basic outlined example">
                                    <button type="button" class="btn btn-outline-primary" onclick="existencias()">LISTA</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="filter">
                        <div class="col-xs-12 col-sm-12 col-md-10">
                            <input class="form-control me-xl-2" type="search" placeholder="Ingrese Datos para Busqueda" name="FiltrarContenido" id="FiltrarContenido">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <div class="input-group">
                                <label class="input-group-text" for="maxRows">Options</label>
                                <select class="form-select" name="state" id="maxRows">
                                    <option value="0">Todas</option>
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="70">70</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="row student text-center" style="align-items: center">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped font-small" id="productos">
                                <thead>
                                    <tr>
                                        <th scope="col" >REFERENCIA</th>
                                        <th scope="col" >PRODUCTO</th>
                                        <th scope="col" >BODEGA / STOCK</th>
                                        <th scope="col" >ULTCOMPRA</th>
                                        <th scope="col" >ESTADO</th>
                                        <th scope="col" >ORD.COMPRA</th>
                                        <th scope="col" >FECHA.ORDCOMPRA</th>
                                    </tr>
                                </thead>
                                <tbody id="tblstock" class="BusquedaRapida">
                                </tbody>
                            </table>
                            <!--		Start Pagination -->
                            <div class='pagination-container' >
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-end">
                                        <li class="page-item" data-page="prev" >
                                            <a class="page-link"><<span class="sr-only">(current)</span></a>
                                        </li>
                                        <li class="page-item" data-page="next" id="prev">
                                            <a class="page-link">><span class="sr-only">(current)</span></a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- fin del contenido principal -->
<div class="modal fade" id="modalorden" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div id="title"></div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
<!-- por ultimo se carga el footer -->
<?php
    include "footer.php";
?>
<!-- carga ficheros javascript -->
<script src="../public/js/stock.js"></script>

<?php }else{
        header("../index.php");
    }
?>