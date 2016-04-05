-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 02 2016 г., 15:44
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
-- Структура таблицы `cold_dishes_meat`
--

CREATE TABLE IF NOT EXISTS `cold_dishes_meat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `portion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `composition` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `cold_dishes_meat`
--

INSERT INTO `cold_dishes_meat` (`name`, `portion`, `cost`, `composition`) VALUES
('Буженина домашняя из окорока фермерской свинины', '75/150', 127.00, 'С салатом из свежей капусты с зернами граната, кедровыми орешками и оливковым маслом'),
('Язык говяжий отварной', '75/150', 180.00, 'С салатом из свежей капусты с зернами граната, кедровыми орешками и оливковым маслом'),
('Тар-тар из говядины', '75/120', 227.00, 'С салатом из спаржи, цуккини и брокколи под заправкой из оливкового масла и лимонного сока'),
('Карпаччо из говядины', '100/150', 250.00, ' С листьями зеленых салатов, солеными груздями и томатами черри. Заправлено оливковым маслом и бальзамическим уксусом'),
('Домашняя колбаса из индейки «А-ля Галантин»', '75/100', 127.00, 'С корнишонами, каперсами, луком и яйцом'),
('Мясное ассорти в стол (на три персоны)', '620', 507.00, 'Буженина, отварной язык, колбаса из индейки со своим гарниром, горчицей и хреном');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
