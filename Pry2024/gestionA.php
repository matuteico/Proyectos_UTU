<?php
session_start();
require_once("controllers/AdminController.php");
$controlador = new AdminController();


if (isset($_POST['volver'])) {
    $controlador->Volver();
}



if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $pendiente = $controlador->mostrarNoAsign();
} else {
    header("Location: administradores.php");
    exit;
}


if(isset($_POST['asignar'])){
$id_p = $_POST['id_p'];
$email_t = $_POST['email_t'];

$controlador->asignarPedido($id_p, $email_t);

}





include("views/pedidoADM.php");
?>