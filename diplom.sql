-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 15 2025 г., 22:45
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `diplom`
--

-- --------------------------------------------------------

--
-- Структура таблицы `attributes`
--

CREATE TABLE `attributes` (
  `ID` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `attributes`
--

INSERT INTO `attributes` (`ID`, `name`) VALUES
(1, 'цвет'),
(2, 'размер'),
(3, 'толщина'),
(4, 'диаметр'),
(5, 'длина'),
(6, 'волна'),
(7, 'примечание'),
(8, 'грузоподъемность');

-- --------------------------------------------------------

--
-- Структура таблицы `cartitems`
--

CREATE TABLE `cartitems` (
  `ID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `cartitems`
--

INSERT INTO `cartitems` (`ID`, `user_id`, `product_id`, `quantity`) VALUES
(22, 21, 1, 12),
(23, 21, 3, 6),
(24, 21, 5, 6),
(30, 1, 14, 6),
(31, 1, 1, 6),
(32, 1, 10, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`ID`, `name`) VALUES
(1, 'Профильная труба'),
(2, 'Круглая труба'),
(3, 'Краска'),
(4, 'Профнастил'),
(5, 'Арматура'),
(6, 'Услуга'),
(7, 'Сетка'),
(8, 'Хомуты'),
(10, 'Проволока'),
(11, 'Гидроизоляция/Пароизоляция'),
(12, 'Утеплитель'),
(13, 'OSB'),
(14, 'Горячекатанный лист'),
(15, 'Уголок'),
(16, 'Кисточки/Валики'),
(17, 'Разное'),
(18, 'Крепеж'),
(19, 'Шпильки/Шайбы/Гайки');

-- --------------------------------------------------------

--
-- Структура таблицы `orderitems`
--

CREATE TABLE `orderitems` (
  `ID` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `orderitems`
--

INSERT INTO `orderitems` (`ID`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(22, 11, 1, 254, 290),
(23, 11, 3, 72, 200),
(24, 12, 1, 20, 390),
(25, 12, 3, 72, 200),
(27, 12, 10, 1, 100);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `ID` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `adress` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`ID`, `phone`, `user_id`, `total`, `created_at`, `status`, `remark`, `adress`, `active`) VALUES
(11, '+7 (918) 677-38-29', 1, 0, '2025-06-13 18:24:44', 'Создан', '', '', 1),
(12, '+7 (918) 677-38-29', 1, 0, '2025-06-13 22:18:50', 'Создан', '', '', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `productattributes`
--

CREATE TABLE `productattributes` (
  `ID` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `productattributes`
--

INSERT INTO `productattributes` (`ID`, `product_id`, `attribute_id`, `value`) VALUES
(1, 1, 2, '60x40мм'),
(2, 1, 3, '2мм'),
(3, 2, 3, '3мм'),
(4, 2, 4, '60мм'),
(56, 3, 2, '40x20мм'),
(57, 3, 3, '2мм'),
(58, 5, 2, '20x20'),
(59, 5, 3, '1.5'),
(60, 7, 5, '1.5м'),
(61, 7, 3, '0.4мм'),
(62, 7, 6, 'С-8'),
(63, 7, 1, '8017 (Коричневый)'),
(64, 8, 4, '10мм'),
(65, 8, 5, '11.7м'),
(66, 2, 5, '12м'),
(67, 3, 5, '6м'),
(68, 1, 5, '6м'),
(69, 5, 5, '6м'),
(70, 9, 4, '12мм'),
(71, 9, 5, '11.7м'),
(72, 10, 7, 'Расчитывается менеджером'),
(73, 11, 7, 'Требуется залог'),
(75, 13, 1, 'цинк'),
(78, 13, 3, '0.5мм'),
(79, 13, 5, '6м'),
(80, 13, 6, 'C-21'),
(81, 14, 2, '3x2м'),
(82, 14, 3, '3мм'),
(83, 15, 8, '8 тонн'),
(84, 15, 7, 'Рассчитывается менеджером '),
(85, 16, 3, '1.2мм'),
(86, 17, 3, '2мм'),
(87, 18, 2, '5,5x19мм'),
(88, 18, 1, '7024(Серый графит)');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `ID` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `price` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `price_for` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`ID`, `category_id`, `name`, `price`, `amount`, `description`, `img`, `price_for`) VALUES
(1, 1, 'Труба 60x40 ГОСТ', 390, 200, '', 'img/60x40x2.jpg', 'метр'),
(2, 2, 'Круглая труба', 450, 120, '', 'img/krug60.jpeg', 'метр'),
(3, 1, 'Труба 40x20 ГОСТ', 200, 200, '', 'img/40 20 2too.jpg', 'метр'),
(5, 1, 'Труба 20x20 1.5', 190, 0, '', 'img/prod_684c294dd5ce38.55545639.jpg', 'метр'),
(7, 4, 'Профнастил С-8 8017 0.4 1.5x1.051', 600, 200, '', 'img/c8-8017.jpg', 'м2'),
(8, 5, 'Арматура 10 ГОСТ', 70, 0, '', 'img/arm10.jpeg', 'метр'),
(9, 5, 'Арматура 12 ГОСТ', 85, 1000, '', 'img/arm12.jpg', 'метр'),
(10, 6, 'Резка под заказ', 100, 0, 'Применяется к заказам с большим количеством резки', 'img/services.jpg', 'за услугу'),
(11, 6, 'Аренда отбойного молотка', 1000, 0, '', 'img/molotok.jpg', 'день'),
(13, 4, 'Профнастил С21 6м оцинкованный 0,5мм', 200, 0, '', 'img/prod_684ea3566521c3.87674848.jpg', 'м2'),
(14, 7, 'Сетка 150x150 3 ГОСТ', 130, 0, '', 'img/prod_684eccb0949042.60274907.jpg', 'м2'),
(15, 6, 'Доставка манипулятором', 2000, 0, '', 'img/prod_684f22ce3d9e33.28557769.jpg', 'доставка'),
(16, 10, 'Вязальная проволока 1.2мм', 190, 0, '', 'img/prod_684f24979a5855.96476658.jpg', 'кг'),
(17, 10, 'Вязальная проволока 2мм', 220, 0, '', 'img/prod_684f25bdc79b42.25689989.jpg', 'кг'),
(18, 18, 'Саморезы кровельные 5,5x19 7024 250шт.', 600, 0, '', 'img/prod_684f2f1f11c040.79162093.jpg', 'упаковка');

-- --------------------------------------------------------

--
-- Структура таблицы `services`
--

CREATE TABLE `services` (
  `ID` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(60) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `userlogs`
--

CREATE TABLE `userlogs` (
  `ID` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `userlogs`
--

INSERT INTO `userlogs` (`ID`, `action`, `log_time`, `user_id`) VALUES
(1, 'зарегистрирован новый пользователь', '2025-05-17 14:07:17', 13),
(9, 'Удален пользователь', '2025-05-19 18:43:18', 20),
(38, 'зарегистрирован новый пользователь', '2025-05-23 20:26:22', 19),
(39, 'авторизован пользователь', '2025-05-23 20:26:28', 19),
(42, 'авторизован пользователь', '2025-05-23 20:44:45', 19),
(45, 'авторизован пользователь', '2025-05-23 21:08:33', 1),
(48, 'авторизован пользователь', '2025-05-23 21:13:53', 19),
(51, 'авторизован пользователь', '2025-05-25 15:20:16', 1),
(54, 'авторизован пользователь', '2025-05-25 15:32:41', 1),
(55, 'авторизован пользователь', '2025-05-25 15:53:32', 1),
(57, 'авторизован пользователь', '2025-05-25 16:15:24', 1),
(59, 'авторизован пользователь', '2025-05-25 16:17:19', 1),
(61, 'авторизован пользователь', '2025-05-25 18:03:51', 1),
(70, 'авторизован пользователь', '2025-06-01 10:17:21', 1),
(71, 'авторизован пользователь', '2025-06-01 15:21:23', 1),
(72, 'авторизован пользователь', '2025-06-02 20:48:03', 1),
(73, 'авторизован пользователь', '2025-06-06 09:29:14', 1),
(74, 'авторизован пользователь', '2025-06-06 16:00:32', 1),
(76, 'авторизован пользователь', '2025-06-07 07:04:55', 1),
(77, 'авторизован пользователь', '2025-06-08 17:04:24', 1),
(78, 'авторизован пользователь', '2025-06-08 18:22:41', 1),
(79, 'авторизован пользователь', '2025-06-08 18:23:10', 1),
(80, 'авторизован пользователь', '2025-06-08 18:37:16', 1),
(81, 'авторизован пользователь', '2025-06-09 13:51:41', 1),
(82, 'авторизован пользователь', '2025-06-10 10:18:31', 1),
(83, 'авторизован пользователь', '2025-06-10 10:19:51', 1),
(84, 'авторизован пользователь', '2025-06-10 10:28:08', 1),
(85, 'авторизован пользователь', '2025-06-11 09:22:14', 1),
(86, 'авторизован пользователь', '2025-06-12 07:34:11', 1),
(87, 'авторизован пользователь', '2025-06-12 16:20:27', 1),
(88, 'авторизован пользователь', '2025-06-13 12:40:18', 1),
(89, 'зарегистрирован новый пользователь', '2025-06-13 13:44:12', 21),
(90, 'авторизован пользователь', '2025-06-13 13:44:33', 21),
(91, 'авторизован пользователь', '2025-06-13 13:48:03', 1),
(92, 'авторизован пользователь', '2025-06-14 16:48:36', 1),
(93, 'зарегистрирован новый пользователь', '2025-06-14 21:38:56', 22),
(94, 'авторизован пользователь', '2025-06-14 21:39:06', 22),
(95, 'авторизован пользователь', '2025-06-15 09:15:06', 1),
(96, 'авторизован пользователь', '2025-06-15 17:34:47', 1),
(97, 'авторизован пользователь', '2025-06-15 19:36:38', 1),
(98, 'зарегистрирован новый пользователь', '2025-06-15 19:37:09', 23),
(99, 'авторизован пользователь', '2025-06-15 19:37:39', 23),
(100, 'авторизован пользователь', '2025-06-15 20:35:19', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `name` varchar(16) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` varchar(30) NOT NULL DEFAULT 'user',
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`ID`, `name`, `password_hash`, `role`, `remember_token`) VALUES
(1, 'admin', '$2y$10$VlbmSdManuqvFCYsPZtuVOP0QubI8TJWcGERSfvK89U8qHAR0y2YC', 'admin', '9f11fed16564ce73c6a32a74c2ca63ee80ccabbe578a8bc1ea55740c45623d8c'),
(2, 'balabol', '$2y$10$mOpmyKBxuvuFm1UlFcydo.Lqpgd.Wa13NtA5cedCOEgDN9JDmTxOq', 'user', NULL),
(13, 'test', '$2y$10$q41BTXG1yzYXTX3ddYEwSOu9ku6EINyuL9jegb59DLQ/U4dil9hAG', 'user', NULL),
(19, 'lol', '$2y$10$8tYSoyhMCJyKwSUho0.V.OygqnuP3OOLzIlGLT0yq9G6yKryYK3XS', 'user', 'e3f98a914c8e029cdc75319cfb5bac92ec54bd51a2bddfc43243425dbd34ec41'),
(20, 'я какал', '$2y$10$ddpyJReo.YQElU.Jx6YFOuq7xyOqQ1zKkXYMFFlSTzotWUyn83/ly', 'user', NULL),
(21, 'kolor', '$2y$10$h5qzK.WMhKw.VESqaxXtQOIwxSVs5qeGqO5MtkbZ287/A2kCwnr/S', 'user', '503f53542badd0b885b9a38e0629daba7517b98ec871e0d9a49d12b62c793216'),
(22, 'baklan', '$2y$10$GiUcd/ZZ9uZGg9EoWR7yyutuMba/5BFkicBBVpvKRbPuF.raCe4q2', 'user', '7a3f8ee692bf18bc6c53564520ccdc39ad017ee9d8e703d6fc4f0814b35193c3'),
(23, 'diplom', '$2y$10$hqhoBDaSyp8qwozuODoIXeCB7qR9PC2SmuO4.uyvZ4rK5dJa2RSvm', 'admin', '9f0486cdf9626b4607d100c8c3c4ed8c8629ccf5823ac6c4a9de25544afae0f2');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `cartitems`
--
ALTER TABLE `cartitems`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `orderitems_ibfk_2` (`order_id`),
  ADD KEY `orderitems_ibfk_3` (`product_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `productattributes`
--
ALTER TABLE `productattributes`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `attribute_id` (`attribute_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `userlogs`
--
ALTER TABLE `userlogs`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `attributes`
--
ALTER TABLE `attributes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `cartitems`
--
ALTER TABLE `cartitems`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `productattributes`
--
ALTER TABLE `productattributes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `services`
--
ALTER TABLE `services`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `userlogs`
--
ALTER TABLE `userlogs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cartitems`
--
ALTER TABLE `cartitems`
  ADD CONSTRAINT `cartitems_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`ID`),
  ADD CONSTRAINT `cartitems_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`);

--
-- Ограничения внешнего ключа таблицы `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `orderitems_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `orderitems_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `products` (`ID`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`);

--
-- Ограничения внешнего ключа таблицы `productattributes`
--
ALTER TABLE `productattributes`
  ADD CONSTRAINT `productattributes_ibfk_1` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`ID`),
  ADD CONSTRAINT `productattributes_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`ID`);

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`ID`);

--
-- Ограничения внешнего ключа таблицы `userlogs`
--
ALTER TABLE `userlogs`
  ADD CONSTRAINT `userlogs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
