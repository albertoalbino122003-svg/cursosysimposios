<?php
include("validar_sesion.php");
include("../conexion.php");

$id = $_GET['id'];

$curso = $conex->query("SELECT * FROM cursos WHERE id=$id")->fetch_assoc();

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
        echo "<script>alert('Debe ser mínimo 20 horas');</script>";
    } else {

        if (!empty($_FILES['imagen']['name'])) {
            $imagen_nombre = $_FILES['imagen']['name'];
            $imagen_tmp = $_FILES['imagen']['tmp_name'];

            $ruta = "../uploads/cursos/" . time() . "_" . $imagen_nombre;
            $ruta_bd = "uploads/cursos/" . time() . "_" . $imagen_nombre;

            move_uploaded_file($imagen_tmp, $ruta);

            $stmt = $conex->prepare("UPDATE cursos SET tipo=?, titulo=?, descripcion=?, objetivos=?, doctor_principal=?, doctores_secundarios=?, total_horas=?, fecha_inicio=?, fecha_fin=?, hora_inicio=?, hora_fin=?, imagen=?, disponible=? WHERE id=?");
            $stmt->bind_param("ssssssissssssi",
                $tipo, $titulo, $descripcion, $objetivos,
                $doctor_principal, $doctores_secundarios,
                $total_horas, $fecha_inicio, $fecha_fin,
                $hora_inicio, $hora_fin, $ruta_bd, $disponible, $id
            );

        } else {
            $stmt = $conex->prepare("UPDATE cursos SET tipo=?, titulo=?, descripcion=?, objetivos=?, doctor_principal=?, doctores_secundarios=?, total_horas=?, fecha_inicio=?, fecha_fin=?, hora_inicio=?, hora_fin=?, disponible=? WHERE id=?");
            $stmt->bind_param("ssssssisssssi",
                $tipo, $titulo, $descripcion, $objetivos,
                $doctor_principal, $doctores_secundarios,
                $total_horas, $fecha_inicio, $fecha_fin,
                $hora_inicio, $hora_fin, $disponible, $id
            );
        }

        if ($stmt->execute()) {
            echo "<script>alert('Curso actualizado'); window.location='cursos.php';</script>";
        } else {
            echo "<script>alert('Error al actualizar');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Curso</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

<div class="header">
    <div class="logo-area">
        <div class="logo-box">LOGO</div>
        <div><strong>Editar Curso</strong></div>
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
    <h1>Editar Curso</h1>

    <div class="card">
        <form method="POST" enctype="multipart/form-data">

            <label>Tipo:</label>
            <select name="tipo">
                <option value="CURSO" <?php if($curso['tipo']=="CURSO") echo "selected"; ?>>CURSO</option>
                <option value="SIMPOSIO" <?php if($curso['tipo']=="SIMPOSIO") echo "selected"; ?>>SIMPOSIO</option>
            </select>

            <label>Título:</label>
            <input type="text" name="titulo" value="<?php echo $curso['titulo']; ?>" required>

            <label>Descripción:</label>
            <textarea name="descripcion" required><?php echo $curso['descripcion']; ?></textarea>

            <label>Objetivos:</label>
            <textarea name="objetivos" required><?php echo $curso['objetivos']; ?></textarea>

            <label>Doctor principal:</label>
            <input type="text" name="doctor_principal" value="<?php echo $curso['doctor_principal']; ?>" required>

            <label>Doctores secundarios:</label>
            <textarea name="doctores_secundarios"><?php echo $curso['doctores_secundarios']; ?></textarea>

            <label>Total horas:</label>
            <input type="number" name="total_horas" value="<?php echo $curso['total_horas']; ?>" required>

            <label>Fecha inicio:</label>
            <input type="date" name="fecha_inicio" value="<?php echo $curso['fecha_inicio']; ?>" required>

            <label>Fecha fin:</label>
            <input type="date" name="fecha_fin" value="<?php echo $curso['fecha_fin']; ?>" required>

            <label>Hora inicio:</label>
            <input type="time" name="hora_inicio" value="<?php echo $curso['hora_inicio']; ?>" required>

            <label>Hora fin:</label>
            <input type="time" name="hora_fin" value="<?php echo $curso['hora_fin']; ?>" required>

            <label>Disponible:</label>
            <select name="disponible">
                <option value="SI" <?php if($curso['disponible']=="SI") echo "selected"; ?>>SI</option>
                <option value="NO" <?php if($curso['disponible']=="NO") echo "selected"; ?>>NO</option>
            </select>

            <label>Imagen actual:</label><br>
            <img src="../<?php echo $curso['imagen']; ?>" style="width:180px; border-radius:10px;"><br><br>

            <label>Subir nueva imagen (opcional):</label>
            <input type="file" name="imagen" accept="image/*">

            <button class="btn" type="submit">Actualizar</button>
        </form>
    </div>
</div>

</body>
</html>
