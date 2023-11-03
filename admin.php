<?php require("session.php");
sesionAbierta();
require("conexion.php");
$asd = new BaseDeDatos();
?>

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
<h1>Administración</h1>
<body>
    <a>Registre un nuevo usuario</a>
    <form action="admin.php" method="post">
        <input type="text" name="nuevousuario">Usuario<br>
        <input type="password" name="nuevacontraseña">Contraseña<br>
        <input type="number" name="permisos" min="1" max ="2">Permisos<br>
        <input type="submit" value="Dar de alta">
    </form>
    <a href="logout.php">Salir</a></li><br><br>
</body>
</html>

<?php 
if(isset($_POST["nuevousuario"])){ 
    $asd = new BaseDeDatos;
    $usuario = trim($_POST["nuevousuario"]);
    $contraseña = trim(sha1($_POST["nuevacontraseña"]));
    $permisos = $_POST["permisos"];

    if(!$asd->usuarioRepetido($usuario)){
        $asd->registrarUsuario($usuario, $contraseña, $permisos);
        //echo "Nuevo usuario registrado correctamente";
        header("Location: admin.php?mensaje=registro_exitoso");
        exit();
    }else{
        header("Location: admin.php?mensaje=usuario_existente");
        exit();
        //echo "Ese usuario ya está utilizado."; 
    }
}

if(isset($_GET["mensaje"])){
    if($_GET["mensaje"] == "registro_exitoso"){
        echo "Nuevo usuario registrado correctamente";
    }elseif($_GET["mensaje"] == "usuario_existente"){
        echo "Ese usuario ya está utilizado.";
    }
}

$asd->getClases();

?>

<a href="crearclase.php" class="tarjeta-enlace">
<div class ="tarjeta">
    <h2> Nueva Clase </h2>
</div>
</a>