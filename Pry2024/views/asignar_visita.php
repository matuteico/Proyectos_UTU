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
    <h1>Asignacion de Visitas</h1>
    <form method="post" action="" style="display: right;">
        <input type="submit" name="return" value="VOLVER">

    </form>
</header>

<div class="container">
   
    <div class="left-column">
        <h2>Lista de Visitas</h2>
        <hr>
        <table class="table" id="pedidoC">
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


    </div>

    <div class="right-column">
    <h2>Alta de Visita</h2>
    <hr>
    <form method="post" action="">
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha disponible</th> 
                    <th>Hora</th>
                    <th>ID del Pedido</th> 
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="fecha" id="f_pedido" class="custom-select">
                        
                        </select>
                    </td>
                    <td>
                        <select name="hora" class="custom-select">
                            <option value="1">09:00 - 10:00</option>
                            <option value="2">10:00 - 11:00</option>
                            <option value="3">11:00 - 12:00</option>
                            <option value="4">12:00 - 13:00</option>
                            <option value="5">13:00 - 14:00</option>
                            <option value="6">14:00 - 15:00</option>
                            <option value="7">15:00 - 16:00</option>
                            <option value="8">16:00 - 17:00</option>
                            <option value="9">17:00 - 18:00</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" name="id_p" id="id_p" placeholder="Ingrese la ID de un pedido">
                    </td>
                    
                </tr>
            </tbody>
        </table>
        <div style="margin-top: 20px; text-align: center;">
            <input type="submit" class="btn-primary" name="btn_alta" value="Alta de Visita">
        </div>
    </form>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
    const numDays = 7;  // Número de días que se mostrarán
    const fechaSelect = document.getElementById('f_pedido');
    const today = new Date();

    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0'); 
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    for (let i = 0; i < numDays; i++) {
        const nextDate = new Date(today);
        nextDate.setDate(today.getDate() + i); 

        const option = document.createElement('option');
        option.value = formatDate(nextDate); 
        option.textContent = formatDate(nextDate); 
        fechaSelect.appendChild(option);
    }
});
</script>

        
    </div>
</div>
</div>

<form action="" method="post">

<h1>MODIFICACION VISITAS</h1>
    
<input type="number" id="b_idv" name="b_idv" placeholder="Ingrese ID de la visita a modificar" required>
    <br><br>
    <input type="submit" name="buscar_v" value="Buscar">
</form>

<form method="post" >
<?php if (isset($datosV)):?>
    <label for="baja">ID Visita:</label>
    <input type="text" name="idv_e" value="<?php echo ($datosV['id_v']); ?>" readonly>
    <label for="baja">ID Pedido:</label>
    <input type="text" name="b_idp" value="<?php echo ($datosV['id_p']); ?>" required>

    <label for="baja">Horario:</label>
<select name="b_idh" class="custom-select">
    <option value="1" <?php echo $datosV['id_h'] == 1 ? 'selected' : ''; ?>>09:00 - 10:00</option>
    <option value="2" <?php echo $datosV['id_h'] == 2 ? 'selected' : ''; ?>>10:00 - 11:00</option>
    <option value="3" <?php echo $datosV['id_h'] == 3 ? 'selected' : ''; ?>>11:00 - 12:00</option>
    <option value="4" <?php echo $datosV['id_h'] == 4 ? 'selected' : ''; ?>>12:00 - 13:00</option>
    <option value="5" <?php echo $datosV['id_h'] == 5 ? 'selected' : ''; ?>>13:00 - 14:00</option>
    <option value="6" <?php echo $datosV['id_h'] == 6 ? 'selected' : ''; ?>>14:00 - 15:00</option>
    <option value="7" <?php echo $datosV['id_h'] == 7 ? 'selected' : ''; ?>>15:00 - 16:00</option>
    <option value="8" <?php echo $datosV['id_h'] == 8 ? 'selected' : ''; ?>>16:00 - 17:00</option>
    <option value="9" <?php echo $datosV['id_h'] == 9 ? 'selected' : ''; ?>>17:00 - 18:00</option>
</select>

<br><br>
    <label for="baja">Día:</label>
    <input type="date" name="b_dia" value="<?php echo ($datosV['dia']); ?>" required>
<br><br>
    <label for="baja">Estado de Baja:</label>
        <select name="b_baja" id="baja" required>
            <option value="0" <?php echo $datosV['baja'] == 0 ? 'selected' : ''; ?>>Activo</option>
            <option value="1" <?php echo $datosV['baja'] == 1 ? 'selected' : ''; ?>>Dado de Baja</option>
        </select>
        <br><br>
    <div>
        <input type="submit" value="Guardar" name="btn_modV">
    </div>
<?php endif; ?>
    





</form>


</body>
</html>
