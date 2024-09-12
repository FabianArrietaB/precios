<?php
session_start();
date_default_timezone_set('America/Bogota');
if (!empty($_SESSION["user_estado"])) {
  header("location:../index.php");
}
setlocale(LC_ALL,"es_ES");
?>
<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
<html lang="en" dir="ltr">
  <head>
  <meta name="viewport" content="width=device-width, initial-scale=1"&amp;gt>
    <!--<title> Responsive Sidebar Menu  | CodingLab </title>-->
    <link rel="stylesheet" href="../public/css/style.css">
    <!--<title> Bootstrap </title>-->
    <link rel="stylesheet" href="../public/bootstrap5/css/bootstrap.min.css">
    <!--<title> Boxicons </title>-->
    <link rel="stylesheet" href="../public/Boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="../public/Boxicons/css/animations.css">
    <link rel="stylesheet" href="../public/Boxicons/css/transformations.css">
    <link rel="stylesheet" href="../public/select2/select2.min.css">
    <!--<title> Fontawesome </title>-->
    <link rel="stylesheet" href="../public/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Boxicons CDN Link -->
    <link href="../public/images/icono.jpg" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metropolis | Precios</title>
  </head>
<body>
