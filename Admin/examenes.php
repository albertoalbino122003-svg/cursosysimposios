<?php
include("validar_sesion.php");
include("../conexion.php");

$modulos = $conex->query("
SELECT m.id, m.nombre_modulo, c.titulo AS curso
FROM modulos m
INNER JOIN cursos c ON c.id = m.curso_id
ORDER BY c.titulo ASC
");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $modulo_id = $_POST['modulo_id'];
    $titulo = $_POST['titulo'];

    $archivo_nombre = $_FILES['archivo']['name'];
    $archivo_tmp = $_FILES['archivo']['tmp_name'];

    $ruta = "../uploads/examenes/" . time() . "_" . $archivo_nombre;
    $ruta_bd = "uploads/examenes/" . time() . "_" . $archivo_nombre;

    move_uploaded_file($archivo_tmp, $ruta);

    $stmt = $conex->prepare("INSERT INTO examenes (modulo_id, titulo, archivo_pdf) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $modulo_id, $titulo, $ruta_bd);

    if ($stmt->execute()) {
        echo "<script>alert('Examen subido correctamente'); window.location='examenes.php';</script>";
    }
}

$lista = $conex->query("
SELECT e.*, m.nombre_modulo, c.titulo AS curso
FROM examenes e
INNER JOIN modulos m ON m.id = e.modulo_id
INNER JOIN cursos c ON c.id = m.curso_id
ORDER BY e.id DESC
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Exámenes</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

<div class="header">
    <div class="logo-area">
        <div class="logo-box">LOGO</div>
        <div><strong>Gestión de Exámenes</strong></div>
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
    <h1>Exámenes</h1>

    <div class="card">
        <h2>Subir Examen (PDF)</h2>

        <form method="POST" enctype="multipart/form-data">
            <label>Módulo:</label>
            <select name="modulo_id" required>
                <?php while($m = $modulos->fetch_assoc()): ?>
                    <option value="<?php echo $m['id']; ?>">
                        <?php echo $m['curso'] . " - " . $m['nombre_modulo']; ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label>Título del examen:</label>
            <input type="text" name="titulo" required>

            <label>Archivo PDF:</label>
            <input type="file" name="archivo" accept="application/pdf" required>

            <button class="btn" type="submit">Subir examen</button>
        </form>
    </div>

    <div class="card">
        <h2>Lista de Exámenes</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Curso</th>
                <th>Módulo</th>
                <th>Título</th>
                <th>Archivo</th>
            </tr>

            <?php while($row = $lista->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['curso']; ?></td>
                <td><?php echo $row['nombre_modulo']; ?></td>
                <td><?php echo $row['titulo']; ?></td>
                <td><a href="../<?php echo $row['archivo_pdf']; ?>" target="_blank">Ver PDF</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

</body>
</html>
