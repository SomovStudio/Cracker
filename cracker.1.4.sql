-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 09 2019 г., 05:58
-- Версия сервера: 5.7.24
-- Версия PHP: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cracker`
--
CREATE DATABASE IF NOT EXISTS `cracker` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `cracker`;

-- --------------------------------------------------------

--
-- Структура таблицы `cycles`
--

DROP TABLE IF EXISTS `cycles`;
CREATE TABLE IF NOT EXISTS `cycles` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `project_id` int(5) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `steps_test_case`
--

DROP TABLE IF EXISTS `steps_test_case`;
CREATE TABLE IF NOT EXISTS `steps_test_case` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `step` text NOT NULL,
  `step_data` text NOT NULL,
  `step_expected_result` text NOT NULL,
  `test_case_id` int(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `test_case_id` (`test_case_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `test_cases`
--

DROP TABLE IF EXISTS `test_cases`;
CREATE TABLE IF NOT EXISTS `test_cases` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `summary` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `cycle_id` int(5) NOT NULL,
  `author` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `summary` (`summary`),
  KEY `cycle_id` (`cycle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `pass`, `email`) VALUES
(1, 'admin', '', '');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cycles`
--
ALTER TABLE `cycles`
  ADD CONSTRAINT `cycles_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `steps_test_case`
--
ALTER TABLE `steps_test_case`
  ADD CONSTRAINT `steps_test_case_ibfk_1` FOREIGN KEY (`test_case_id`) REFERENCES `test_cases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `test_cases`
--
ALTER TABLE `test_cases`
  ADD CONSTRAINT `test_cases_ibfk_1` FOREIGN KEY (`cycle_id`) REFERENCES `cycles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
