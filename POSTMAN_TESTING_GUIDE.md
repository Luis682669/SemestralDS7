# 🧪 GUÍA POSTMAN - Testing de GET, PUT, DELETE

**Sistema:** Capital Humano  
**Fecha:** 2026-07-02  
**Herramienta:** Postman v11+

---

## ⚙️ Configuración Inicial en Postman

### 1. Crear Colección

```
1. Click en "Collections" (lado izquierdo)
2. Click en "+" (Create a New Collection)
3. Nombre: "Capital Humano - Security Tests"
4. Guardar
```

### 2. Crear Environment

```
1. Click en "Environments" (lado izquierdo)
2. Click en "Create an environment"
3. Nombre: "Capital Humano - Local"
4. Agregar variable:
   - Name: baseUrl
   - Initial Value: http://localhost
   - Current Value: http://localhost
5. Guardar
```

---

## 🧪 PRUEBAS HTTP METHODS

### 1️⃣ GET - Obtener Datos (SIN CSRF - Es lectura)

#### Test 1.1: GET - Obtener todos los colaboradores
```
URL:    {{baseUrl}}/colaboradores
Método: GET
Headers: (ninguno especial)
Body:   (vacío)

Resultado Esperado:
Status:  200 OK
Body:    JSON/HTML con lista de colaboradores
```

**En Postman:**
```
1. Nuevo Request: "GET - Colaboradores"
2. Método: GET
3. URL: {{baseUrl}}/colaboradores
4. Enviar (Send)
5. Ver respuesta
```

#### Test 1.2: GET - Búsqueda de Colaborador
```
URL:    {{baseUrl}}/colaboradores?q=luis
Método: GET
Headers: (ninguno)
Body:   (vacío)

Resultado Esperado:
Status:  200 OK
Body:    Colaboradores que coincidan con "luis"
```

**En Postman:**
```
1. Nuevo Request: "GET - Búsqueda Colaborador"
2. Método: GET
3. URL: {{baseUrl}}/colaboradores?q=luis
4. Tabs: Params
   - Key: q
   - Value: luis
5. Enviar
```

#### Test 1.3: GET - Obtener vacaciones
```
URL:    {{baseUrl}}/vacaciones
Método: GET
Headers: (ninguno)
Body:   (vacío)

Resultado Esperado:
Status:  200 OK
Body:    Lista de solicitudes de vacaciones
```

#### Test 1.4: GET - Obtener reportes
```
URL:    {{baseUrl}}/reportes
Método: GET
Headers: (ninguno)
Body:   (vacío)

Resultado Esperado:
Status:  200 OK
Body:    Dashboard de reportes
```

---

### 2️⃣ POST - Crear Datos (CON CSRF OBLIGATORIO)

#### Test 2.1: POST - Login (Primero para obtener cookies/sesión)

**Step A: Hacer login para obtener token CSRF**
```
URL:    {{baseUrl}}/login
Método: POST
Headers: 
  Content-Type: application/x-www-form-urlencoded
Body:   (form-data)
  username: admin
  password: Admin1234!
  csrf_token: [se captura de la respuesta GET anterior]

Resultado Esperado:
Status:  302 (Redirect a /home)
Cookies: PHPSESSID guardada
```

**En Postman:**
```
1. Nuevo Request: "POST - Login"
2. Método: POST
3. URL: {{baseUrl}}/login
4. Tab "Body":
   - Seleccionar: x-www-form-urlencoded
   - username: admin
   - password: Admin1234!
   - csrf_token: [ver paso 2.2]
5. Tab "Cookies": Verificar que se guarda PHPSESSID
6. Enviar
```

**¿Cómo obtener el CSRF token?**
```
1. Primero, hacer GET a {{baseUrl}}/login
2. En la respuesta HTML, buscar:
   <input type="hidden" name="csrf_token" value="a7f3c9e2b1d45678...">
3. Copiar el valor (64 caracteres hex)
4. Usarlo en el POST
```

#### Test 2.2: POST - Crear Colaborador (CON CSRF)

**Paso 1: Obtener token CSRF desde formulario**
```
GET {{baseUrl}}/colaboradores/crear
(capturar token de la respuesta HTML)
```

**Paso 2: Enviar datos con token**
```
URL:    {{baseUrl}}/colaboradores/guardar
Método: POST
Headers: 
  Content-Type: application/x-www-form-urlencoded
Body (form-data):
  csrf_token: [TOKEN_CAPTURADO]
  identificacion: 8999999
  primer_nombre: Juan
  primer_apellido: Pérez
  segundo_nombre: Carlos
  segundo_apellido: López
  sexo: M
  fecha_nacimiento: 1990-05-15
  direccion: Calle Principal 123
  correo_personal: juan@example.com
  telefono: 2345678
  celular: 68888888
  departamento: Ventas
  fecha_contratacion: 2026-01-15
  tipo_contrato: Indefinido
  ocupacion: Vendedor
  estatus: Activo

Resultado Esperado:
Status:  302 (Redirect)
Location: /colaboradores (éxito)
```

