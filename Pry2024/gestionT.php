<?php
session_start();
require_once("controllers/AdminController.php");
$controlador = new AdminController();


if (isset($_POST['volver'])) {
    $controlador->Volver();
}





if (isset($_POST['btn_guardar_tec'])) {
    $email = $_POST['email'];
    $nombre = $_POST['nombre'];
    $passwd = $_POST['passwd'];
    $celular = $_POST['celular'];
    $email_a = $_SESSION['email'];
    
    $controlador->altaUsuario($email, $nombre, $passwd, $celular, $email_a);
}

if (isset($_POST['btn_baja'])) {
    $email = $_POST['email_B'];
    
    $controlador->bajaUsuario($email);
}


$datosB = null;

if (isset($_POST['buscar'])) {
    $email = $_POST['email_M'];
    $datosB = $controlador->buscarUsuario($email);
}

if (isset($_POST['btn_guardar'])) {
    $email = $_POST['email'];
    $nombre = $_POST['nombre'];
    $passwd = $_POST['passwd'];
    $celular = $_POST['celular'];
    $baja = $_POST['baja'];
    $controlador->actualizarUsu($email, $nombre, $passwd, $celular, $baja);
}



include("views/CRUDtecnicos.php");
?>