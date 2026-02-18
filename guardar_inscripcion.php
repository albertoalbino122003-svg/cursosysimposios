<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['user_id'])) {
    die("Error: No has iniciado sesión.");
}

if (!isset($_GET['curso_id'])) {
    die("Error: No se recibió el curso.");
}

$usuario_id = intval($_SESSION['user_id']);
$curso_id = intval($_GET['curso_id']);

$check = $conex->prepare("SELECT id FROM inscripciones WHERE usuario_id = ? AND curso_id = ?");
$check->bind_param("ii", $usuario_id, $curso_id);
$check->execute();
$res = $check->get_result();

if ($res->num_rows > 0) {
    header("Location: mis_cursos.php");
    exit;
}

$stmt = $conex->prepare("INSERT INTO inscripciones (usuario_id, curso_id) VALUES (?, ?)");
$stmt->bind_param("ii", $usuario_id, $curso_id);

if ($stmt->execute()) {
    header("Location: mis_cursos.php");
    exit;
} else {
    echo "Error al inscribirse: " . $stmt->error;
}