**En Postman:**
```
1. Nuevo Request: "POST - Crear Colaborador"
2. Método: POST
3. URL: {{baseUrl}}/colaboradores/guardar
4. Tab "Body": x-www-form-urlencoded
5. Pegar todos los campos (incluyendo csrf_token)
6. Enviar
```

#### Test 2.3: POST - SIN Token CSRF (Debe fallar)

```
URL:    {{baseUrl}}/colaboradores/guardar
Método: POST
Headers: 
  Content-Type: application/x-www-form-urlencoded
Body (sin csrf_token):
  identificacion: 8999998
  primer_nombre: Atacante
  primer_apellido: Malicioso
  ... (más campos)

Resultado Esperado:
Status:  200
Body:    "Error de seguridad: Token CSRF inválido. Posible ataque detectado."
```

**En Postman:**
```
1. Copiar request anterior
2. ELIMINAR el campo: csrf_token
3. Enviar
4. Ver error: "Token CSRF inválido"
```

#### Test 2.4: POST - Crear Usuario (CON CSRF)

```
URL:    {{baseUrl}}/usuarios/guardar
Método: POST
Headers: 
  Content-Type: application/x-www-form-urlencoded
Body:
  csrf_token: [TOKEN]
  username: nuevouser
  password: Password123
  rol_id: 2

Resultado Esperado:
Status:  302 /usuarios (éxito)
```

#### Test 2.5: POST - SQL Injection Attempt (Debe estar protegido)

```
URL:    {{baseUrl}}/colaboradores/guardar
Método: POST
Headers: 
  Content-Type: application/x-www-form-urlencoded
Body:
  csrf_token: [TOKEN]
  identificacion: '); DROP TABLE colaboradores; --
  primer_nombre: Hacker
  ... (resto de campos)

Resultado Esperado:
Status:  302 /colaboradores
Body:    Se guarda el nombre como texto literal
         La tabla NO se elimina (SQL Injection BLOQUEADO)
```

---

### 3️⃣ PUT - Actualizar Datos

⚠️ **Nota:** Tu aplicación actual usa POST para todo. PUT se usa en APIs REST modernas.  
**Si quieres implementar PUT, sigue este patrón:**

#### Ejemplo: Implementar PUT para actualizar colaborador

**Primero, agregar en Controller:**
```php
// ColaboradorController.php
public function update(int $id): void {
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        Security::validateCSRFToken($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');
        
        // Lógica de actualización...
    }
}
```

**En public/index.php:**
```php
case '/colaboradores/actualizar':
    preg_match('/\/colaboradores\/(\d+)/', $_SERVER['REQUEST_URI'], $matches);
    $id = $matches[1] ?? 0;
    $colaboradorController->update((int)$id);
    break;
```

**Test PUT en Postman:**
```
URL:    {{baseUrl}}/colaboradores/actualizar/123
Método: PUT
Headers:
  Content-Type: application/json
  X-CSRF-Token: [TOKEN]
Body (raw JSON):
{
  "primer_nombre": "Juan Actualizado",
  "departamento": "Recursos Humanos"
}

Resultado Esperado:
Status:  200 OK
Body:    {
            "success": true,
            "message": "Colaborador actualizado"
          }
```

**En Postman:**
```
1. Nuevo Request: "PUT - Actualizar Colaborador"
2. Método: PUT
3. URL: {{baseUrl}}/colaboradores/actualizar/123
4. Tab "Headers":
   - Key: X-CSRF-Token
   - Value: [TOKEN]
5. Tab "Body": raw (JSON)
6. Enviar
```

---

### 4️⃣ DELETE - Eliminar Datos

⚠️ **Nota:** Tu aplicación actual usa desactivación lógica, no DELETE físico.

#### Test 4.1: DELETE - Desactivar Usuario (usando POST)

```
URL:    {{baseUrl}}/usuarios/desactivar
Método: POST (actualmente)
Headers: 
  Content-Type: application/x-www-form-urlencoded
Body:
  csrf_token: [TOKEN]
  id: 5

Resultado Esperado:
Status:  302 /usuarios
Body:    Usuario desactivado (no eliminado)
```

#### Si implementas DELETE puro:

**Test DELETE en Postman:**
```
URL:    {{baseUrl}}/usuarios/eliminar/5
Método: DELETE
Headers:
  X-CSRF-Token: [TOKEN]
Body:   (vacío)

Resultado Esperado:
Status:  200 OK
Body:    {
            "success": true,
            "message": "Usuario eliminado"
          }
```

**En Postman:**
```
1. Nuevo Request: "DELETE - Eliminar Usuario"
2. Método: DELETE
3. URL: {{baseUrl}}/usuarios/eliminar/5
4. Tab "Headers":
   - Key: X-CSRF-Token
   - Value: [TOKEN]
5. Enviar
```

---

