<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="views/styles_login.css">
    <title>Login</title>
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form action="index.php" method="post">
            <input type="text" name="usuario" placeholder="Usuario">
            <input type="password" name="clave" placeholder="Clave">
            <button type="submit" name="ingresar"><b>Ingresar</b></button>
            <button type="submit" name="registrarse"><b>Registrarse</b></button>
        </form>
    </div>
</body>
</html>
