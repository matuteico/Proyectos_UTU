<?php
session_start(); 

require_once("controllers/ClienteController.php");

$controlador = new ClienteController();

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $pedidos = $controlador->mostrarP($email);
    $visitas = $controlador->cargarV($email);
} else {
    header("Location: index.php");
    exit;
}

if (isset($_POST['cs'])) {
    $controlador->logout();
}

if (isset($_POST['btn_guardar'])) {
    $email_c = $_SESSION['email'];
    $servicio_id = $_POST['servicio_tipo'];
    $comentario = $_POST['comentario'];
    $f_pedido = $_POST['f_pedido'];
    $h_pedido = $_POST['h_pedido'];
    $controlador->altaP($servicio_id, $email_c, $comentario, $f_pedido, $h_pedido);
}


$pedidoB = null;

if (isset($_POST['btn_buscar'])) {
    $id = $_POST['bid'];

    if (!empty($id) && is_numeric($id)) {
        $pedidoB = $controlador->buscarPedido($id);
        if (!$pedidoB) {
            echo "No se encontró un pedido con esa ID.";
        }
    } else {
        echo "Por favor, ingresa un ID de pedido válido.";
    }
}

if (isset($_POST['btn_actualizar'])) {
    $id = $_POST['id'];
    $servicio_id = $_POST['servicio_tipob'];
    $comentario = $_POST['comentario'];
    $email = $_SESSION['email'];


    if (!empty($id) && is_numeric($id) && !empty($servicio_id) && !empty($comentario)) {
        $actualizado = $controlador->actualizarPedido($id, $servicio_id, $comentario);
        if ($actualizado) {
            header("Location: clientei.php");
            exit;
        } else {
            echo "Error al actualizar el pedido.";
        }
    } else {
        echo "Por favor, completa todos los campos.";
    }
}


if(isset($_POST['btn_irm'])){
    header("Location: clientem.php");
            exit;

}




include("views/pedidoC.php");


?>
