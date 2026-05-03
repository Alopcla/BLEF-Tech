<div align="center">
  <img src="LOGO.jpg" alt="Logo de BLR-Zoo" width="350">
</div>

# BLR-Zoo

Este repositorio contiene la aplicación integral desarrollada para la gestión operativa y la mejora de la experiencia de usuario del zoológico **BLR-Zoo**.

## Descripción del Proyecto

El objetivo principal de nuestro equipo es desarrollar **BLR-Zoo**, una aplicación web completa y profesional que sirva tanto para que los visitantes disfruten más de su estancia en el parque, como para facilitar y optimizar el flujo de trabajo diario de todos los empleados.

Para alcanzar este estándar de calidad, el proyecto se ha diseñado bajo los siguientes objetivos estratégicos:

* **Crear un sistema "Todo en uno":** Centralizar todas las funciones administrativas, de venta y de gestión en una sola plataforma, evitando el uso de herramientas fragmentadas.
* **Hacer una web más atractiva e interactiva:** Implementar una interfaz moderna y dinámica que mejore el engagement del visitante.
* **Mejorar la venta online:** Optimizar la pasarela de pagos y la distribución de entradas para agilizar el acceso al recinto.
* **Facilitar el trabajo a los empleados:** Desarrollar herramientas digitales que simplifiquen tareas complejas y mejoren la comunicación interna.
* **Aplicar de forma práctica lo aprendido en el grado:** Consolidar y demostrar los conocimientos técnicos en arquitectura de software, bases de datos y desarrollo Full-Stack.

## Stack Tecnológico

El proyecto utiliza un stack de última generación para garantizar rendimiento y escalabilidad:

* **Backend:** **Laravel 12** sobre **PHP 8.3+** (LTS compatible con Windows 10). Se utilizan *Facades* para tareas ligeras que requieren objetos genéricos y *Eloquent ORM* para la lógica de negocio pesada, relaciones complejas y persistencia de datos.
* **Frontend:** Desarrollo reactivo con **React 19.2+** integrado en vistas **Blade**, utilizando **Tailwindcss 3.4+** para el diseño visual. La comunicación asíncrona se gestiona mediante **Axios** y el empaquetado de activos con **Vite 7.3** ejecutándose sobre **NODE-v24.14**.
* **Servicios e Integraciones:** Pasarela de pagos con **Stripe**, sistema de mensajería **Mailable** y generación de entradas en PDF mediante **DomPDF**, con envío automatizado a través de Gmail.
* **Base de Datos:** Infraestructura relacional en la nube con **Supabase** (Postgres 17.6+).

## Configuración Requerida

Antes de comenzar la instalación, asegúrate de cumplir con los siguientes requisitos en tu entorno local:

* Windows 10 o superior.
* PHP 8.3 o superior añadido al PATH.
* Node.js v24.14 o superior.
* Git instalado.
* Una cuenta activa en Supabase y Stripe para obtener las claves de API necesarias.

## Documentación Técnica: Instalación y Despliegue Local

Sigue paso a paso estas instrucciones para configurar el entorno de desarrollo y poner la aplicación en funcionamiento:

### 1. Instalación de Composer y Laravel Installer
Si no cuentas con las herramientas globales, ejecuta los siguientes comandos en tu terminal de PowerShell:

```powershell
# Instalar Composer (si no se tiene el instalador global de getcomposer.org)
# Verificar instalación
composer -V

# Instalar el instalador de Laravel de forma global
composer global require laravel/installer

# Verificar que el PATH incluya el directorio bin de Composer
# (Ejemplo: C:\Users\NombreUsuario\AppData\Roaming\Composer\vendor\bin)
```

### 2. Clonación y Preparación de Dependencias
Descarga el proyecto e instala todos los paquetes necesarios para el funcionamiento de React y Laravel:

```powershell
# Clonar el repositorio
git clone <URL_DEL_REPOSITORIO>
cd BLR-Zoo

# Instalar dependencias de PHP (Laravel, DomPDF, Stripe SDK)
composer install

# Instalar dependencias de Frontend (React, Tailwind, Axios, Vite)
npm install
```

### 3. Configuración del Entorno
Configura las claves de acceso para la base de datos y los servicios externos:

```powershell
# Crear el archivo .env a partir del ejemplo
cp .env.example .env

# Generar la clave secreta de la aplicación
php artisan key:generate

# NOTA CRÍTICA: Edita el archivo .env e introduce tus credenciales:
# - Datos de conexión de Supabase (Host, Database, User, Password)
# - Stripe API Keys
# - Gmail App Password para el sistema Mailable
```

### 4. Ejecución del Proyecto
Para que la aplicación funcione correctamente, debes mantener activos dos procesos simultáneos. Abre dos terminales diferentes:

**Terminal 1 (Backend):**
```powershell
php artisan serve
```

**Terminal 2 (Frontend - Compilación en tiempo real):**
```powershell
npm run dev
```
