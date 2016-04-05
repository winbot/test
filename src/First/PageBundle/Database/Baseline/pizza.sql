-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 02 2016 г., 16:38
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
-- Структура таблицы `pizza`
--

CREATE TABLE IF NOT EXISTS `pizza` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `portion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `composition` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `pizza`
--

INSERT INTO `pizza` (`name`, `portion`, `cost`, `composition`) VALUES
('Фокачча с сыром', '310', 80.00, 'Фокачча с сыром моцарелла и гауда'),
('Пицца грибная', '410', 150.00, 'Соус «итальяно», сыр моцарелла, сливки, шампиньоны, красный лук'),
('Пепперони', '330', 157.00, 'Соус «итальяно», сыр моцарелла, салями, болгарский перец'),
('Пицца Ростбиф', '500', 265.00, 'Соус «итальяно», сыр моцарелла, сливки, шампиньоны, красный лук'),
('Маргарита', '320', 110.00, 'Соус «итальяно», сыр моцарелла, салями, болгарский перец'),
('Цезарь', '400', 230.00, 'Соус «цезарь», сыры моцарелла и пармезан, куриное филе помидоры черри'),
('Карбонара', '400', 155.00, 'Соус сливочный, бекон, сыры моцарелла и гауда, Базилик'),
('Аль-Сальмоне', '450', 177.00, 'Соус «итальяно», лосось, сыр моцарелла, спаржа, помидоры черри, сливки'),
('Вегетарианская', '400', 140.00, 'Соус «итальяно», сыр моцарелла, цукини, цветная капуста, баклажаны, свежие помидоры, красный лук, болгарский перец'),
('Кальцоне с курицей', '320', 120.00, 'Соус «итальяно», сыр моцарелла, куриное филе, шпинат'),
('Кальцоне с грибами', '350', 110.00, 'Соус «итальяно», сыр моцарелла, шампиньоны, ветчина, красный лук, баклажан, свежие помидоры');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
