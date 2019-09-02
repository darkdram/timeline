-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 02 2019 г., 23:03
-- Версия сервера: 5.6.38
-- Версия PHP: 7.2.0

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
  `project_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `assigned_groups`
--

INSERT INTO `assigned_groups` (`id`, `project_id`, `group_id`) VALUES
(14, 34, 3),
(15, 35, 1),
(16, 36, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `assigned_workers`
--

CREATE TABLE `assigned_workers` (
  `id` int(11) NOT NULL,
  `id_worker` int(11) NOT NULL,
  `id_group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `assigned_workers`
--

INSERT INTO `assigned_workers` (`id`, `id_worker`, `id_group`) VALUES
(1, 1, 1),
(2, 4, 1),
(3, 1, 2),
(4, 7, 2),
(6, 5, 3),
(7, 3, 3),
(8, 2, 4),
(9, 7, 4),
(10, 6, 5),
(11, 3, 5),
(12, 5, 5),
(13, 6, 3),
(14, 4, 8),
(15, 6, 8),
(16, 2, 5),
(17, 5, 5),
(18, 2, 6),
(19, 5, 6);

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
(4, 'Бригада 4'),
(6, 'супир бригада');

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
(34, 'проект'),
(35, 'проект 2'),
(36, 'проект 3');

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
(121, 'проект', 34, '2019-09-01', '2019-09-26', 3, 'background', 'contract', 'title'),
(122, 'Допуск', 34, '2019-09-01', '2019-09-03', 3, 'range', 'real', 'admittance'),
(123, 'Реальные сроки проведения работ', 34, '2019-09-04', '2019-09-25', 3, 'range', 'real', 'work'),
(124, 'Договорные сроки проведения работ', 34, '2019-09-01', '2019-09-26', 3, 'range', 'contract', 'work'),
(125, 'реальные сроки сдачи технических отчетов', 34, '2019-09-28', '2019-10-01', 3, 'range', 'real', 'report'),
(126, 'Договорные сроки сдачи технических отчетов', 34, '2019-09-30', '2019-09-30', 3, 'range', 'contract', 'report'),
(127, 'проект 2', 35, '2019-09-01', '2019-09-30', 1, 'background', 'contract', 'title'),
(128, 'Допуск', 35, '2019-09-01', '2019-09-02', 1, 'range', 'real', 'admittance'),
(129, 'Реальные сроки проведения работ', 35, '2019-09-03', '2019-09-24', 1, 'range', 'real', 'work'),
(130, 'Договорные сроки проведения работ', 35, '2019-09-01', '2019-09-30', 1, 'range', 'contract', 'work'),
(131, 'реальные сроки сдачи технических отчетов', 35, '2019-09-27', '0000-00-00', 1, 'range', 'real', 'report'),
(132, 'Договорные сроки сдачи технических отчетов', 35, '2019-09-29', '2019-09-29', 1, 'range', 'contract', 'report'),
(133, 'проект 3', 36, '2019-09-01', '2019-09-30', 6, 'background', 'contract', 'title'),
(134, 'Допуск', 36, '2019-09-01', '2019-09-02', 6, 'range', 'real', 'admittance'),
(135, 'Реальные сроки проведения работ', 36, '2019-09-04', '2019-09-24', 6, 'range', 'real', 'work'),
(136, 'Договорные сроки проведения работ', 36, '2019-09-01', '2019-09-30', 6, 'range', 'contract', 'work'),
(137, 'реальные сроки сдачи технических отчетов', 36, '2019-09-27', '2019-09-28', 6, 'point', 'real', 'report'),
(138, 'Договорные сроки сдачи технических отчетов', 36, '2019-09-27', '2019-09-27', 6, 'point', 'contract', 'report');

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
(7, 'Федоров Федор Петрович');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `assigned_groups`
--
ALTER TABLE `assigned_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniquepair` (`project_id`,`group_id`) USING BTREE;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `assigned_workers`
--
ALTER TABLE `assigned_workers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT для таблицы `timetable`
--
ALTER TABLE `timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT для таблицы `workers`
--
ALTER TABLE `workers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
