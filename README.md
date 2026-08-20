# Prueba App - Intranet

## 📋 Descripción General

**Prueba App** es una aplicación de intranet desarrollada con Laravel que permite a los empleados gestionar sus cuentas de usuario de forma segura. La plataforma ofrece funcionalidades básicas de CRUD (crear, leer, actualizar, eliminar) para perfiles de usuario con un sistema de autenticación integrado.

### Funcionalidades principales

- ✅ **Autenticación de usuarios**: Sistema de login seguro con validación de credenciales
- ✅ **Registro de nuevos usuarios**: Creación de cuentas en la intranet
- ✅ **Gestión de perfil**: Ver y editar información personal de la cuenta
- ✅ **Panel de intranet**: Acceso a recursos internos con autenticación
- ✅ **Eliminación de cuentas**: Opción para borrar la cuenta de usuario

---

## 🛠️ Documentación Técnica

### Requisitos Previos

- **PHP**: 8.3 o superior
- **Laravel**: 13.17
- **Node.js**: 16+ (para gestión de activos frontend)
- **Composer**: 2.0+
- **Base de datos**: SQLite (por defecto) o MySQL/PostgreSQL

### Stack Tecnológico

- **Backend**: Laravel 13.17
- **Base de datos**: SQLite
- **Frontend**: Vite + npm
- **Testing**: Pest + Mockery
- **Code Quality**: Laravel Pint
- **Herramientas de desarrollo**: Laravel Boost, Laravel Pail

### Arquitectura del Proyecto

```
prueba-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/    # PostController (gestión de usuarios)
│   │   └── Middleware/     # Middleware personalizado (intranet.auth)
│   └── Models/             # Modelos Eloquent
├── routes/
│   ├── web.php            # Rutas principales
│   ├── api.php            # Rutas API (si aplica)
│   └── console.php        # Comandos Artisan
├── resources/              # Vistas y activos frontend
├── database/
│   ├── migrations/         # Migraciones de BD
│   ├── factories/          # Factories para testing
│   └── seeders/            # Seeders para datos
├── tests/                  # Tests con Pest
├── config/                 # Configuración de la aplicación
└── public/                 # Punto de entrada web
```

### Rutas Disponibles

| Método | Ruta | Descripción | Autenticación |
|--------|------|-------------|----------------|
| GET | `/` | Página de login | No |
| GET | `/registro` | Página de registro | No |
| GET | `/intranet` | Panel principal de la intranet | Sí |
| GET | `/editar` | Página para editar perfil | Sí |

### Middleware Personalizado

- **`intranet.auth`**: Valida la autenticación del usuario para acceder a rutas protegidas

---

## 🚀 Instalación y Configuración

### 1. Clonar el repositorio

```bash
git clone <repositorio-url>
cd prueba-app
```

### 2. Instalar dependencias

```bash
composer setup
```

Este comando ejecutará automáticamente:
- Instalación de dependencias PHP
- Configuración del archivo `.env`
- Generación de clave de aplicación
- Ejecución de migraciones
- Instalación de dependencias Node.js
- Compilación de activos frontend

### 3. Ejecutar en desarrollo

```bash
composer run dev
```

Esto inicia:
- Servidor PHP (puerto 8000)
- Cola de trabajo (queue listener)
- Desarrollo de Vite (hot reload)

### 4. Acceder a la aplicación

```
http://localhost:8000
```

---

## 📖 Guía de Uso - Para Empleados

### 1. Crear una Cuenta

1. Dirígete a la página de inicio
2. Haz clic en **"Crear Cuenta"** o ve a `/registro`
3. Completa el formulario con tu información:
   - Nombre completo
   - Correo electrónico
   - Contraseña segura
4. Haz clic en **"Registrarse"**
5. Recibirás una confirmación de registro exitoso

### 2. Acceder a la Intranet

1. Dirígete a la página de inicio (`/`)
2. Inicia sesión con tu correo y contraseña
3. Accederás al **panel de intranet** (`/intranet`) con acceso a recursos internos

### 3. Editar tu Perfil

1. Desde el panel de intranet, ve a **"Editar Perfil"** (`/editar`)
2. Actualiza tu información personal:
   - Nombre
   - Correo electrónico
   - Contraseña (opcional)
3. Haz clic en **"Guardar cambios"**

### 4. Eliminar tu Cuenta

1. En la página de editar perfil, encontrarás la opción **"Eliminar Cuenta"**
2. Confirma la acción (esta acción es irreversible)
3. Tu cuenta y datos asociados serán eliminados permanentemente

---

## 🧪 Testing

### Ejecutar todos los tests

```bash
composer test
```

### Ejecutar tests específicos

```bash
php artisan test --filter=testName
```

### Ver cobertura de tests

```bash
php artisan test --coverage
```

---

## 💻 Desarrollo

### Comandos útiles

```bash
# Generar un modelo nuevo con migraciones y factory
php artisan make:model NombreModelo -mf

# Crear un controlador
php artisan make:controller NombreControlador

# Crear un middleware personalizado
php artisan make:middleware NombreMiddleware

# Listar todas las rutas
php artisan route:list

# Ejecutar migraciones
php artisan migrate

# Revertir última migración
php artisan migrate:rollback
```

### Formato de código

Para mantener consistencia en el código, ejecuta Laravel Pint:

```bash
vendor/bin/pint
```

### Debugging

Durante el desarrollo, puedes usar:

```bash
# Laravel Tinker - REPL interactivo
php artisan tinker

# Ver logs en tiempo real
php artisan pail
```

---

## 📝 Variables de Entorno

Configura el archivo `.env` con las siguientes variables importantes:

```env
APP_NAME="Prueba App"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
# DB_DATABASE=/full/path/to/database.sqlite

MAIL_DRIVER=log
```

---

## 📊 Estructura de Base de Datos

La aplicación utiliza una tabla principal de usuarios con campos como:

- `id`: Identificador único
- `name`: Nombre del usuario
- `email`: Correo electrónico (único)
- `password`: Contraseña hasheada
- `created_at`: Fecha de creación
- `updated_at`: Última actualización

---

## 🔐 Seguridad

- ✅ Las contraseñas se hashean con **bcrypt**
- ✅ Validación de entrada en todos los formularios
- ✅ Middleware `intranet.auth` protege rutas sensibles
- ✅ Protección contra CSRF en formularios
- ✅ Escapado de salida en vistas

---

## 📄 Licencia

Este proyecto está bajo licencia **MIT**. Ver archivo [LICENSE](LICENSE) para más detalles.

---

## 📞 Soporte

Para reportar problemas o sugerencias, por favor abre un issue en el repositorio de la aplicación.
