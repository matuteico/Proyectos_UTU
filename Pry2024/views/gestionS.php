<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="views/styles_pags.css">
    <title>Panel Técnico</title>
</head>
<body>

<header>
    <h1>Gestión de Servicios</h1>
    <form method="post" action="" style="display: right;">
        <input type="submit" name="volver" value="VOLVER">
    </form>
</header>


<form action="" method="post">
    <input type="text" name="id_p" id="id_p" placeholder="Ingrese la ID del Pedido a actualizar...">
    <br><br>
    <input type="submit" name="b_gs" value="BUSCAR" style="margin-left:26%;">
</form>

<?php if (isset($pedido) && $pedido): ?>
    <form action="" method="post">
        <input type="hidden" name="id_p" value="<?php echo htmlspecialchars($id_p); ?>">

        <div class="form-group">
            <label for="servicio_tipo">Selecciona el estado del servicio:</label>
            <select name="servicio_tipo" id="servicio_tipo" class="custom-select">
                <option value="enproceso" <?php echo (isset($_POST['servicio_tipo']) && $_POST['servicio_tipo'] == 'enproceso') ? 'selected' : ''; ?>>EN PROCESO</option>
                <option value="finalizado" <?php echo (isset($_POST['servicio_tipo']) && $_POST['servicio_tipo'] == 'finalizado') ? 'selected' : ''; ?>>FINALIZADO</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="comentarios">Comentarios:</label>
            <textarea name="comentarios" id="comentarios" rows="4" cols="50"><?php echo isset($_POST['comentarios']) ? $_POST['comentarios'] : ''; ?></textarea>
        </div>

        <input type="submit" name="g_gs" value="GUARDAR" style="margin-left:26%;">
    </form>
<?php endif; ?>



</body>
</html>