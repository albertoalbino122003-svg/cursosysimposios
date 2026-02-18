<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['user_id'])) {
  header("Location: login.html");
  exit;
}

$user_id = intval($_SESSION['user_id']);

$sql = "
SELECT 
  i.id AS inscripcion_id,
  i.estado,
  i.asistencia_zoom,
  i.examen_diagnostico,
  i.encuesta_satisfaccion,
  c.id AS curso_id,
  c.titulo,
  c.tipo,
  c.imagen
FROM inscripciones i
INNER JOIN cursos c ON i.curso_id = c.id
WHERE i.usuario_id = ?
ORDER BY i.fecha_inscripcion DESC
";

$stmt = $conex->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$activos = 0;
$completados = 0;

$cursos = [];
while ($row = $result->fetch_assoc()) {
  $cursos[] = $row;
  if ($row['estado'] == "ACTIVO") $activos++;
  if ($row['estado'] == "COMPLETADO") $completados++;
}

$nombre_usuario = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : "Usuario";
?>

<!doctype html>
<html class="light" lang="es">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Mis Cursos - HRAEI 2026</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&amp;family=Noto+Serif:wght@400;700&amp;display=swap"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
    rel="stylesheet" />

  <script>
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            primary: "#691c3d",
            secondary: "#C38D33",
            "background-light": "#F8F8F8",
            "background-dark": "#18181b",
            surface: "#ffffff",
          },
          fontFamily: {
            display: ["Noto Sans", "sans-serif"],
            serif: ["Noto Sans", "sans-serif"],
          },
          borderRadius: {
            DEFAULT: "0.25rem",
            lg: "0.5rem",
            xl: "0.75rem",
            full: "9999px",
          },
        },
      },
    };
  </script>

  <style>
    .material-symbols-outlined {
      font-variation-settings:
        "FILL" 0,
        "wght" 400,
        "GRAD" 0,
        "opsz" 24;
    }

    body {
      background-image: linear-gradient(rgba(255, 255, 255, 0.5), rgba(255, 255, 255, 0.5)), url('assets/imagenes/textura_blanca_1-100.jpg');
      background-size: cover;
      background-attachment: fixed;
    }

    header {
      background-color: #611232 !important;
    }

    footer {
      background-color: #611232 !important;
    }
  </style>
</head>

