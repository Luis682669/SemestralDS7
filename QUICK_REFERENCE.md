# 🚀 GUÍA RÁPIDA - Implementación de CSRF & SQL Injection Prevention

**Para:** Equipo de Desarrollo  
**Uso:** Referencia cuando agregues nuevas características  
**Última actualización:** 2026-07-02

---

## 📝 Checklist para Nuevos Endpoints POST

Cuando agregues un nuevo endpoint que modifique datos (POST, PUT, DELETE):

### 1️⃣ Controller - Validar CSRF

```php
<?php
namespace App\Controllers;

use App\Core\Security;

class MiController {
    public function miAccion(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // ✅ PASO 1: VALIDAR TOKEN CSRF (OBLIGATORIO)
            Security::validateCSRFToken($_POST['csrf_token'] ?? '');
            
            // ✅ PASO 2: SANITIZAR DATOS
            $dato = Security::sanitizeString($_POST['dato'] ?? '');
            
            // ✅ PASO 3: USAR MODELO (que ya tiene prepared statements)
            $resultado = $this->miModelo->crear($dato);
            
            // ✅ PASO 4: REDIRECCIONAR
            header('Location: /mi-ruta?msg=exito');
            exit;
        }
    }
}
```

### 2️⃣ Modelo - Usar Prepared Statements

```php
<?php
namespace App\Models;

class MiModelo {
    private \PDO $db;

    public function crear(string $dato): bool {
        // ✅ OBLIGATORIO: Usar prepared statements
        // Opción A: Positional parameters (?)
        $stmt = $this->db->prepare("INSERT INTO mi_tabla (dato) VALUES (?)");
        $stmt->execute([$dato]);
        
        // Opción B: Named parameters (:nombre)
        // $stmt = $this->db->prepare("INSERT INTO mi_tabla (dato) VALUES (:dato)");
        // $stmt->execute(['dato' => $dato]);
        
        return true;
    }

    public function buscar(string $termino): array {
        // ✅ OBLIGATORIO: En búsquedas LIKE, usar prepared statements
        $termino = "%{$termino}%";  // ← Construir aquí, NO en SQL
        $stmt = $this->db->prepare("SELECT * FROM mi_tabla WHERE dato LIKE ?");
        $stmt->execute([$termino]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // ❌ NO HACER ESTO:
    // $sql = "SELECT * FROM mi_tabla WHERE id = " . $_GET['id'];  // ¡SQL Injection!
    // $stmt = $this->db->query($sql);
}
```

### 3️⃣ Vista - Incluir Token CSRF

```html
<!-- create.php o show.php o index.php -->
<?php
// ✅ PASO 1: Generar token en el controller
$csrf_token = \App\Core\Security::generateCSRFToken();
// Luego pasar a la vista: require_once 'mi_vista.php';
?>

<!-- ✅ PASO 2: Incluir en formulario -->
<form method="POST" action="/mi-ruta/guardar">
    <!-- OBLIGATORIO: Este campo oculto -->
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
    
    <!-- Tus campos aquí -->
    <input type="text" name="dato" required>
    <button type="submit">Guardar</button>
</form>

<!-- ❌ NO HACER ESTO:
<form method="POST" action="/mi-ruta/guardar">
    <!-- SIN csrf_token = VULNERABLE A CSRF -->
</form>
-->
```

### 4️⃣ Routing - Agregar en public/index.php

```php
<?php
// En el switch de rutas

case '/mi-ruta/guardar':
    $miController->miAccion();
    break;

// Luego instanciar el controller en la sección de dependencias
$miModel = new \App\Models\MiModelo($db);
$miController = new \App\Controllers\MiController($miModel);
```

---

## 🔍 Patrones de Código Seguros

### ✅ SEGURO: INSERT con Prepared Statement

```php
// Modelo
$stmt = $this->db->prepare("
    INSERT INTO usuarios (username, email, activo) 
    VALUES (?, ?, ?)
");
$stmt->execute([$username, $email, 1]);
```

### ✅ SEGURO: UPDATE con Prepared Statement

```php
// Modelo
$stmt = $this->db->prepare("
    UPDATE usuarios 
    SET email = ? 
    WHERE id = ?
");
$stmt->execute([$nuevoEmail, $id]);
```

### ✅ SEGURO: SELECT con WHERE

```php
// Modelo
$stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
$usuario = $stmt->fetch();
```

### ✅ SEGURO: SELECT con LIKE (búsqueda)

```php
// Modelo
$termino = "%{$termino}%";  // Construir fuera del SQL
$stmt = $this->db->prepare("SELECT * FROM usuarios WHERE nombre LIKE ?");
$stmt->execute([$termino]);
$resultados = $stmt->fetchAll();
```

### ✅ SEGURO: DELETE

```php
// Modelo
$stmt = $this->db->prepare("DELETE FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
```

---

## ❌ PATRONES INSEGUROS A EVITAR

### ❌ INSEGURO: Concatenación SQL (SQL Injection)

```php
// NUNCA HACER ESTO:
$sql = "SELECT * FROM usuarios WHERE id = " . $_GET['id'];  // ¡VULNERABLE!
$stmt = $this->db->query($sql);

// CORRECTO:
$stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$_GET['id']]);
```

### ❌ INSEGURO: Sin Token CSRF

```php
// Controller - NUNCA HACER ESTO:
public function store() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Falta: Security::validateCSRFToken($_POST['csrf_token'] ?? '');
        $dato = $_POST['dato'];  // ¡VULNERABLE A CSRF!
    }
}
```

### ❌ INSEGURO: Sin Sanitización

