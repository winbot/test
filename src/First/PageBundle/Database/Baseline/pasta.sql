-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 02 2016 г., 16:24
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
-- Структура таблицы `pasta`
--

CREATE TABLE IF NOT EXISTS `pasta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `portion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `composition` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `pasta`
--

INSERT INTO `pasta` (`name`, `portion`, `cost`, `composition`) VALUES
('Спагетти «Болоньезе»', '350', 187.00, 'С классическим итальянским соусом болоньезе'),
('Пене «Сальмон»', '300', 230.00, 'Сливочный соус с семгой и красной икрой'),
('Тальолини «Песто»', '300', 200.00, 'Спаржа, сладкий горошек, брокколи в соусе «Песто»'),
('Спагетти «Карбонара»', '350', 187.00, 'С луком, беконом и сливочным соусом'),
('Пене с цыпленком и паприкой', '300', 215.00, 'Слегка острый соус из помидор с беконом и курицей'),
('Ризотто с белыми грибами или курицей ', '300', 150.00, 'Можете заказать на Ваш вкус с белыми грибами или мясом цыпленка');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
