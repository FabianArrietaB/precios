<?php
    $idusuario = $_SESSION['usuario']['preid'];
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">PRECIOS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="d-md-flex d-block flex-row mx-md-auto mx-0">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                <?php if ($_SESSION['usuario']['prerol'] == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="inicio.php">INICIO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="proveedores.php">PROVEEDORES</a>
                    </li>
                <?php } else if ($_SESSION['usuario']['prerol'] == 2) { ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="inicio.php">INICIO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="stock.php">EXISTENCIAS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="inventario.php">BODEGA</a>
                    </li>
                <?php } else if ($_SESSION['usuario']['prerol'] == 3) { ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="inicio.php">INICIO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="stock.php">EXISTENCIAS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="precios.php">PRECIOS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="apolo.php">APOLO</a>
                    </li>
                <?php } else if ($_SESSION['usuario']['prerol'] == 4) { ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="inicio.php">INICIO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="precios.php">PRECIOS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="stock.php">EXISTENCIAS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="inventario.php">BODEGA</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="proveedores.php">PROVEEDORES</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="apolo.php">APOLO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="historial.php">HISTORIAL</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="usuarios.php">USUARIOS</a>
                    </li>
                <?php } ?>
                </ul>
            </div>
        </div>
        <span class="navbar-brand" href="#">Usuario:</span>
        <a class="mr-sm-2 btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#contraseña" onclick="detallepass('<?php echo $idusuario ?>')"><?php echo $_SESSION['usuario']['preusuario'] ?></a>
        <a href="../controller/usuarios/salir.php" class="btn btn-danger" type="submit">
            <i class="fa-solid fa-power-off fa-2x"></i>
        </a>
    </div>
</nav>
<?php
    include "../view/usuarios/cambiarcontraseña.php";
?>