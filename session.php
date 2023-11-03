<?php
session_start();

function sesionAbierta(){
    if(!$_SESSION["usuario"]){
        header("location: login.php");
    }
}
?>