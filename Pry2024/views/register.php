<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="views/styles_regis.css">
    <title>Registro de Usuario</title>
</head>
<body>
<h1>Registro de Usuario</h1>
    <div class="container">
        <form method="post" action="registeri.php">
            <label for="email">Email:</label>
            <input type="text" name="email" placeholder="Ingrese su Email" required>

            <label for="nombre">Nombre Completo:</label>
            <input type="text" name="nombre" placeholder="Ingrese su Nombre" required>

            <label for="password">Contraseña:</label>
            <input type="password" name="passwd" placeholder="Ingrese una Contraseña" maxlength="12" minlength="8" required>

            <label for="celular">Celular:</label>
            <input type="text" name="celular" placeholder="Ingrese un Celular" required>

            <input type="submit" name="registrar" value="Registrar">
            <button type="button" id="volver" onclick="window.location.href='index.php'">Volver</button>
        </form>
    </div>
</body>
</html>
