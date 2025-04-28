<?php
session_start();
require_once("controllers/AdminController.php");

$controlador = new AdminController();

if (isset($_POST['gt'])) {
    $controlador->irCRUDT();
} elseif (isset($_POST['as'])) {
    $controlador->irAsignarServicio();
} elseif (isset($_POST['av'])) {
    $controlador->irAsignarVisitas();
}elseif (isset($_POST['lc'])){
    header("Location: listadoCadm.php");
}


if(isset($_POST['cs'])){
    $controlador->logout();
}


if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $pedidos = $controlador->mostrarP($email);
} else {
    echo "No has iniciado sesión.";
    header("Location: index.php");
    exit;
}

include("views/admin_ini.php");


?>

