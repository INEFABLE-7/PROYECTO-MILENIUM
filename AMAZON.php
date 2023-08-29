<?php 

$server = "localhost";
$user = "root";
$pass = "";
$db = "datoscliente";

$conectar = new mysqli($server, $user, $pass, $db);

if ($conectar->connect_error) {
    die("Conexión fallida. Intente de nuevo señor: " . $conectar->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Datos del formulario de cliente
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $DNI = $_POST['DNI'];
    $telefono = $_POST['telefono'];
    $fecha = $_POST['Fecha'];

    // Datos del formulario de producto
    $tip_produ = $_POST['tip_produ'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];

    // Verificar que se proporcionaron datos para ambas tablas
    if (!empty($nombre) && !empty($apellido) && !empty($DNI) && !empty($telefono) && !empty($fecha) &&
        !empty($tip_produ) && !empty($descripcion) && !empty($cantidad) && !empty($precio)) {

        // Comenzar una transacción
        $conectar->begin_transaction();

        try {
            // Insertar datos en la tabla "cliente"
            $sql_cliente = "INSERT INTO cliente (nombre, apellido, DNI, telefono, fecha)
                            VALUES ('$nombre', '$apellido', '$DNI', '$telefono', '$fecha')";

            if ($conectar->query($sql_cliente) !== TRUE) {
                throw new Exception("Error en el registro del cliente: " . $conectar->error);
            }

            $cliente_id = $conectar->insert_id;

            // Insertar datos en la tabla "producto" relacionados al cliente
            $sql_producto = "INSERT INTO producto (tip_produ, descripcion, cantidad, precio, cliente_id)
                            VALUES ('$tip_produ', '$descripcion', $cantidad, $precio, $cliente_id)";

            if ($conectar->query($sql_producto) !== TRUE) {
                throw new Exception("Error en el registro del producto: " . $conectar->error);
            }

            // Confirmar la transacción
            $conectar->commit();

            echo "Registro de cliente y producto exitoso<br>";
        } catch (Exception $e) {
            // Si hay un error, revertir la transacción
            $conectar->rollback();
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Por favor, complete todos los campos antes de enviar.";
    }
}

// Cerrar la conexión
$conectar->close();
?>