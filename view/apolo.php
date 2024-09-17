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
                    </div>
                    <div class="row" id="filter">
                        <div class="col-xs-12 col-sm-12 col-md-5">
                            <input class="form-control me-xl-2" type="search" placeholder="Ingrese Datos para Busqueda" name="FiltrarContenido" id="FiltrarContenido">
                        </div>
                        <?php if ($_SESSION['usuario']['prerol'] == 4) { ?>
                        <div class="col-xs-12 col-sm-12 col-md-5">
                            <form action="#" id="form_file" enctype="multipart/form-data">
                                <div class="input-group">
                                    <input accept=".csv,.xlsx,.xls" id="productos" name="productos" type="file" class="form-control" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                                    <button onclick="importarproductos()" class="btn btn-outline-success" type="button" id="inputGroupFileAddon04">Cargar</button>
                                </div>
                            </form>
                        </div>
                        <?php } else { ?>
                        <div class="col-xs-12 col-sm-4 col-md-2">
                            <div class="d-grid gap-2">
                                <a href="apolo2.php" class="btn btn-outline-primary" type="button">SIN REFERENCIA</a>
                            </div>
                        </div>
                        <?php } ?>
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
                                        <th scope="col" >REFERENCIA FOMPLUS</th>
                                        <th scope="col" >NOMBRE FOMPLUS</th>
                                        <th scope="col" >REFERENCIA APOLO</th>
                                        <th scope="col" >NOMBRE APOLO</th>
                                        <th scope="col" >STOCK APOLO</th>
                                    </tr>
                                </thead>
                                <tbody id="tblsinreferencia" class="BusquedaRapida">
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
<!-- por ultimo se carga el footer -->
<?php
    include "footer.php";
?>
<!-- carga ficheros javascript -->
<script src="../public/js/stockapolo.js"></script>

<?php }else{
        header("../index.php");
    }
?>