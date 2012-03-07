-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 07-03-2012 a las 10:52:29
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
-- Estructura de tabla para la tabla `wm_module_configs`
--

CREATE TABLE IF NOT EXISTS `wm_module_configs` (
  `product_id` int(11) NOT NULL,
  `module_config_group_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `ordering` int(11) NOT NULL,
  `options` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `wm_module_configs`
--

INSERT INTO `wm_module_configs` (`product_id`, `module_config_group_id`, `name`, `key`, `value`, `description`, `ordering`, `options`) VALUES
(8, '8-application_setup', 'URL SuscripciÃ³n', 'suscribe_url', 'http://[DOMAIN]/mod_newsletters/suscribe', '', 1, ''),
(8, '8-application_setup', 'URL de Baja', 'unsubscribe_url', 'http://[DOMAIN]/mod_newsletters/users/delete/[userkey]', '', 2, ''),
(8, '8-application_setup', 'URL ConfimaciÃ³n', 'confirmation_url', 'http://[DOMAIN]/mod_newsletters/confirm/[userkey]', '', 3, ''),
(8, '8-application_setup', 'DirecciÃ³n Remitente', 'message_from_address', 'noreply@[DOMAIN]', '', 4, ''),
(8, '8-application_setup', 'DirecciÃ³n de Respuesta', 'message_replyto_address', 'noreply@[DOMAIN]', '', 5, ''),
(8, '8-application_setup', 'Asunto en Mensaje de SuscripciÃ³n', 'subscribe_subject', 'Request for confirmation', '', 6, ''),
(8, '8-application_setup', 'Mensaje SuscripciÃ³n', 'subscribe_message', '  Almost welcome to our newsletter(s) ...\n\n  Someone, hopefully you, has subscribed your email address to our newsletters.\n\n  If this is correct, please click the following link to confirm your subscription.\n  Without this confirmation, you will not receive any newsletters.\n  \n  [CONFIRMATIONURL]\n  \n  If this is not correct, you do not need to do anything, simply delete this message.\n\n  Thank you\n  \n    ', '', 7, ''),
(8, '8-application_setup', 'Asunto en Mensaje Darse de Baja', 'unsubscribe_subject', 'Goodbye from our Newsletter', '', 8, ''),
(8, '8-application_setup', 'Mensaje Darse de Baja', 'unsubscribe_message', '  \n  Goodbye from our Newsletter, sorry to see you go.\n\n  You have been unsubscribed from our newsletters.\n\n  This is the last email you will receive from us. We have added you to our\n  "blacklist", which means that our newsletter system will refuse to send\n  you any other email, without manual intervention by our administrator.\n\n  If there is an error in this information, you can re-subscribe:\n  please go to [SUBSCRIBEURL] and follow the steps.\n\n  Thank you\n  \n  ', '', 9, ''),
(8, '8-application_setup', 'Asunto en Mensaje de ConfirmaciÃ³n', 'confirmation_subject', 'Welcome to our Newsletter', '', 10, ''),
(8, '8-application_setup', 'Mensaje de ConfirmaciÃ³n', 'confirmation_message', '  \n  Welcome to our Newsletter\n\n  Please keep this email for later reference.\n\n  Your email address has been added to the following newsletter(s):\n  [LISTS]\n\n  To update your details and preferences please go to [PREFERENCESURL].\n  If you do not want to receive any more messages, please go to [UNSUBSCRIBEURL].\n\n  Thank you\n  ', '', 11, ''),
(8, '8-application_setup', 'URL ''Preferencias''', 'preferences_url', 'http://[DOMAIN]/mod_newsletters/users/edit/[useremail]/[userkey]', '', 12, ''),
(8, '8-application_setup', 'Pie de Mensajes', 'message_footer', '---------------\nIf you do not want to receive any more newsletters,  [UNSUBSCRIBEURL]\n\nTo update your preferences and to unsubscribe visit [PREFERENCESURL]\n-------------------------', '', 13, ''),
(8, '8-email_setup', 'Mensajes por Refesco', 'messages_per_refresh', '25', '', 14, ''),
(8, '8-email_setup', 'Pausas Entre Refrescos', 'pause_between_refreshes', '1', '', 15, ''),
(8, '8-email_setup', 'Tiempo de Cola', 'queue_timeout', '60', '', 16, ''),
(8, '8-email_setup', 'Delivery Method', 'delivery_method', 'mail', '', 17, ''),
(8, '8-email_setup', 'Smtp Address', 'SMTP_address', 'smtp.quickmultimedia.es', '', 18, ''),
(8, '8-email_setup', 'Smtp Keep Alive', 'SMTP_keep_alive', 'no', '', 19, ''),
(8, '8-email_setup', 'Smtp Auth', 'SMTP_auth', 'true', '', 20, ''),
(8, '8-email_setup', 'Smtp User', 'SMTP_user', 'chris@quickmultimedia.es', '', 21, ''),
(8, '8-email_setup', 'Smtp Password', 'SMTP_password', '142600', '', 22, ''),
(8, '8-application_setup', 'Nombre Remitente', 'message_from_name', 'Webmanager, Newsletters Module', '', 23, ''),
(8, '8-email_setup', 'Gmail Address', 'GMAIL_address', 'ssl://smtp.gmail.com', '', 24, ''),
(8, '8-email_setup', 'Gmail Port', 'GMAIL_port', '465', '', 25, ''),
(8, '8-email_setup', 'Gmail User', 'GMAIL_user', 'y2k2000@gmail.com', '', 26, ''),
(8, '8-email_setup', 'Gmail Password', 'GMAIL_password', '', '', 27, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
