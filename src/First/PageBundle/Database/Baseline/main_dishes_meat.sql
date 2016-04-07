-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 02 2016 г., 16:13
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
-- Структура таблицы `main_dishes_meat`
--

CREATE TABLE IF NOT EXISTS `main_dishes_meat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `portion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `composition` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `main_dishes_meat`
--

INSERT INTO `main_dishes_meat` (`name`, `portion`, `cost`, `composition`) VALUES
('Бифштекс', '75/100/125', 265.00, 'Из говяжьей вырезки с овощным салатом, яйцом «Пашот» и картофелем фри'),
('Утиная грудка', '100/180', 295.00, 'В соусе из брусники с рисом и фруктами'),
('Кролик по — деревенски', '200', 275.00, 'С тушеными овощами в сметанном соусе'),
('Цыпленок «Таппака»', '300', 275.00, 'Запеченный под баклажанами, помидорами и сыром'),
('Свиная корейка на косточке', '360', 227.00, 'Жареная на гриль — сковороде, с пюре из зеленого горошка, овощным салатом и соусом «ББК»'),
('Свинина по -монастырски', '150', 214.00, 'Медальоны из свиной вырезки и гречка с белыми грибами, перепелиными яйцами, зеленым луком и свежим огурцом'),
('Утиная ножка «Конфи»', '100/150', 295.00, 'С гречкой и белыми грибами'),
('Жаркое из свинины', '370', 210.00, 'С картофелем, беконом и грибами'),
('Медальоны «Воронофф»', '50/75/150', 285.00, 'В горчичном соусе, с картофельным пюре и салатом из помидор черри'),
('Говядина «Метрдотель»', '100/150', 320.00, 'Медальоны жареные в беконе с соусом из помидор, кинзы и фасоли'),
('Горячий язык', '125/150', 267.00, 'С отварным картофелем и зеленым горошком в сливочно-горчичном соусе'),
('Карэ ягненка', '50/75/150', 420.00, 'Жареное на гриль сковороде с рисом «Пилафф» соусом «сацибели» и помидорами черри'),
('Жаркое из лосятины', '240', 183.00, 'Тушеное с помидорами, луком, морковью и опятами на толченом картофеле с зеленым луком и укропом'),
('Отбивная из кабана', '300', 195.00, 'В соусе «Сацибели» с обжаренным картофелем и солеными груздями');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;