-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Июн 21 2019 г., 16:56
-- Версия сервера: 5.6.42
-- Версия PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cd-collection-1`
--

-- --------------------------------------------------------

--
-- Структура таблицы `albums`
--

CREATE TABLE `albums` (
  `id` int(10) UNSIGNED NOT NULL,
  `collection_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `image` varchar(60) DEFAULT NULL,
  `artist` varchar(60) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `duration` varchar(3) NOT NULL DEFAULT '0',
  `payed_date` datetime DEFAULT NULL,
  `payed_sum` float DEFAULT '0',
  `store_key` varchar(60) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0'
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP,
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `albums`
--

INSERT INTO `albums` (`id`, `collection_id`, `name`, `image`, `artist`, `year`, `duration`, `payed_date`, `payed_sum`, `store_key`, `create_time`, `deleted`) VALUES
(1, 1, 'test album 1', NULL, NULL, NULL, '0', NULL, 0, NULL, '2019-06-21 19:29:48', 0),
(2, 1, 'test album 2', NULL, NULL, NULL, '0', NULL, 0, NULL, '2019-06-21 19:31:12', 1),
(4, 1, 'test album 3', NULL, NULL, NULL, '0', NULL, 0, NULL, '2019-06-21 19:34:24', 0),
(5, 1, 'test album 3', NULL, NULL, NULL, '0', NULL, 0, NULL, '2019-06-21 19:43:42', 0),
(6, 1, 'test album 3', NULL, NULL, NULL, '0', NULL, 0, NULL, '2019-06-21 19:44:51', 0),
(7, 1, 'test album 3', NULL, NULL, NULL, '0', NULL, 0, NULL, '2019-06-21 19:45:04', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `collections`
--

CREATE TABLE `collections` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `collections`
--

INSERT INTO `collections` (`id`, `name`, `create_time`) VALUES
(1, 'test collection', '2019-06-21 19:19:29');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `collection_id` (`collection_id`);

--
-- Индексы таблицы `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `collections`
--
ALTER TABLE `collections`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `albums_ibfk_1` FOREIGN KEY (`collection_id`) REFERENCES `collections` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
