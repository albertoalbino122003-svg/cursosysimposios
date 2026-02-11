<?php
include "admin_proteger.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Administrador</title>

  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

  <style>
    body{
      margin:0;
      font-family:'Noto Sans', sans-serif;
      background:#f4f4f4;
    }

    header{
      background:#611232;
      color:white;
      padding:15px 25px;
      display:flex;
      justify-content:space-between;
      align-items:center;
    }

    header h1{
      font-size:18px;
      margin:0;
    }

    .logos{
      display:flex;
      gap:10px;
      align-items:center;
    }

    .logo-placeholder{
      width:70px;
      height:50px;
      border:2px dashed #a57f2c;
      border-radius:10px;
      display:flex;
      justify-content:center;
      align-items:center;
      font-size:11px;
      font-weight:700;
      color:#fff;
    }

    .btn-logout{
      background:#a57f2c;
      padding:10px 14px;
      border-radius:10px;
      text-decoration:none;
      font-weight:700;
      color:#002f2a;
    }

    .container{
      padding:25px;
      max-width:1100px;
      margin:auto;
    }

    .card{
      background:white;
      padding:25px;
      border-radius:18px;
      box-shadow:0px 8px 20px rgba(0,0,0,0.1);
    }

    h2{
      color:#611232;
      margin-top:0;
    }

    label{
      font-weight:700;
      color:#002f2a;
      display:block;
      margin-top:12px;
    }

    input, textarea, select{
      width:100%;
      padding:10px;
      margin-top:6px;
      border-radius:10px;
      border:1px solid #ccc;
      font-size:14px;
      outline:none;
    }

    textarea{
      height:90px;
      resize:none;
    }

    button{
      margin-top:18px;
      padding:12px;
      width:100%;
      background:#611232;
      color:white;
      border:none;
      border-radius:10px;
      font-size:16px;
      font-weight:700;
      cursor:pointer;
    }

    button:hover{
      background:#002f2a;
    }

    .msg{
      margin-top:15px;
      font-weight:700;
      color:green;
    }

    .error{
      color:red;
    }
  </style>
</head>

<body>

<header>
  <div>
    <h1>Panel Administrador - Bienvenido <?php echo $_SESSION['admin_nombre']; ?></h1>
  </div>

  <div class="logos">
    <div class="logo-placeholder">LOGO 1</div>
    <div class="logo-placeholder">LOGO 2</div>
    <a class="btn-logout" href="admin_logout.php">Salir</a>
  </div>
</header>

<div class="container">

  <div class="card">
    <h2>Registrar Curso / Simposio</h2>

    <form action="admin_guardar_curso.php" method="POST" enctype="multipart/form-data">

      <label>Tipo</label>
      <select name="tipo" required>
        <option value="CURSO">CURSO</option>
        <option value="SIMPOSIO">SIMPOSIO</option>
      </select>

      <label>Título</label>
      <input type="text" name="titulo" required>

      <label>Descripción</label>
      <textarea name="descripcion" required></textarea>

      <label>Objetivos</label>
      <textarea name="objetivos" required></textarea>

      <label>Imagen alusiva (JPG/PNG)</label>
      <input type="file" name="imagen" accept="image/*" required>

      <label>Fecha inicio</label>
      <input type="date" name="fecha_inicio" required>

      <label>Fecha fin</label>
      <input type="date" name="fecha_fin" required>

      <label>Hora inicio</label>
      <input type="time" name="hora_inicio" required>

      <label>Hora fin</label>
      <input type="time" name="hora_fin" required>

      <label>Total de horas (mínimo 20)</label>
      <input type="number" name="total_horas" min="20" required>

      <label>Doctor principal</label>
      <input type="text" name="doctor_principal" required>

      <label>Doctores secundarios</label>
      <textarea name="doctores_secundarios"></textarea>

      <label>Disponible</label>
      <select name="disponible">
        <option value="SI">SI</option>
        <option value="NO">NO</option>
      </select>

      <button type="submit">Guardar Curso / Simposio</button>

    </form>
  </div>

</div>

</body>
</html>
