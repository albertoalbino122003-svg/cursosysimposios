<?php
// 1. INICIO DE SESIÓN Y SEGURIDAD
session_start();
include 'conexion.php';

// Si el usuario no ha iniciado sesión, lo devolvemos al login
if (!isset($_SESSION['user_id'])) {
    header("Location: iniciar_sesion.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// 2. CONSULTA A LA BASE DE DATOS
// Seleccionamos todos los datos del usuario actual
$stmt = $conex->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();
} else {
    // Si algo falla y no encuentra al usuario (raro si la sesión existe)
    echo "Error: No se pudieron cargar los datos del perfil.";
    exit();
}

$stmt->close();
// Cerramos la conexión aquí si no la usaremos más abajo, 
// o dejamos que se cierre al final del script.
?>

<!DOCTYPE html>
<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Mi Perfil | HRAEI 2026</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&family=Noto+Serif:wght@400;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#691c3d",
                        "secondary": "#C38D33",
                        "background-light": "#F8F8F8",
                        "background-dark": "#18181b",
                        "surface": "#ffffff",
                        "success": "#2D6A4F"
                    },
                },
                fontFamily: {
                    display: ["Noto Sans", "sans-serif"],
                    serif: ["Noto Sans", "sans-serif"],
                },
                borderRadius: {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
                },
            },
        };
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
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

