<?php
session_start();
include("../conexion.php");

$correo = $_POST['correo'];
$password = $_POST['password'];

$stmt = $conex->prepare("SELECT id, nombre, password FROM admins WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    if (password_verify($password, $row['password'])) {
        $_SESSION['admin_id'] = $row['id'];
        $_SESSION['admin_nombre'] = $row['nombre'];

        header("Location: dashboard.php");
        exit;
    } else {
        echo "<script>alert('Contraseña incorrecta'); window.location='login_admin.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Administrador no encontrado'); window.location='login_admin.php';</script>";
    exit;
}
