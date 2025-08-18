🏥 Sistema de Gestión de Citas Médicas
Este proyecto es una aplicación web full-stack diseñada para la administración de citas médicas, pacientes y especialidades. La aplicación cuenta con un frontend interactivo construido con HTML, Bootstrap 5 y JavaScript, y un backend robusto que expone una API RESTful, probablemente desarrollada en PHP, para gestionar los datos en una base de datos MySQL.
✨ Características Principales
Gestión de Citas:
📅 Agendamiento: Crear nuevas citas médicas.
📋 Listado: Ver todas las citas agendadas en una tabla clara y organizada.
✏️ Actualización: Modificar los detalles de una cita existente.
❌ Eliminación: Cancelar o eliminar citas del sistema.
Gestión de Pacientes:
👤 Registro: Añadir nuevos pacientes al sistema.
👥 Listado: Visualizar la lista completa de pacientes registrados.
🔄 Actualización: Editar la información de un paciente.
🗑️ Eliminación: Dar de baja a pacientes.
Gestión de Especialidades:
🩺 Creación: Registrar nuevas especialidades médicas.
📖 Listado: Ver todas las especialidades disponibles.
📝 Actualización: Cambiar el nombre de una especialidad.
⛔ Eliminación: Eliminar especialidades del sistema.
Interfaz Amigable:
🚀 Navegación Intuitiva: Barra de navegación para acceder a las diferentes secciones.
👋 Página de Bienvenida: Un portal de inicio amigable.
❓ Página 404: Manejo de rutas no encontradas para una mejor experiencia de usuario.
🛠️ Tecnologías Utilizadas
Frontend
HTML5: Estructura semántica de la aplicación.
Bootstrap 5: Framework CSS para un diseño responsive y componentes modernos.
JavaScript (ES6+): Lógica del cliente, interactividad y consumo de la API (Fetch API).
Backend
PHP (implícito): Lenguaje del lado del servidor para la lógica de la API REST.
MySQL / MariaDB: Sistema de gestión de bases de datos para el almacenamiento de datos.
Apache: Servidor web para alojar la aplicación (requerido para .htaccess).
Herramientas
Postman: Colección incluida para probar los endpoints de la API.
XAMPP (o similar): Entorno de desarrollo local que incluye Apache, PHP y MySQL.
📂 Estructura del Proyecto
El proyecto está organizado en dos carpetas principales para separar claramente las responsabilidades del frontend y el backend.
code
Code
.
├── 📄 .gitignore
├── 📁 reto-hiberus-alcampoverde-backend/
│   ├── 📄 .htaccess            # Reglas de enrutamiento y CORS para la API
│   ├── 📄 index.php            # Punto de entrada de la API (Front Controller)
│   └── 📁 ... (controller, model, repository, etc.)
│
├── 📁 reto-hiberus-alcampoverde-frontend/
│   ├── 📄 .htaccess            # Regla para la página de error 404
│   ├── 📄 404.html             # Página de "No Encontrado"
│   ├── 📄 index.html           # Página de bienvenida
│   └── 📁 pages/
│       ├── 📄 appointments.html
│       ├── 📄 patients.html
│       └── 📄 specialty.html
│
├── 📜 mediapp19.sql             # Script de la base de datos
├── 📝 Readme.md                  # Esta documentación
└── 📦 reto-tecnico-alcampoverde-hiberus.postman_collection.json
🚀 Guía de Instalación y Puesta en Marcha
Sigue estos pasos para configurar el proyecto en tu entorno de desarrollo local.
Pre-requisitos
Tener instalado un entorno de servidor local como XAMPP, WAMP o MAMP.
Un cliente de base de datos como phpMyAdmin (incluido en XAMPP) o MySQL Workbench.
Un navegador web moderno (Chrome, Firefox, etc.).
Pasos de Configuración
Clonar el Repositorio (o copiar los archivos)
Coloca las carpetas reto-hiberus-alcampoverde-frontend y reto-hiberus-alcampoverde-backend dentro del directorio htdocs de tu instalación de XAMPP.
Configurar la Base de Datos
Inicia los servicios de Apache y MySQL desde el panel de control de XAMPP.
Abre phpMyAdmin (generalmente en http://localhost/phpmyadmin).
Crea una nueva base de datos llamada mediapp19.
Selecciona la base de datos mediapp19 y ve a la pestaña Importar.
Selecciona el archivo mediapp19.sql incluido en este proyecto y ejecuta la importación.
Verificar Configuración del Servidor
Asegúrate de que el módulo mod_rewrite de Apache esté activado en tu configuración (httpd.conf). Esto es necesario para que los archivos .htaccess funcionen correctamente.
¡Listo para Usar!
Abre tu navegador y accede a la URL: http://localhost/reto-hiberus-alcampoverde-frontend/.
Serás recibido por la página de bienvenida y podrás empezar a navegar por la aplicación.
🔌 Endpoints de la API
La API RESTful se encuentra en la ruta base: http://localhost/reto-hiberus-alcampoverde-backend/. Puedes probar estos endpoints usando la colección de Postman proporcionada.
Método	Endpoint	Descripción
GET	/appointments	Obtiene una lista de todas las citas.
POST	/appointments	Crea una nueva cita.
PUT	/appointments	Actualiza una cita existente.
DELETE	/appointments/{id}	Elimina una cita por su ID.
GET	/patients	Obtiene una lista de todos los pacientes.
POST	/patients	Crea un nuevo paciente.
PUT	/patients	Actualiza un paciente existente.
DELETE	/patients/{id}	Elimina un paciente por su ID.
GET	/specialties	Obtiene una lista de todas las especialidades.
POST	/specialties	Crea una nueva especialidad.
PUT	/specialties	Actualiza una especialidad existente.
DELETE	/specialties/{id}	Elimina una especialidad por su ID.
