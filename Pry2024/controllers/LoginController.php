<?php
require_once("models/UserModel.php");
session_start();

class LoginController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function login($usu, $psw) {
        if ($usu != "" && $psw != "") {
            $usuarioData = $this->userModel->login($usu, $psw);
            if ($usuarioData) {
                $_SESSION['email'] = $usu;
                
                // Redirección según tipo de usuario
                if ($usuarioData['tipoU'] == 'Admin') {
                   header("Location: administradores.php");
                } elseif ($usuarioData['tipoU'] == 'Cliente') {
                    header("Location: clientei.php");
                   

                }elseif($usuarioData['tipoU'] == 'Tecnico'){
                    header("Location: teci.php");

                }
                exit;
            } else {
                echo "<script>alert('Usuario y/o contraseña incorrectos.');
                window.location.href='index.php';</script>";
            }
        } else {
            echo "<script>alert('Ha dejado campos vacios.');
            window.location.href='index.php';</script>";
        }
    }

    public function registrarse() {
        header("Location: registeri.php");
        exit();
    }
}
?>
