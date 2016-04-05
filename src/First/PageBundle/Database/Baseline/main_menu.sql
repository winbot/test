-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Мар 18 2016 г., 15:48
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
-- Структура таблицы `main_menu`
--

CREATE TABLE IF NOT EXISTS `main_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_page` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name_tab` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Дамп данных таблицы `main_menu`
--

INSERT INTO `main_menu` (`name_page`, `name_tab`) VALUES 
('ГОРЯЧИЕ БЛЮДА ИЗ РЫБЫ', 'hot_dishes_fish'),
('ГОРЯЧИЕ ЗАКУСКИ', 'hot_snacks'),
('ОСНОВНЫЕ БЛЮДА ИЗ МЯСА И ПТИЦЫ', 'main_dishes_meat'),
('МЯСНЫЕ ХОЛОДНЫЕ ЗАКУСКИ', 'cold_dishes_meat'),
('ХОЛОДНЫЕ РЫБНЫЕ ЗАКУСКИ', 'cold_dishes_fish'),
('СУПЫ', 'soup'),
('ДЕСЕРТЫ', 'dessert'),
('САЛАТЫ', 'salads'),
('ПАСТА', 'pasta'),
('ПИЦЦА', 'pizza');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
