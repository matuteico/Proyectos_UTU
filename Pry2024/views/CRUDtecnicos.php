<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="views/styles_pags.css">

    <title></title>
    
<body>
    <header>
        <h1>CRUD TECNICOS</h1>
        <form method="post" action="" style="display: right;">
        <input type="submit" name="volver" value="VOLVER">       
     </form>
    </header>

    <form method="post" action="">
        <h1>ALTA TECNICOS</h1>
        <div>
        <label for="email">Email:</label>
        <input type="text" name="email" placeholder="Ingrese su Email" >
        </div>
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" placeholder="Ingrese su nombre" >
        </div>
        <div>
            <label for="password">Contraseña:</label>
            <input type="password" name="passwd" placeholder="Ingrese una Contraseña" 
            maxlength="12" minlength="8" >
        </div>
        <div>
            <label for="celular">Celular:</label>
            <input type="text" name="celular" placeholder="Ingrese un Celular" >
        </div>
        
        <div>
            <input type="submit" value="Guardar" name="btn_guardar_tec">
        </div>
    </form>

    <form method="post" action="">
        <h1>BAJA TECNICOS</h1>
        <div>
        <label for="email">Email:</label>
        <input type="text" name="email_B" placeholder="Email de tecnico a borrar" required>
        </div>
        <div>
            <input type="submit" value="Guardar" name="btn_baja">
        </div>
    </form>
    <form method="post" action=""> 
    <h1>MODIFICACION TECNICOS</h1>
    
    <input type="text" name="email_M" placeholder="Ingrese Email del tecnico a modificar" required>
    <input type="submit" name="buscar" value="Buscar">
</form>

<form method="post" >
<?php if (isset($datosB)):?>
    <input type="text" name="email" value="<?php echo ($datosB['email']); ?>" readonly>
    <input type="text" name="nombre" value="<?php echo ($datosB['nombre']); ?>" required>
    <input type="password" name="passwd" placeholder="Nueva contraseña" required maxlength="12" minlength="8">
    <input type="text" name="celular" value="<?php echo ($datosB['celular']); ?>" required>
    <label for="baja">Estado de Baja:</label>
        <select name="baja" id="baja" required>
            <option value="0" <?php echo $datosB['baja'] == 0 ? 'selected' : ''; ?>>Activo</option>
            <option value="1" <?php echo $datosB['baja'] == 1 ? 'selected' : ''; ?>>Dado de Baja</option>
        </select>
        
    <div>
        <br>
        <input type="submit" value="Guardar" name="btn_guardar">
    </div>
<?php endif; ?>
    
</form>


