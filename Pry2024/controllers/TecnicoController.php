<?php
require_once("models/TecnicoModel.php");


class TecnicoController{
    private $tecnicoModel;

    public function __construct(){
        $this->tecnicoModel = new TecnicoModel();
    }

    public function logout() {
        if (session_status() == PHP_SESSION_ACTIVE) {
            $_SESSION = [];
            session_destroy();
            header("Location: index.php");
            exit();
        }
    }

    public function Volver() {
        header("Location: teci.php");
        exit();
    }

    public function cargarP($email) {
        $pedidos = $this->tecnicoModel->cargarP($email);
        return $pedidos; 
    }

public function cargarV($email){
    $visitas = $this->tecnicoModel->cargarV($email);
    return $visitas;

}

public function buscarPedido($id_p) {
    if (empty($id_p) || !is_numeric($id_p)) {
        echo "<script>alert('Los datos ingresados son erróneos.'); 
              window.location.href='tecP.php';</script>";
        return null;
    }

    $pedido = $this->tecnicoModel->buscarPedidoEnVisita($id_p);
    if (!$pedido) {
        echo "<script>alert('Error al buscar el Pedido.'); 
              window.location.href='tecP.php';</script>";
        return null;
    }

    return $pedido; 
}

public function actualizarEstadoPedido($id_p, $nuevoEstado, $comentarios) {
    
    if (empty($comentarios)) {
        echo "<script>alert('Los comentarios no pueden estar vacíos.'); 
              window.location.href='tecP.php';</script>";
        return false;
    }

    return $this->tecnicoModel->actualizarEstadoYComentarios($id_p, $nuevoEstado, $comentarios);
}


public function darBajaVisita($id_p) {
    if (empty($id_p)) {
        echo "<script>alert('ID del pedido inválido.'); window.location.href='tecP.php';</script>";
        return false;
    }
    return $this->tecnicoModel->darBajaVisita($id_p);
}


public function buscarC($email){
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Los datos ingresados son erróneos.'); 
        window.location.href='listadoCtec.php';</script>";
        return null;
    }

    $datosC = $this->tecnicoModel->buscarClientes($email);
    if (!$datosC) {
        echo "<script>alert('Error al buscar el usuario.'); 
        window.location.href='listadoCtec.php';</script>";
        return null;
    }

    return $datosC;
}


}
?>