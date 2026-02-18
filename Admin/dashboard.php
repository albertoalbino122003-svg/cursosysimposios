<?php
include("validar_sesion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

<div class="header">
    <div class="logo-area">
        <div class="logo-box">LOGO</div>
        <div>
            <strong>Panel Administrador</strong><br>
            Cursos y Simposios HRAEI
        </div>
    </div>
    <div>
        Bienvenido: <b><?php echo $_SESSION['admin_nombre']; ?></b>
    </div>
</div>

<div class="sidebar">
    <a href="dashboard.php">🏠 Inicio</a>
    <a href="cursos.php">📚 Cursos / Simposios</a>
    <a href="modulos.php">📌 Módulos</a>
    <a href="examenes.php">📝 Exámenes</a>
    <a href="encuestas.php">📋 Encuestas</a>
    <a href="logout.php">🚪 Cerrar sesión</a>
</div>

<div class="content">
    <h1>Dashboard</h1>

    <div class="card">
        <h2>Bienvenido al sistema</h2>
        <p>Desde aquí podrás administrar cursos, módulos, exámenes y encuestas.</p>
    </div>
</div>

</body>
</html>
