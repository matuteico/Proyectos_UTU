<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="views/styles_pags.css">

    <title>Panel Cliente</title>
</head>
<body>
<header>

<h1>Modificación de Datos</h1>
    <form method="post" action="" style="display: right;">
        <input type="submit" name="volver" value="VOLVER">       
     </form>
</header>
<?php if (!is_null($datosC)): ?>
<form action="" method="post">
    <label for="email">Email:</label>
    <input type="text" name="email" value="<?php echo htmlspecialchars($datosC['email']); ?>" readonly>

    <label for="nombre">Nombre Completo:</label>
    <input type="text" name="nombre" value="<?php echo htmlspecialchars($datosC['nombre']); ?>" required>

    <label for="password">Nueva Contraseña:</label>
    <input type="password" name="passwd" placeholder="Nueva contraseña" required maxlength="12" minlength="8">

    <label for="celular">Celular:</label>
    <input type="text" name="celular" value="<?php echo htmlspecialchars($datosC['celular']); ?>" required>

    <input type="submit" name="mod" value="Modificar">
</form>
<?php endif; ?>





</body>
</html>