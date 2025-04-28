<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="views/styles_pags.css">

    <title>Gestor de Pedidos</title>
   <body>
    <header>
        <h1>Gestión de Pedidos</h1>
        <form method="post" action="" style="display: right;">
        <input type="submit" name="cs" value="CERRAR SESION">
        <input type="submit" value="MODIFICAR DATOS" name="btn_irm" class="btn-secondary">
        </form>
    </header>

    <table class="table" id="pedidoC">
    <thead>
        <tr>
            <th>ID Pedido</th>
            <th>Tipo de Servicio</th>
            <th>Fecha Registro</th>
            <th>Comentarios</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($pedidos)): ?>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?php echo ($pedido['id_p']); ?></td>
                    <td><?php echo ($pedido['servicio_tipo']); ?></td>
                    <td><?php echo ($pedido['f_reg']); ?></td>
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

      <table class="table" id="visitaC">
        <thead>
          <tr>
            <th>ID Pedido</th>
            <th>Mail Técnico</th>
            <th>Horario Estimado</th>
            <th>Dia</th>
          </tr>
        </thead>
        <tbody>
        
        <?php if (!empty($visitas)): ?>
            <?php foreach ($visitas as $visita): ?>
                <tr>
                    <td><?php echo ($visita['id_p']); ?></td>
                    <td><?php echo ($visita['email_t']); ?></td>
                    <td><?php echo ($visita['h_e']); ?></td>
                    <td><?php echo ($visita['dia']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No se encontraron visitas.</td>
            </tr>
        <?php endif; ?>
    </tbody>
                        
          </tr>
       
      </table>      



    <form method="post" action="">
   
    <div>

    <div class="form-group">
    <label for="servicio_tipo">Selecciona el tipo de servicio:</label>
    <select name="servicio_tipo" id="servicio_tipo" class="custom-select">
        <option value="reparacionpc">REPARACION PC | $2000</option>
        <option value="tv">TELEVISORES | $1000</option>
        <option value="otros">OTROS | $500</option>
    </select>
</div>

<div class="form-group">
    <label for="msg">Comentarios:</label>
    <textarea id="msg" name="comentario" placeholder="Ingrese datos de contacto y dirección" class="custom-textarea"></textarea>
</div>


<div class="form-group">
    <input type="submit" value="Guardar" name="btn_guardar" class="btn-primary">
</div>



</div>


<hr>


<form method="POST">
<div class="form-group">
    <label for="bid">Buscar por ID:</label>
    <input type="number" name="bid" id="bid" class="custom-input"> <br> <br>
    <input type="submit" value="Buscar" name="btn_buscar" class="btn-secondary">
</div>
</form>

<?php if ($pedidoB): ?>
<form method="POST">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($pedidoB['id_p']); ?>">
    
    <label for="servicio_tipob">Tipo de Servicio:</label>
    <select name="servicio_tipob" id="servicio_tipob" required>
        <option value="reparacionpc" <?php if ($pedidoB['servicio_id'] == 1) echo 'selected'; ?>>REPARACION PC</option>
        <option value="tv" <?php if ($pedidoB['servicio_id'] == 2) echo 'selected'; ?>>TELEVISORES</option>
        <option value="otros" <?php if ($pedidoB['servicio_id'] == 3) echo 'selected'; ?>>OTROS</option>
    </select>

    <label for="comentario">Comentario:</label>
    <textarea name="comentario" id="comentario" placeholder="Ingrese datos de contacto y dirección" 
    style="height:200px" required><?php echo htmlspecialchars($pedidoB['comentarios']); ?></textarea>

    <input type="submit" value="Actualizar" name="btn_actualizar">
</form>
<?php endif; ?>



</form>
