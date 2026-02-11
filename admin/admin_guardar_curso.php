<?php
include "admin_proteger.php";
include "../conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $tipo = $_POST['tipo'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $objetivos = $_POST['objetivos'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];
    $total_horas = $_POST['total_horas'];
    $doctor_principal = $_POST['doctor_principal'];
    $doctores_secundarios = $_POST['doctores_secundarios'];
    $disponible = $_POST['disponible'];

    if ($total_horas < 20) {
        die("Error: el curso debe tener mínimo 20 horas.");
    }

    // Carpeta donde se guardan imágenes
    $carpeta = "../uploads/cursos/";

    if (!is_dir($carpeta)) {
        mkdir($carpeta, 0777, true);
    }

    $nombreImagen = time() . "_" . basename($_FILES["imagen"]["name"]);
    $rutaFinal = $carpeta . $nombreImagen;

    if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaFinal)) {
        die("Error al subir imagen.");
    }

    // Guardar solo la ruta relativa
    $rutaBD = "uploads/cursos/" . $nombreImagen;

    $stmt = $conex->prepare("INSERT INTO cursos 
    (tipo, titulo, descripcion, objetivos, imagen, fecha_inicio, fecha_fin, hora_inicio, hora_fin, total_horas, doctor_principal, doctores_secundarios, disponible)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssssssisss",
        $tipo,
        $titulo,
        $descripcion,
        $objetivos,
        $rutaBD,
        $fecha_inicio,
        $fecha_fin,
        $hora_inicio,
        $hora_fin,
        $total_horas,
        $doctor_principal,
        $doctores_secundarios,
        $disponible
    );

    if ($stmt->execute()) {
        header("Location: admin_panel.php");
        exit;
    } else {
        echo "Error al guardar: " . $stmt->error;
    }

    $stmt->close();
    $conex->close();
}
?>
