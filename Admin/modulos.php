<?php
include("validar_sesion.php");
include("../conexion.php");

$cursos = $conex->query("SELECT id, titulo FROM cursos ORDER BY titulo ASC");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $curso_id = $_POST['curso_id'];
    $nombre_modulo = $_POST['nombre_modulo'];
    $descripcion_modulo = $_POST['descripcion_modulo'];
    $fecha = $_POST['fecha'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];
    $link_zoom = $_POST['link_zoom'];

    $stmt = $conex->prepare("INSERT INTO modulos (curso_id, nombre_modulo, descripcion_modulo, fecha, hora_inicio, hora_fin, link_zoom)
    VALUES (?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("issssss", $curso_id, $nombre_modulo, $descripcion_modulo, $fecha, $hora_inicio, $hora_fin, $link_zoom);

    if ($stmt->execute()) {
        echo "<script>alert('Módulo agregado'); window.location='modulos.php';</script>";
    }
}

$lista = $conex->query("
SELECT m.*, c.titulo AS curso_titulo
FROM modulos m
INNER JOIN cursos c ON c.id = m.curso_id
ORDER BY m.fecha DESC
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulos</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

<div class="header">
    <div class="logo-area">
        <div class="logo-box">LOGO</div>
        <div><strong>Gestión de Módulos</strong></div>
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
    <h1>Módulos</h1>

    <div class="card">
        <h2>Agregar Módulo</h2>

        <form method="POST">
            <label>Curso:</label>
            <select name="curso_id" required>
                <?php while($c = $cursos->fetch_assoc()): ?>
                    <option value="<?php echo $c['id']; ?>"><?php echo $c['titulo']; ?></option>
                <?php endwhile; ?>
            </select>

            <label>Nombre del módulo:</label>
            <input type="text" name="nombre_modulo" required>

            <label>Descripción:</label>
            <textarea name="descripcion_modulo"></textarea>

            <label>Fecha:</label>
            <input type="date" name="fecha" required>

            <label>Hora inicio:</label>
            <input type="time" name="hora_inicio" required>

            <label>Hora fin:</label>
            <input type="time" name="hora_fin" required>

            <label>Link Zoom:</label>
            <input type="text" name="link_zoom">

            <button class="btn" type="submit">Guardar módulo</button>
        </form>
    </div>

    <div class="card">
        <h2>Lista de Módulos</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Curso</th>
                <th>Módulo</th>
                <th>Fecha</th>
                <th>Zoom</th>
            </tr>

            <?php while($row = $lista->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['curso_titulo']; ?></td>
                <td><?php echo $row['nombre_modulo']; ?></td>
                <td><?php echo $row['fecha']; ?></td>
                <td>
                    <?php if(!empty($row['link_zoom'])): ?>
                        <a href="<?php echo $row['link_zoom']; ?>" target="_blank">Abrir Zoom</a>
                    <?php else: ?>
                        Sin link
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

</div>

</body>
</html>
