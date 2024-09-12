<?php
   session_start();
   $datos = array(
      'idoperador'     => $_SESSION['usuario']['preid'],
      "refere"         => $_POST['refere'],
      "produc"         => $_POST['producto'],
      "lista"          => $_POST['lista'],
      "precio"         => $_POST['precio'],
      "newprecio"      => $_POST['newprecio'],
   );

   include "../../model/precios.php";
   $Precios = new Precios();
   echo $Precios->hisprecios($datos);
?>