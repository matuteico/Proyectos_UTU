<?php
session_start(); 

require_once("controllers/TecnicoController.php");

$controlador = new TecnicoController();


if (isset($_POST['volver'])) {
    $controlador->Volver();
}

if (isset($_POST['b_gs'])) {
    $id_p = $_POST['id_p'];
    $pedido = $controlador->buscarPedido($id_p);
    
    if ($pedido) {
        // Guardamos el estado y comentarios del pedido
        $_POST['servicio_tipo'] = $pedido['estado'];  
        $_POST['comentarios'] = $pedido['comentarios'];  
    } else {
        echo "<script>alert('Pedido no encontrado en la tabla Visita.'); 
              window.location.href='tecP.php';</script>";
    }
}

if (isset($_POST['g_gs'])) {
    $id_p = $_POST['id_p'];
    $nuevoEstado = $_POST['servicio_tipo']; 
    $comentarios = $_POST['comentarios']; 

 
    if (empty($id_p)) {
        echo "<script>alert('El ID del pedido no es válido.'); window.location.href='tecP.php';</script>";
        return;
    }

    if (empty($comentarios)) {
        echo "<script>alert('Los comentarios no pueden estar vacíos.'); window.location.href='tecP.php';</script>";
        return;
    }

    if ($nuevoEstado === 'enproceso') {
        $nuevoEstado = 'En Proceso'; 
    } elseif ($nuevoEstado === 'finalizado') {
        $nuevoEstado = 'Finalizado'; 
    }

    if ($controlador->actualizarEstadoPedido($id_p, $nuevoEstado, $comentarios)) {
        echo "<script>alert('Estado y comentarios del pedido actualizados correctamente.'); window.location.href='tecP.php';</script>";

        if ($nuevoEstado === 'Finalizado') {
            if ($controlador->darBajaVisita($id_p)) {
                echo "<script>alert('La visita correspondiente ha sido dada de baja.'); window.location.href='tecP.php';</script>";
            } else {
                echo "<script>alert('Error al dar de baja la visita.'); window.location.href='tecP.php';</script>";
            }
        }
    } else {
        echo "<script>alert('Error al actualizar el estado y/o comentarios del pedido.'); window.location.href='tecP.php';</script>";
    }
}






include("views/gestionS.php");
?>