## 📊 Suite Completa de Pruebas

### Flujo de Prueba Completo

```
1. GET /login
   └─ Capturar CSRF token del formulario

2. POST /login
   └─ Usar token para autenticación
   └─ Guardar PHPSESSID en cookies

3. GET /colaboradores
   └─ Listar colaboradores (lectura)

4. GET /colaboradores/crear
   └─ Capturar nuevo CSRF token

5. POST /colaboradores/guardar
   └─ Crear colaborador CON token

6. POST /colaboradores/guardar (SIN token)
   └─ Verificar CSRF protection

7. POST /colaboradores/guardar (SQL Injection)
   └─ Verificar SQL protection

8. GET /colaboradores?q=atacante
   └─ Búsqueda con entrada maliciosa (protegida)

9. POST /vacaciones/guardar
   └─ Crear vacación CON token

10. POST /vacaciones/estado
    └─ Cambiar estado vacación CON token
```

---

## 🔐 Validación de Seguridad en Postman

### Checklist de Pruebas

#### ✅ CSRF Protection
- [ ] POST SIN token → Error
- [ ] POST CON token válido → Éxito
- [ ] POST CON token inválido → Error
- [ ] GET (lectura) → Sin token requerido

#### ✅ SQL Injection Protection
- [ ] Buscar: `%'; DROP TABLE usuarios; --` → Sin efecto
- [ ] Crear con nombre: `'); DELETE FROM *; --` → Guardado literal
- [ ] Buscar con: `1 OR 1=1` → Búsqueda normal

#### ✅ Session Management
- [ ] Nueva sesión → Nuevo token
- [ ] Token reutilizable en sesión
- [ ] Token diferente al reabrir navegador

---

## 📝 Template de Request (Copiar y Pegar)

### Template: GET
```
GET {{baseUrl}}/ENDPOINT
Accept: application/json

```

### Template: POST con CSRF
```
POST {{baseUrl}}/ENDPOINT
Content-Type: application/x-www-form-urlencoded

csrf_token=[TOKEN]&campo1=valor1&campo2=valor2
```

### Template: PUT con CSRF
```
PUT {{baseUrl}}/ENDPOINT
Content-Type: application/json
X-CSRF-Token: [TOKEN]

{
  "campo1": "valor1",
  "campo2": "valor2"
}
```

### Template: DELETE con CSRF
```
DELETE {{baseUrl}}/ENDPOINT
X-CSRF-Token: [TOKEN]

```

---

## 🎯 Pruebas Específicas del Sistema

### Prueba: Flujo Completo de Crear Colaborador

**1. Obtener token CSRF**
```
GET http://localhost/colaboradores/crear
```
Response → Buscar en HTML:
```html
<input type="hidden" name="csrf_token" value="a7f3c9e2b1d45678...">
```
Copiar: `a7f3c9e2b1d45678...`

**2. Crear colaborador con token**
```
POST http://localhost/colaboradores/guardar
Content-Type: application/x-www-form-urlencoded

csrf_token=a7f3c9e2b1d45678...&identificacion=8999999&primer_nombre=Juan&segundo_nombre=&primer_apellido=Perez&segundo_apellido=&sexo=M&fecha_nacimiento=1990-05-15&direccion=Calle+Principal&correo_personal=juan@mail.com&telefono=2345678&celular=68888888&departamento=Ventas&fecha_contratacion=2026-01-15&tipo_contrato=Indefinido&ocupacion=Vendedor&estatus=Activo
```

Expected:
```
Status: 302
Location: /colaboradores?msg=... 
```

---

## 💾 Variables de Postman

### Crear Variables Automáticas

**En Tests tab (después de GET /login):**
```javascript
// Extraer token CSRF del HTML
var html = pm.response.text();
var tokenMatch = html.match(/name="csrf_token"\s+value="([^"]+)"/);
if (tokenMatch) {
    pm.environment.set("csrf_token", tokenMatch[1]);
}

// Extraer PHPSESSID
var cookies = pm.cookies.jar;
pm.environment.set("phpsessid", cookies.get("PHPSESSID"));
```

**Usar en siguiente request:**
```
{{baseUrl}}/colaboradores/guardar
csrf_token={{csrf_token}}
```

---

## 🐛 Troubleshooting

### Problema: "Token CSRF inválido"
**Solución:**
1. Verificar que el token es de 64 caracteres
2. Verificar que la sesión está activa
3. Verificar que el token es del mismo navegador/sesión

### Problema: 302 Redirect sin guardar
**Solución:**
1. En Postman: Settings → Redirect → Enable
2. Verificar que cookies se guardan automáticamente

### Problema: SQL Injection parece funcionar
**Solución:**
1. Verificar que el dato se guarda como TEXT literal
2. Revisar logs de BD para confirmar no hay ejecución SQL
3. Confirmar que la tabla aún existe

---

**Última actualización:** 2026-07-02  
**Postman versión testada:** 11.0+  
**Sistema:** Capital Humano
