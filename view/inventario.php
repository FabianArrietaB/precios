<!-- Vista Admin-->
<?php
    include "header.php";
    include "navbar.php";
    if(isset($_SESSION['usuario']) &&
    $_SESSION['usuario']['prerol'] == 4){
    include "../model/conexion.php";
    $con = new Conexion();
    $conexion = $con->conectar();
?>
<!-- inicio del contenido principal -->
<div class="container-fluid">
    <div class="page-content">
        <div class="card border-primary">
            <div class="card-header text-center">
                <div class="row">
                    <div class="title">
                        <h2>EXISTENCIA POR BODEGA</h2>
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
                                <option value="5000" selected>Todas</option>
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
            <div class="card-body">
                <div class="row student text-center" style="align-items: center">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped font-small" id="existencias">
                            <thead>
                                <tr>
                                    <th scope="col" >REFERENCIA</th>
                                    <th scope="col" >PRODUCTO</th>
                                    <th scope="col" >COSTO</th>
                                    <th scope="col" >IVA</th>
                                    <th scope="col" >STOCK INICIAL</th>
                                    <th scope="col" >STOCK FOMPLUS</th>
                                    <th scope="col" >SALIDAS</th>
                                    <th scope="col" >ENTRADAS</th>
                                </tr>
                            </thead>
                            <tbody id="tblexistencias" class="BusquedaRapida">
                            </tbody>
                        </table>
                        <!--		Start Pagination -->
                        <div class='pagination-container' >
                            <nav aria-label="Page navigation example">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <p id="labelpag" class="justify-content-start"></p>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <ul class="pagination justify-content-end">
                                            <li class="page-item" data-page="prev" >
                                                <a class="page-link"><<span class="sr-only">(current)</span></a>
                                            </li>
                                            <li class="page-item" data-page="next" id="prev">
                                                <a class="page-link">><span class="sr-only">(current)</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>
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
<script src="../public/js/bodegas.js"></script>

<?php }else{
        header("../index.php");
    }
?>