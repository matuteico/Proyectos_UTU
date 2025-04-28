<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="views/styles_pags.css">

    <title>Listado de Clientes</title>
</head>
<body>
<header>
<h1>Listar Clientes</h1>
    <form method="post" action="" style="display: right;">
        <input type="submit" name="volver" value="VOLVER">       
     </form>
</header>


<form method="POST">
<div class="form-group">
    <label for="bid">Buscar por email:</label>
    <input type="text" name="email_C" placeholder="Ingrese Email del cliente a buscar" required>
    <input type="submit" value="Buscar" name="btn_buscar" class="btn-secondary">
</div>


<table class="table" id="listadoC">
        <thead>
          <tr>
            <th>Email</th>
            <th>Nombre</th>
            <th>Celular</th>
          </tr>
        </thead>
        <tbody>
        
        <?php if (!empty($datosC)): ?>
                <tr>
                    <td><?php echo ($datosC['email']); ?></td>
                    <td><?php echo ($datosC['nombre']); ?></td>
                    <td><?php echo ($datosC['celular']); ?></td>
                </tr>
        <?php else: ?>
            <tr>
                <td colspan="5">No se encontraron Clientes.</td>
            </tr>
        <?php endif; ?>
    </tbody>
                        
          </tr>
       
      </table>      



        </form>
</body>
</html>