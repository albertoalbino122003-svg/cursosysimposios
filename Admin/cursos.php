<?php
include("validar_sesion.php");
include("../conexion.php");

$result = $conex->query("SELECT * FROM cursos ORDER BY fecha_inicio DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión Cursos</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

<div class="header">
    <div class="logo-area">
        <div class="logo-box">LOGO</div>
        <div>
            <strong>Panel Administrador</strong><br>
            Gestión de Cursos
        </div>
    </div>
</div>

<div class="sidebar">
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="cursos.php">📚 Cursos / Simposios</a>
    <a href="modulos.php">📌 Módulos</a>
    <a href="examenes.php">📝 Exámenes</a>
    <a href="encuestas.php">📋 Encuestas</a>
    <a href="logout.php">🚪 Cerrar sesión</a>
</div>

<div class="content">
    <h1>Cursos / Simposios</h1>

    <a class="btn" href="curso_nuevo.php">➕ Agregar Nuevo</a>

    <br><br>

    <table>
        <tr>
            <th>ID</th>
            <th>Tipo</th>
            <th>Título</th>
            <th>Horas</th>
            <th>Disponible</th>
            <th>Acciones</th>
        </tr>

        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['tipo']; ?></td>
            <td><?php echo $row['titulo']; ?></td>
            <td><?php echo $row['total_horas']; ?></td>
            <td><?php echo $row['disponible']; ?></td>
            <td>
                <a class="btn" href="curso_editar.php?id=<?php echo $row['id']; ?>">✏️ Editar</a>
                <a class="btn btn-danger" href="curso_eliminar.php?id=<?php echo $row['id']; ?>" onclick="return confirm('¿Eliminar este curso?')">🗑 Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
