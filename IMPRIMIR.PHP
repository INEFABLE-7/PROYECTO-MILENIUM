<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Cliente</title>
    <link rel="stylesheet" href="IMPRIMIR.CSS">


</head>
<body class="body-style">
    <h1 class="temaimp">Buscar Cliente y su Relación</h1>
    <form class="forbus" action="IMPRIMIR.PHP" method="post">
        <label for="nombre_buscar">Ingrese el nombre del cliente:</label>
        <input type="text" id="nombre_buscar" name="nombre_buscar">
        <button type="submit">Buscar</button>
    </form>

<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1); 
    
    $server = "localhost";
    $user = "root";
    $pass = "";
    $db = "datoscliente";
    
    $conectar = new mysqli($server, $user, $pass, $db);
    
    if ($conectar->connect_error) {
        die("Conexión fallida. Intente de nuevo señor: " . $conectar->connect_error);
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre_buscar = $_POST['nombre_buscar'];
    
        if (!empty($nombre_buscar)) {
            $sql_buscar = "SELECT c.nombre AS cliente_nombre, c.apellido, c.DNI, c.telefono, c.fecha,
                                e.nombre AS empresa_nombre, e.direccion, e.telefono AS empresa_telefono,
                                p.tip_produ, p.descripcion, p.cantidad, p.precio
                        FROM cliente c
                        INNER JOIN empresa e ON c.FK_EMPRESA_ENLACE = e.id_empresa
                        INNER JOIN producto p ON c.id_cliente = p.FK_CLIENTE_ENLACE
                        WHERE c.nombre = '$nombre_buscar'";
    
            $resultado_buscar = $conectar->query($sql_buscar);
    
            if ($resultado_buscar->num_rows > 0) {
                while ($fila = $resultado_buscar->fetch_assoc()) {

                    echo "<div class='resultado'>";
echo "<div class='cliente-nombre'>" . $fila['cliente_nombre'] .  " " . $fila['apellido'] . "</div>";
echo "<div class='dni'>DNI: " . $fila['DNI'] . "</div>";
echo "<div class='telefono'>Teléfono: " . $fila['telefono'] . "</div>";
echo "<div class='fecha'>Fecha: " . $fila['fecha'] . "</div>";
echo "<div class='empresa'>Empresa: " . $fila['empresa_nombre'] . "</div>";
echo "<div class='direccion'>Dirección: " . $fila['direccion'] . "</div>";
echo "<div class='empresa-telefono'>Teléfono de la empresa: " . $fila['empresa_telefono'] . "</div>";
echo "<div class='producto'>Producto: " . $fila['tip_produ'] . "</div>";
echo "<div class='descripcion'>Descripción: " . $fila['descripcion'] . "</div>";
echo "<div class='cantidad'>Cantidad: " . $fila['cantidad'] . "</div>";
echo "<div class='precio'>Precio: " . $fila['precio'] ." soles". "</div>";
echo "<div class='separador'>------------------------</div>";
echo "</div>";
                }
            } else {
                echo "No se encontraron registros para el cliente: $nombre_buscar<br>";
            }
        } 
    }
    
    
    // Cerrar la conexión
    $conectar->close();
    ?>
</body>
</html>