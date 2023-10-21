-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 21 2023 г., 10:55
-- Версия сервера: 5.6.51
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `quiz`
--

-- --------------------------------------------------------

--
-- Структура таблицы `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_correct` tinyint(1) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `order_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `answer_text`, `is_correct`, `created_at`, `updated_at`, `order_id`) VALUES
(105, 45, '1', 0, '2023-10-20', '2023-10-20', 0),
(106, 45, '2', 0, '2023-10-20', '2023-10-20', 0),
(107, 45, '3', 0, '2023-10-20', '2023-10-20', 0),
(108, 45, '4', 0, '2023-10-20', '2023-10-20', 0),
(114, 48, '123', 0, '2023-10-20', '2023-10-20', 0),
(115, 48, '312', 0, '2023-10-20', '2023-10-20', 0),
(116, 49, '1', 0, '2023-10-20', '2023-10-20', 0),
(117, 49, '2', 0, '2023-10-20', '2023-10-20', 0),
(118, 49, '3', 0, '2023-10-20', '2023-10-20', 0),
(122, 51, '1', 0, '2023-10-20', '2023-10-20', 0),
(123, 51, '2', 0, '2023-10-20', '2023-10-20', 0),
(124, 52, '1', 0, '2023-10-20', '2023-10-20', 0),
(125, 53, '1', 0, '2023-10-20', '2023-10-20', 0),
(126, 54, '1', 0, '2023-10-20', '2023-10-20', 0),
(127, 54, '1', 0, '2023-10-20', '2023-10-20', 0),
(128, 55, '1', 0, '2023-10-20', '2023-10-20', 0),
(129, 55, '2', 0, '2023-10-20', '2023-10-20', 0),
(130, 56, '1', 0, '2023-10-20', '2023-10-20', 0),
(131, 56, '2', 0, '2023-10-20', '2023-10-20', 0),
(132, 57, '1', 0, '2023-10-20', '2023-10-20', 0),
(133, 57, '2', 0, '2023-10-20', '2023-10-20', 0),
(134, 58, '1', 1, '2023-10-20', '2023-10-20', 0),
(135, 58, '2', 1, '2023-10-20', '2023-10-20', 0),
(136, 58, '3', 1, '2023-10-20', '2023-10-20', 0),
(137, 59, '1', 0, '2023-10-20', '2023-10-20', 0),
(138, 59, '2', 0, '2023-10-20', '2023-10-20', 0),
(139, 60, '1', 0, '2023-10-21', '2023-10-21', 0),
(140, 60, '2', 0, '2023-10-21', '2023-10-21', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2023_10_05_090432_add_unique_key_to_questions_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 2),
(4, '2023_10_11_074557_create_users_table', 3),
(5, '2023_10_11_120835_modify_surname_column_in_users_table', 4),
(6, '2023_10_12_103141_add_status_to_users_table', 5),
(7, '2023_10_13_064335_add_is_admin_to_users_table', 6),
(11, '2023_10_13_070132_add_user_id_to_questions', 7);

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `question_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `unique_key` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_anonymous` tinyint(1) NOT NULL DEFAULT '0',
  `answer_type` enum('radio','checkbox') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'radio'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `questions`
--

INSERT INTO `questions` (`id`, `user_id`, `question_text`, `created_at`, `updated_at`, `unique_key`, `is_anonymous`, `answer_type`) VALUES
(45, 9, 'Тестовый вопрос(не анон + радио)', '2023-10-20 09:27:16', '2023-10-20 09:27:16', '13b8cba0d1', 0, 'radio'),
(48, 9, 'Тестовый вопрос(не анон + чек)', '2023-10-20 09:40:52', '2023-10-20 09:42:34', 'acbbcb07d6', 0, 'checkbox'),
(49, 9, 'Тестовый вопрос(анон + радио)', '2023-10-20 09:42:51', '2023-10-20 09:42:51', '7db5e18a67', 1, 'radio'),
(51, 9, 'Тестовый вопрос(анон + чек)', '2023-10-20 09:44:14', '2023-10-20 09:44:14', 'bd6aab7cf8', 0, 'checkbox'),
(52, NULL, 'анон', '2023-10-20 09:52:50', '2023-10-20 09:52:50', '8b5e3363bf', 1, 'radio'),
(53, NULL, 'не анон', '2023-10-20 09:52:59', '2023-10-20 09:52:59', '36c6916bfd', 1, 'radio'),
(54, NULL, 'анон чек', '2023-10-20 09:59:08', '2023-10-20 09:59:08', '256f2699a0', 1, 'checkbox'),
(55, NULL, 'анон', '2023-10-20 10:11:43', '2023-10-20 10:11:43', 'a4d8db5db9', 1, 'radio'),
(56, NULL, 'не анон', '2023-10-20 10:12:44', '2023-10-20 10:12:44', 'a24411ba4d', 0, 'radio'),
(57, NULL, 'тест', '2023-10-20 10:13:12', '2023-10-20 10:13:12', 'cb76e3cc55', 1, 'radio'),
(58, 9, 'Это тест', '2023-10-20 10:34:52', '2023-10-20 10:34:52', 'f094a511d3', 0, 'radio'),
(59, 14, '123', '2023-10-20 10:43:16', '2023-10-20 10:43:16', '403da30b27', 0, 'radio'),
(60, NULL, '1', '2023-10-21 07:12:13', '2023-10-21 07:12:13', '9e8f4d82b4', 0, 'radio');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','enabled','disabled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `company_name`, `phone`, `email`, `password`, `created_at`, `updated_at`, `status`, `is_admin`) VALUES
(9, 'admin', 'Rustamov', 'Arassa Nusga', '993649274222', 'test@mail.ru', '$2y$10$vvyH9YOJ/Z6qrkKsQjXb8.XR6VLQvWlUvcjrVrQeVbXAK6BVRjAZm', '2023-10-12 07:58:44', '2023-10-20 06:20:53', 'enabled', 1),
(12, 'Anonym', 'Anonym', 'Anonym', '123456789', 'anonym@mail.ru', '$2y$10$Fj6fm5C7q0QqeuainMkG2e/bYi27SjR3LUcFeIDK1wPxt9baz9GkS', '2023-10-18 06:39:20', '2023-10-18 06:39:36', 'enabled', 0),
(13, 'emil123', NULL, NULL, NULL, NULL, '$2y$10$msMqzp2NCIOQ51.mEmKm.eWzJi.7wjZLAEn2G3gYxfacx.OZowdqO', '2023-10-20 07:28:22', '2023-10-20 07:28:22', 'pending', 0),
(14, 'alex', NULL, NULL, NULL, NULL, '$2y$10$//.dEDy/KJY9zHRjfm27hu942RFOvsbOUnU2XeVTrfXfumqonetKe', '2023-10-20 07:35:52', '2023-10-20 07:35:52', 'pending', 0),
(15, 'Эмиль', NULL, NULL, NULL, NULL, '$2y$10$R7wjC7uVBu/V7nFg0dsT9uEYAh4DflY4l5VbS3K13CrIKxktFXhfq', '2023-10-21 04:43:50', '2023-10-21 04:43:50', 'pending', 0),
(16, 'Исмаил', NULL, NULL, NULL, NULL, '$2y$10$yIcZfJu1SAIBpWqhn6iGiu1HoAVBDE9jq/9DXQi.SwddyqiJmftS2', '2023-10-21 04:53:09', '2023-10-21 04:53:09', 'pending', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `user_answers`
--

CREATE TABLE `user_answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `answer_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_answers`
--

