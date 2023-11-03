<?php require("session.php"); 
if(isset($_SESSION["usuario"])){
    header("location: admin.php");
    exit();
}
require_once("conexion.php");
?>
<?php
if(isset($_POST["usuario"])){
    $usuario = trim($_POST["usuario"]);
    $contraseña = sha1(trim($_POST["contraseña"]));
    $asd = new BaseDeDatos();

    $validacion = $asd->validarUsuario($usuario, $contraseña);

    if($validacion){
        $permiso = $asd->validarPermiso($usuario, $contraseña);
        $_SESSION["usuario"] = $_POST["usuario"];
        $_SESSION["contraseña"] = $_POST["contraseña"];
        if($permiso == 0){
            $_SESSION["permiso"] = 0;
            header("location: admin.php");
            exit();
        }elseif($permiso == 1){
            $_SESSION["permiso"] = 1;
            header("location: profesor.php");
            exit();
        }elseif($permiso == 2){
            $_SESSION["permiso"] = 2;
            header("location: alumno.php");
            exit();
        }

    }else{
        echo "Usuario o contraseña incorrectos.";
    }
}


?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="login.php" method="post">
        <input type="text" name="usuario">Usuario<br>
        <input type="password" name="contraseña">Contraseña<br>
        <input type="submit" value="Ingresar">
    </form>
</body>
</html>



