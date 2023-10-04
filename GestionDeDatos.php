<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registros de Clientes y Productos</title>
    <!-- Estilos CSS aquí (si es necesario) -->
</head>
<body>
    <h1>Registros de Clientes</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>DNI</th>
                <th>Teléfono</th>
                <th>Fecha</th>
                <!-- Agrega más encabezados según tu tabla si es necesario -->
            </tr>
        </thead>
        <tbody>
            <?php
            if ($resultado_cliente->num_rows > 0) {
                while ($fila = $resultado_cliente->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $fila['id_cliente'] . "</td>";
                    echo "<td>" . $fila['nombre'] . "</td>";
                    echo "<td>" . $fila['apellido'] . "</td>";
                    echo "<td>" . $fila['DNI'] . "</td>";
                    echo "<td>" . $fila['telefono'] . "</td>";
                    echo "<td>" . $fila['fecha'] . "</td>";
                    // Agrega más celdas según tu tabla si es necesario
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay registros de clientes disponibles</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <h1>Registros de Productos</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo de Producto</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <!-- Agrega más encabezados según tu tabla si es necesario -->
            </tr>
        </thead>
        <tbody>
            <?php
            if ($resultado_producto->num_rows > 0) {
                while ($fila = $resultado_producto->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $fila['id_producto'] . "</td>";
                    echo "<td>" . $fila['tip_produ'] . "</td>";
                    echo "<td>" . $fila['descripcion'] . "</td>";
                    echo "<td>" . $fila['cantidad'] . "</td>";
                    echo "<td>" . $fila['precio'] . "</td>";
                    // Agrega más celdas según tu tabla si es necesario
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No hay registros de productos disponibles</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
