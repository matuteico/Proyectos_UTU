<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        .container {
            display: flex;
            justify-content: space-between;
        }
        .left-column, .right-column {
            width: 48%;
            background: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        hr {
            margin: 20px 0;
        }
        form {
            background: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        input[type="text"],button, input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="password"],button, input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        button, input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover, input[type="submit"]{
            background-color: #0056b3;
        }
    </style>
<body>
    <header>
        <h1>Visita</h1>
        <form method="post" action="" style="display: right;">
        <button type="button" id="volver" onclick="window.location.href='pagina1.php'">Volver</button>
        </form>
    </header>

    <form method="post" action="">
   
   <?php

   // administrador
   // tabla con los pedidos asignados 
   // tabla de visitas completas

   // crear vistas de cantidad de pedidos segun el estado y cantidad de veces que aparecen los tecnicos
   
   ?>

    <div>
    <select name="id_p" id="id_p">
        <option value="id_p">id_p</option>
        </select>
   </div>

   <div>
    <select name="id_h" id="id_h">
        <option value="id_h">Horarios</option>
        </select>
   </div>

   <div>

<input type="date" name="dia" id="dia">
    
   </div>
    
        <div>
            <input type="submit" value="Guardar" name="btn_guardar">
        </div>
    </form>
