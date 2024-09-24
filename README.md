Proyecto Web con Laravel 11
Instalación
Este es un proyecto web desarrollado con Laravel 11. A continuación, se detallan los pasos para configurar
el entorno, crear la base de datos, ejecutar las migraciones y sembrar la base de datos con datos iniciales.
Requisitos Previos:
- PHP >= 8.2 (fundamental)
- Composer
- MySQL o cualquier otra base de datos compatible
- Redis instalado
- Nginx
- Extensiones de PHP necesarias (pueden variar según el proyecto):
 - OpenSSL
 - PDO
 - Mbstring
 - Tokenizer
 - JSON
 - Ctype
 - XML
Pasos de Instalación
1. **Clonar el repositorio**
```bash
Proyecto Web con Laravel 11
git clone https://github.com/rmalcac16/municipalidad
cd municipalidad
```
2. **Instalar las dependencias de Composer**
Ejecuta el siguiente comando para instalar todas las dependencias del proyecto:
```bash
composer update
```
3. **Configurar el archivo .env**
Copia el archivo `.env.example` y renómbralo a `.env`:
```bash
cp .env.example .env
```
Luego, ajusta las variables de entorno para conectar tu base de datos. Un ejemplo básico:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
Proyecto Web con Laravel 11
DB_PORT=3306
DB_DATABASE=municipalidad
DB_USERNAME=root
DB_PASSWORD=root
```
4. **Generar la clave de la aplicación**
Ejecuta el siguiente comando para generar la clave de la aplicación:
```bash
php artisan key:generate
```
5. **Migrar la base de datos**
Ejecuta las migraciones para crear las tablas en tu base de datos:
```bash
php artisan migrate
```
6. **Ejecutar el Seeder**
Sembrar la base de datos con datos iniciales utilizando el seeder `InitialConfigSeeder.php`:
Proyecto Web con Laravel 11
```bash
php artisan db:seed --class=InitialConfigSeeder
```
7. **Hacer link al storage**
Para que los archivos públicos puedan ser accesibles, ejecuta el siguiente comando:
```bash
php artisan storage:link
```
Servidor de Desarrollo (Opcional)
Si deseas ejecutar el servidor de desarrollo de Laravel, puedes iniciar con el siguiente comando:
```bash
php artisan serve
```
El servidor estará disponible en `http://localhost:8000`, aunque esto es opcional si utilizas Nginx para servir
la aplicación.