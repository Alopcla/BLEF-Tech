# 🦁 BLR-Zoo

Este repositorio contiene el código fuente de la aplicación integral para la gestión y experiencia del zoológico **BLR-Zoo**.

## 📋 Descripción del Proyecto

El objetivo principal de nuestro equipo es desarrollar **BLR-Zoo**, una aplicación web completa que sirva tanto para que los visitantes disfruten más del parque, como para facilitar el trabajo diario de los empleados.

Para conseguirlo, nos hemos marcado los siguientes objetivos como alumnos:
* **Crear un sistema "Todo en uno":** Centralizar las herramientas necesarias en una única plataforma.
* **Hacer una web más atractiva e interactiva:** Ofrecer una interfaz moderna y fluida para el usuario.
* **Mejorar la venta online:** Optimizar el proceso de compra de entradas y servicios.
* **Facilitar el trabajo a los empleados:** Digitalizar y agilizar las tareas operativas diarias.
* **Aplicar de forma práctica lo aprendido:** Demostrar de forma tangible los conocimientos adquiridos en el grado.

## ⚙️ Stack Tecnológico

* **Backend:** **Laravel 12** con **PHP 8.3+** (la última versión LTS compatible con Windows 10). Empleamos *Facades* para tareas ligeras que solo requieren de objetos genéricos, y *Eloquent* para tareas más pesadas que requieren instancias de clase.
* **Frontend:** Interfaz construida con **React 19.2+**, **Blade** y **Tailwindcss 3.4+**. Para las peticiones HTTP utilizamos **Axios**, todo empaquetado con **Vite 7.3** funcionando sobre **NODE-v24.14**.
* **Servicios Integrados:** Integración de **Stripe** para la pasarela de pagos y **Mailable / DomPDF** para el envío de entradas en PDF vía Gmail.
* **Base de Datos:** Alojamiento en la nube usando **Supabase** en **Postgres 17.6+**.

## 📝 Configuración Requerida (Local)

Para poder desplegar y ejecutar el proyecto en tu máquina local, es necesario contar con lo siguiente:
* PHP 8.3 o superior.
* Composer (Gestor de dependencias de PHP).
* Node.js v24.14 o superior (incluye npm).
* Git (para clonar el repositorio).
* Una cuenta en Supabase y claves de prueba de Stripe.

## 💻 Documentación Técnica: Instalación y Puesta en Marcha

A continuación, se detallan los comandos necesarios para preparar el entorno de desarrollo. Asegúrate de tener Composer descargado (desde getcomposer.org) si no lo tienes instalado globalmente.

Ejecuta los siguientes comandos en tu terminal para clonar el repositorio, instalar todas las dependencias, configurar las variables de entorno y levantar los servidores:

```bash
# Clonar el repositorio y entrar en la carpeta
git clone <URL_DEL_REPOSITORIO>
cd BLR-Zoo

# Instalación de dependencias de Backend y Frontend
composer install
npm install

# Configurar las variables de entorno y generar la clave de Laravel
cp .env.example .env
php artisan key:generate

# NOTA: Antes de continuar, abre el archivo .env y rellena tus credenciales de Supabase, Stripe y correo.

# Iniciar los servidores de desarrollo (abre dos terminales)
# Terminal 1:
php artisan serve

# Terminal 2:
npm run dev
