<?php
$server = "localhost";
$user = "root";
$pass = "";
$db = "datoscliente";

$conectar = new mysqli($server, $user, $pass, $db);

if ($conectar->connect_error) {
    die("Conexión fallida. Intente de nuevo señor: " . $conectar->connect_error);
}

if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];

    // Consulta SQL para obtener datos relacionados
    $sql_cliente = "SELECT c.nombre AS nombre_cliente, c.apellido, c.DNI, c.telefono, c.fecha,
            e.nombre AS nombre_empresa, e.direccion AS direccion_empresa,
            p.tip_produ, p.descripcion, p.cantidad, p.precio
            FROM cliente AS c
            JOIN empresa AS e ON c.empresa_id = e.id
            JOIN producto AS p ON c.id = p.cliente_id
            WHERE c.nombre LIKE '%$nombre%' ";

    $resultado = $conectar->query($sql_cliente);

    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            echo "Nombre del Cliente: " . $fila['nombre'] . "<br>";
            echo "'Nombre de la empresa': " . $fila['empresa'] . "<br>";
            echo "Nombre del Cliente: " . $fila['nombre'] . "<br>";
            echo "Nombre del Cliente: " . $fila['nombre'] . "<br>";
            // ... Imprime los demás datos
            echo "<br>";
        }
    } else {
        echo "No se encontraron resultados para el cliente: " . $nombre;
    }
} else {
    echo "No se ha proporcionado un nombre para buscar.";
}
?>
