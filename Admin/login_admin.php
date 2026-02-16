<?php
session_start();
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Administrador</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body style="display:flex; justify-content:center; align-items:center; height:100vh;">

<div class="card" style="width:420px;">
    <div style="text-align:center; margin-bottom:15px;">
        <div style="display:flex; justify-content:center; gap:15px;">
            <div class="logo-box">LOGO 1</div>
            <div class="logo-box">LOGO 2</div>
        </div>
        <h2 style="margin-top:15px;">Panel Administrador</h2>
        <p style="color:#444;">Cursos y Simposios HRAEI</p>
    </div>

    <form action="procesar_login_admin.php" method="POST">
        <label>Correo:</label>
        <input type="email" name="correo" required>

        <label>Contraseña:</label>
        <input type="password" name="password" required>

        <button type="submit" class="btn" style="width:100%;">Ingresar</button>
    </form>
</div>

</body>
</html>
