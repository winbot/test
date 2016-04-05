-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 02 2016 г., 17:06
-- Версия сервера: 5.5.47-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `restaurant`
--

-- --------------------------------------------------------

--
-- Структура таблицы `soup`
--

CREATE TABLE IF NOT EXISTS `soup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `portion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `composition` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `soup`
--

INSERT INTO `soup` (`name`, `portion`, `cost`, `composition`) VALUES
('Борщ «Украинский»', '350', 175.00, 'Со свиными ребрышками и тостом с сыром и чесноком'),
('«Пити» из ягненка', '350', 160.00, 'С горохом «Нут»,картофелем, болгарским перцем и кинзой'),
('Уха', '350', 185.00, 'Из судака и семги с овощным сэндвичем. (огурец, руккола, майонез, яйцо)'),
('Лапша по — Одесски', '350', 145.00, 'С потрошками и грибочками');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
