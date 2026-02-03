<?php
header('Content-Type: application/json');
include 'conexion.php';

// Obtener datos del JSON enviado por JS
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "No se recibieron datos."]);
    exit;
}

// Verificar si el correo ya existe
$checkEmail = $conex->prepare("SELECT id FROM usuarios WHERE correo = ?");
$checkEmail->bind_param("s", $data['correo']);
$checkEmail->execute();
$checkEmail->store_result();

if ($checkEmail->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Este correo ya está registrado."]);
    exit;
}

// Encriptar contraseña
$passwordHash = password_hash($data['contrasena'], PASSWORD_BCRYPT);

// Preparar la inserción
$stmt = $conex->prepare("INSERT INTO usuarios (nombre, apellido_paterno, apellido_materno, correo, telefono, estado, fecha_nacimiento, genero, tiene_discapacidad, desc_discapacidad, es_indigena, lengua_indigena, password, institucion, especialidad, nivel_academico, es_trabajador, num_empleado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("ssssssssssssssssss", 
    $data['nombre'], 
    $data['apellidoPaterno'], 
    $data['apellidoMaterno'], 
    $data['correo'], 
    $data['telefono'], 
    $data['estado'], 
    $data['fechaNacimiento'], 
    $data['genero'], 
    $data['discapacidad'], 
    $data['descDiscapacidad'], 
    $data['indigena'], 
    $data['lenguaIndigena'], 
    $passwordHash, 
    $data['institucion'], 
    $data['especialidad'], 
    $data['nivelAcademico'], 
    $data['trabajador'], 
    $data['numEmpleado']
);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Cuenta creada exitosamente."]);
} else {
    echo json_encode(["success" => false, "message" => "Error al registrar en BD: " . $stmt->error]);
}

$stmt->close();
$conex->close();
?>