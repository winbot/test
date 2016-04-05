-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 02 2016 г., 11:02
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
-- Структура таблицы `hot_dishes_fish`
--

CREATE TABLE IF NOT EXISTS `hot_dishes_fish` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `portion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `composition` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `hot_dishes_fish`
--

INSERT INTO `hot_dishes_fish` (`name`, `portion`, `cost`, `composition`) VALUES 
('Стейк из Семги', '180/75', 367.00, 'Со свежими, рукколой и креветками'),
('Филе Семги', '125/100', 317.00, 'В сливочном соусе из шампанского, с красной икрой и картофельным пюре'),
('Дорадо целиком', '400', 434.00, 'На Ваш вкус, жареная или паровая. Брокколи, помидор, картофель и цуккини «Гриль» или отварные'),
('Филе Дорадо по — корсикански', '300', 367.00, 'С помидорами, луком, маслинами и рисом'),
('Филе Палтуса отварное', '350', 367.00, 'С пюре из подкопченного зеленого горошка с отварной спаржей и каплями граната'),
('Филе Палтуса жареное в хрустящих сухарях', '300', 317.00, 'С картофельным пюре и соусом «Тар-Тар»');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
