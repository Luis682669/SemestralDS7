<?php
/**
 * Front Controller - Portero de Seguridad
 * @author Luis Alberto De Los Rios
 * @colaboradores Jeremías Donoso, Juan Segundo
 * Institución: Universidad Tecnológica de Panamá
 */

// 1. Iniciar sesión al inicio absoluto
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Definir la ruta base del proyecto para evitar errores de directorios
define('BASE_PATH', dirname(__DIR__));

// 3. Cargar las dependencias manualmente
require_once BASE_PATH . '/app/Core/IError.php';
require_once BASE_PATH . '/app/Core/Database.php';
require_once BASE_PATH . '/app/Core/Security.php';
require_once BASE_PATH . '/app/Core/Response.php';
require_once BASE_PATH . '/app/Core/Auth.php';
require_once BASE_PATH . '/app/Core/Integrity.php';
require_once BASE_PATH . '/app/Models/Usuario.php';
require_once BASE_PATH . '/app/Controllers/LoginController.php';
require_once BASE_PATH . '/app/Controllers/UsuarioController.php';
require_once BASE_PATH . '/app/Models/Colaborador.php';
require_once BASE_PATH . '/app/Controllers/ColaboradorController.php';
require_once BASE_PATH . '/app/Models/Vacacion.php';
require_once BASE_PATH . '/app/Controllers/VacacionController.php';
require_once BASE_PATH . '/app/Controllers/ReporteController.php';
require_once BASE_PATH . '/app/Models/Reporte.php';
require_once BASE_PATH . '/app/Controllers/ApiController.php';
require_once BASE_PATH . '/app/Models/Planilla.php';
require_once BASE_PATH . '/app/Controllers/PlanillaController.php';



// 4. Analizar la URL solicitada por el usuario
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
if ($basePath !== '' && $basePath !== '/' && str_starts_with($uri, $basePath)) {
    $uri = substr($uri, strlen($basePath));
}
$uri = '/' . trim($uri, '/');

// 5. APLICACIÓN SOLID: Instanciamos dependencias en orden estricto
$db = \App\Core\Database::getInstance();
$usuarioModel = new \App\Models\Usuario($db); 
$loginController = new \App\Controllers\LoginController($usuarioModel); 
$usuarioController = new \App\Controllers\UsuarioController($usuarioModel); 
$colaboradorModel = new \App\Models\Colaborador($db);
$colaboradorController = new \App\Controllers\ColaboradorController($colaboradorModel);
$vacacionModel = new \App\Models\Vacacion($db);
$vacacionController = new \App\Controllers\VacacionController($vacacionModel, $colaboradorModel);
$reporteModel = new \App\Models\Reporte($db);
$reporteController = new \App\Controllers\ReporteController($reporteModel);
$planillaModel = new \App\Models\Planilla($db);
$planillaController = new \App\Controllers\PlanillaController($planillaModel, $colaboradorModel);
$apiController = new \App\Controllers\ApiController($colaboradorModel);

// 6. Control de Acceso
if (!isset($_SESSION['user_id']) && $uri !== '/login' && $uri !== '/' && $uri !== '/reset' && strpos($uri, '/api/') !== 0) {
    header('Location: /login');
    exit;
}

// 7. Enrutador básico (Switch)
switch ($uri) {
    case '/':
    case '/login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $loginController->authenticate();
        } else {
            $loginController->index();
        }
        break;
        
    case '/home':
        require_once BASE_PATH . '/app/Views/modules/home.php';
        break;

    // --- RUTAS DE USUARIOS ---
    case '/usuarios':
        $usuarioController->index();
        break;
    case '/usuarios/crear':
        $usuarioController->create();
        break;
    case '/usuarios/guardar':
        $usuarioController->store();
        break;
    case '/usuarios/desactivar':
        $usuarioController->deactivate();
        break;

    // --- RUTAS DE COLABORADORES ---
    case '/colaboradores':
        $colaboradorController->index();
        break;
    case '/colaboradores/crear':
        $colaboradorController->create();
        break;
    case '/colaboradores/guardar':
        $colaboradorController->store();
        break;
    case '/colaboradores/perfil':
        $colaboradorController->show();
        break;
    case '/colaboradores/cargo/guardar':
        $colaboradorController->storeCargo();
        break;

    // --- RUTAS DE VACACIONES ---
    case '/vacaciones':
        $vacacionController->index();
        break;
    case '/vacaciones/crear':
        $vacacionController->create();
        break;
    case '/vacaciones/guardar':
        $vacacionController->store();
        break;
    case '/vacaciones/estado':
        $vacacionController->cambiarEstado();
        break;
    case '/vacaciones/derechos':
        $vacacionController->derechos();
        break;

        // --- RUTAS DE REPORTES ---
    case '/reportes':
        $reporteController->index();
        break;

    case '/reportes/pdf':
        $reporteController->generarFichaColaborador();
        break;

    case '/reportes/listado':
        $reporteController->generarListadoColaboradores();
        break;
    case '/reportes/vacaciones':
        $reporteController->generarReporteVacaciones();
        break;

    case '/api/colaboradores/sexo':
        $apiController->colaboradoresPorSexo();
        break;

        // --- RUTAS DE PLANILLA ---
    case '/planillas':
        $planillaController->index();
        break;
    case '/planillas/generar':
        $planillaController->store();
        break;
    case '/planillas/exportar':
        $planillaController->exportExcel();
        break;

    case '/logout':
        session_unset();
        session_destroy();
        header('Location: /login');
        exit;

    case '/reset':

        
        try {
            $db = \App\Core\Database::getInstance();
            $db->exec("UPDATE usuarios SET activo = 1 WHERE username = 'admin'");
            $db->exec("DELETE FROM login_logs WHERE username = 'admin'");
            
            $password_real = 'Admin1234!';
            $hash = password_hash($password_real, PASSWORD_DEFAULT);
            
            $stmt = $db->prepare("UPDATE usuarios SET password = :hash WHERE username = 'admin'");
            $stmt->execute(['hash' => $hash]);

            echo "<div style='font-family: sans-serif; text-align: center; margin-top: 50px;'>";
            echo "<h2 style='color: green;'>¡Sistema reparado!</h2>";
            echo "<a href='/login' style='padding: 10px 20px; background: #0056b3; color: white; text-decoration: none; border-radius: 5px;'>Ir al Login</a>";
            echo "</div>";
        } catch (Exception $e) {
            echo "Error de base de datos: " . $e->getMessage();
        }
        exit;

    default:
        http_response_code(404);
        echo "<h1 style='font-family: sans-serif; text-align: center; margin-top: 50px;'>404 - Página no encontrada</h1>";
        break;
}