-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 24 2019 г., 07:49
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
(13, 6, 3);

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
(1, 'Проект 1'),
(2, 'Проект 2'),
(3, 'Проект 3'),
(4, 'Проект 4'),
(5, 'Проект 5');

-- --------------------------------------------------------

--
-- Структура таблицы `timetable`
--

CREATE TABLE `timetable` (
  `id` int(11) NOT NULL,
  `content` int(11) NOT NULL,
  `id_project` int(11) NOT NULL,
  `start` date NOT NULL DEFAULT current_timestamp(),
  `end` date NOT NULL DEFAULT current_timestamp(),
  `group` int(11) NOT NULL,
  `type` varchar(32) NOT NULL,
  `subtype` varchar(32) NOT NULL,
  `subgroup` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(7, 'Ефимов Ефим'),
(8, 'Кириллов Кирилл');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `assigned_workers`
--
ALTER TABLE `assigned_workers`
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
-- AUTO_INCREMENT для таблицы `assigned_workers`
--
ALTER TABLE `assigned_workers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `timetable`
--
ALTER TABLE `timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `workers`
--
ALTER TABLE `workers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
