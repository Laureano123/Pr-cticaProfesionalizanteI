<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica 9</title>

    <style>
    .tarjeta {
    border: 2px solid #333;
    padding: 10px; 
    margin: 10px; 
    }
    .tarjeta-enlace {
    text-decoration: none;
    color: #333;
    }
    </style>
</head>
<?php 
require("session.php");
require("conexion.php");
$asd = new BaseDeDatos();
$asd->mostrarTituloClase($_GET["id"]);


?>
<a href="crearexamen.php" class="tarjeta-enlace">
<div class ="tarjeta">
    <h2> Nuevo Examen </h2>
</div>
</a>