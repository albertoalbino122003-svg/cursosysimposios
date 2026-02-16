<?php
include("validar_sesion.php");
include("../conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $tipo = $_POST['tipo'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $objetivos = $_POST['objetivos'];
    $doctor_principal = $_POST['doctor_principal'];
    $doctores_secundarios = $_POST['doctores_secundarios'];
    $total_horas = $_POST['total_horas'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];
    $disponible = $_POST['disponible'];

    if ($total_horas < 20) {
        echo "<script>alert('El curso debe tener mínimo 20 horas');</script>";
    } else {

        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_tmp = $_FILES['imagen']['tmp_name'];

        $ruta = "../uploads/cursos/" . time() . "_" . $imagen_nombre;
        $ruta_bd = "uploads/cursos/" . time() . "_" . $imagen_nombre;

        move_uploaded_file($imagen_tmp, $ruta);

        $stmt = $conex->prepare("INSERT INTO cursos 
        (tipo, titulo, descripcion, objetivos, doctor_principal, doctores_secundarios, total_horas, fecha_inicio, fecha_fin, hora_inicio, hora_fin, imagen, disponible) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("ssssssissssss",
            $tipo, $titulo, $descripcion, $objetivos,
            $doctor_principal, $doctores_secundarios,
            $total_horas, $fecha_inicio, $fecha_fin,
            $hora_inicio, $hora_fin, $ruta_bd, $disponible
        );

        if ($stmt->execute()) {
            echo "<script>alert('Curso agregado correctamente'); window.location='cursos.php';</script>";
        } else {
            echo "<script>alert('Error al guardar');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Curso</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

<div class="header">
    <div class="logo-area">
        <div class="logo-box">LOGO</div>
        <div>
            <strong>Agregar Curso / Simposio</strong>
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
    <h1>Nuevo Curso / Simposio</h1>

    <div class="card">
        <form method="POST" enctype="multipart/form-data">

            <label>Tipo:</label>
            <select name="tipo" required>
                <option value="CURSO">CURSO</option>
                <option value="SIMPOSIO">SIMPOSIO</option>
            </select>

            <label>Título:</label>
            <input type="text" name="titulo" required>

            <label>Descripción:</label>
            <textarea name="descripcion" required></textarea>

            <label>Objetivos:</label>
            <textarea name="objetivos" required></textarea>

            <label>Doctor principal:</label>
            <input type="text" name="doctor_principal" required>

            <label>Doctores secundarios:</label>
            <textarea name="doctores_secundarios"></textarea>

            <label>Total horas (mínimo 20):</label>
            <input type="number" name="total_horas" required>

            <label>Fecha inicio:</label>
            <input type="date" name="fecha_inicio" required>

            <label>Fecha fin:</label>
            <input type="date" name="fecha_fin" required>

            <label>Hora inicio:</label>
            <input type="time" name="hora_inicio" required>

            <label>Hora fin:</label>
            <input type="time" name="hora_fin" required>

            <label>Disponible:</label>
            <select name="disponible">
                <option value="SI">SI</option>
                <option value="NO">NO</option>
            </select>

            <label>Imagen:</label>
            <input type="file" name="imagen" accept="image/*" required>

            <button class="btn" type="submit">Guardar</button>
        </form>
    </div>
</div>

</body>
</html>
