<?php

require_once("models/AdminModel.php");


class AdminController{
    private $adminModel;

    public function __construct(){
        $this->adminModel = new AdminModel();
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
        header("Location: administradores.php");
        exit();
    }

    public function irCRUDT() {
        header("Location: gestionT.php");
        exit();
    }
    
    public function irAsignarServicio() {
        header("Location: gestionA.php");
        exit();
    }

    public function irAsignarVisitas() {
        header("Location: visitaadm.php");
        exit();
    }

    public function altaUsuario($email, $nombre, $passwd, $celular, $email_a) {
        if (empty($email) || empty($nombre) || empty($passwd) || empty($celular)){
                    echo "<script>alert('Ha dejado campos vacios.'); 
            window.location.href='gestionT.php';</script>";
        }else{
            if (preg_match('/\d/', $nombre) || !ctype_digit($celular) 
            || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                
                echo "<script>alert('Los datos ingresados son erróneos.'); 
            window.location.href='gestionT.php';</script>";

            }else{
                $passwd = MD5($passwd);
            $altUs = $this->adminModel->altaUsuario($email, $nombre, $passwd, $celular, $email_a);

                echo "<script>alert('Usuario creado exitosamente.'); 
                window.location.href='gestionT.php';</script>";
            }
         }
    }

    public function bajaUsuario($email){ 
     if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){

     echo "<script>alert('Los datos ingresados son erróneos.'); 
     window.location.href='gestionT.php';</script>";

      }else{

        $actualizarUs = $this->adminModel->bajaUsuario($email);
        if (!$actualizarUs) {
            echo "<script>alert('Error al modificar el usuario.'); 
            window.location.href='gestionT.php';</script>";
        } else {
            echo "<script>alert('Usuario dado de baja exitosamente.'); 
            window.location.href='gestionT.php';</script>";
        }
     }


    }

    public function buscarUsuario($email) {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Los datos ingresados son erróneos.'); 
            window.location.href='gestionT.php';</script>";
            return null;
        }
    
        $datosB = $this->adminModel->buscarUsuario($email);
        if (!$datosB) {
            echo "<script>alert('Error al buscar el usuario.'); 
            window.location.href='gestionT.php';</script>";
            return null;
        }
    
        return $datosB;
    }
    
    public function actualizarUsu($email, $nombre, $passwd, $celular, $baja) {

        if (empty($email) || empty($nombre) || empty($passwd) || empty($celular)){
            echo "<script>alert('Ha dejado campos vacios.'); 
      window.location.href='gestionT.php';</script>";
      }else{
      if (preg_match('/\d/', $nombre) || !ctype_digit($celular) 
     || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    
        echo "<script>alert('Los datos ingresados son erróneos.'); 
       window.location.href='gestionT.php';</script>";
        }else{
        $actualizarUs = $this->adminModel->actualizarUsuario($email, $nombre, $passwd, $celular, $baja);
        if (!$actualizarUs) {
            echo "<script>alert('Error al modificar el usuario.'); 
            window.location.href='gestionT.php';</script>";
        } else {
            echo "<script>alert('Usuario modificado exitosamente.'); 
            window.location.href='gestionT.php';</script>";
        }
     }
      }
    }

    public function asignarPedido($id_p, $email_t) {
        if ($this->adminModel->existeAsignacion($id_p)) {
            echo "<script>alert('Este pedido ya fue asignado.'); 
            window.location.href='gestionA.php';</script>";
            exit;
        }
    
        if (!$this->adminModel->esTecnico($email_t)) {
            echo "<script>alert('El correo ingresado no pertenece a un técnico.'); 
            window.location.href='gestionA.php';</script>";
            exit;
        }
    
        if (!is_numeric($id_p) || $id_p <= 0) {
            echo "<script>alert('ID inválido.'); 
            window.location.href='gestionA.php';</script>";
            exit;
        }
    
       
        if (!filter_var($email_t, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Mail inválido.'); 
            window.location.href='gestionA.php';</script>";
            exit;
        }
    
     
        $datosPedido = $this->adminModel->obtenerDatosPedido($id_p);
    
        if ($datosPedido) {
            $email_c = $datosPedido['email_c'];
            $servicio_id = $datosPedido['servicio_id'];
    
            if (empty($email_c) || empty($servicio_id)) {
                echo "<script>alert('Datos vacíos o inválidos.'); 
                window.location.href='gestionA.php';</script>";
                exit;
            }
    
         
            if ($this->adminModel->altaAsigna($id_p, $email_c, $email_t, $servicio_id)) {
               
                header("Location: gestionA.php");
                exit;
            } else {
                echo "<script>alert('Error al asignar el pedido.'); 
                window.location.href='gestionA.php';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Pedido no encontrado.'); 
            window.location.href='gestionA.php';</script>";
            exit;
        }
    }
   
    public function darAltaVisita($id_p, $id_h, $dia) {
        if ($this->adminModel->verificarVisitaExistente($id_p, $id_h, $dia)) {
            echo "<script>alert('Datos ingresados inválidos.'); 
                  window.location.href='visitaadm.php';</script>";
            return;
        }
        
        if ($this->adminModel->verificarPedidoEnAsigna($id_p)) {
            if ($this->adminModel->insertarVisita($id_p, $id_h, $dia)) {
                header("Location: visitaadm.php");
                exit;
            } else {
                echo "<script>alert('Error al asignar la visita.'); 
                       window.location.href='visitaadm.php';</script>";
            }
        } else {
            echo "<script>alert('El pedido no está registrado en la tabla Asigna.');
                  window.location.href='visitaadm.php';</script>";
        }
    }
    
    
    public function buscarC($email){
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Los datos ingresados son erróneos.'); 
            window.location.href='listadoCadm.php';</script>";
            return null;
        }
    
        $datosC = $this->adminModel->buscarClientes($email);
        if (!$datosC) {
            echo "<script>alert('Error al buscar el usuario.'); 
            window.location.href='listadoCadm.php';</script>";
            return null;
        }
    
        return $datosC;
    }

    public function buscarV($id_v){
        if (empty($id_v)) {
            echo "<script>alert('Los datos ingresados son erróneos.'); 
            window.location.href='visitaadm.php';</script>";
            return null;
        }
    
        $datosV = $this->adminModel->buscarVisita($id_v);
        if (!$datosV) {
            echo "<script>alert('Error al buscar la visita.'); 
            window.location.href='visitaadm.php';</script>";
            return null;
        }
    
        return $datosV;


    }

    public function actualizarV($id_v, $id_p, $id_h, $dia, $baja) {
        if (empty($id_p) || empty($id_h) || empty($dia) || $baja === '') {
            echo "<script>alert('Ha dejado campos vacíos.'); 
            window.location.href='visitaadm.php';</script>";
            return;
        }
        
        $actualizarV = $this->adminModel->actVisitas($id_p, $id_h, $dia, $baja, $id_v);
        if (!$actualizarV) {
            echo "<script>alert('Error al modificar la visita.'); 
            window.location.href='visitaadm.php';</script>";
        } else {
            echo "<script>alert('Visita modificada exitosamente.'); 
            window.location.href='visitaadm.php';</script>";
        }
    }
    



    public function mostrarP() {
        $pedidos = $this->adminModel->cargarAsigna();
        return $pedidos;
    }

    public function mostrarNoAsign(){
        $pendientes = $this->adminModel->cargarNoAsigna();
        return $pendientes;
    }

    public function cargarV(){
        $visita = $this->adminModel->cargarV();
        return $visita;
    }

} 

?>