<body class="dark:bg-background-dark font-display text-[#191014] antialiased min-h-screen flex flex-col">
  <header class="sticky top-0 z-50 w-full bg-primary text-white shadow-md">
    <div class="max-w-[1280px] mx-auto px-4 md:px-8 h-16 md:h-20 flex items-center justify-between gap-4">
      <div class="flex items-center gap-4 shrink-0">
        <div class="flex items-center gap-2">
          <img src="assets/imagenes/logo_HRAEI.png" alt="Logo HRAEI" class="h-12 w-auto" />
        </div>
      </div>

      <div class="hidden md:flex flex-1 max-w-md mx-8">
        <div class="relative w-full group">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-white/60">
            <span class="material-symbols-outlined text-[20px]">search</span>
          </div>
          <input
            class="block w-full pl-10 pr-3 py-2 border-none rounded-lg leading-5 bg-white/10 text-white placeholder-white/60 focus:outline-none focus:bg-white/20 focus:ring-1 focus:ring-white/30 sm:text-sm transition-colors"
            placeholder="Buscar mis cursos..." type="text" />
        </div>
      </div>

      <div class="flex items-center gap-4 md:gap-6">
        <nav class="hidden lg:flex items-center gap-6 text-sm font-medium text-white/90">
          <a class="hover:text-white transition-colors" href="Inicio.php">Inicio</a>
          <a class="text-white border-b-2 border-secondary pb-1" href="mis_cursos.php">Mis Cursos</a>
        </nav>
        <div class="flex items-center gap-3 pl-4 border-l border-white/20">
          <div
            class="h-8 w-8 md:h-10 md:w-10 rounded-full bg-white/20 p-0.5 cursor-pointer ring-2 ring-transparent hover:ring-white/30 transition-all">
            <a href="perfil.php">
              <img alt="User Profile" class="h-full w-full rounded-full object-cover"
                src="assets/imagenes/doctor.jpg" />
            </a>
          </div>
        </div>
      </div>
    </div>
  </header>

  <main class="flex-grow">

    <nav class="bg-white dark:bg-zinc-900 border-b border-gray-200 dark:border-zinc-800 py-3 md:py-4">
      <div class="max-w-[1280px] mx-auto px-4 md:px-8">
        <ol class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
          <li>
            <a class="hover:text-primary transition-colors hover:underline" href="Inicio.php">Inicio</a>
          </li>
          <li><span class="text-gray-300">/</span></li>
          <li class="font-medium text-primary dark:text-white">Mis Cursos</li>
        </ol>
      </div>
    </nav>

    <section class="bg-white dark:bg-zinc-900 border-b border-gray-200 dark:border-zinc-800">
      <div class="max-w-[1280px] mx-auto px-4 md:px-8 py-8 md:py-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
          <div class="space-y-2">
            <h1 class="font-serif text-3xl md:text-4xl font-bold text-primary dark:text-white uppercase">
              Mi Panel de Cursos
            </h1>
            <p class="text-gray-500 dark:text-gray-400 max-w-2xl">
              Bienvenido de nuevo, <?php echo $nombre_usuario; ?>. Realiza un seguimiento
              detallado de tus actividades y evaluaciones.
            </p>
          </div>

          <div
            class="flex gap-4 md:gap-8 bg-gray-50 dark:bg-zinc-800/50 p-6 rounded-xl border border-gray-100 dark:border-zinc-700">
            <div class="text-center">
              <span class="block text-2xl font-bold text-primary dark:text-white"><?php echo $activos; ?></span>
              <span class="text-[10px] uppercase font-bold tracking-wider text-gray-400">Activos</span>
            </div>
            <div class="w-px bg-gray-200 dark:bg-zinc-700 h-10"></div>
            <div class="text-center">
              <span class="block text-2xl font-bold text-green-600"><?php echo $completados; ?></span>
              <span class="text-[10px] uppercase font-bold tracking-wider text-gray-400">Completados</span>
            </div>
          </div>

        </div>
      </div>
    </section>

    <div class="max-w-[1280px] mx-auto px-4 md:px-8 py-10 md:py-16">
      <div class="flex items-center justify-between mb-8">
        <h2 class="font-serif text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
          <span class="material-symbols-outlined text-secondary">dashboard_customize</span>
          Seguimiento de Progreso
        </h2>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <?php if (count($cursos) == 0) { ?>
          <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-gray-200 dark:border-zinc-700 p-10 text-center">
            <span class="material-symbols-outlined text-secondary text-5xl mb-4">school</span>
            <h3 class="font-serif text-xl font-bold text-gray-900 dark:text-white mb-2">
              Aún no estás inscrito en ningún curso
            </h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">
              Inscríbete en un curso disponible desde el apartado Inicio.
            </p>
            <a href="Inicio.php"
              class="inline-block bg-primary hover:bg-[#5a1632] text-white font-bold py-3 px-6 rounded-lg shadow-sm transition-colors">
              Ver Cursos Disponibles
            </a>
          </div>
        <?php } ?>

        <?php foreach ($cursos as $curso) { ?>
          <div
            class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-gray-200 dark:border-zinc-700 overflow-hidden flex flex-col md:flex-row group transition-all duration-300">
            <div class="relative w-full md:w-48 h-48 md:h-auto overflow-hidden shrink-0">
              <img alt="<?php echo $curso['titulo']; ?>"
                class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500"
                src="<?php echo $curso['imagen']; ?>" />

              <div class="absolute top-3 left-3">
                <span
                  class="bg-secondary text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm uppercase tracking-wider">
                  <?php echo $curso['tipo']; ?>
                </span>
              </div>
            </div>

            <div class="p-6 flex flex-col flex-grow">
              <h3 class="font-serif text-lg font-bold text-gray-900 dark:text-white mb-4 line-clamp-2 leading-tight">
                <?php echo $curso['titulo']; ?>
              </h3>

              <div class="space-y-3 mb-6 bg-gray-50 dark:bg-zinc-900/50 p-4 rounded-lg">

                <div class="flex items-center justify-between text-sm">
                  <span class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                    <span class="material-symbols-outlined text-[18px]">videocam</span>
                    Asistencia Zoom
                  </span>
                  <?php if ($curso['asistencia_zoom'] == 1) { ?>
                    <span class="material-symbols-outlined text-green-600">check_circle</span>
                  <?php } else { ?>
                    <span class="material-symbols-outlined text-gray-400">circle</span>
                  <?php } ?>
                </div>

                <div class="flex items-center justify-between text-sm">
                  <span class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                    <span class="material-symbols-outlined text-[18px]">quiz</span>
                    Exámenes diagnósticos
                  </span>
                  <?php if ($curso['examen_diagnostico'] == 1) { ?>
                    <span class="material-symbols-outlined text-green-600">check_circle</span>
                  <?php } else { ?>
                    <span class="material-symbols-outlined text-gray-400">circle</span>
                  <?php } ?>
                </div>

                <div class="flex items-center justify-between text-sm">
                  <span class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                    <span class="material-symbols-outlined text-[18px]">rate_review</span>
                    Encuesta satisfacción
                  </span>
                  <?php if ($curso['encuesta_satisfaccion'] == 1) { ?>
                    <span class="material-symbols-outlined text-green-600">check_circle</span>
                  <?php } else { ?>
                    <span class="material-symbols-outlined text-amber-500">pending</span>
                  <?php } ?>
                </div>

              </div>

              <div class="mt-auto grid grid-cols-1 sm:grid-cols-2 gap-3">
                <button onclick="window.location.href='Inscripcion.php?id=<?php echo $curso['curso_id']; ?>'"
                  class="w-full bg-primary hover:bg-[#5a1632] text-white font-bold py-2.5 px-4 rounded-lg shadow-sm transition-colors flex items-center justify-center gap-2 text-sm">
                  <span class="material-symbols-outlined text-[18px]">login</span>
                  Entrar al Curso
                </button>

                <button onclick="window.location.href='progreso.php?curso_id=<?php echo $curso['curso_id']; ?>'"
                  class="w-full bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-600 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-zinc-700 font-bold py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center gap-2 text-sm">
                  <span class="material-symbols-outlined text-[18px]">analytics</span>
                  Consultar mi progreso
                </button>
              </div>

            </div>
          </div>
        <?php } ?>

      </div>

    </div>
  </main>

  <footer class="bg-primary text-white/90 pt-16 pb-8 border-t-4 border-secondary">
    <div class="max-w-[1280px] mx-auto px-4 md:px-8">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
        <div>
          <h4 class="font-bold text-white mb-4">Redes Sociales</h4>
          <ul class="space-y-2 text-sm text-white/70">
            <li>
              <a href="https://www.facebook.com/share/14VLkV9scHQ/?mibextid=wwXIfr" target="_blank"
                class="hover:text-white hover:underline decoration-secondary underline-offset-4">Facebook</a>
            </li>
            <li>
              <a href="https://www.instagram.com/hrae.ixtapaluca?igsh=Z3Ryd3VqbmQ2eWdm" target="_blank"
                class="hover:text-white hover:underline decoration-secondary underline-offset-4">Instagram</a>
            </li>
            <li>
              <a href="https://x.com/HRAEIxtapaluca?t=v-f7qiSr3yUbD7wdf7V0wA&s=08" target="_blank"
                class="hover:text-white hover:underline decoration-secondary underline-offset-4">Twitter</a>
            </li>
            <li>
              <a href="https://www.youtube.com/@hraeixtapaluca3460" target="_blank"
                class="hover:text-white hover:underline decoration-secondary underline-offset-4">Youtube</a>
            </li>
          </ul>
        </div>

        <div>
          <h4 class="font-bold text-white mb-4">Institucional</h4>
          <ul class="space-y-2 text-sm text-white/70">
            <li>
              <a class="hover:text-white hover:underline decoration-secondary underline-offset-4" href="#">Sobre Nosotros</a>
            </li>
            <li>
              <a class="hover:text-white hover:underline decoration-secondary underline-offset-4" href="#">Directorio</a>
            </li>
          </ul>
        </div>

        <div>
          <h4 class="font-bold text-white mb-4">Contacto</h4>
          <div class="flex flex-col gap-3 text-sm text-white/70">
            <div class="flex items-start gap-2">
              <span class="material-symbols-outlined text-[18px] mt-0.5">location_on</span>
              <span>Carretera Federal México-Puebla Km 34.5, Ixtapaluca, Edo. Méx.</span>
            </div>
            <div class="flex items-center gap-2">
              <span class="material-symbols-outlined text-[18px]">call</span>
              <span>(55) 5972 9800 ext. 1215</span>
            </div>
            <div class="flex items-center gap-2">
              <span class="material-symbols-outlined text-[18px]">mail</span>
              <span>acarino@hraei.gob.mx</span>
            </div>
          </div>
        </div>

      </div>

      <div
        class="pt-8 border-t border-white/10 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-white/50">
        <p>
          © 2026 Hospital Regional de Alta Especialidad de Ixtapaluca. Todos los derechos reservados.
        </p>
        <div class="flex gap-4">
          <a class="hover:text-white" href="#">Aviso de Privacidad</a>
          <a class="hover:text-white" href="#">Términos y Condiciones</a>
        </div>
      </div>
    </div>
  </footer>
</body>

</html>
