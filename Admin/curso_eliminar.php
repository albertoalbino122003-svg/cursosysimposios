<?php
include("validar_sesion.php");
include("../conexion.php");

$id = $_GET['id'];

$conex->query("DELETE FROM cursos WHERE id=$id");

header("Location: cursos.php");
exit;
