<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="views/styles_pags.css">

    <title>Panel Técnico</title>
    
<body>
    <header>
        <h1>INICIO</h1>
        <form method="post" action="" style="display: right;">
        <input type="submit" name="cs" value="CERRAR SESION">
        </form>
    </header>

    <form method="post" action="">
   
<h2>Pedidos Asignados</h2>

<table class="table" id="pedidoT">
    <thead>
        <tr>
            <th>ID Pedido</th>
            <th>Email Cliente</th>
            <th>ID Servicio</th>
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
<h2>Visitas Programadas</h2>


<table class="table" id="visitaT">
    <thead>
        <tr>
            <th>ID Visita</th>
            <th>ID Pedido</th>
            <th>Horario Inicio</th>
            <th>Horario Fin</th>
            <th>Dia</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($visitas)): ?>
            <?php foreach ($visitas as $visita): ?>
                <tr>
                    <td><?php echo ($visita['id_v']); ?></td>
                    <td><?php echo ($visita['id_p']); ?></td>
                    <td><?php echo ($visita['h_ini']); ?></td>
                    <td><?php echo ($visita['h_fin']); ?></td>
                    <td><?php echo ($visita['dia']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No se encontraron pedidos.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>



    </form>

  <form method="post" action="">
  <div>
    <input type="submit" name="gs" value="Gestión de Servicios">
    <input type="submit" name="lc" value="Listado de Clientes">
</div>
  </form>


    </body>
</html>
