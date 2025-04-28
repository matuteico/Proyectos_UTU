<?php
require_once("models/UserModel.php");

class RegisterController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function register($email, $nombre, $passwd, $celular) {
        if ($this->userModel->register($email, $nombre, $passwd, $celular)) {
            echo "<script>alert('Registro exitoso!');
             window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Datos inválidos o error en el registro.'); 
            window.location.href='registeri.php';</script>";
        }
    }
}
?>
