<?php
session_start();
header('Content-Type: application/json');
include "../conexion.php";

$data = json_decode(file_get_contents("php://input"), true);

$correo = $data['correo'] ?? '';
$password = $data['password'] ?? '';

$stmt = $conex->prepare("SELECT id, nombre, password, rol, activo FROM administradores WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    if ($row['activo'] == 0) {
        echo json_encode(["success" => false, "message" => "Este administrador está desactivado."]);
        exit;
    }

    if (password_verify($password, $row['password'])) {
        $_SESSION['admin_id'] = $row['id'];
        $_SESSION['admin_nombre'] = $row['nombre'];
        $_SESSION['admin_rol'] = $row['rol'];

        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Contraseña incorrecta."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Administrador no encontrado."]);
}

$stmt->close();
$conex->close();
?>
