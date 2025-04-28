<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="views/styles_pags.css">
    <title>Panel de Administrador</title>
    
<body>
    <header>
        <h1>Asignación de Pedidos</h1>
        <form method="post" action="" style="display: right;">
        <input type="submit" name="volver" value="VOLVER">  
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
            <th>ID de Servicio</th>
            <th>Comentarios</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($pendiente)): ?>
            <?php foreach ($pendiente as $pentientes): ?>
                <tr>
                    <td><?php echo ($pentientes['id_p']); ?></td>
                    <td><?php echo ($pentientes['email_c']); ?></td>
                    <td><?php echo ($pentientes['servicio_id']); ?></td>
                    <td><?php echo ($pentientes['comentarios']); ?></td>
                    <td><?php echo ($pentientes['estado']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No se encontraron pedidos.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>


    <form method="post" action="">
    <h1>ASIGNAR TECNICOS</h1>

   <div>
   <input type="number" name="id_p" id="id_p" placeholder="Ingrese la id del Pedido">
   </div>
       
        <div>
            <input type="text" name="email_t" placeholder="Ingrese Email del tecnico" required>
        </div>

        <div>
            <input type="submit" name="asignar" value="ASIGNAR">
        </div>
        
    </form>
