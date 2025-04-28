<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="views/styles_admin.css">

    <title>Panel de Administrador</title>
</head>
<body>
<header>
        <h1>Gestión de Pedidos</h1>
        <form method="post" action="" style="display: right;">
        <input type="submit" name="cs" value="CERRAR SESION">
        </form>
    </header>
                    
<div>
    <h2>Lista de Pedidos</h2>
</div>
<hr>
   <table class="table" id="pedidoC">
    <thead>
        <tr>
            <th>ID Pedido</th>
            <th>Email Cliente</th>
            <th>Email Técinco</th>
            <th>Tipo de Servicio</th>
            <th>Comentarios</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($pedidos)): ?>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?php echo ($pedido['id_p']); ?></td>
                    <td><?php echo ($pedido['email_c']); ?></td>
                    <td><?php echo ($pedido['email_t']); ?></td>
                    <td><?php echo ($pedido['servicio_id']); ?></td>
                    <td><?php echo ($pedido['comentarios']); ?></td>
                    <td><?php echo ($pedido['estado']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No se encontraron pedidos.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
 <form action="" method="post">
<div>

<input type="submit" name="gt" value="Gestión de Técnicos">
<br><br>
<input type="submit" name="as" value="Asignar Servicio">
<input type="submit" name="lc" value="Listar Clientes"> 
<br><br>
<input type="submit" name="av" value="Asignar Visitas">
                    

</div>
</form>


   
</body>
</html>







</body>
</html>