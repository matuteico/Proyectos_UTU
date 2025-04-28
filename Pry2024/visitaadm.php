<?php
session_start();
require_once("controllers/AdminController.php");

$controlador = new AdminController();


if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $visitas = $controlador->cargarV();
} else {
    echo "No has iniciado sesión.";
    header("Location: index.php");
    exit;
}

if(isset($_POST['return'])){
    $controlador->Volver();
}

if(isset($_POST['btn_alta'])){
    $id_p = $_POST['id_p'];  
    $id_h = $_POST['hora'];  
    $dia = $_POST['fecha']; 

    if (empty($id_p) || empty($id_h) || empty($dia)) {
        echo "<script>alert('Todos los campos son obligatorios.');</script>";
    } else {
        $controlador->darAltaVisita($id_p, $id_h, $dia);
    }
    
}

if(isset($_POST['buscar_v'])){
$id_v = $_POST['b_idv'];

$datosV = $controlador->buscarV($id_v);
}

if(isset($_POST['btn_modV'])){
    $id_v = $_POST['idv_e'];
    $id_p = $_POST['b_idp'];  
    $id_h = $_POST['b_idh'];  
    $dia = $_POST['b_dia'];
$baja = $_POST['b_baja'];

$controlador->actualizarV($id_v, $id_p, $id_h, $dia, $baja);



}



include("views/asignar_visita.php");
?>