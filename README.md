# 🖥️ Siste de gestión comercial - Electronica Arielito.

Este proyecto corresponde al sistema registro y gestion de la empresa Electronica Arielito, desarrollado como parte del proyecto final de grado.

El sistema permite administrar los registros de inventario, compra, ventas, clientes, metricas, facturaciín etc, dando un salto de calidad al negocio
permitiendo controlar los movimientos tanto de stock como monetarios del mismo.

---

## 🚀 Tecnologías Utilizadas
- **Fronted**
- **Nuxt.js 2 (Vue 2.7.x)**
- **Vuex** (soporte activado automáticamente)
- **Axios** (con instancias personalizadas: `api`)
- **SweetAlert2** – Alertas y confirmaciones
- **Font Awesome** – Íconos integrados
- **Soft UI Dashboard** (plantilla visual integrada)
- **Plugins JS externos** (Chart.js, Dropzone, Dragula, etc.)
 
- **Backend**
- **Laravel 9**
- **PHP 8.0+**
- **Laravel Sanctum** – Autenticación vía tokens
- **DOMPDF** – Generación de PDF (comprobantes, facturas, etc.)
- **Guzzle HTTP** – Cliente HTTP para integraciones externas
- **Vite** – Bundler moderno para recursos JS/CSS
- **MySQL** – Base de datos principal
---

```plaintext
📁 Estructura del proyecto/
├── frontend/ # Cliente web - Nuxt.js (Vue 2)
│ ├── assets/ # Archivos estáticos (CSS, fuentes, imágenes)
│ ├── components/ # Componentes Vue reutilizables
│ ├── layouts/ # Layouts generales (dashboard, login, etc.)
│ ├── pages/ # Rutas de la app
│ ├── plugins/ # Axios personalizado (api.js, printer.js)
│ ├── static/ # Archivos públicos (favicon, imágenes)
│ ├── store/ # Vuex store (activación automática)
│ ├── models/ # Tipos, DTOs y respuestas de API
│ ├── config/ # Configuraciones generales
│ ├── routes/ # Definición de rutas (si aplica)
│ ├── nuxt.config.js # Configuración principal de Nuxt
│ └── package.json # Dependencias del frontend
│
├── backend/ # Servidor - Laravel 9 (API REST)
│ ├── app/ # Modelos, Controladores, Providers
│ ├── bootstrap/ # Archivos de arranque
│ ├── config/ # Configuraciones de Laravel
│ ├── database/ # Migraciones, Seeders y Factories
│ ├── public/ # Punto de entrada para servidor web
│ ├── resources/ # Vistas Blade (si se usan)
│ ├── routes/ # api.php (API) y web.php (opcional)
│ ├── storage/ # Logs, caché, archivos temporales
│ ├── tests/ # Pruebas automatizadas
│ ├── .env # Variables de entorno
│ ├── artisan # CLI de Laravel
│ ├── composer.json # Dependencias PHP
│ ├── package.json # Scripts JS y Vite (si se usa)
│ └── vite.config.js # Configuración de Vite para Laravel
```
## 📦 Instalación Frontend

1. **Clonar el repositorio**:
   ```bash
   git clone https://github.com/tuUsuario/
   Proyecto---II.git
2. **Instalar las dependencias:**:
   ```bash
   npm install
3. **Iniciar entorno de desarrollo:**:
   ```bash
   npm run dev
4. **Acceder desde el navegador:**:
   ```bash
   http://localhost:3000
5. **El backend debera estar corriendo localmente:**:
   ```bash
   [http://localhost:3000](http://localhost/Proyecto2/api_titular/public/api/ (ajustable en el plugin api.js))

## 📦 Instalación Backend
1. **Instalá las dependencias PHP:**:
   ```bash
   composer install
2. **IInstalá las dependencias de desarrollo**:
   ```bash
   npm install
3. **Configurá el entorno:**:
   ```bash
   cp .env.example .env
   php artisan key:generate

4. **Configurá la base de datos en el archivo .env:**:
   ```bash
   DB_DATABASE="nombre de la base de datos"
   DB_USERNAME=root
   DB_PASSWORD=

5. **Ejecutá las migraciones y seeders**:
   ```bash
   php artisan migrate --seed

⚙️ Scripts Útiles
| Comando                    | Descripción                   |
| -------------------------- | ----------------------------- |
| `php artisan serve`        | Inicia servidor local         |
| `php artisan migrate`      | Aplica las migraciones        |
| `php artisan key:generate` | Genera clave de aplicación    |
| `npm run dev`              | Compila recursos con Vite     |
| `npm run build`            | Compila versión de producción |


👨‍💻 Autores

**Rene Acosta**

**Ariel Bogado**
