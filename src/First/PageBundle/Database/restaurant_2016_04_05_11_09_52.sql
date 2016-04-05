-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 05 2016 г., 11:09
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
-- Структура таблицы `cold_dishes_fish`
--
-- Создание: Апр 04 2016 г., 20:52
--

CREATE TABLE IF NOT EXISTS `cold_dishes_fish` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `portion` text COLLATE utf8_unicode_ci NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `composition` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Структура таблицы `cold_dishes_meat`
--
-- Создание: Апр 05 2016 г., 07:23
--

CREATE TABLE IF NOT EXISTS `cold_dishes_meat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `portion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `composition` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Структура таблицы `dessert`
--
-- Создание: Апр 05 2016 г., 07:23
--

CREATE TABLE IF NOT EXISTS `dessert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `portion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `composition` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `hot_dishes_fish`
--
-- Создание: Апр 05 2016 г., 07:23
--

CREATE TABLE IF NOT EXISTS `hot_dishes_fish` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `portion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `composition` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Структура таблицы `hot_snacks`
--
-- Создание: Апр 05 2016 г., 07:23
--

CREATE TABLE IF NOT EXISTS `hot_snacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `portion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `composition` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Структура таблицы `main_dishes_meat`
--
-- Создание: Апр 05 2016 г., 07:24
--

CREATE TABLE IF NOT EXISTS `main_dishes_meat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `portion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `composition` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Структура таблицы `main_menu`
--
-- Создание: Апр 02 2016 г., 14:50
--

CREATE TABLE IF NOT EXISTS `main_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_page` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name_tab` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Структура таблицы `pasta`
--
-- Создание: Мар 18 2016 г., 13:27
--

CREATE TABLE IF NOT EXISTS `pasta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `portion` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:simple_array)',
  `cost` decimal(10,2) NOT NULL,
  `composition` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Структура таблицы `pizza`
--
-- Создание: Мар 18 2016 г., 13:27
--

CREATE TABLE IF NOT EXISTS `pizza` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `portion` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:simple_array)',
  `cost` decimal(10,2) NOT NULL,
  `composition` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Структура таблицы `salads`
--
-- Создание: Апр 02 2016 г., 14:10
--

CREATE TABLE IF NOT EXISTS `salads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `portion` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:simple_array)',
  `cost` decimal(10,2) NOT NULL,
  `composition` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Структура таблицы `soup`
--
-- Создание: Мар 18 2016 г., 13:27
--

CREATE TABLE IF NOT EXISTS `soup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `portion` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:simple_array)',
  `cost` decimal(10,2) NOT NULL,
  `composition` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Структура таблицы `zakaz`
--
-- Создание: Мар 18 2016 г., 13:27
--

CREATE TABLE IF NOT EXISTS `zakaz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_zak` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_t` datetime NOT NULL,
  `portion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_dishes` int(11) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `name_tab` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `accept` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