INSERT INTO `user_answers` (`id`, `user_id`, `question_id`, `answer_id`, `created_at`, `updated_at`) VALUES
(1, 9, 23, 64, '2023-10-12 09:04:35', '2023-10-12 09:04:35'),
(2, 9, 23, 62, '2023-10-12 09:09:59', '2023-10-12 09:09:59'),
(3, 9, 23, 63, '2023-10-12 09:09:59', '2023-10-12 09:09:59'),
(4, 9, 22, 58, '2023-10-12 09:58:46', '2023-10-12 09:58:46'),
(5, 9, 22, 56, '2023-10-12 09:58:48', '2023-10-12 09:58:48'),
(6, 9, 22, 59, '2023-10-12 09:58:50', '2023-10-12 09:58:50'),
(7, 9, 22, 57, '2023-10-12 09:58:52', '2023-10-12 09:58:52'),
(8, 9, 22, 56, '2023-10-12 09:58:53', '2023-10-12 09:58:53'),
(9, 10, 24, 68, '2023-10-13 01:13:46', '2023-10-13 01:13:46'),
(10, 11, 25, 70, '2023-10-13 01:56:19', '2023-10-13 01:56:19'),
(11, 11, 25, 72, '2023-10-13 01:56:19', '2023-10-13 01:56:19'),
(12, 11, 25, 69, '2023-10-13 02:56:34', '2023-10-13 02:56:34'),
(13, 11, 25, 72, '2023-10-13 02:56:34', '2023-10-13 02:56:34'),
(14, 11, 33, 80, '2023-10-13 08:36:05', '2023-10-13 08:36:05'),
(15, 9, 36, 87, '2023-10-13 09:45:04', '2023-10-13 09:45:04'),
(16, 9, 36, 88, '2023-10-13 09:45:05', '2023-10-13 09:45:05'),
(17, 9, 36, 87, '2023-10-16 05:24:37', '2023-10-16 05:24:37'),
(18, 9, 38, 91, '2023-10-18 04:32:42', '2023-10-18 04:32:42'),
(19, 9, 38, 92, '2023-10-18 04:32:42', '2023-10-18 04:32:42'),
(20, 9, 37, 89, '2023-10-18 04:33:18', '2023-10-18 04:33:18'),
(21, 9, 37, 90, '2023-10-18 04:33:18', '2023-10-18 04:33:18'),
(22, 9, 37, 90, '2023-10-18 04:42:45', '2023-10-18 04:42:45'),
(23, 9, 39, 93, '2023-10-18 04:44:27', '2023-10-18 04:44:27'),
(24, 12, 44, 104, '2023-10-20 04:50:19', '2023-10-20 04:50:19'),
(25, 12, 44, 103, '2023-10-20 04:54:30', '2023-10-20 04:54:30'),
(26, 12, 43, 102, '2023-10-20 04:55:09', '2023-10-20 04:55:09'),
(27, 12, 57, 132, '2023-10-20 07:13:28', '2023-10-20 07:13:28'),
(28, 13, 56, 130, '2023-10-20 07:28:22', '2023-10-20 07:28:22'),
(29, 14, 45, 107, '2023-10-20 07:35:52', '2023-10-20 07:35:52'),
(30, 12, 57, 133, '2023-10-21 04:34:50', '2023-10-21 04:34:50'),
(31, 15, 60, 139, '2023-10-21 04:43:50', '2023-10-21 04:43:50'),
(32, 15, 60, 140, '2023-10-21 04:43:57', '2023-10-21 04:43:57'),
(33, 16, 60, 139, '2023-10-21 04:53:22', '2023-10-21 04:53:22');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Индексы таблицы `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `questions_unique_key_unique` (`unique_key`),
  ADD KEY `questions_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Индексы таблицы `user_answers`
--
ALTER TABLE `user_answers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `user_answers`
--
ALTER TABLE `user_answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