<body class="bg-background-light dark:bg-background-dark font-display text-[#191014] antialiased min-h-screen flex flex-col">
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
                    <input class="block w-full pl-10 pr-3 py-2 border-none rounded-lg leading-5 bg-white/10 text-white placeholder-white/60 focus:outline-none focus:bg-white/20 focus:ring-1 focus:ring-white/30 sm:text-sm transition-colors" placeholder="Buscar mis cursos..." type="text" />
                </div>
            </div>
            <div class="flex items-center gap-4 md:gap-6">
                <nav class="hidden lg:flex items-center gap-6 text-sm font-medium text-white/90">
                    <a class="hover:text-white transition-colors" href="Inicio.html">Inicio</a>
                    <a class="text-white border-b-2 border-secondary pb-1" href="mis_cursos.html">Mis Cursos</a>
                </nav>
                <div class="flex items-center gap-3 pl-4 border-l border-white/20">
                    <div class="h-8 w-8 md:h-10 md:w-10 rounded-full bg-white/20 p-0.5 cursor-pointer ring-2 ring-transparent hover:ring-white/30 transition-all">
                        <img alt="User Profile" class="h-full w-full rounded-full object-cover" src="assets/imagenes/doctor.jpg" />
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow max-w-[1280px] mx-auto w-full px-4 md:px-8 py-8 md:py-12">
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
            <a class="hover:text-primary transition-colors" href="Inicio.html">Inicio</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="font-semibold text-primary">Mi Perfil</span>
        </nav>
        <div class="mb-10">
            <h1 class="font-serif text-3xl md:text-4xl font-bold text-primary dark:text-white">Mi Perfil Personal</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Gestiona tu información académica y datos personales de contacto.</p>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-gray-100 dark:border-zinc-700 p-8 flex flex-col items-center text-center">
                    <div class="relative group">
                        <div class="w-32 h-32 md:w-40 md:h-40 rounded-full overflow-hidden border-4 border-gray-50 shadow-inner">
                            <img alt="Profile Large" class="h-full w-full object-cover" src="assets/imagenes/doctor.jpg" />
                        </div>
                        <button class="absolute bottom-2 right-2 bg-white text-primary p-2 rounded-full shadow-lg hover:scale-110 transition-transform border border-gray-100">
                            <span class="material-symbols-outlined text-[20px]">photo_camera</span>
                        </button>
                    </div>

                    <h2 class="mt-6 font-bold text-xl text-gray-900 dark:text-white">
                        <?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido_paterno']); ?>
                    </h2>

                    <p class="text-sm text-gray-500 mb-6">
                        ID de Usuario: #HRAEI-2026-<?php echo str_pad($usuario['id'], 4, "0", STR_PAD_LEFT); ?>
                    </p>

                    <button class="w-full py-2.5 px-4 border border-primary text-primary hover:bg-primary hover:text-white font-semibold rounded-lg transition-all text-sm">
                        Actualizar foto
                    </button>
                </div>

                <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-gray-100 dark:border-zinc-700 p-6">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2 border-b border-gray-100 dark:border-zinc-700 pb-3">
                        <span class="material-symbols-outlined text-primary">school</span>
                        Resumen Académico
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-background-light dark:bg-zinc-900 rounded-lg">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Cursos Inscritos</span>
                            <span class="font-bold text-primary">0</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-background-light dark:bg-zinc-900 rounded-lg">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Completados</span>
                            <span class="font-bold text-success">0</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-background-light dark:bg-zinc-900 rounded-lg">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Constancias</span>
                            <span class="font-bold text-secondary">0</span>
                        </div>
                    </div>
                    <a class="block text-center mt-6 text-sm font-semibold text-primary hover:underline" href="#">
                        Ver historial completo
                    </a>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-gray-100 dark:border-zinc-700 overflow-hidden">
                    <div class="bg-gray-50 dark:bg-zinc-900/50 px-8 py-4 border-b border-gray-100 dark:border-zinc-700">
                        <h3 class="font-bold text-gray-900 dark:text-white">Información Personal y Profesional</h3>
                    </div>
                    <div class="p-8">
                        <form class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" for="fullname">Nombre Completo</label>
                                    <input
                                        class="w-full px-4 py-2.5 rounded-lg border-gray-200 focus:border-primary focus:ring-primary transition-colors dark:bg-zinc-900 dark:border-zinc-700 dark:text-white"
                                        id="fullname" name="fullname" type="text"
                                        value="<?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido_paterno'] . ' ' . $usuario['apellido_materno']); ?>" />
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" for="email">Correo Electrónico</label>
                                    <input
                                        class="w-full px-4 py-2.5 rounded-lg border-gray-200 focus:border-primary focus:ring-primary transition-colors dark:bg-zinc-900 dark:border-zinc-700 dark:text-white"
                                        id="email" name="email" type="email"
                                        value="<?php echo htmlspecialchars($usuario['correo']); ?>" />
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" for="fecha_nacimiento">Fecha de Nacimiento</label>
                                    <input
                                        class="w-full px-4 py-2.5 rounded-lg border-gray-200 focus:border-primary focus:ring-primary transition-colors dark:bg-zinc-900 dark:border-zinc-700 dark:text-white"
                                        id="fecha_nacimiento"
                                        name="fecha_nacimiento"
                                        type="date"
                                        value="<?php echo isset($usuario['fecha_nacimiento']) ? htmlspecialchars($usuario['fecha_nacimiento']) : ''; ?>" />
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" for="cedula">institucion</label>
                                    <input
                                        class="w-full px-4 py-2.5 rounded-lg border-gray-200 focus:border-primary focus:ring-primary transition-colors dark:bg-zinc-900 dark:border-zinc-700 dark:text-white"
                                        id="cedula" name="institucion" type="text"
                                        value="<?php echo isset($usuario['institucion']) ? htmlspecialchars($usuario['institucion']) : ''; ?>" />
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" for="specialty">Especialidad</label>
                                    <select
                                        class="w-full px-4 py-2.5 rounded-lg border-gray-200 focus:border-primary focus:ring-primary transition-colors dark:bg-zinc-900 dark:border-zinc-700 dark:text-white"
                                        id="specialty" name="specialty">
                                        <option <?php if ($usuario['especialidad'] == 'Medicina Interna') echo 'selected'; ?>>Medicina Interna</option>
                                        <option <?php if ($usuario['especialidad'] == 'Cardiología') echo 'selected'; ?>>Cardiología</option>
                                        <option <?php if ($usuario['especialidad'] == 'Enfermería General') echo 'selected'; ?>>Enfermería General</option>
                                        <option <?php if ($usuario['especialidad'] == 'Cirugía General') echo 'selected'; ?>>Cirugía General</option>
                                        <option <?php if ($usuario['especialidad'] == 'Anestesiología') echo 'selected'; ?>>Anestesiología</option>
                                        <?php
                                        $lista_default = ['Medicina Interna', 'Cardiología', 'Enfermería General', 'Cirugía General', 'Anestesiología'];
                                        if (!in_array($usuario['especialidad'], $lista_default) && !empty($usuario['especialidad'])) {
                                            echo "<option selected>" . htmlspecialchars($usuario['especialidad']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2" for="phone">Teléfono de Contacto</label>
                                    <input
                                        class="w-full px-4 py-2.5 rounded-lg border-gray-200 focus:border-primary focus:ring-primary transition-colors dark:bg-zinc-900 dark:border-zinc-700 dark:text-white"
                                        id="phone" name="phone" type="tel"
                                        value="<?php echo htmlspecialchars($usuario['telefono']); ?>" />
                                </div>
                            </div>

                            <div class="pt-8 mt-8 border-t border-gray-100 dark:border-zinc-700 flex flex-col md:flex-row justify-end gap-4">
                                <button class="order-2 md:order-1 px-8 py-3 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 transition-colors font-semibold text-sm" type="button">
                                    Cancelar
                                </button>
                                <button class="order-1 md:order-2 px-8 py-3 rounded-lg bg-success hover:bg-success/90 text-white font-bold transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2" type="submit">
                                    <span class="material-symbols-outlined text-[20px]">save</span>
                                    Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mt-8 bg-white dark:bg-zinc-800 rounded-xl shadow-sm border border-gray-100 dark:border-zinc-700 p-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white">Seguridad de la cuenta</h4>
                            <p class="text-sm text-gray-500">Cambia tu contraseña o gestiona el acceso de tu cuenta.</p>
                        </div>
                        <button class="text-primary font-bold text-sm hover:underline">
                            Gestionar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-primary text-white/90 pt-16 pb-8 border-t-4 border-secondary">
        <div class="max-w-[1280px] mx-auto px-4 md:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <div>
                    <h4 class="font-bold text-white mb-4">Redes Sociales</h4>
                    <ul class="space-y-2 text-sm text-white/70">
                        <li><a href="https://www.facebook.com/share/14VLkV9scHQ/?mibextid=wwXIfr" target="_blank" class="hover:text-white hover:underline decoration-secondary underline-offset-4">Facebook</a></li>
                        <li><a href="https://www.instagram.com/hrae.ixtapaluca?igsh=Z3Ryd3VqbmQ2eWdm" target="_blank" class="hover:text-white hover:underline decoration-secondary underline-offset-4">Instagram</a></li>
                        <li><a href="https://x.com/HRAEIxtapaluca?t=v-f7qiSr3yUbD7wdf7V0wA&s=08" target="_blank" class="hover:text-white hover:underline decoration-secondary underline-offset-4">Twitter</a></li>
                        <li><a href="https://www.youtube.com/@hraeixtapaluca3460" target="_blank" class="hover:text-white hover:underline decoration-secondary underline-offset-4">Youtube</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4">Institucional</h4>
                    <ul class="space-y-2 text-sm text-white/70">
                        <li><a class="hover:text-white hover:underline decoration-secondary underline-offset-4" href="#">Sobre Nosotros</a></li>
                        <li><a class="hover:text-white hover:underline decoration-secondary underline-offset-4" href="#">Directorio</a></li>
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
            <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-white/50">
                <p>© 2026 Hospital Regional de Alta Especialidad de Ixtapaluca. Todos los derechos reservados.</p>
                <div class="flex gap-4">
                    <a class="hover:text-white" href="#">Aviso de Privacidad</a>
                    <a class="hover:text-white" href="#">Términos y Condiciones</a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>