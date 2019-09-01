-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 02 2019 г., 01:39
-- Версия сервера: 10.3.13-MariaDB
-- Версия PHP: 7.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `timeschedule`
--

-- --------------------------------------------------------

--
-- Структура таблицы `assigned_groups`
--

CREATE TABLE `assigned_groups` (
  `id` int(11) NOT NULL,
  `worker_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `assigned_groups`
--

INSERT INTO `assigned_groups` (`id`, `worker_id`, `group_id`) VALUES
(4, 1, 1),
(1, 1, 2),
(5, 2, 1),
(10, 5, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `assigned_workers`
--

CREATE TABLE `assigned_workers` (
  `id` int(11) NOT NULL,
  `id_worker` int(11) NOT NULL,
  `id_project` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `assigned_workers`
--

INSERT INTO `assigned_workers` (`id`, `id_worker`, `id_project`) VALUES
(1, 1, 1),
(2, 4, 1),
(3, 1, 2),
(4, 7, 2),
(5, 8, 2),
(6, 5, 3),
(7, 3, 3),
(8, 2, 4),
(9, 7, 4),
(10, 6, 5),
(11, 3, 5),
(12, 5, 5),
(13, 6, 3),
(14, 4, 8),
(15, 6, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `name`) VALUES
(1, 'Бригада 1'),
(2, 'Бригада 2'),
(3, 'Бригада 3'),
(4, 'Бригада 4');

-- --------------------------------------------------------

--
-- Структура таблицы `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `content` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `projects`
--

INSERT INTO `projects` (`id`, `content`) VALUES
(5, 'Проект 5'),
(8, 'Задача 8');

-- --------------------------------------------------------

--
-- Структура таблицы `timetable`
--

CREATE TABLE `timetable` (
  `id` int(11) NOT NULL,
  `content` varchar(512) NOT NULL,
  `id_project` int(11) NOT NULL,
  `start` date DEFAULT '1970-01-01',
  `end` date NOT NULL DEFAULT '1970-01-01',
  `group` int(11) NOT NULL,
  `type` varchar(32) NOT NULL,
  `subtype` varchar(32) NOT NULL,
  `ttype` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `timetable`
--

INSERT INTO `timetable` (`id`, `content`, `id_project`, `start`, `end`, `group`, `type`, `subtype`, `ttype`) VALUES
(1, 'Задача 5', 5, '2019-04-01', '2019-11-15', 5, 'background', 'real', NULL),
(2, 'Допуск', 5, '2019-04-01', '2019-04-17', 5, 'range', 'real', 'admittance'),
(3, 'Допуск', 5, '2019-04-01', '2019-04-18', 5, 'range', 'contract', 'admittance'),
(4, 'Работа', 5, '2019-04-18', '2019-11-13', 5, 'range', 'real', 'work'),
(5, 'Работа', 5, '2019-04-18', '2019-11-13', 5, 'range', 'contract', 'work'),
(6, 'Отчет', 5, '2019-11-14', '2019-11-15', 5, 'range', 'real', 'report'),
(7, 'Отчет', 5, '2019-11-14', '2019-11-15', 5, 'range', 'contract', 'report'),
(8, 'Задача 8', 8, '2019-01-01', '2019-08-20', 8, 'background', 'real', NULL),
(9, 'Допуск', 8, '2019-01-01', '2019-02-01', 8, 'range', 'real', 'admittance'),
(10, 'Допуск', 8, '2019-01-01', '2019-02-01', 8, 'range', 'contract', 'admittance'),
(11, 'Работа', 8, '2019-02-02', '2019-08-08', 8, 'range', 'real', 'work'),
(12, 'Работа', 8, '2019-02-02', '2019-08-18', 8, 'range', 'contract', 'work'),
(13, 'Отчет', 8, '2019-08-09', '2019-08-10', 8, 'range', 'real', 'report'),
(14, 'Отчет', 8, '2019-08-19', '2019-08-20', 8, 'range', 'contract', 'report');

-- --------------------------------------------------------

--
-- Структура таблицы `workers`
--

CREATE TABLE `workers` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `workers`
--

INSERT INTO `workers` (`id`, `name`) VALUES
(1, 'Иванов Иван'),
(2, 'Федоров Федор'),
(3, 'Егоров Егор'),
(4, 'Петров Петр'),
(5, 'Фомин Фома'),
(6, 'Александров Александр'),
(12, 'Федоров Федор Петрович');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `assigned_groups`
--
ALTER TABLE `assigned_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniquepair` (`worker_id`,`group_id`) USING BTREE;

--
-- Индексы таблицы `assigned_workers`
--
ALTER TABLE `assigned_workers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `assigned_groups`
--
ALTER TABLE `assigned_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `assigned_workers`
--
ALTER TABLE `assigned_workers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `timetable`
--
ALTER TABLE `timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `workers`
--
ALTER TABLE `workers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
