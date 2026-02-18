<?php
include("conexion.php");

if (!isset($_GET['id'])) {
  die("Error: No se recibió el ID del curso.");
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM cursos WHERE id = $id";
$resultado = $conex->query($sql);

if ($resultado->num_rows == 0) {
  die("Error: Curso no encontrado.");
}

$curso = $resultado->fetch_assoc();
?>

<!doctype html>
<html class="light" lang="es">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Detalle del Curso - HRAEI 2026</title>
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
      background-image:
        linear-gradient(rgba(255, 255, 255, 0.5), rgba(255, 255, 255, 0.5)),
        url("assets/imagenes/textura_blanca_1-100.jpg");
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
      <!-- Logo Section -->
      <div class="flex items-center gap-4 shrink-0">
        <div class="flex items-center gap-2">
          <img src="assets/imagenes/logo_HRAEI.png" alt="Logo HRAEI" class="h-12 w-auto" />
        </div>
      </div>
      <!-- Search Bar (Hidden on Mobile) -->
      <div class="hidden md:flex flex-1 max-w-md mx-8">
        <div class="relative w-full group">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-white/60">
            <span class="material-symbols-outlined text-[20px]">search</span>
          </div>
          <input
            class="block w-full pl-10 pr-3 py-2 border-none rounded-lg leading-5 bg-white/10 text-white placeholder-white/60 focus:outline-none focus:bg-white/20 focus:ring-1 focus:ring-white/30 sm:text-sm transition-colors"
            placeholder="Buscar Cursos o Simposios" type="text" />
        </div>
      </div>
      <!-- Navigation & Profile -->
      <div class="flex items-center gap-4 md:gap-6">
        <nav class="hidden lg:flex items-center gap-6 text-sm font-medium text-white/90">
          <a class="hover:text-white transition-colors" href="Inicio.php">Inicio</a>
          <a class="hover:text-white transition-colors" href="mis_cursos.html">Mis Cursos</a>
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

    <section class="relative h-[420px] w-full overflow-hidden bg-gray-900">
      <div class="absolute inset-0 z-0">
        <img alt="Imagen del curso" class="h-full w-full object-cover opacity-60"
          src="<?php echo $curso['imagen']; ?>" />

        <div class="absolute inset-0 bg-gradient-to-r from-primary/95 via-primary/80 to-black/40 mix-blend-multiply">
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
      </div>

      <div class="relative z-10 h-full max-w-[1280px] mx-auto px-4 md:px-8 flex flex-col justify-end pb-12 text-white">
        <div class="max-w-3xl animate-fade-in-up">
          <div class="flex flex-wrap items-center gap-3 mb-4">

            <span
              class="bg-secondary text-white text-xs font-bold px-3 py-1 rounded shadow-sm uppercase tracking-wider">
              <?php echo $curso['tipo']; ?>
            </span>

            <span class="bg-green-600/90 text-white text-xs font-bold px-3 py-1 rounded shadow-sm flex items-center gap-1">
              <span class="material-symbols-outlined text-[14px]">check_circle</span>
              <?php echo ($curso['disponible'] == 'SI') ? "ABIERTO" : "CERRADO"; ?>
            </span>
          </div>

          <h1 class="font-serif text-3xl md:text-5xl lg:text-5xl font-bold leading-tight mb-4 drop-shadow-md">
            <?php echo $curso['titulo']; ?>
          </h1>

          <p class="text-lg md:text-xl text-white/90 font-light mb-0 max-w-2xl leading-relaxed">
            <?php echo $curso['descripcion']; ?>
          </p>

        </div>
      </div>
    </section>

    <div class="max-w-[1280px] mx-auto px-4 md:px-8 py-10 md:py-16">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

        <div class="lg:col-span-8 space-y-12">

          <section>
            <h3 class="font-serif text-2xl font-bold text-primary dark:text-white mb-6 flex items-center gap-2">
              <span class="material-symbols-outlined text-secondary">info</span>
              Acerca de este curso
            </h3>

            <div class="prose prose-lg text-gray-700 dark:text-gray-300 leading-relaxed max-w-none">
              <p class="mb-4">
                <?php echo nl2br($curso['descripcion']); ?>
              </p>
            </div>

            <div
              class="mt-8 p-5 bg-gray-50 dark:bg-zinc-800/50 border border-gray-100 dark:border-zinc-700 rounded-xl flex items-center gap-4">

              <img alt="Instructor Profile"
                class="w-14 h-14 rounded-full border-2 border-white dark:border-zinc-700 shadow-sm"
                src="assets/imagenes/doctor.jpg" />

              <div>
                <p class="text-sm font-bold text-gray-900 dark:text-white">
                  <?php echo $curso['doctor_principal']; ?>
                </p>

                <p class="text-xs text-gray-500 dark:text-gray-400">
                  <?php echo $curso['doctores_secundarios']; ?>
                </p>
              </div>

            </div>
          </section>

          <section>
            <h3 class="font-serif text-2xl font-bold text-primary dark:text-white mb-6 flex items-center gap-2">
              <span class="material-symbols-outlined text-secondary">target</span>
              Objetivos de Aprendizaje
            </h3>

            <div class="prose prose-lg text-gray-700 dark:text-gray-300 leading-relaxed max-w-none">
              <p>
                <?php echo nl2br($curso['objetivos']); ?>
              </p>
            </div>

          </section>

          <section>
            <h3 class="font-serif text-2xl font-bold text-primary dark:text-white mb-6 flex items-center gap-2">
              <span class="material-symbols-outlined text-secondary">menu_book</span>
              Información del Curso
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div
                class="flex items-start gap-3 p-4 bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-gray-100 dark:border-zinc-700">
                <span class="material-symbols-outlined text-secondary mt-0.5">calendar_month</span>
                <span class="text-sm text-gray-700 dark:text-gray-300">
                  <b>Inicio:</b> <?php echo $curso['fecha_inicio']; ?>
                  <br>
                  <b>Fin:</b> <?php echo $curso['fecha_fin']; ?>
                </span>
              </div>

              <div
                class="flex items-start gap-3 p-4 bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-gray-100 dark:border-zinc-700">
                <span class="material-symbols-outlined text-secondary mt-0.5">schedule</span>
                <span class="text-sm text-gray-700 dark:text-gray-300">
                  <b>Horario:</b>
                  <?php echo substr($curso['hora_inicio'], 0, 5); ?> - <?php echo substr($curso['hora_fin'], 0, 5); ?>
                </span>
              </div>

              <div
                class="flex items-start gap-3 p-4 bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-gray-100 dark:border-zinc-700">
                <span class="material-symbols-outlined text-secondary mt-0.5">school</span>
                <span class="text-sm text-gray-700 dark:text-gray-300">
                  <b>Total de horas:</b> <?php echo $curso['total_horas']; ?>
                </span>
              </div>

              <div
                class="flex items-start gap-3 p-4 bg-white dark:bg-zinc-800 rounded-lg shadow-sm border border-gray-100 dark:border-zinc-700">
                <span class="material-symbols-outlined text-secondary mt-0.5">person</span>
                <span class="text-sm text-gray-700 dark:text-gray-300">
                  <b>Responsable:</b> <?php echo $curso['doctor_principal']; ?>
                </span>
              </div>
            </div>

          </section>

        </div>

        <div class="lg:col-span-4">
          <div class="sticky top-24 space-y-6">
            <div
              class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg border border-gray-200 dark:border-zinc-700 overflow-hidden relative">
              <div class="h-2 bg-gradient-to-r from-primary via-primary to-secondary w-full"></div>
              <div class="p-6 md:p-8">
                <div class="flex items-center justify-between mb-6">
                  <h3 class="font-serif text-xl font-bold text-gray-900 dark:text-white">
                    Ficha de Inscripción
                  </h3>

                  <?php if ($curso['disponible'] == 'SI') { ?>
                    <span
                      class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded font-bold border border-green-200">
                      DISPONIBLE
                    </span>
                  <?php } else { ?>
                    <span
                      class="bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded font-bold border border-gray-300">
                      NO DISPONIBLE
                    </span>
                  <?php } ?>

                </div>

                <div class="space-y-5 mb-8">

                  <div class="relative group">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5 ml-1">
                      Curso / Simposio
                    </label>
                    <div
                      class="flex items-center bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-700 rounded-lg px-4 py-3 text-gray-800 dark:text-gray-200 font-medium">
                      <span class="material-symbols-outlined text-gray-400 mr-3 text-[20px]">menu_book</span>
                      <?php echo $curso['titulo']; ?>
                    </div>
                  </div>

                  <div class="relative group">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5 ml-1">
                      Tipo
                    </label>
                    <div
                      class="flex items-center bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-700 rounded-lg px-4 py-3 text-gray-800 dark:text-gray-200 font-medium">
                      <span class="material-symbols-outlined text-gray-400 mr-3 text-[20px]">category</span>
                      <?php echo $curso['tipo']; ?>
                    </div>
                  </div>

                  <div class="relative group">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5 ml-1">
                      Fechas
                    </label>
                    <div
                      class="flex items-center bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-700 rounded-lg px-4 py-3 text-gray-800 dark:text-gray-200 font-medium">
                      <span class="material-symbols-outlined text-gray-400 mr-3 text-[20px]">calendar_month</span>
                      <?php echo $curso['fecha_inicio']; ?> - <?php echo $curso['fecha_fin']; ?>
                    </div>
                  </div>

                  <div class="relative group">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5 ml-1">
                      Horario
                    </label>
                    <div
                      class="flex items-center bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-700 rounded-lg px-4 py-3 text-gray-800 dark:text-gray-200 font-medium">
                      <span class="material-symbols-outlined text-gray-400 mr-3 text-[20px]">schedule</span>
                      <?php echo substr($curso['hora_inicio'], 0, 5); ?> - <?php echo substr($curso['hora_fin'], 0, 5); ?>
                    </div>
                  </div>

                  <div class="relative group">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5 ml-1">
                      Total Horas
                    </label>
                    <div
                      class="flex items-center bg-gray-50 dark:bg-zinc-900 border border-gray-200 dark:border-zinc-700 rounded-lg px-4 py-3 text-gray-800 dark:text-gray-200 font-medium">
                      <span class="material-symbols-outlined text-gray-400 mr-3 text-[20px]">school</span>
                      <?php echo $curso['total_horas']; ?> Horas
                    </div>
                  </div>

                </div>

                <div class="flex items-start gap-3 mb-6">
                  <div class="flex h-5 items-center">
                    <input checked=""
                      class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary cursor-not-allowed"
                      disabled="" id="terms" type="checkbox" />
                  </div>
                  <div class="text-xs text-gray-500 dark:text-gray-400 leading-tight">
                    Confirmo que mis datos son correctos y acepto los
                    <a class="text-primary hover:underline" href="#">Términos y Condiciones</a>
                    del programa académico 2026.
                  </div>
                </div>

                <button onclick="confirmarInscripcion()"
                  class="w-full bg-primary hover:bg-[#5a1632] text-white font-bold text-lg py-4 px-6 rounded-lg shadow-md hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 group"
                  <?php echo ($curso['disponible'] == 'SI') ? "" : "disabled"; ?>>

                  <span>Confirmar Inscripción</span>
                  <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">
                    arrow_forward
                  </span>

                </button>

                <script>
                  function confirmarInscripcion() {
                    const confirmacion = confirm("¿Seguro que deseas confirmar tu inscripción?");
                    if (confirmacion) {
                      window.location.href = "confirmacion.html";
                    }
                  }
                </script>

              </div>

              <div class="bg-gray-50 dark:bg-zinc-900/50 p-4 border-t border-gray-100 dark:border-zinc-700 text-center">
                <p class="text-xs text-gray-500">
                  <span class="font-bold">¿Dudas?</span> Contacte a
                  <a class="text-primary hover:underline" href="#info">Educacion Continua</a>
                </p>
              </div>
            </div>

            <div
              class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-5 border border-blue-100 dark:border-blue-800 flex items-start gap-3">
              <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 mt-0.5">info</span>
              <p class="text-sm text-blue-800 dark:text-blue-200 leading-snug">
                Este curso otorga constancia con valor curricular avalada por
                la Dirección de Enseñanza e Investigación.
              </p>
            </div>

          </div>
        </div>

      </div>
    </div>
  </main>

  <footer class="bg-primary text-white/90 pt-16 pb-8 border-t-4 border-secondary" id="info">
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