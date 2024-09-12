<!-- Formulario (Agregar) -->
<form id="frmagregarusuario" method="POST" onsubmit="return agregarusuario()">
    <div class="modal fade" id="create" tabindex="-1" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario (Usuario) -->
                <!-- Formulario (Usuario) -->
                <fieldset class="group-border">
                    <legend class="group-border">Informacion Usuario</legend>
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <select class="form-select input-sm" name="idpersona" id="idpersona" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <input placeholder="Ingrese Usuario" type="text" id="usuario" name="usuario" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <input placeholder="Ingrese Contraseña" type="text" id="password" name="password" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <select name="idrol" id="idrol" class="form-control input-sm">
                                    <option selected >Selecione un Rol</option>
                                    <?php
                                    $sql="SELECT r.id_rol as idrol, r.rol_nombre as rol FROM roles as r";
                                    $respuesta = mysqli_query($conexion, $sql);
                                    while($persona = mysqli_fetch_array($respuesta)) {
                                    ?>
                                    <option value="<?php echo $persona['idrol']?>"><?php echo $persona['rol'];?></option>
                                    <?php }?>
                                </select>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <select name="idsede" id="idsede" class="form-control input-sm">
                                    <option selected >Selecione Sede</option>
                                    <?php
                                    $sql="SELECT s.id_sede as idsede, s.sed_nombre as sede FROM sedes as s";
                                    $respuesta = mysqli_query($conexion, $sql);
                                    while($persona = mysqli_fetch_array($respuesta)) {
                                    ?>
                                    <option value="<?php echo $persona['idsede']?>"><?php echo $persona['sede'];?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <select name="idarea" id="idarea" class="form-control input-sm">
                                    <option selected >Selecione Area</option>
                                    <?php
                                    $sql="SELECT a.id_area as idarea, a.are_nombre as area FROM areas as a";
                                    $respuesta = mysqli_query($conexion, $sql);
                                    while($persona = mysqli_fetch_array($respuesta)) {
                                    ?>
                                    <option value="<?php echo $persona['idarea']?>"><?php echo $persona['area'];?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="card-footer text-center">
                    <button class="btn btn-success" data-bs-dismiss="modal">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Fin Formulario (Agregar, Modificar) -->
