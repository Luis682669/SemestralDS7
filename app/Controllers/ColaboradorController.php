<?php
namespace App\Controllers;

use App\Models\Colaborador;
use App\Core\Security;

class ColaboradorController {
    private Colaborador $colaboradorModel;

    public function __construct(Colaborador $colaboradorModel) {
        $this->colaboradorModel = $colaboradorModel;
    }

    public function index(): void {
        // Capturar el término de búsqueda si existe
        $busqueda = $_GET['q'] ?? '';
        $busqueda = \App\Core\Security::sanitizeString($busqueda);
        
        if (!empty($busqueda)) {
            $colaboradores = $this->colaboradorModel->search($busqueda);
        } else {
            $colaboradores = $this->colaboradorModel->getAllActive();
        }
        
        require_once BASE_PATH . '/app/Views/modules/colaboradores/index.php';
    }

    public function create(): void {
        $csrf_token = Security::generateCSRFToken();
        require_once BASE_PATH . '/app/Views/modules/colaboradores/create.php';
    }

    public function store(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Security::validateCSRFToken($_POST['csrf_token'] ?? '');
            
            // Procesar subida de PDF
            $pdfPath = '';
            if (isset($_FILES['historial_academico']) && $_FILES['historial_academico']['error'] === 0) {
                $uploadDir = BASE_PATH . '/public/uploads/';
                $fileName = time() . '_' . basename($_FILES['historial_academico']['name']);
                if (move_uploaded_file($_FILES['historial_academico']['tmp_name'], $uploadDir . $fileName)) {
                    $pdfPath = $fileName;
                }
            }

            // Procesar foto de perfil
            $photoPath = '';
            if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
                $allowedExts = ['jpg', 'jpeg', 'png', 'webp'];
                $photoInfo = pathinfo($_FILES['foto_perfil']['name']);
                $photoExt = strtolower($photoInfo['extension'] ?? '');
                $photoMime = mime_content_type($_FILES['foto_perfil']['tmp_name']);

                if (in_array($photoMime, $allowedTypes, true) && in_array($photoExt, $allowedExts, true)) {
                    $uploadDir = BASE_PATH . '/public/uploads/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    $photoPath = time() . '_' . bin2hex(random_bytes(6)) . '.' . $photoExt;
                    if (!move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $uploadDir . $photoPath)) {
                        $photoPath = '';
                    }
                }
            }

            // Sanitizar datos
            $sueldo = isset($_POST['sueldo']) ? (int)round((float)$_POST['sueldo']) : 0;

            $data = [
                'identificacion' => Security::sanitizeString($_POST['identificacion']),
                'primer_nombre' => Security::sanitizeString($_POST['primer_nombre']),
                'segundo_nombre' => Security::sanitizeString($_POST['segundo_nombre']),
                'primer_apellido' => Security::sanitizeString($_POST['primer_apellido']),
                'segundo_apellido' => Security::sanitizeString($_POST['segundo_apellido']),
                'sexo' => $_POST['sexo'],
                'fecha_nacimiento' => $_POST['fecha_nacimiento'],
                'direccion' => Security::sanitizeString($_POST['direccion']),
                'correo_personal' => Security::sanitizeString($_POST['correo_personal']),
                'telefono' => Security::sanitizeString($_POST['telefono']),
                'celular' => Security::sanitizeString($_POST['celular']),
                'departamento' => Security::sanitizeString($_POST['departamento']),
                'fecha_contratacion' => $_POST['fecha_contratacion'],
                'tipo_contrato' => $_POST['tipo_contrato'],
                'ocupacion' => Security::sanitizeString($_POST['ocupacion']),
                'estatus' => $_POST['estatus']
            ];

            $colaboradorId = $this->colaboradorModel->create($data, $pdfPath, $photoPath);
            if ($colaboradorId) {
                $this->colaboradorModel->addCargo($colaboradorId, $data['ocupacion'], $sueldo, $data['fecha_contratacion']);
                header('Location: /colaboradores');
            } else {
                // Redirigir con un mensaje de error en lugar de un alert
                header('Location: /colaboradores/crear?error=guardado');
            }
        }
    }

    public function show(): void {
        $id = $_GET['id'] ?? 0;
        $colaborador = $this->colaboradorModel->getById((int)$id);
        
        if (!$colaborador) {
            header('Location: /colaboradores');
            exit;
        }

        $cargos = $this->colaboradorModel->getCargos((int)$id);
        $csrf_token = Security::generateCSRFToken();

        // Preparamos los datos para la gráfica de evolución salarial
        $chart_labels = [];
        $chart_salaries = [];
        // El historial viene en orden descendente, lo invertimos para la gráfica
        $reversed_cargos = array_reverse($cargos); 
        foreach ($reversed_cargos as $cargo) {
            // Formateamos la fecha para que sea legible en el eje X
            $chart_labels[] = (new \DateTime($cargo['fecha_inicio']))->format('M Y');
            $chart_salaries[] = $cargo['sueldo'];
        }
        // Convertimos los datos a formato JSON para pasarlos a JavaScript
        $chart_data_json = json_encode(['labels' => $chart_labels, 'salaries' => $chart_salaries]);
        
        require_once BASE_PATH . '/app/Views/modules/colaboradores/show.php';
    }

    public function storeCargo(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Security::validateCSRFToken($_POST['csrf_token'] ?? '');
            
            $colaborador_id = (int)$_POST['colaborador_id'];
            $nombre_cargo = Security::sanitizeString($_POST['nombre_cargo']);
            // Se asegura de que el sueldo sea un número entero para los cálculos de planilla
            $sueldo = (int)round((float)$_POST['sueldo']); 
            $fecha_inicio = $_POST['fecha_inicio'];

            // Lógica para desactivar el cargo anterior y activar el nuevo
            // 1. Desactivamos el cargo activo actual, estableciendo su fecha de fin.
            $this->colaboradorModel->deactivateCurrentCargo($colaborador_id, $fecha_inicio);
            // 2. Añadimos el nuevo cargo, que quedará como el único activo.
            $this->colaboradorModel->addCargo($colaborador_id, $nombre_cargo, $sueldo, $fecha_inicio);
            
            header("Location: /colaboradores/perfil?id=" . $colaborador_id);
            exit;
        }
    }
}