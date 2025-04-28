<?php
session_start(); 

require_once("controllers/ClienteController.php");

$controlador = new ClienteController();

$datosC = null;

if (isset($_SESSION['email'])) {
    $datosC = $controlador->cargarC();
} else {
    header("Location: clientei.php");
    exit;
}

if(isset($_POST['mod'])){
$email = $_POST['email'];
$nombre = $_POST['nombre'];
$passwd = $_POST['passwd'];
$celular = $_POST['celular'];

$controlador->modC($email, $nombre, $passwd, $celular);



}





if (isset($_POST['volver'])) {
    $controlador->Volver();
}


include("views/modC.php");


?>