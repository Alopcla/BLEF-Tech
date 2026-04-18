-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-02-2026 a las 19:37:59
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `zoologic`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `DNI` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `employees`
--

INSERT INTO `employees` (`id`, `DNI`, `name`, `surname`, `birth_date`, `email`, `address`, `province`, `created_at`, `updated_at`) VALUES
(1, '40030592y', 'Kale', 'Schroeder', '1977-04-13', 'josiane62@example.net', '40635 Hamill Forge', 'Arizona', '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(2, '79862532p', 'Eveline', 'Mueller', '1968-07-07', 'ecarter@example.com', '61996 Ruben Row', 'Florida', '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(3, '32126506c', 'Giles', 'Ward', '1979-07-17', 'keira07@example.net', '19597 Friedrich Underpass Suite 392', 'Texas', '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(4, '56208169e', 'Hazel', 'Brekke', '2002-05-05', 'willa96@example.net', '30419 Coby Square', 'Mississippi', '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(5, '36377186r', 'Kirk', 'Keebler', '1971-05-20', 'zgoldner@example.net', '582 Dibbert Plaza Suite 057', 'Louisiana', '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(6, '19203600l', 'Athena', 'Oberbrunner', '1992-08-21', 'leilani.pollich@example.org', '6993 Adelia Prairie Suite 315', 'Oregon', '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(7, '89317976s', 'Mittie', 'Harvey', '1970-01-23', 'hsporer@example.com', '642 Lavinia Station Suite 274', 'New York', '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(8, '92274557x', 'Aurelio', 'Bahringer', '1993-02-18', 'weber.christine@example.net', '1100 Macejkovic Curve Suite 330', 'Pennsylvania', '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(9, '90062338b', 'Odessa', 'Treutel', '2006-04-05', 'peyton70@example.net', '238 Stephany Heights Apt. 123', 'Montana', '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(10, '14441772z', 'Marley', 'Kemmer', '1999-04-12', 'lenny.kris@example.net', '290 Gottlieb Village Apt. 027', 'Washington', '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(13, '12345678A', 'Alejandro', 'López Claro', '1994-01-16', 'hola@html.com', 'Calle Oliva, 23', 'Sevilla', '2026-02-05 17:03:57', '2026-02-05 17:03:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `employee_telephones`
--

CREATE TABLE `employee_telephones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `number` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `employee_telephones`
--

INSERT INTO `employee_telephones` (`id`, `employee_id`, `number`, `order`, `created_at`, `updated_at`) VALUES
(1, 1, '934-628-0486', 1, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(2, 1, '+1 (302) 902-2469', 2, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(3, 1, '+1-364-370-0872', 3, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(4, 2, '520-916-2856', 1, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(5, 2, '1-513-352-5599', 2, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(6, 2, '878-920-7409', 3, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(7, 3, '+1-279-715-8897', 1, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(8, 3, '(352) 674-5514', 2, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(9, 3, '872.821.3795', 3, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(10, 4, '+13474318381', 1, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(11, 4, '+12179784550', 2, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(12, 4, '+1 (765) 645-4167', 3, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(13, 5, '628-659-8665', 1, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(14, 5, '+1-520-459-2615', 2, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(15, 5, '(669) 712-7013', 3, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(16, 6, '+1.725.400.0352', 1, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(17, 6, '(319) 960-2079', 2, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(18, 6, '+1.435.526.5165', 3, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(19, 7, '531-961-9221', 1, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(20, 7, '1-571-346-7954', 2, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(21, 7, '1-660-815-2036', 3, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(22, 8, '1-386-955-7484', 1, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(23, 8, '765.453.2730', 2, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(24, 8, '1-220-257-3627', 3, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(25, 9, '+1-517-937-4420', 1, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(26, 9, '+1-931-632-5092', 2, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(27, 9, '361.767.3165', 3, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(28, 10, '+1 (609) 753-9445', 1, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(29, 10, '(269) 750-6497', 2, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(30, 10, '661-460-0309', 3, '2026-02-05 16:32:52', '2026-02-05 16:32:52'),
(31, 13, '123456789', 1, '2026-02-05 17:03:57', '2026-02-05 17:03:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_30_113407_create_employees_table', 1),
(5, '2026_01_30_113701_create_employee_telephones_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens_employees`
--

CREATE TABLE `password_reset_tokens_employees` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('wyJ9fGHIhgyV0Xg1GVMIuJ1ZMGGHD0EDQFz5Ktti', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidGxVcmZuZE9wcUNaVXMxOG45Z1htR1RheDRLSVhlWE5zYkVEUmt0TCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wcnVlYmEiO3M6NToicm91dGUiO3M6MTU6ImVtcGxveWVlcy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1770314638);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions_employees`
--

CREATE TABLE `sessions_employees` (
  `id` varchar(255) NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indices de la tabla `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_dni_unique` (`DNI`),
  ADD UNIQUE KEY `employees_email_unique` (`email`);

--
-- Indices de la tabla `employee_telephones`
--
ALTER TABLE `employee_telephones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_telephones_employee_id_order_unique` (`employee_id`,`order`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `password_reset_tokens_employees`
--
ALTER TABLE `password_reset_tokens_employees`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `sessions_employees`
--
ALTER TABLE `sessions_employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_employees_employee_id_foreign` (`employee_id`),
  ADD KEY `sessions_employees_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `employee_telephones`
--
ALTER TABLE `employee_telephones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `employee_telephones`
--
ALTER TABLE `employee_telephones`
  ADD CONSTRAINT `employee_telephones_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sessions_employees`
--
ALTER TABLE `sessions_employees`
  ADD CONSTRAINT `sessions_employees_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
