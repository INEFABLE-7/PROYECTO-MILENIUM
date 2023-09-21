<?php
require_once('C:/xampp/htdocs/AMAZON/LIBRARY/tcpdf.php');

// Define la constante PDF_CREATOR antes de su uso
define('PDF_CREATOR', 'INEFABLE-7');

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
            $nombre_empresa = "AMAZON";

            // Consulta para obtener el ID de la empresa
            $sql_obtener_empresa = "SELECT id_empresa FROM empresa WHERE nombre = '$nombre_empresa'";
            $resultado_empresa = $conectar->query($sql_obtener_empresa);

            if ($resultado_empresa->num_rows > 0) {
                $fila_empresa = $resultado_empresa->fetch_assoc();
                $empresa_id = $fila_empresa['id_empresa'];
            } else {
                // Si no se encontró la empresa, puedes insertarla aquí
                $sql_insertar_empresa = "INSERT INTO empresa (nombre) VALUES ('$nombre_empresa')";
                if ($conectar->query($sql_insertar_empresa) !== TRUE) {
                    throw new Exception("Error al insertar la empresa: " . $conectar->error);
                }
                $empresa_id = $conectar->insert_id; // Obtener el ID de la empresa recién insertada
            }

            // Insertar datos en la tabla "cliente"
            $sql_cliente = "INSERT INTO cliente (nombre, apellido, DNI, telefono, fecha, FK_EMPRESA_ENLACE)
                            VALUES ('$nombre', '$apellido', '$DNI', '$telefono', '$fecha', $empresa_id)";

            if ($conectar->query($sql_cliente) !== TRUE) {
                throw new Exception("Error en el registro del cliente: " . $conectar->error);
            }

            $cliente_id = $conectar->insert_id; // Obtener el ID del cliente

            // Insertar datos en la tabla "producto" relacionados al cliente
            $sql_producto = "INSERT INTO producto (tip_produ, descripcion, cantidad, precio, FK_CLIENTE_ENLACE)
                            VALUES ('$tip_produ', '$descripcion', $cantidad, $precio, $cliente_id)";

            if ($conectar->query($sql_producto) !== TRUE) {
                throw new Exception("Error en el registro del producto: " . $conectar->error);
            }else {
        echo "Por favor, complete todos los campos antes de enviar.";
    }


// Cerrar la conexión
$conectar->close();
?>
