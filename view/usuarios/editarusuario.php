<!-- Formulario (Editar) -->
<form id="frmeditarusuario" method="post" onsubmit="return editarusuario()">
    <div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario (Usuario) -->
                    <fieldset class="group-border">
                    <legend class="group-border">Informacion Usuario</legend>
                    <div class="row">
                        <input hidden type="text" id="idusuario" name="idusuario" class="form-control" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <input disabled type="text" id="nombreu" name="nombreu" class="form-control input-sm">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <input type="text" id="usuariou" name="usuariou" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <input placeholder="Ingrese Nueva Contraseña" type="text" id="passwordu" name="passwordu" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <select name="idrolu" id="idrolu" class="form-control input-sm">
                                    <?php
                                    $sql="SELECT r.id_rol as idrol, r.rol_nombre as rol FROM roles as r";
                                    $respuesta = mysqli_query($conexion, $sql);
                                    while($rol = mysqli_fetch_array($respuesta)) {
                                    ?>
                                    <option value="<?php echo $rol['idrol']?>"><?php echo $rol['rol'];?></option>
                                    <?php }?>
                                </select>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <select name="idsedeu" id="idsedeu" class="form-control input-sm">
                                    <?php
                                    $sql="SELECT s.id_sede as idsede, s.sed_nombre as sede FROM sedes as s";
                                    $respuesta = mysqli_query($conexion, $sql);
                                    while($sede = mysqli_fetch_array($respuesta)) {
                                    ?>
                                    <option value="<?php echo $sede['idsede']?>"><?php echo $sede['sede'];?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <select name="idareau" id="idareau" class="form-control input-sm">
                                    <?php
                                    $sql="SELECT a.id_area as idarea, a.are_nombre as area FROM areas as a";
                                    $respuesta = mysqli_query($conexion, $sql);
                                    while($area = mysqli_fetch_array($respuesta)) {
                                    ?>
                                    <option value="<?php echo $area['idarea']?>"><?php echo $area['area'];?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                    </div>
                </fieldset>
                    <div class="card-footer text-center">
                        <button class="btn btn-success" data-bs-dismiss="modal">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Fin Formulario (Editar) -->
