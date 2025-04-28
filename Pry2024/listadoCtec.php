<?php
session_start();
require_once("controllers/TecnicoController.php");

$controlador = new TecnicoController();

$datosC = null;

if (isset($_POST['volver'])) {
    $controlador->Volver();
}



if (isset($_POST['btn_buscar'])) {
    $email = $_POST['email_C'];
    $datosC = $controlador->buscarC($email);
}



include("views/listC.php");


?>