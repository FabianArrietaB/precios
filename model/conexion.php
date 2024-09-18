<?php
date_default_timezone_set('America/Bogota');
class Conexion{

   protected $dbh;

   public function conectar(){
      $servidor = "localhost";
      $usuario = "root";
      $password = "";
      $db = "updateprecios";
      $conexion = mysqli_connect($servidor, $usuario, $password, $db);
      return $conexion;
   }

   public function conectarBD(){
      $servidor = "SERVIDOR";
      $usuario  = "consulta";
      $password = "Sistema2024";
      $db       = "METROPOLIS_EXT";
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
      //$servidor = "SERVER";
      $usuario  = "consulta";
      $password = "Sistema2024";
      $db       = "METROCERAMICA";
      try {
         $conexion = new PDO("sqlsrv:server=$servidor;database=$db", $usuario, $password);
         $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (Exception $e) {
         echo "Ocurrió un error con la base de datos: " . $e->getMessage();
      }
      return  $conexion;
   }

   public function conectarapolo(){
      // $servidor = "auth-db486.hstgr.io";
      // $usuario = "u914867005_apolo";
      // $password = "Apolo2023";

      $servidor = "localhost";
      $usuario = "root";
      $password = "";

      $db = "u914867005_apolo";
      $conexion = mysqli_connect($servidor, $usuario, $password, $db);
      return $conexion;
   }
}
?>