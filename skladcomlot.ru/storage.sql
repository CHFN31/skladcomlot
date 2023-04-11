-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 07 2023 г., 01:23
-- Версия сервера: 8.0.30
-- Версия PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `storage`
--

-- --------------------------------------------------------

--
-- Структура таблицы `calls`
--

CREATE TABLE `calls` (
  `id` int UNSIGNED NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `calls`
--

INSERT INTO `calls` (`id`, `phone`, `created_at`) VALUES
(13, '+7(951) 154-93-97', '2023-03-21 16:50:47'),
(14, '+7(904) 233-21-22', '2023-03-21 16:54:52'),
(15, '+7(139) 232-12-12', '2023-03-21 16:55:40'),
(16, '+7 (139) 232-12-12', '2023-03-21 16:56:43'),
(17, '+7 (951) 154-94-97', '2023-03-21 16:57:29'),
(18, '+7 (951) 154-93-97', '2023-03-21 16:58:33'),
(19, '+7(951) 154-94-39', '2023-03-24 11:14:56');

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `text`, `created_at`, `phone`) VALUES
(1, 'Иванников Дмитрий Сергеевич', 'dima.ivannikov2004@mail.ru', 'Привет! Это проверка', '2023-03-03 18:58:20', ''),
(2, 'Артём', 'pol777edjkomb@gmail.com', 'Привет! Это проверка', '2023-03-03 23:01:37', ''),
(3, 'Иванников Дмитрий Сергеевич', 'dima.ivannikov2004@mail.ru', 'Привет! Это проверка', '2023-03-04 00:22:19', '+7 (951) 154-93-97'),
(4, 'Иванников Дмитрий Сергеевич', 'dima.ivannikov2004@mail.ru', 'Привет! Это проверка', '2023-03-06 19:30:23', '+7 (951) 154-93-97'),
(5, 'CRZYMNE', 'pol777edjkomb@gmail.com', 'Привет! Это проверка', '2023-03-06 19:31:45', '+7 (951) 154-93-97'),
(6, 'CrazyMine', 'i.n.irina@mail.ru', 'Привет! Это проверка', '2023-03-06 19:32:47', '+7 (139) 232-12-12'),
(7, 'dimaiv_', 'pol777edjkomb@gmail.com', 'Привет! Это проверка', '2023-03-06 20:19:10', '+7 (139) 232-12-12');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int UNSIGNED NOT NULL,
  `product_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `days_in_stock` int NOT NULL,
  `days_left` int NOT NULL,
  `sales_per_day` int NOT NULL,
  `purchase_plan` decimal(10,2) NOT NULL,
  `status` enum('есть в наличии','нет в наличии') COLLATE utf8mb4_unicode_ci DEFAULT 'есть в наличии',
  `date_added` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `product_name`, `quantity`, `price`, `days_in_stock`, `days_left`, `sales_per_day`, `purchase_plan`, `status`, `date_added`) VALUES
(1, 'Клавиатура', 80, '2500.00', 45, 10, 6, '15000.00', 'есть в наличии', '2023-03-28 12:42:21'),
(2, 'Мышь', 75, '1000.00', 60, 10, 5, '5000.00', 'есть в наличии', '2023-03-28 12:42:21'),
(4, 'Ноутбук', 15, '50000.00', 120, 30, 1, '50000.00', 'есть в наличии', '2023-03-28 12:42:21'),
(5, 'Смартфон', 30, '25000.00', 60, 10, 3, '75000.00', 'есть в наличии', '2023-03-28 12:42:21'),
(6, 'Наушники', 100, '1500.00', 90, 25, 4, '6000.00', 'есть в наличии', '2023-03-28 12:42:21'),
(7, 'Чехол для ноутбука', 25, '1000.00', 120, 40, 1, '120.00', 'есть в наличии', '2023-03-28 12:42:21'),
(8, 'Чехол для смартфона', 50, '500.00', 60, 5, 7, '3500.00', 'есть в наличии', '2023-03-28 12:42:21'),
(9, 'USB флешка', 200, '500.00', 180, 90, 2, '1000.00', 'есть в наличии', '2023-03-28 12:42:21'),
(10, 'Жесткий диск', 41, '4000.00', 120, 50, 1, '4000.00', 'есть в наличии', '2023-03-28 12:42:21'),
(11, 'Процессор', 5, '20000.00', 90, 40, 1, '20000.00', 'есть в наличии', '2023-03-28 12:42:21'),
(12, 'Материнская плата', 10, '8000.00', 120, 20, 2, '16000.00', 'есть в наличии', '2023-03-28 12:42:21'),
(13, 'Оперативная память', 50, '5000.00', 90, 30, 2, '10000.00', 'есть в наличии', '2023-03-28 12:42:21'),
(14, 'Видеокарта', 3, '25000.00', 60, 5, 1, '25000.00', 'есть в наличии', '2023-03-28 12:42:21'),
(15, 'Блок питания', 20, '3000.00', 90, 25, 1, '3000.00', 'есть в наличии', '2023-03-28 12:42:21'),
(16, 'Корпус для ПК', 15, '4000.00', 120, 40, 1, '4000.00', 'есть в наличии', '2023-03-28 12:42:21'),
(17, 'Комплект проводной мыши и клавиатуры', 25, '1500.00', 90, 20, 2, '3000.00', 'есть в наличии', '2023-03-28 12:42:21'),
(18, 'Комплект беспроводной мыши и клавиатуры', 10, '3000.00', 60, 10, 1, '3000.00', 'есть в наличии', '2023-03-28 12:42:21'),
(19, 'Акустическая система', 10, '5000.00', 120, 70, 1, '5000.00', 'есть в наличии', '2023-03-28 12:42:21'),
(20, 'Наушники с шумоподавлением', 50, '5000.00', 30, 15, 2, '10000.00', 'есть в наличии', '2023-03-28 12:42:21');

--
-- Триггеры `products`
--
DELIMITER $$
CREATE TRIGGER `update_days_left` BEFORE UPDATE ON `products` FOR EACH ROW SET NEW.days_left = DATEDIFF(NOW(), NEW.date_added)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `last_name` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `first_name` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `patronymic` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `login` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `password` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `last_name`, `first_name`, `patronymic`, `login`, `password`) VALUES
(1, '', '', '', 'admin', 'admin11'),
(2, 'Иванников', 'Дмитрий', 'Сергеевич', 'ivannikovdmitsergeev', 'L7zk8931'),
(7, 'Сидякин', 'Даниил', 'Евгеньевич', 'sydyakindaniilevgeneevich', 'D7sd3131');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `calls`
--
ALTER TABLE `calls`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `calls`
--
ALTER TABLE `calls`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
