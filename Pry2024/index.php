<?php
// Cargar controladores necesarios
require_once("controllers/LoginController.php");


// Verificar si se ha enviado el formulario de inicio de sesión o de registro
if (isset($_POST['ingresar'])) {
    // Manejar el inicio de sesión
    $usu = trim($_POST['usuario']);
    $psw = $_POST['clave'];

    // Crear instancia del controlador de inicio de sesión y llamar a la función login
    $loginController = new LoginController();
    $loginController->login($usu, $psw);

} elseif (isset($_POST['registrarse'])) {
    // Redirigir al formulario de registro si se presiona el botón de "Registrarse" en el login
    header("Location: ./registeri.php");
    exit();
} else {
    // Cargar la vista de inicio de sesión por defecto
    include("views/login.php");
}
?>
