<?php
date_default_timezone_set('America/Bogota');
class Conexion{

   protected $dbh;

   public function conectar(){
      $servidor = "localhost";
      $usuario = "";
      $password = "";
      $db = "precios";
      $conexion = mysqli_connect($servidor, $usuario, $password, $db);
      return $conexion;
   }

   public function conectarBD(){
      $servidor = "SERVIDOR";
      $usuario  = "";
      $password = "";
      $db       = "METRO";
      try {
         $conexion = new PDO("sqlsrv:server=$servidor;database=$db", $usuario, $password);
         $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (Exception $e) {
         echo "Ocurrió un error con la base de datos: " . $e->getMessage();
      }
      return  $conexion;
   }

   public function conectarFomplus(){
      $servidor = "SERVIDOR";
      $usuario  = "";
      $password = "";
      $db       = "METROCERA";
      try {
         $conexion = new PDO("sqlsrv:server=$servidor;database=$db", $usuario, $password);
         $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (Exception $e) {
         echo "Ocurrió un error con la base de datos: " . $e->getMessage();
      }
      return  $conexion;
   }

   public function conectarapolo(){
      $servidor = "auth-db486.hstgr.io";
      $usuario = "";
      $password = "";
      $db = "";
      $conexion = mysqli_connect($servidor, $usuario, $password, $db);
      return $conexion;
   }
}
?>
