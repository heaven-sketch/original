<?php
// Habilitar errores visibles en pantalla (solo para pruebas)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexión con la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "ventadematesinstantaneos";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
}

// Verificar que los datos se recibieron
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre           = $_POST['nombre'];
    $numerodecontacto = $_POST['numerodecontacto'];
    $direccion        = $_POST['direccion'];
    $producto         = $_POST['producto'];
    $presentacion     = $_POST['presentacion'];
    $notas            = $_POST['notas'];

    // Preparar la consulta
    $sql = "INSERT INTO pedidos (nombre, numerodecontacto, direccion, producto, presentacion, notas)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("❌ Error al preparar la consulta: " . $conn->error);
    }

    $stmt->bind_param("ssssss", $nombre, $numerodecontacto, $direccion, $producto, $presentacion, $notas);

    if ($stmt->execute()) {
        echo "<h2>✅ Pedido enviado correctamente.</h2>";
        echo "<a href='pideahora.html'>Volver al formulario</a>";
    } else {
        echo "❌ Error al guardar el pedido: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "⚠ No se recibió ningún dato.";
}

$conn->close();
?>