<?php

session_start(); 

require_once("controllers/TecnicoController.php");

$controlador = new TecnicoController();

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $pedidos = $controlador->cargarP($email);
    $visitas = $controlador->cargarV($email);
} else {
    header("Location: index.php");
    exit;
}



if(isset($_POST['cs'])){
    $controlador->logout();
}

if(isset($_POST['gs'])){

header("Location: tecP.php");

}

if (isset($_POST['lc'])){
    header("Location: listadoCtec.php");
}


include("views/pedidoT.php");




?>