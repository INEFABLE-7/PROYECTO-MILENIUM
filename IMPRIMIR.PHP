<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Cliente</title>
    <link rel="stylesheet" href="IMPRIMIR.CSS">
</head>
<body>

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
    $DNI_buscar = $_POST['DNI_buscar'];

    if (!empty($DNI_buscar)) {
        // Consulta SQL preparada para evitar SQL Injection
        $sql_buscar = "SELECT c.DNI, c.nombre, c.apellido, c.telefono, c.fecha,
                        e.nombre AS empresa_nombre, e.direccion, e.telefono AS empresa_telefono,
                        p.tip_produ, p.descripcion, p.cantidad, p.precio
                    FROM cliente c
                    INNER JOIN empresa e ON c.FK_EMPRESA_ENLACE = e.id_empresa
                    INNER JOIN producto p ON c.id_cliente = p.FK_CLIENTE_ENLACE
                    WHERE c.DNI = ?";

        $stmt = $conectar->prepare($sql_buscar);
        $stmt->bind_param("s", $DNI_buscar);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) {
                // Mostrar la información del cliente
                echo "<div class='resultado'>";
                echo "<div class='nombre'>Nombre: " . $fila['nombre'] . "</div>";
                echo "<div class='apellido'>Apellido: " . $fila['apellido'] . "</div>";
                echo "<div class='dni'>DNI: " . $fila['DNI'] . "</div>";
                echo "<div class='telefono'>Teléfono: " . $fila['telefono'] . "</div>";
                echo "<div class='fecha'>Fecha: " . $fila['fecha'] . "</div>";
                echo "<div class='empresa'>Empresa: " . $fila['empresa_nombre'] . "</div>";
                echo "<div class='direccion'>Dirección: " . $fila['direccion'] . "</div>";
                echo "<div class='empresa_telefono'>Teléfono de la empresa: " . $fila['empresa_telefono'] . "</div>";
                echo "<div class='producto'>Producto: " . $fila['tip_produ'] . "</div>";
                echo "<div class='descripcion'>Descripción: " . $fila['descripcion'] . "</div>";
                echo "<div class='cantidad'>Cantidad: " . $fila['cantidad'] . "</div>";
                echo "<div class='precio'>Precio: " . $fila['precio'] . " soles" . "</div>";
                echo "<div class='separador'></div>"; // Separador sin contenido
                echo "</div>";
            }
        } else {
            echo "No se encontraron registros para el cliente con DNI: $DNI_buscar";
        }

        $stmt->close();
    } else {
        echo "Por favor, ingrese un número de DNI para buscar.";
    }
}

// Cerrar la conexión
$conectar->close();
?>
</body>
</html>
