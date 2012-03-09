-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 07-03-2012 a las 10:52:11
-- Versión del servidor: 5.5.16
-- Versión de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `wm2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wm_modules`
--

CREATE TABLE IF NOT EXISTS `wm_modules` (
  `product_id` int(11) NOT NULL,
  `tables` text COLLATE utf8_unicode_ci NOT NULL,
  `folder` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `access` text COLLATE utf8_unicode_ci NOT NULL,
  `user_setup` text COLLATE utf8_unicode_ci NOT NULL,
  `ordering` int(11) NOT NULL,
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `license` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `wm_modules`
--

INSERT INTO `wm_modules` (`product_id`, `tables`, `folder`, `access`, `user_setup`, `ordering`, `version`, `type`, `license`, `active`) VALUES
(8, 'newsletter_cdata\r\nnewsletter_cfields\r\nnewsletter_lists\r\nnewsletter_messages\r\nnewsletter_queue\r\nnewsletter_sending\r\nnewsletter_templates\r\nnewsletter_users\r\nnewsletter_user_list_relationships', 'mod_newsletters', '', '{"uploadFolder":"modNewsletters"}', 2, '1.1', 'module', '1-29-8-1246120144-1679091c', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