```php
// Controller - NUNCA HACER ESTO:
$nombre = $_POST['nombre'];  // Sin sanitizar
$this->modelo->crear($nombre);  // ¡VULNERABLE A XSS!

// CORRECTO:
$nombre = Security::sanitizeString($_POST['nombre']);
$this->modelo->crear($nombre);
```

---

## 📚 Ejemplo Completo: Nuevo Módulo

### Escenario: Agregar módulo de "Departamentos"

**Paso 1: Crear Modelo** - `app/Models/Departamento.php`
```php
<?php
namespace App\Models;

class Departamento {
    private \PDO $db;

    public function __construct(\PDO $db) {
        $this->db = $db;
    }

    public function crear(string $nombre, string $codigo): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO departamentos (nombre, codigo) VALUES (?, ?)"
        );
        return $stmt->execute([$nombre, $codigo]);
    }

    public function actualizar(int $id, string $nombre, string $codigo): bool {
        $stmt = $this->db->prepare(
            "UPDATE departamentos SET nombre = ?, codigo = ? WHERE id = ?"
        );
        return $stmt->execute([$nombre, $codigo, $id]);
    }

    public function obtener(int $id) {
        $stmt = $this->db->prepare("SELECT * FROM departamentos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
```

**Paso 2: Crear Controller** - `app/Controllers/DepartamentoController.php`
```php
<?php
namespace App\Controllers;

use App\Models\Departamento;
use App\Core\Security;

class DepartamentoController {
    private Departamento $departamentoModel;

    public function __construct(Departamento $departamentoModel) {
        $this->departamentoModel = $departamentoModel;
    }

    public function crear(): void {
        $csrf_token = Security::generateCSRFToken();
        require_once BASE_PATH . '/app/Views/modules/departamentos/crear.php';
    }

    public function guardar(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. Validar CSRF
            Security::validateCSRFToken($_POST['csrf_token'] ?? '');

            // 2. Sanitizar datos
            $nombre = Security::sanitizeString($_POST['nombre'] ?? '');
            $codigo = Security::sanitizeString($_POST['codigo'] ?? '');

            // 3. Validar no vacío
            if (empty($nombre) || empty($codigo)) {
                echo "<script>alert('Campos requeridos'); window.history.back();</script>";
                exit;
            }

            // 4. Usar modelo (prepared statements)
            if ($this->departamentoModel->crear($nombre, $codigo)) {
                header('Location: /departamentos?msg=exito');
            } else {
                echo "<script>alert('Error'); window.history.back();</script>";
            }
            exit;
        }
    }
}
```

**Paso 3: Crear Vista** - `app/Views/modules/departamentos/crear.php`
```html
<form method="POST" action="/departamentos/guardar">
    <!-- OBLIGATORIO: Token CSRF -->
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
    
    <input type="text" name="nombre" placeholder="Nombre del Departamento" required>
    <input type="text" name="codigo" placeholder="Código" required>
    <button type="submit">Crear Departamento</button>
</form>
```

**Paso 4: Actualizar Routing** - `public/index.php`
```php
<?php
// En sección de dependencias (alrededor de línea 50)
$departamentoModel = new \App\Models\Departamento($db);
$departamentoController = new \App\Controllers\DepartamentoController($departamentoModel);

// En switch de rutas (alrededor de línea 100)
case '/departamentos/crear':
    $departamentoController->crear();
    break;

case '/departamentos/guardar':
    $departamentoController->guardar();
    break;
```

---

## 🧪 Pruebas Rápidas

### Test CSRF
```bash
# Intento sin token CSRF → Debe fallar
curl -X POST http://localhost/departamentos/guardar \
  -d "nombre=Ventas&codigo=VEN"

# Resultado esperado: "Error de seguridad: Token CSRF inválido"
```

### Test SQL Injection
```bash
# Intento con SQL injection → Debe tratarse como texto literal
curl -X POST http://localhost/departamentos/guardar \
  -d "csrf_token=...&nombre='); DROP TABLE departamentos; --&codigo=HACK"

# Resultado: Se guarda como nombre literal, BD intacta
```

---

## 📋 Preguntas Frecuentes

### P: ¿Siempre necesito validar CSRF?
**R:** Sí, en TODO endpoint POST/PUT/DELETE que modifique datos. Las operaciones GET (lectura) NO necesitan.

### P: ¿Debo sanitizar en Controller o Modelo?
**R:** En **ambos**:
- **Controller:** Sanitizar antes de pasar al modelo (defensa en profundidad)
- **Modelo:** Usar prepared statements (defensa técnica)

### P: ¿Qué tipo de validación usar: ? o :nombre?
**R:** Ambas son seguras. Usa la que prefieras:
- `?` - Más simple (positional parameters)
- `:nombre` - Más legible (named parameters)

### P: ¿Qué pasa si olvido el token CSRF?
**R:** El endpoint rechaza la petición:
```
Die: Error de seguridad: Token CSRF inválido. Posible ataque detectado.
```

### P: ¿Puedo usar `$_GET` directamente en SQL?
**R:** **NO**. Siempre usar prepared statements:
```php
// ❌ NO
$id = $_GET['id'];
$sql = "SELECT * FROM tabla WHERE id = $id";

// ✅ SÍ
$stmt = $db->prepare("SELECT * FROM tabla WHERE id = ?");
$stmt->execute([$_GET['id']]);
```

---

## 🔗 Documentación de Referencia

1. **SECURITY_SUMMARY.md** - Resumen ejecutivo (para stakeholders)
2. **SECURITY_EVIDENCE.md** - Evidencia técnica detallada (para auditorías)
3. **SECURITY_CHECKLIST.md** - Checklist completo (para validaciones)
4. **QUICK_REFERENCE.md** - Esta guía (para desarrollo)

---

**Última revisión:** 2026-07-02  
**Estado:** Listo para producción  
**Contacto:** Equipo de Seguridad
