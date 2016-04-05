-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 02 2016 г., 11:44
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
-- Структура таблицы `hot_snacks`
--

CREATE TABLE IF NOT EXISTS `hot_snacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `portion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `composition` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `hot_snacks`
--

INSERT INTO `hot_snacks` (`name`, `portion`, `cost`, `composition`) VALUES
('«Шашука» на чугунной сковороде', '200', 160.00, 'Овощное рагу, запеченное с сыром и яйцом'),
('Гребешки «Сен-Жак»', '100/75/50', 207.00, 'С жареной в беконе спаржей и соусом из помидор'),
('«Чили кон-Корне»', '200', 127.00, 'Рагу из баранины с черной фасолью, помидорами и сыром'),
('«Дьявольские крылья»', '6 шт', 150.00, 'Куриные крылья в остро сладком соусе с сельдереем и морковью'),
('«Куриные потрошка»', '200', 160.00, 'Желудки и сердечки, жареные с луком в сметанном соусе, грибами, зеленью и чесноком'),
('«Семечки»', '250', 217.00, 'Из ребрышек ягненка. Жареные в казане, с восточными пряностями');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
