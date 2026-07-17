<?php
/**
 * Copyright (c) 2026.
 * Proyecto Semestral Capital Humano
 * Universidad Tecnológica de Panamá
 * Autores: Luis De Los Rios, Jeremías Donoso, Lionel Cordoba, Juan Segundo
 */

namespace App\Controllers;

use App\Models\Usuario;
use App\Core\Security;
use App\Core\Response;
use App\Core\FlashMessage;

class UsuarioController {
    
    private Usuario $usuarioModel;

    public function __construct(Usuario $usuarioModel) {
        $this->usuarioModel = $usuarioModel;
    }

    /**
     * Muestra la tabla principal de usuarios (Read)
     */
    public function index(): void {
        // PUNTO 3 (Roles): Solo el Administrador Total (rol_id = 1) puede gestionar usuarios
        if (!isset($_SESSION['rol_id']) || $_SESSION['rol_id'] != 1) {
            echo "<div style='font-family: sans-serif; text-align: center; margin-top: 50px;'>";
            echo "<h2 style='color: #d9534f;'>Acceso Denegado</h2>";
            echo "<p>No tienes los permisos necesarios para ver este módulo.</p>";
            echo "<a href='/home' style='padding: 10px 20px; background: #0d1b2e; color: white; text-decoration: none; border-radius: 5px;'>Volver al Inicio</a>";
            echo "</div>";
            exit;
        }

        // 1. Pedir los datos al modelo
        $usuarios = $this->usuarioModel->getAllUsers();
        $roles = $this->usuarioModel->getRoles();
        
        // 2. Generar token de seguridad para los futuros formularios de alta/desactivar
        $csrf_token = Security::generateCSRFToken();

        // 3. Cargar la vista HTML
        require_once BASE_PATH . '/app/Views/modules/usuarios/index.php';
    }

    /**
     * Muestra el formulario para crear un nuevo usuario
     */
    public function create(): void {
        if (!isset($_SESSION['rol_id']) || $_SESSION['rol_id'] != 1) {
            header('Location: /home'); exit;
        }

        $roles = $this->usuarioModel->getRoles();
        $csrf_token = Security::generateCSRFToken();
        
        // Cargamos la vista del formulario
        require_once BASE_PATH . '/app/Views/modules/usuarios/create.php';
    }

    /**
     * Recibe los datos del formulario y los guarda en la base de datos
     */
    /**
     * Recibe los datos del formulario y los guarda en la base de datos
     */
    public function store(): void {
        if (!isset($_SESSION['rol_id']) || $_SESSION['rol_id'] != 1) {
            header('Location: /home'); exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. Validar Token CSRF (Nombre corregido)
            Security::validateCSRFToken($_POST['csrf_token'] ?? '');
            
            // 2. Sanitizar datos de entrada (Nombre corregido)
            $username = Security::sanitizeString($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $rol_id = (int)($_POST['rol_id'] ?? 0);

            // 3. Validar campos y longitud de contraseña
            if (empty($username) || empty($password) || $rol_id <= 0) {
                FlashMessage::set('error', 'Por favor, completa todos los campos requeridos.');
                header('Location: /usuarios/crear');
                exit;
            }

            if (!Security::validatePasswordLength($password)) {
                FlashMessage::set('warning', 'La contraseña debe tener entre 8 y 12 caracteres.');
                header('Location: /usuarios/crear');
                exit;
            }

            // 4. Intentar guardar
            $result = $this->usuarioModel->createUser($username, $password, $rol_id);
            if ($result) {
                $message = '¡Usuario agregado exitosamente! <strong>Guarde estas claves de API en un lugar seguro, no se mostrarán de nuevo:</strong><br>'
                         . 'Clave Pública: <code>' . htmlspecialchars($result['api_key_public']) . '</code><br>'
                         . 'Clave Privada: <code>' . htmlspecialchars($result['api_key_private_plain']) . '</code>';
                FlashMessage::set('success', $message);
            } else {
                FlashMessage::set('error', 'Error: El nombre de usuario ya está registrado. Por favor, elige otro.');
            }
            header('Location: /usuarios');
            exit;
        }
    }
    /**
     * Procesa la desactivación lógica de un usuario
     */
    public function deactivate(): void {
        if (!isset($_SESSION['rol_id']) || $_SESSION['rol_id'] != 1) {
            header('Location: /home'); exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar token de seguridad
            Security::validateCSRFToken($_POST['csrf_token'] ?? '');
            
            $id = (int)($_POST['id'] ?? 0);

            if ($id > 0) {
                $this->usuarioModel->deactivateUser($id);
            }
            
            // Redireccionar de vuelta a la lista de usuarios
            header('Location: /usuarios');
            exit;
        }
    }
    
    }