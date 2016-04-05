-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 02 2016 г., 15:29
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
-- Структура таблицы `dessert`
--

CREATE TABLE IF NOT EXISTS `dessert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `portion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `composition` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `dessert`
--

INSERT INTO `dessert` (`name`, `portion`, `cost`, `composition`) VALUES
('«Панна-Кота»', '150', 127.00, 'Молочный десерт со свежими ягодами и малиновым соусом'),
('Творожная запеканка', '200', 117.00, 'Фермерский творог и сметана с курагой, изюмом'),
('Фруктовый салат', '150', 117.00, 'Апельсин, грейпфрут, клубника, киви и взбитые сливки'),
('Яблочный штрудель', '125/80', 154.00, 'С шариком ванильного мороженого и ванильным соусом'),
('Тирамиссу', '220/50', 187.00, 'Классический итальянский десерт из сыра «Москарпоне» и печенья «Савоярди»'),
('Мороженое и сорбэ ассорти', '60', 30.00, ''),
('Жареная клубника с блинчиками и Маскарпоне', '150', 160.00, 'Фаршированные обжаренной в ликере Куантро свежей клубникой и сыром «Москарпоне»');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
