-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 02 2016 г., 17:43
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

CREATE TABLE IF NOT EXISTS `cold_dishes_fish` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `portion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `composition` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `cold_dishes_fish`
--

INSERT INTO `cold_dishes_fish` (`name`, `portion`, `cost`, `composition`) VALUES
('Карпаччо  «ПримаВера»', '70/120', 195.00, 'Филе свежей семги, заправленное оливковым маслом и соком лимона с зеленым салатом и маслинами'),
('Тар–тар из семги', '75/150', 220.00, 'С салатом из морских водорослей, маринованным имбирем. Заправлен оливковым маслом и соевым соусом. С тостами из ржаного хлеба'),
('Рыбное ассорти в стол на три персоны', '700', 585.00, 'Семга, сельдь, икра красная, судак под маринадом, сашими из тунца, с теплым картофелем, блинчиками и жареными цуккини'),
('Канапе с сельдью', '75/100', 120.00, 'На обжаренном тосте, с отварным картофелем, луком и перепелиным яйцом'),
('Семга слабосоленая', '75/150', 195.00, 'С теплыми блинчиками из цуккини и креветок'),
('Филе судака по-русски', '100', 150.00, 'Томленое с белым вином, под овощным маринадом с помидорами и зеленью'),
('Осьминог', '200', 200.00, 'винегретом из белой и черной фасоли и жареным луком и рукколой'),
('Икра красная с блинчиками', '2 шт', 135.00, 'Гарнированная рубленым луком, свежими огурцами и отварным яйцом. С тостами из пшеничного хлеба'),
('Домашние маринады и соленья', '100', 65.00, 'Квашеная капуста, соленые огурцы, маринованные помидоры, перец. Можно заказать как ассорти, так и отдельно.');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
