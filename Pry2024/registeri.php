<?php

require_once("controllers/RegisterController.php");

if (isset($_POST['registrar'])) {
    // Manejar el registro de usuario
    $email = trim($_POST['email']);
    $nombre = $_POST['nombre'];
    $passwd = $_POST['passwd'];
    $celular = $_POST['celular'];

    // Crear instancia del controlador de registro y llamar a la función register
    $registerController = new RegisterController();
    $registerController->register($email, $nombre, $passwd, $celular);

 } else {
        // Cargar la vista de inicio de sesión por defecto
        include("views/register.php");
    }