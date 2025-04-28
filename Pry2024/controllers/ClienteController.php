<?php
require_once("models/UserModel.php");

class ClienteController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
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
        header("Location: clientei.php");
        exit();
    }






    public function altaP($s_id, $email, $comentarios, $f_pedido, $h_pedido) {
        if ($comentarios != "") {
            if ($s_id == "reparacionpc") {
                $s_id = 1;
            } elseif ($s_id == "tv") {
                $s_id = 2;
            } elseif ($s_id == "otros") {
                $s_id = 3;
            } else {
                echo "<script>alert('Tipo de servicio no válido.'); 
                window.location.href='clientei.php';</script>";
                return;
            }
            
            $altaP = $this->userModel->altaP($s_id, $email, $comentarios, $f_pedido, $h_pedido);
            if (!$altaP) {
                echo "<script>alert('Error al crear el pedido.'); 
                window.location.href='clientei.php';</script>";
            } else {
                echo "<script>alert('Pedido creado exitosamente.'); 
                window.location.href='clientei.php';</script>";
            }
        } else {
            echo "<script>alert('Comentarios no pueden estar vacíos.'); 
            window.location.href='clientei.php';</script>";
        }
    }

    
    public function mostrarP($email) {
        $pedidos = $this->userModel->obtenerPedidos($email);
        return $pedidos; 
    }
    

    public function cargarV($email) {
        $visitas = $this->userModel->cargarV($email);
        return $visitas; 
    }

   
    public function buscarPedido($id) {
        $email = $_SESSION['email'];
        return $this->userModel->buscarPedidoPorId($id, $email);
        require_once("registeri.php");
    }

    public function actualizarPedido($id, $servicio_id, $comentario) {
        if ($servicio_id == "reparacionpc") {
            $servicio_id = 1;
        } elseif ($servicio_id == "tv") {
            $servicio_id = 2;
        } elseif ($servicio_id == "otros") {
            $servicio_id = 3;
        } else {
            echo "<script>alert('Tipo de servicio no válido.'); 
            window.location.href='clientei.php';</script>";
            return;
        }

        return $this->userModel->actualizarPedido($id, $servicio_id, $comentario);
    }
    
    public function cargarC() {
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
        $datosC = $this->userModel->cargarC($email);
        return $datosC;
    }
    return null;
}

public function modC($email, $nombre, $passwd, $celular){
        if (empty($email) || empty($nombre) || empty($passwd) || empty($celular)){
            echo "<script>alert('Ha dejado campos vacios.'); 
      window.location.href='clientem.php';</script>";
      }else{
      if (preg_match('/\d/', $nombre) || !ctype_digit($celular) 
     || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    
        echo "<script>alert('Los datos ingresados son erróneos.'); 
       window.location.href='clientem.php';</script>";

        }else{
        $actualizarUs = $this->userModel->modC($email, $nombre, $passwd, $celular);
        if (!$actualizarUs) {
            echo "<script>alert('Error al modificar el usuario.'); 
            window.location.href='clientem.php';</script>";
        } else {
            echo "<script>alert('Usuario modificado exitosamente.'); 
            window.location.href='clientei.php';</script>";
        }
     }
      }
    }




}








?>
