<?php
include("validar_sesion.php");
include("../conexion.php");

$cursos = $conex->query("SELECT id, titulo FROM cursos ORDER BY titulo ASC");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $curso_id = $_POST['curso_id'];
    $titulo = $_POST['titulo'];
    $link_encuesta = $_POST['link_encuesta'];

    $stmt = $conex->prepare("INSERT INTO encuestas (curso_id, titulo, link_encuesta) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $curso_id, $titulo, $link_encuesta);

    if ($stmt->execute()) {
        echo "<script>alert('Encuesta agregada'); window.location='encuestas.php';</script>";
    }
}

$lista = $conex->query("
SELECT e.*, c.titulo AS curso
FROM encuestas e
INNER JOIN cursos c ON c.id = e.curso_id
ORDER BY e.id DESC
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Encuestas</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

<div class="header">
    <div class="logo-area">
        <div class="logo-box">LOGO</div>
        <div><strong>Gestión de Encuestas</strong></div>
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
    <h1>Encuestas</h1>

    <div class="card">
        <h2>Agregar Encuesta</h2>

        <form method="POST">
            <label>Curso:</label>
            <select name="curso_id" required>
                <?php while($c = $cursos->fetch_assoc()): ?>
                    <option value="<?php echo $c['id']; ?>"><?php echo $c['titulo']; ?></option>
                <?php endwhile; ?>
            </select>

            <label>Título encuesta:</label>
            <input type="text" name="titulo" required>

            <label>Link encuesta (Google Forms o similar):</label>
            <input type="text" name="link_encuesta" required>

            <button class="btn" type="submit">Guardar encuesta</button>
        </form>
    </div>

    <div class="card">
        <h2>Lista de Encuestas</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Curso</th>
                <th>Título</th>
                <th>Link</th>
            </tr>

            <?php while($row = $lista->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['curso']; ?></td>
                <td><?php echo $row['titulo']; ?></td>
                <td><a href="<?php echo $row['link_encuesta']; ?>" target="_blank">Abrir Encuesta</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

</body>
</html>
