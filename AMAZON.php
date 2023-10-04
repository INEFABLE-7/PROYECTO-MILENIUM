<?php
// Código para la conexión a la base de datos (código original)
$server = "localhost";
$user = "tu_usuario";
$pass = "tu_contraseña";
$db = "nombre_de_tu_base_de_datos";

// Intentar establecer la conexión
$conectar = new mysqli($server, $user, $pass, $db);

if ($conectar->connect_error) {
    die("Conexión fallida: " . $conectar->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cliente'])) {
        // Datos del cliente
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $DNI = $_POST['DNI'];
        $telefono = $_POST['telefono'];
        $fecha = $_POST['Fecha'];

        if (!empty($nombre) && !empty($apellido) && !empty($DNI) && !empty($telefono) && !empty($fecha)) {
            // Procesar los datos del cliente (código original)
            $nombre_empresa = "AMAZON";

            $conectar->begin_transaction();

            try {
                // Consulta para obtener el ID de la empresa (código original)

                // Insertar datos en la tabla "cliente" (código original)

                $conectar->commit();

                echo "Datos del cliente ingresados correctamente.";

            } catch (Exception $e) {
                $conectar->rollback();
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Por favor, complete todos los campos del cliente antes de enviar.";
        }
    } elseif (isset($_POST['producto'])) {
        // Datos del producto
        $tip_produ = $_POST['tip_produ'];
        $descripcion = $_POST['descripcion'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];

        if (!empty($tip_produ) && !empty($descripcion) && !empty($cantidad) && !empty($precio)) {
            // Procesar los datos del producto (código original)
            $conectar->begin_transaction();

            try {
                // Insertar datos en la tabla "producto" relacionada con el cliente (código original)

                $conectar->commit();

                echo "Datos del producto ingresados correctamente.";

            } catch (Exception $e) {
                $conectar->rollback();
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Por favor, complete todos los campos del producto antes de enviar.";
        }
    }
    // Close the connection

    $conectar->close();
}
?>
