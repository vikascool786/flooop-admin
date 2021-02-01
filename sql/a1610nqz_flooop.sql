-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 01, 2021 at 05:00 PM
-- Server version: 5.7.23-23
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `a1610nqz_flooop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_preferences`
--

CREATE TABLE `admin_preferences` (
  `id` tinyint(1) NOT NULL,
  `user_panel` tinyint(1) NOT NULL DEFAULT '0',
  `sidebar_form` tinyint(1) NOT NULL DEFAULT '0',
  `messages_menu` tinyint(1) NOT NULL DEFAULT '0',
  `notifications_menu` tinyint(1) NOT NULL DEFAULT '0',
  `tasks_menu` tinyint(1) NOT NULL DEFAULT '0',
  `user_menu` tinyint(1) NOT NULL DEFAULT '1',
  `ctrl_sidebar` tinyint(1) NOT NULL DEFAULT '0',
  `transition_page` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_preferences`
--

INSERT INTO `admin_preferences` (`id`, `user_panel`, `sidebar_form`, `messages_menu`, `notifications_menu`, `tasks_menu`, `user_menu`, `ctrl_sidebar`, `transition_page`) VALUES
(1, 0, 0, 0, 0, 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `short_name` varchar(255) DEFAULT NULL,
  `long_name` varchar(255) DEFAULT NULL,
  `symbol` char(5) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `short_name`, `long_name`, `symbol`) VALUES
(1, 'KRW', '(South) Korean Won', '$'),
(2, 'AFA', 'Afghanistan Afghani', '$'),
(3, 'ALL', 'Albanian Lek', '$'),
(4, 'DZD', 'Algerian Dinar', '$'),
(5, 'ADP', 'Andorran Peseta', '$'),
(6, 'AOK', 'Angolan Kwanza', '$'),
(7, 'ARS', 'Argentine Peso', '$'),
(8, 'AMD', 'Armenian Dram', '$'),
(9, 'AWG', 'Aruban Florin', '$'),
(10, 'AUD', 'Australian Dollar', '$'),
(11, 'BSD', 'Bahamian Dollar', '$'),
(12, 'BHD', 'Bahraini Dinar', '$'),
(13, 'BDT', 'Bangladeshi Taka', '$'),
(14, 'BBD', 'Barbados Dollar', '$'),
(15, 'BZD', 'Belize Dollar', '$'),
(16, 'BMD', 'Bermudian Dollar', '$'),
(17, 'BTN', 'Bhutan Ngultrum', '$'),
(18, 'BOB', 'Bolivian Boliviano', '$'),
(19, 'BWP', 'Botswanian Pula', '$'),
(20, 'BRL', 'Brazilian Real', '$'),
(21, 'GBP', 'British Pound', '$'),
(22, 'BND', 'Brunei Dollar', '$'),
(23, 'BGN', 'Bulgarian Lev', '$'),
(24, 'BUK', 'Burma Kyat', '$'),
(25, 'BIF', 'Burundi Franc', '$'),
(26, 'CAD', 'Canadian Dollar', '$'),
(27, 'CVE', 'Cape Verde Escudo', '$'),
(28, 'KYD', 'Cayman Islands Dollar', '$'),
(29, 'CLP', 'Chilean Peso', '$'),
(30, 'CLF', 'Chilean Unidades de Fomento', '$'),
(31, 'COP', 'Colombian Peso', '$'),
(32, 'XOF', 'Communauté Financière Africaine BCEAO - Francs', '$'),
(33, 'XAF', 'Communauté Financière Africaine BEAC, Francs', '$'),
(34, 'KMF', 'Comoros Franc', '$'),
(35, 'XPF', 'Comptoirs Français du Pacifique Francs', '$'),
(36, 'CRC', 'Costa Rican Colon', '$'),
(37, 'CUP', 'Cuban Peso', '$'),
(38, 'CYP', 'Cyprus Pound', '$'),
(39, 'CZK', 'Czech Republic Koruna', '$'),
(40, 'DKK', 'Danish Krone', '$'),
(41, 'YDD', 'Democratic Yemeni Dinar', '$'),
(42, 'DOP', 'Dominican Peso', '$'),
(43, 'XCD', 'East Caribbean Dollar', '$'),
(44, 'TPE', 'East Timor Escudo', '$'),
(45, 'ECS', 'Ecuador Sucre', '$'),
(46, 'EGP', 'Egyptian Pound', '$'),
(47, 'SVC', 'El Salvador Colon', '$'),
(48, 'EEK', 'Estonian Kroon (EEK)', '$'),
(49, 'ETB', 'Ethiopian Birr', '$'),
(50, 'EUR', 'Euro', '$'),
(51, 'FKP', 'Falkland Islands Pound', '$'),
(52, 'FJD', 'Fiji Dollar', '$'),
(53, 'GMD', 'Gambian Dalasi', '$'),
(54, 'GHC', 'Ghanaian Cedi', '$'),
(55, 'GIP', 'Gibraltar Pound', '$'),
(56, 'XAU', 'Gold, Ounces', '$'),
(57, 'GTQ', 'Guatemalan Quetzal', '$'),
(58, 'GNF', 'Guinea Franc', '$'),
(59, 'GWP', 'Guinea-Bissau Peso', '$'),
(60, 'GYD', 'Guyanan Dollar', '$'),
(61, 'HTG', 'Haitian Gourde', '$'),
(62, 'HNL', 'Honduran Lempira', '$'),
(63, 'HKD', 'Hong Kong Dollar', '$'),
(64, 'HUF', 'Hungarian Forint', '$'),
(65, 'INR', 'Indian Rupee', '₹'),
(66, 'IDR', 'Indonesian Rupiah', '$'),
(67, 'XDR', 'International Monetary Fund (IMF) Special Drawing Rights', '$'),
(68, 'IRR', 'Iranian Rial', '$'),
(69, 'IQD', 'Iraqi Dinar', '$'),
(70, 'IEP', 'Irish Punt', '$'),
(71, 'ILS', 'Israeli Shekel', '$'),
(72, 'JMD', 'Jamaican Dollar', '$'),
(73, 'JPY', 'Japanese Yen', '$'),
(74, 'JOD', 'Jordanian Dinar', '$'),
(75, 'KHR', 'Kampuchean (Cambodian) Riel', '$'),
(76, 'KES', 'Kenyan Schilling', '$'),
(77, 'KWD', 'Kuwaiti Dinar', '$'),
(78, 'LAK', 'Lao Kip', '$'),
(79, 'LBP', 'Lebanese Pound', '$'),
(80, 'LSL', 'Lesotho Loti', '$'),
(81, 'LRD', 'Liberian Dollar', '$'),
(82, 'LYD', 'Libyan Dinar', '$'),
(83, 'MOP', 'Macau Pataca', '$'),
(84, 'MGF', 'Malagasy Franc', '$'),
(85, 'MWK', 'Malawi Kwacha', '$'),
(86, 'MYR', 'Malaysian Ringgit', '$'),
(87, 'MVR', 'Maldive Rufiyaa', '$'),
(88, 'MTL', 'Maltese Lira', '$'),
(89, 'MRO', 'Mauritanian Ouguiya', '$'),
(90, 'MUR', 'Mauritius Rupee', '$'),
(91, 'MXP', 'Mexican Peso', '$'),
(92, 'MNT', 'Mongolian Tugrik', '$'),
(93, 'MAD', 'Moroccan Dirham', '$'),
(94, 'MZM', 'Mozambique Metical', '$'),
(95, 'NAD', 'Namibian Dollar', '$'),
(96, 'NPR', 'Nepalese Rupee', '$'),
(97, 'ANG', 'Netherlands Antillian Guilder', '$'),
(98, 'YUD', 'New Yugoslavia Dinar', '$'),
(99, 'NZD', 'New Zealand Dollar', '$'),
(100, 'NIO', 'Nicaraguan Cordoba', '$'),
(101, 'NGN', 'Nigerian Naira', '$'),
(102, 'KPW', 'North Korean Won', '$'),
(103, 'NOK', 'Norwegian Kroner', '$'),
(104, 'OMR', 'Omani Rial', '$'),
(105, 'PKR', 'Pakistan Rupee', '$'),
(106, 'XPD', 'Palladium Ounces', '$'),
(107, 'PAB', 'Panamanian Balboa', '$'),
(108, 'PGK', 'Papua New Guinea Kina', '$'),
(109, 'PYG', 'Paraguay Guarani', '$'),
(110, 'PEN', 'Peruvian Nuevo Sol', '$'),
(111, 'PHP', 'Philippine Peso', '$'),
(112, 'XPT', 'Platinum, Ounces', '$'),
(113, 'PLN', 'Polish Zloty', '$'),
(114, 'QAR', 'Qatari Rial', '$'),
(115, 'RON', 'Romanian Leu', '$'),
(116, 'RUB', 'Russian Ruble', '$'),
(117, 'RWF', 'Rwanda Franc', '$'),
(118, 'WST', 'Samoan Tala', '$'),
(119, 'STD', 'Sao Tome and Principe Dobra', '$'),
(120, 'SAR', 'Saudi Arabian Riyal', '$'),
(121, 'SCR', 'Seychelles Rupee', '$'),
(122, 'SLL', 'Sierra Leone Leone', '$'),
(123, 'XAG', 'Silver, Ounces', '$'),
(124, 'SGD', 'Singapore Dollar', '$'),
(125, 'SKK', 'Slovak Koruna', '$'),
(126, 'SBD', 'Solomon Islands Dollar', '$'),
(127, 'SOS', 'Somali Schilling', '$'),
(128, 'ZAR', 'South African Rand', '$'),
(129, 'LKR', 'Sri Lanka Rupee', '$'),
(130, 'SHP', 'St. Helena Pound', '$'),
(131, 'SDP', 'Sudanese Pound', '$'),
(132, 'SRG', 'Suriname Guilder', '$'),
(133, 'SZL', 'Swaziland Lilangeni', '$'),
(134, 'SEK', 'Swedish Krona', '$'),
(135, 'CHF', 'Swiss Franc', '$'),
(136, 'SYP', 'Syrian Potmd', '$'),
(137, 'TWD', 'Taiwan Dollar', '$'),
(138, 'TZS', 'Tanzanian Schilling', '$'),
(139, 'THB', 'Thai Baht', '$'),
(140, 'TOP', 'Tongan Paanga', '$'),
(141, 'TTD', 'Trinidad and Tobago Dollar', '$'),
(142, 'TND', 'Tunisian Dinar', '$'),
(143, 'TRY', 'Turkish Lira', '$'),
(144, 'UGX', 'Uganda Shilling', '$'),
(145, 'AED', 'United Arab Emirates Dirham', '$'),
(146, 'UYU', 'Uruguayan Peso', '$'),
(147, 'USD', 'US Dollar', '$'),
(148, 'VUV', 'Vanuatu Vatu', '$'),
(149, 'VEF', 'Venezualan Bolivar', '$'),
(150, 'VND', 'Vietnamese Dong', '$'),
(151, 'YER', 'Yemeni Rial', '$'),
(152, 'CNY', 'Yuan (Chinese) Renminbi', '$'),
(153, 'ZRZ', 'Zaire Zaire', '$'),
(154, 'ZMK', 'Zambian Kwacha', '$'),
(155, 'ZWD', 'Zimbabwe Dollar', '$');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `addDate` datetime DEFAULT NULL,
  `lastModified` datetime DEFAULT NULL,
  `event_title` varchar(255) DEFAULT NULL,
  `host_id` int(11) DEFAULT NULL,
  `event_cost` float DEFAULT NULL,
  `event_currency` int(11) DEFAULT NULL,
  `event_date` datetime DEFAULT NULL,
  `event_start` time DEFAULT NULL,
  `event_ampm` enum('AM','PM','MILITARY') DEFAULT NULL,
  `event_duration` int(11) DEFAULT NULL COMMENT 'in minutes',
  `timezone` varchar(255) DEFAULT NULL,
  `event_image` varchar(255) DEFAULT NULL,
  `event_desc` text,
  `event_tags` varchar(255) DEFAULT NULL,
  `event_lang` int(11) DEFAULT NULL,
  `max_group_size` varchar(255) DEFAULT NULL,
  `event_attendees_do` text,
  `event_attendees` enum('public','private') DEFAULT NULL,
  `attendees_can_invite` enum('yes','no') DEFAULT NULL,
  `display_attendees` enum('yes','no') DEFAULT NULL,
  `event_cohost` varchar(255) DEFAULT NULL,
  `event_question` varchar(255) DEFAULT NULL,
  `status` enum('0','1','2') NOT NULL COMMENT '0-inactive, 1-active,2-trash'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `addDate`, `lastModified`, `event_title`, `host_id`, `event_cost`, `event_currency`, `event_date`, `event_start`, `event_ampm`, `event_duration`, `timezone`, `event_image`, `event_desc`, `event_tags`, `event_lang`, `max_group_size`, `event_attendees_do`, `event_attendees`, `attendees_can_invite`, `display_attendees`, `event_cohost`, `event_question`, `status`) VALUES
(1, '2021-01-29 23:14:55', '2021-01-30 00:59:24', 'Event 1', 15, 0, NULL, '2021-01-31 00:00:00', '01:15:00', 'AM', 30, '1', '1611948564.jpg', 'event 1 description event 1 description event 1 description event 1 description event 1 description event 1 description event 1 description event 1 description event 1 description event 1 description event 1 description event 1 description event 1 descrip', '', 1, '10', '', '', '', '', '', '', '1'),
(2, '2021-01-29 23:25:22', '2021-01-29 23:25:22', 'event 2event 2event 2event 2', 15, 0, NULL, '2021-02-04 00:00:00', '01:15:00', 'AM', 30, '2', '1611942922.jpg', 'event 2 description event 2 description event 2 description event 2 description event 2 description event 2 description ', '', 1, ' 10', '', '', '', '', '', '', '1'),
(3, '2021-01-30 00:00:39', '2021-01-30 00:00:39', 'event 3 event 3 event 3 event 3 event 3 ', 15, 0, NULL, '2021-02-06 00:00:00', '01:15:00', 'AM', 30, '2', '1611945039.jpg', 'event 3 description event 3 description event 3 description event 3 description event 3 description event 3 description ', '', 1, ' 10', '', '', '', '', '', '', '1'),
(4, '2021-01-30 00:02:38', '2021-01-30 00:02:38', 'event 4', 15, 0, NULL, '2021-02-05 00:00:00', '01:30:00', 'AM', 30, '2', '1611945158.jpg', 'event 4', 'event 4', 1, ' 10', 'event 4', 'public', 'yes', 'yes', 'event 4 vikas', 'event 4', '1'),
(5, '2021-01-30 00:22:51', '2021-01-30 00:22:51', 'event 5', 15, 0, NULL, '2021-02-06 00:00:00', '01:15:00', 'AM', 30, '2', 'default.jpg', 'event 5 description ', 'event 5 description ', 1, ' 10', 'event 5 description ', 'public', 'yes', 'yes', 'Vikas W', 'event 5 description ', '1'),
(6, '2021-01-30 00:27:53', '2021-01-30 00:27:53', 'event 6 ', 15, 0, NULL, '2021-02-06 00:00:00', '01:15:00', 'AM', 30, '2', 'default.jpg', 'event 6  description', '', 1, ' 10', '', '', '', '', '', '', '1'),
(7, '2021-01-30 00:31:15', '2021-01-30 00:31:15', 'party all night', 15, 0, NULL, '2020-12-31 00:00:00', '00:00:00', '', 90, '45', 'default.jpg', 'Hello world!', '8', 1, '4545', '54', '', '', '', '5454', '58', '1'),
(8, '2021-01-30 00:36:14', '2021-01-30 00:36:14', 'party all night', 15, 0, NULL, '2020-12-31 00:00:00', '00:00:00', '', 90, '45', '1611947174.png', 'Hello world!', '8', 1, '4545', '54', '', '', '', '5454', '58', '1'),
(9, '2021-01-30 00:53:05', '2021-01-30 00:53:05', 'party all night', 15, 0, NULL, '2020-12-31 00:00:00', '00:00:00', '', 90, '45', '1611948185.png', 'Hello world!', '8', 1, '4545', '54', '', '', '', '5454', '58', '1'),
(10, '2021-01-30 00:54:50', '2021-01-30 00:54:50', 'event 7', 15, 0, NULL, '2021-02-06 00:00:00', '01:15:00', 'AM', 30, '2', '1611948290.jpg', 'event 7 description', '', 1, ' 10', '', '', '', '', '', '', '1'),
(11, '2021-01-30 12:10:54', '2021-02-01 13:34:43', 'Test Jan 30', 15, 0, NULL, '2021-02-03 00:00:00', '08:30:00', 'PM', 30, '2', '1612166683.png', 'event edited on 1 February 2021 event edited on 1 February 2021 event edited on 1 February 2021 event edited on 1 February 2021 event edited on 1 February 2021 event edited on 1 February 2021 event edited on 1 February 2021 event edited on 1 February 2021 event edited on 1 February 2021 event edited on 1 February 2021event edited on 1 February 2021 event edited on 1 February 2021 event edited on 1 February 2021 event edited on 1 February 2021 event edited on 1 February 2021event edited on 1 February 2021 event edited on 1 February 2021 event edited on 1 February 2021 event edited on 1 February 2021 event edited on 1 February 2021event edited on 1 February 2021 event edited on 1 February 2021 event edited on 1 February 2021 event edited on 1 February 2021 event edited on 1 February 2021event edited on 1 February 2021 event edited on 1 February 2021 event edited on 1 February 2021 event edited on 1 February 2021 event edited on 1 February 2021event edited on 1 February 2021 event edited on 1 February 2021 event edited on 1 February 2021 event edited on 1 February 2021 event edited on 1 February 2021event edited on 1 February 2021 event edited on 1 February 2021 event edited on 1 February 2021 event edited on 1 February 2021 event edited on 1 February 2021event edited on 1 February 2021 event edited on 1 February 2021 event edited ', '', 1, ' 10', '', '', '', '', '', '', '1'),
(12, '2021-01-30 18:10:04', '2021-01-30 18:10:04', 'Learn from makeup artist for IZONE', 15, 0, NULL, '2021-02-01 00:00:00', '05:30:00', 'AM', 30, '1', '1612010404.png', 'K-Pop stars dance and sweat under powerful spotlights on stage, so long-lasting makeup that doesn\'t melt is extremely important! If you wonder how they always look so put together and perfect, look no longer - join me as I walk you through the step-by-ste', '', 1, ' 10', '', '', '', '', '', '', '1'),
(13, '2021-01-30 19:20:50', '2021-01-30 19:20:50', 'event check event check event check even', 15, 0, NULL, '2021-03-13 00:00:00', '02:15:00', 'AM', 30, '1', '1612014650.jpg', 'event check event check event check even descritpevent check event check event check even descritpevent check event check event check even descritpevent check event check event check even descritpevent check event check event check even descritpevent check event check event check even descritpevent check event check event check even descritpevent check event check event check even descritpevent check event check event check even descritpevent check event check event check even descritpevent check event check event check even descritpevent check event check event check even descritpevent check event check event check even descritpevent check event check event check even descritpevent check event check event check even descritpevent check event check event check even descritpevent check event check event check even descritpevent check event check event check even descritpevent check event check event check even descritpevent check event check event check even descritpevent check event check event check even descritpevent check event check event check even descritpevent check event check event check even descritpevent check event check event check even descritpevent check event check event check even descritpevent check event check event check even descritpevent check event check event check even descritpevent check event check eve', '', 1, ' 10', '', '', '', '', 'Vikas', '', '1'),
(14, '2021-01-30 19:52:20', '2021-01-30 19:52:20', 'jan 30 event that doesnt display', 15, 0, NULL, '2021-01-31 00:00:00', '12:30:00', 'PM', 30, '1', '1612016540.png', 'jan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30 event that doesnt displayjan 30', '', 1, ' 10', '', '', '', '', '', '', '1'),
(15, '2021-02-01 13:38:28', '2021-02-01 13:38:28', 'How to Paint with Red Wine', 15, 0, NULL, '2021-02-01 00:00:00', '07:30:00', 'PM', 30, '1', '1612166908.png', 'This activity is very special, it is not only about the art, but as well about enjoying the time in a good company. We will learn to paint with RED WINE only. Sounds cool, right?\n\nEvery month I prepare a new drawing.\n\nAt the moment very few people worldwide use this technique, and I would be very happy to use it with you and help you paint with something that everyone has in their home.\n\nDuring the class I will explain the difference between wine technique and watercolors. I will help you understand more about supplies as paintbrushes and paper. Why we use some and not use other supplies.\n\nI will explain as well the basics of drawing lines, and how those help us on expressing ourselves. During the class, I will guide you, and help to solve your doubts, I will answer every question you will make. I will get out of you the artists that stay inside each of us.\n\nThis experience is great for groups, great for team-building and you can contact me for a new date and new time.\n\nOther things to note\nYou will need a good internet connection and please, make sure you have all the requested supplies. It would be difficult to get a great result without proper supplies.', '', 1, ' 10', '', '', '', '', '', '', '1'),
(16, '2021-02-01 14:04:40', '2021-02-01 14:04:40', 'Classical Piano Concert Live from Vienna', 15, 0, NULL, '2021-02-03 00:00:00', '08:30:00', 'PM', 30, '1', '1612168480.png', 'Classical Piano Concert from Vienna with an international prize winner pianist!\n\nBefore the currently situation my concert experience was no.1 Airbnb Experience in all Vienna/Austria. I decided to continue to my concerts in Online because I believe beauty of music connect us with each other and do our community stronger.\nI will tell short, interesting, funny stories behind of the pieces and play some famous classical piano pieces for you, also my own compositions..During the concert you can ask also your questions about music and piano. I would be very happy to answer you questions.\nI believe that this bad days will pass and we will meet again in beautiful concert halls but now time for Online Concert.\nLet\'s enjoy! :)\n\nYouTube: abuzarmanafzade\nInstagram: abuzarmanafzade\nFacebook: abuzarmanafzadeofficial\nTwitter: abuzarmanafzade', '', 1, ' 10', 'Please download \"ZOOM\" application on your mobile phone or computer before the experience ( www.zoom.us )\n\nAs Airbnb rule, it has to be ticket per person\n\nFor best sound quality experience, please prefer a headphone or external sound speaker\n\nStay positive and smile! :)', 'public', '', '', '', 'does this post anywhere?', '1'),
(17, '2021-02-01 14:13:52', '2021-02-01 14:13:52', 'Tango Concert with Latin Grammy Nominee', 15, 0, NULL, '2021-02-02 00:00:00', '05:30:00', 'PM', 60, '1', '1612169032.png', 'This experience is ideal for corporate groups, team-building, anniversaries, special celebrations and private groups. Now accepting private groups up to 100. Contact us to request a date.\n\n--\nExperience a soulful, intimate journey into the world of tango. Part cocktail party, part history lesson, part live concert, we will learn about the culture while feeling the camaraderie that comes from sharing live music together!\n\nWe love to bring people together across cultures through the music and stories of tango.\n\nThrough history, live music and personal anecdotes drawn from our four decades on stage, we will lead you from the origins of tango in the 1890s to the thriving Buenos Aires music scene of today, full of bands like ours that are reinventing tango for the modern world.\n\nJoin us for a world-class concert... in your living room!\n\n--\nThis experience is great for team building, date nights, family celebrations and all cultural adventurers. Custom-tailored events available for private groups. Join teams from Google, Facebook, Netflix and many other companies, law firms and universities that have already visited Buenos Aires virtually though the music and stories of tango.\n\nThis is part tango history class, part concert. We speak in English and sing in Spanish.\n\nThis is an online, virtual experience that can be joined from around ', '', 1, ' 10', '', '', '', '', '', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `event_attendees`
--

CREATE TABLE `event_attendees` (
  `id` int(11) NOT NULL,
  `addDate` datetime NOT NULL,
  `lastModified` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `status` enum('CONFIRM','CANCEL') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_attendees`
--

INSERT INTO `event_attendees` (`id`, `addDate`, `lastModified`, `user_id`, `event_id`, `status`) VALUES
(15, '2021-01-31 21:40:01', '2021-01-31 21:40:01', 15, 13, 'CONFIRM'),
(17, '2021-01-31 21:44:45', '2021-01-31 21:44:45', 15, 14, 'CONFIRM'),
(22, '2021-02-01 13:31:19', '2021-02-01 13:31:19', 15, 11, 'CONFIRM'),
(25, '2021-02-01 14:40:02', '2021-02-01 14:40:02', 15, 17, 'CONFIRM'),
(26, '2021-02-01 14:52:45', '2021-02-01 14:52:45', 15, 16, 'CONFIRM'),
(27, '2021-02-01 19:08:38', '2021-02-01 19:08:38', 15, 12, 'CONFIRM');

-- --------------------------------------------------------

--
-- Table structure for table `event_category`
--

CREATE TABLE `event_category` (
  `id` int(11) NOT NULL,
  `cat_title` varchar(255) DEFAULT NULL,
  `cat_image` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `orderno` int(11) DEFAULT NULL,
  `addDate` datetime DEFAULT NULL,
  `lastModified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_category`
--

INSERT INTO `event_category` (`id`, `cat_title`, `cat_image`, `status`, `orderno`, `addDate`, `lastModified`) VALUES
(1, 'Fashion and Beauty', 'default.jpg', 1, 4, '2020-11-10 00:00:00', '2020-11-10 00:00:00'),
(2, 'Food and Drink', 'default.jpg', 1, 2, '2020-11-10 00:00:00', '2020-11-10 00:00:00'),
(3, 'Business and Entrepreneurship', 'default.jpg', 1, 1, '2020-11-10 00:00:00', '2020-11-10 00:00:00'),
(4, 'Home and Garden', 'default.jpg', 1, 6, '2020-11-10 00:00:00', '2020-11-10 00:00:00'),
(5, 'Kids Activities', 'default.jpg', 1, 3, '2020-11-10 00:00:00', '2020-11-10 00:00:00'),
(6, 'Game Night', 'default.jpg', 1, 5, '2020-11-10 00:00:00', '2020-11-10 00:00:00'),
(7, 'Mingling Singles', 'default.jpg', 1, 7, '2020-11-10 00:00:00', '2020-11-10 00:00:00'),
(8, 'Others', 'default.jpg', 1, 8, '2020-11-10 00:00:00', '2020-11-10 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `event_cat_match`
--

CREATE TABLE `event_cat_match` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `addDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_cat_match`
--

INSERT INTO `event_cat_match` (`id`, `cat_id`, `event_id`, `addDate`) VALUES
(5, 2, 2, '2021-01-29 23:25:22'),
(6, 5, 2, '2021-01-29 23:25:22'),
(7, 1, 2, '2021-01-29 23:25:22'),
(8, 6, 2, '2021-01-29 23:25:22'),
(9, 2, 3, '2021-01-30 00:00:39'),
(10, 5, 3, '2021-01-30 00:00:39'),
(11, 1, 3, '2021-01-30 00:00:39'),
(12, 2, 4, '2021-01-30 00:02:38'),
(13, 5, 4, '2021-01-30 00:02:38'),
(14, 2, 5, '2021-01-30 00:22:51'),
(15, 5, 5, '2021-01-30 00:22:51'),
(16, 2, 6, '2021-01-30 00:27:53'),
(17, 5, 6, '2021-01-30 00:27:53'),
(18, 2, 7, '2021-01-30 00:31:15'),
(19, 1, 7, '2021-01-30 00:31:15'),
(20, 6, 7, '2021-01-30 00:31:15'),
(23, 2, 8, '2021-01-30 00:36:14'),
(24, 1, 8, '2021-01-30 00:36:14'),
(25, 6, 8, '2021-01-30 00:36:14'),
(26, 2, 9, '2021-01-30 00:53:05'),
(27, 1, 9, '2021-01-30 00:53:05'),
(28, 6, 9, '2021-01-30 00:53:05'),
(29, 2, 10, '2021-01-30 00:54:50'),
(30, 5, 10, '2021-01-30 00:54:50'),
(31, 1, 10, '2021-01-30 00:54:50'),
(32, 2, 1, '2021-01-30 00:59:24'),
(33, 5, 1, '2021-01-30 00:59:24'),
(37, 2, 12, '2021-01-30 18:10:04'),
(38, 5, 12, '2021-01-30 18:10:04'),
(39, 1, 12, '2021-01-30 18:10:04'),
(40, 2, 13, '2021-01-30 19:20:50'),
(41, 5, 13, '2021-01-30 19:20:50'),
(42, 1, 13, '2021-01-30 19:20:50'),
(43, 6, 13, '2021-01-30 19:20:50'),
(44, 2, 14, '2021-01-30 19:52:20'),
(45, 2, 11, '2021-02-01 13:34:43'),
(46, 6, 11, '2021-02-01 13:34:43'),
(47, 2, 15, '2021-02-01 13:38:28'),
(48, 6, 15, '2021-02-01 13:38:28'),
(49, 6, 16, '2021-02-01 14:04:40'),
(50, 5, 16, '2021-02-01 14:04:40'),
(51, 5, 17, '2021-02-01 14:13:52'),
(52, 6, 17, '2021-02-01 14:13:52'),
(53, 7, 17, '2021-02-01 14:13:52');

-- --------------------------------------------------------

--
-- Table structure for table `event_invites`
--

CREATE TABLE `event_invites` (
  `id` int(11) NOT NULL,
  `addDate` datetime NOT NULL,
  `lastModified` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `invite_email` varchar(255) DEFAULT NULL,
  `event_id` int(11) NOT NULL,
  `status` enum('CONFIRM','CANCEL') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_invites`
--

INSERT INTO `event_invites` (`id`, `addDate`, `lastModified`, `user_id`, `invite_email`, `event_id`, `status`) VALUES
(14, '2020-12-16 23:04:40', '2020-12-16 23:04:40', 2, 'dummyamd@gmail.com', 29, 'CONFIRM'),
(15, '2020-12-16 23:07:36', '2020-12-16 23:07:36', 2, 'dummyamd@gmail.com', 0, 'CONFIRM'),
(16, '2020-12-16 23:23:06', '2020-12-16 23:23:06', 2, 'dummyamd@gmail.com', 30, 'CONFIRM'),
(17, '2020-12-17 02:28:36', '2020-12-17 02:28:36', 2, 'dummyamd@gmail.com', 3, 'CONFIRM');

-- --------------------------------------------------------

--
-- Table structure for table `event_lang`
--

CREATE TABLE `event_lang` (
  `id` int(11) NOT NULL,
  `lang_title` varchar(255) DEFAULT NULL,
  `lang_image` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `addDate` datetime DEFAULT NULL,
  `lastModified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_lang`
--

INSERT INTO `event_lang` (`id`, `lang_title`, `lang_image`, `status`, `addDate`, `lastModified`) VALUES
(1, 'English', 'default.jpg', 1, '2020-11-10 00:00:00', '2020-11-10 00:00:00'),
(2, 'Hindi', 'default.jpg', 1, '2020-11-10 00:00:00', '2020-11-10 00:00:00'),
(3, 'Arabic', 'default.jpg', 1, '2020-11-10 00:00:00', '2020-11-10 00:00:00'),
(4, 'French', 'default.jpg', 1, NULL, NULL),
(5, 'German', 'default.jpg', 1, NULL, NULL),
(6, 'Italian', 'default.jpg', 1, NULL, NULL),
(7, 'Spanish', 'default.jpg', 1, NULL, NULL),
(8, 'Russian', 'default.jpg', 1, NULL, NULL),
(9, 'Mandarian', 'default.jpg', 1, NULL, NULL),
(10, 'Indonesian', 'default.jpg', 1, NULL, NULL),
(11, 'Portuguese', 'default.jpg', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event_lang_match`
--

CREATE TABLE `event_lang_match` (
  `id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `addDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_lang_match`
--

INSERT INTO `event_lang_match` (`id`, `lang_id`, `event_id`, `addDate`) VALUES
(1, 1, 4, '2021-01-30 00:02:38'),
(2, 1, 5, '2021-01-30 00:22:51'),
(3, 2, 5, '2021-01-30 00:22:51'),
(4, 1, 7, '2021-01-30 00:31:15'),
(5, 2, 7, '2021-01-30 00:31:15'),
(6, 1, 8, '2021-01-30 00:36:14'),
(7, 2, 8, '2021-01-30 00:36:14'),
(8, 1, 9, '2021-01-30 00:53:05'),
(9, 2, 9, '2021-01-30 00:53:05'),
(10, 1, 16, '2021-02-01 14:04:40'),
(11, 2, 16, '2021-02-01 14:04:40');

-- --------------------------------------------------------

--
-- Table structure for table `event_timezone`
--

CREATE TABLE `event_timezone` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `value_gcal` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `addDate` datetime DEFAULT NULL,
  `lastModified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event_timezone`
--

INSERT INTO `event_timezone` (`id`, `title`, `value`, `value_gcal`, `status`, `addDate`, `lastModified`) VALUES
(1, 'UTC', 'UTC', 'UTC', 1, '2020-11-10 00:00:00', '2020-11-10 00:00:00'),
(2, 'IST', 'Asia/Kolkata', 'Asia/Calcutta', 1, '2020-11-10 00:00:00', '2020-11-10 00:00:00'),
(3, 'CST', 'America/New_York', 'America/New_York', 1, '2020-11-10 00:00:00', '2020-11-10 00:00:00'),
(4, 'GMT', 'UK/ICELAND', 'UK/ICELAND', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  `bgcolor` char(7) NOT NULL DEFAULT '#607D8B'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`, `bgcolor`) VALUES
(1, 'admin', 'Administrator', '#F44336'),
(2, 'members', 'General User', '#2196F3');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `addDate` datetime DEFAULT NULL,
  `task` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `entity_id` int(11) DEFAULT NULL,
  `entity_title` varchar(255) DEFAULT NULL,
  `ipAddr` varchar(255) DEFAULT NULL,
  `extraDetail` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `addDate`, `task`, `description`, `entity_id`, `entity_title`, `ipAddr`, `extraDetail`) VALUES
(1, 2, '2020-11-26 21:08:28', '', 'Event cancelled by user', 30, '', '157.47.148.210', ''),
(2, 7, '2020-11-26 21:37:36', 'CANCEL_EVENT', 'Event cancelled by user', 3, '', '103.7.79.103', ''),
(3, 7, '2020-11-26 21:40:30', 'CANCEL_EVENT', 'Event cancelled by user', 3, '', '103.7.79.103', ''),
(4, 15, '2020-11-28 20:38:26', 'CANCEL_EVENT', 'Event cancelled by user', 32, '', '49.32.136.140', ''),
(5, 15, '2020-11-28 20:38:44', 'CANCEL_EVENT', 'Event cancelled by user', 32, '', '49.32.136.140', ''),
(6, 2, '2020-11-30 17:57:43', 'CANCEL_EVENT', 'Event cancelled by user', 32, '', '157.47.192.147', ''),
(7, 2, '2020-12-17 00:32:05', 'CANCEL_EVENT', 'Event cancelled by user', 30, '', '157.38.37.96', ''),
(8, 2, '2020-12-17 00:59:34', 'CANCEL_EVENT', 'Event cancelled by user', 10, '', '157.38.37.96', ''),
(9, 2, '2020-12-17 01:21:55', 'CANCEL_EVENT', 'Event cancelled by user', 30, '', '157.38.37.96', ''),
(10, 2, '2020-12-17 01:28:31', 'CANCEL_EVENT', 'Event cancelled by user', 10, '', '157.38.37.96', ''),
(11, 21, '2020-12-24 21:23:22', 'CANCEL_EVENT', 'Event cancelled by user', 34, '', '49.33.240.71', ''),
(12, 21, '2020-12-24 21:27:01', 'CANCEL_EVENT', 'Event cancelled by user', 34, '', '49.33.240.71', ''),
(13, 2, '2020-12-25 23:26:54', 'EVENT_FAV_ADD', 'Event added as favourite by user', 10, '', '157.37.125.157', ''),
(14, 2, '2020-12-25 23:26:59', 'EVENT_FAV_REMOVE', 'Event removed as favourite  by user', 10, '', '157.37.125.157', ''),
(15, 2, '2020-12-25 23:56:47', 'EVENT_FAV_ADD', 'Event added as favourite by user', 10, '', '157.37.125.157', ''),
(16, 2, '2020-12-25 23:56:51', 'EVENT_FAV_ADD', 'Event added as favourite by user', 34, '', '157.37.29.85', ''),
(17, 21, '2021-01-02 17:28:23', 'CANCEL_EVENT', 'Event cancelled by user', 35, '', '49.33.224.104', ''),
(18, 15, '2021-01-07 18:51:23', 'CANCEL_EVENT', 'Event cancelled by user', 31, '', '49.32.247.68', ''),
(19, 15, '2021-01-08 13:09:22', 'CANCEL_EVENT', 'Event cancelled by user', 46, '', '103.240.76.122', ''),
(20, 15, '2021-01-08 13:23:28', 'CANCEL_EVENT', 'Event cancelled by user', 46, '', '103.240.76.122', ''),
(21, 15, '2021-01-08 13:25:15', 'CANCEL_EVENT', 'Event cancelled by user', 46, '', '103.240.76.122', ''),
(22, 15, '2021-01-08 13:44:37', 'CANCEL_EVENT', 'Event cancelled by user', 44, '', '103.240.76.122', ''),
(23, 15, '2021-01-08 23:41:08', 'CANCEL_EVENT', 'Event cancelled by user', 45, '', '150.107.241.129', ''),
(24, 15, '2021-01-08 23:47:52', 'CANCEL_EVENT', 'Event cancelled by user', 39, '', '150.107.241.129', ''),
(25, 15, '2021-01-30 02:33:53', 'CANCEL_EVENT', 'Event cancelled by user', 1, '', '103.252.170.182', ''),
(26, 15, '2021-01-30 02:34:02', 'CANCEL_EVENT', 'Event cancelled by user', 1, '', '103.252.170.182', ''),
(27, 15, '2021-01-30 02:41:58', 'CANCEL_EVENT', 'Event cancelled by user', 4, '', '103.252.170.182', ''),
(28, 15, '2021-01-30 16:10:34', 'CANCEL_EVENT', 'Event cancelled by user', 11, '', '103.252.171.182', ''),
(29, 15, '2021-01-30 16:15:39', 'CANCEL_EVENT', 'Event cancelled by user', 11, '', '103.252.171.182', ''),
(30, 15, '2021-01-30 19:27:17', 'CANCEL_EVENT', 'Event cancelled by user', 13, '', '103.252.171.40', ''),
(31, 15, '2021-01-30 19:27:30', 'CANCEL_EVENT', 'Event cancelled by user', 13, '', '103.252.171.40', ''),
(32, 15, '2021-01-30 19:32:06', 'CANCEL_EVENT', 'Event cancelled by user', 12, '', '103.252.171.40', ''),
(33, 15, '2021-01-30 20:14:49', 'EVENT_FAV_ADD', 'Event added as favourite by user', 1, '', '49.32.155.38', ''),
(34, 15, '2021-01-30 20:15:02', 'EVENT_FAV_ADD', 'Event added as favourite by user', 14, '', '49.32.155.38', ''),
(35, 15, '2021-01-30 20:18:35', 'EVENT_FAV_REMOVE', 'Event removed as favourite  by user', 14, '', '49.32.155.38', ''),
(36, 15, '2021-01-30 20:18:42', 'EVENT_FAV_ADD', 'Event added as favourite by user', 14, '', '49.32.155.38', ''),
(37, 15, '2021-01-30 20:18:52', 'EVENT_FAV_REMOVE', 'Event removed as favourite  by user', 14, '', '49.32.155.38', ''),
(38, 15, '2021-01-30 22:18:51', 'EVENT_FAV_REMOVE', 'Event removed as favourite  by user', 1, '', '103.252.171.40', ''),
(39, 15, '2021-01-30 22:18:54', 'EVENT_FAV_ADD', 'Event added as favourite by user', 1, '', '103.252.171.40', ''),
(40, 15, '2021-01-31 10:35:27', 'CANCEL_EVENT', 'Event cancelled by user', 14, '', '49.33.235.159', ''),
(41, 15, '2021-01-31 10:35:39', 'CANCEL_EVENT', 'Event cancelled by user', 13, '', '49.33.235.159', ''),
(42, 15, '2021-01-31 19:41:15', 'CANCEL_EVENT', 'Event cancelled by user', 4, '', '103.252.170.101', ''),
(43, 15, '2021-01-31 19:42:33', 'CANCEL_EVENT', 'Event cancelled by user', 4, '', '103.252.170.101', ''),
(44, 15, '2021-01-31 21:39:38', 'CANCEL_EVENT', 'Event cancelled by user', 1, '', '49.33.250.18', ''),
(45, 15, '2021-01-31 21:41:04', 'EVENT_FAV_ADD', 'Event added as favourite by user', 12, '', '49.33.250.18', ''),
(46, 15, '2021-01-31 21:41:11', 'EVENT_FAV_REMOVE', 'Event removed as favourite  by user', 12, '', '49.33.250.18', ''),
(47, 15, '2021-01-31 21:41:16', 'EVENT_FAV_ADD', 'Event added as favourite by user', 12, '', '49.33.250.18', ''),
(48, 15, '2021-01-31 21:42:36', 'CANCEL_EVENT', 'Event cancelled by user', 14, '', '49.33.250.18', ''),
(49, 15, '2021-01-31 21:42:44', 'CANCEL_EVENT', 'Event cancelled by user', 12, '', '49.33.250.18', ''),
(50, 15, '2021-01-31 21:43:57', 'CANCEL_EVENT', 'Event cancelled by user', 11, '', '49.33.250.18', ''),
(51, 15, '2021-01-31 22:09:35', 'CANCEL_EVENT', 'Event cancelled by user', 1, '', '103.252.170.101', ''),
(52, 15, '2021-01-31 22:10:09', 'CANCEL_EVENT', 'Event cancelled by user', 1, '', '103.252.170.101', ''),
(53, 15, '2021-02-01 13:30:29', 'CANCEL_EVENT', 'Event cancelled by user', 11, '', '49.32.205.148', ''),
(54, 15, '2021-02-01 13:31:13', 'CANCEL_EVENT', 'Event cancelled by user', 11, '', '49.32.205.148', ''),
(55, 15, '2021-02-01 13:45:56', 'CANCEL_EVENT', 'Event cancelled by user', 12, '', '49.32.205.148', ''),
(56, 15, '2021-02-01 13:46:07', 'CANCEL_EVENT', 'Event cancelled by user', 15, '', '49.32.205.148', ''),
(57, 15, '2021-02-01 14:06:59', 'EVENT_FAV_ADD', 'Event added as favourite by user', 15, '', '49.32.205.148', ''),
(58, 15, '2021-02-01 14:39:59', 'CANCEL_EVENT', 'Event cancelled by user', 17, '', '49.32.205.148', '');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `addDate` datetime DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `link_value` varchar(255) DEFAULT NULL,
  `link_title` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `addDate`, `image`, `title`, `subtitle`, `link_value`, `link_title`, `status`) VALUES
(1, '2020-12-12 00:47:08', 'bg_id_1607714213.png', 'Slide one', 'slide one sub title', 'https://www.answebtechnologies.in', 'Read More', 1),
(2, '2020-12-12 00:51:17', 'EmakumeEkinpost_750x280_id_1607714458.jpg', 'Slide two', 'slide two sub title', 'https://www.answebtechnologies.in', 'sfsdf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `oauth_type` enum('FACEBOOK','GOOGLE','TWITTER','LINKEDIN') DEFAULT NULL,
  `oauth_data_fb` text,
  `oauth_data_google` text,
  `oauth_data_twitter` text,
  `oauth_data_linkedin` text,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `profilephoto` varchar(255) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `addDate` datetime DEFAULT NULL,
  `lastModified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `oauth_type`, `oauth_data_fb`, `oauth_data_google`, `oauth_data_twitter`, `oauth_data_linkedin`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `profilephoto`, `company`, `phone`, `addDate`, `lastModified`) VALUES
(1, NULL, '', '', '', NULL, '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', '', NULL, NULL, NULL, 1594665296, 1607709945, 1, 'Admin', 'istrator', NULL, 'ADMIN', '0', NULL, NULL),
(2, NULL, '', '', '', NULL, '', 'dummyamd@gmail.com', '$2y$10$oz7rsCZftK.azjpixcT.AuhhOkbl2kNVWTIzyCMYPWLLpFhaWzztS', NULL, 'dummyamd@gmail.com', NULL, '', 0, NULL, 0, NULL, NULL, 'Amit', 'Dave', NULL, NULL, NULL, '2020-11-12 22:39:37', '2021-01-04 14:30:34'),
(3, NULL, '', '', '', NULL, '', 'abc@test.com', '$2y$10$iL4fB1SRjdrLVYkIkMHfkuqri8okFHmz5Fgcv4ED1g2/STAR16qnG', NULL, 'test@test.com', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-13 18:38:37', '2020-11-13 18:38:37'),
(4, NULL, '', '', '', NULL, '', 'hafizfarooqpsr@gmail.com', '$2y$10$7CspZCP1J89xu6ednUYhOOTEl70C3nP0EQCe7Z.c8JiX2G/N5a5PC', NULL, 'hafizfarooqpsr@gmail.com', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-13 23:39:15', '2020-11-13 23:39:15'),
(5, NULL, '', '', '', NULL, '', 'nov16@mail.com', '$2y$10$Ti2eSyBEu8TxauhIQLtQ7ubwNJV4zH0G0WfyY79mAHoBlM9ppCf0q', NULL, 'nov16@mail.com', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-16 22:21:35', '2020-11-16 22:21:35'),
(7, NULL, '', '', '', NULL, '', 'hafizfarooq@gmail.com', '$2y$10$9qXNriKbeU7yMqUZmSmzFe/ZJviAqA.zfu2MG14uTZBREPf.Ocn6q', NULL, 'hafizfarooq@gmail.com', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-20 23:02:28', '2020-11-23 16:56:09'),
(9, NULL, '', '', '', NULL, '', 'abcd@test.com', '$2y$10$URuDXmifH3CCbd/LQMGf7.8rhrIA2UV78akMlveaaDFu4JDj5P/EG', NULL, 'abcd@test.com', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-24 15:04:44', '2020-11-24 15:04:44'),
(10, NULL, '', '', '', NULL, '', 'umerfarooq47@hotmail.com', '$2y$10$cyy3my2uXJuLMzTnOo6ZZusWj/bSHLcheeKmgLgQzNvEqQFc6g7wG', NULL, 'umerfarooq47@hotmail.com', NULL, '', 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-25 12:04:33', '2020-11-25 12:13:45'),
(12, NULL, '', '', '', NULL, '', 'abc@test.com', '$2y$10$wHW5TK/OyEyEE/VB5GGyJ.5nqg2mCMsXKSTLOo9UFzK8/ZzYwM6c.', NULL, 'abc@test.com', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-25 20:33:31', '2020-11-25 20:33:31'),
(13, NULL, '', '', '', NULL, '', 'kk@test.com', '$2y$10$SHUggBQyyicrOu.Zbw3wDOh39Nt7THg.FjL4E1LfE4HLEsLjYoa5y', NULL, 'kk@test.com', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-25 20:35:10', '2020-11-25 20:35:10'),
(14, NULL, '', '', '', NULL, '', 'test@gmail.com', '$2y$10$ojSB2IpBi0q0Otqbg04s2uaWLu0sODWA0Fgj.9pbF.OzeyXGR0EJC', NULL, 'test@gmail.com', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-26 01:50:40', '2020-11-26 01:50:40'),
(15, NULL, '', '', '', NULL, '', 'sanfrancali@hotmail.com', '$2y$10$6cnDtfmWQbtHWqFvw6KBtOtXF8kCiDyH3SnidKuBkXB1wtcS8C3fi', NULL, 'sanfrancali@hotmail.com', NULL, '$2y$10$ZhahDvRI2ALljyI2ubARI.fY8bhxD0MSdCnff4UX7TY8JGTY3cYUW', 1612069646, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-11-26 20:14:44', '2021-01-07 18:50:16'),
(16, NULL, '', '', '', NULL, '', 'sindia@gmail.com', '$2y$10$/B5Si7DyrD9HVsZHXJIeWOsVLMPc5B8pgkBdoc5fGYpTZIKvXNRRq', NULL, 'sindia@gmail.com', NULL, '1958724710', 1608565191, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-12-01 20:26:39', '2020-12-01 20:26:39'),
(21, NULL, NULL, NULL, NULL, NULL, '', 'bharwans@yahoo.com', '$2y$10$pFq1iq22/Wi4CGGCyD6W3ujAVKORjpbCihlFQhNcLX6vO.81kJLB6', NULL, 'bharwans@yahoo.com', NULL, '', 0, NULL, 0, NULL, NULL, 'sindia', '', '', NULL, NULL, '2020-12-22 21:08:40', '2020-12-24 21:04:05'),
(27, NULL, NULL, NULL, NULL, NULL, '', 'sahil.blueberry@gmail.com', '$2y$10$8oqjK78XqkbG6pm6ng1JpOOszVUbUbRCgjD2x/ZcEHQCSA5dBxdG2', NULL, 'sahil.blueberry@gmail.com', NULL, NULL, NULL, NULL, 0, NULL, NULL, 'sahil', '', '', NULL, NULL, '2021-01-08 13:52:41', '2021-01-08 13:52:41'),
(28, NULL, NULL, NULL, NULL, NULL, '', 'vikas.cool786@gmail.com', '$2y$10$Dio1DvO5tqin8sd2lsDP.O5hHP9O7R14x5TfFuW4WLk3qcT8yULdm', NULL, 'vikas.cool786@gmail.com', NULL, '$2y$10$QhmnKkfdZ7eenzX9gEpF.HwdEZoDPXyElWIzgeIZSxhpP7OwY6', 1612032716, NULL, 0, NULL, NULL, 'vikas', '', '', NULL, NULL, '2021-01-30 23:38:12', '2021-01-31 00:16:57');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_fav_events`
--

CREATE TABLE `user_fav_events` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `addDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_fav_events`
--

INSERT INTO `user_fav_events` (`id`, `user_id`, `event_id`, `addDate`) VALUES
(4, 15, 1, '2021-01-30 22:18:54'),
(6, 15, 12, '2021-01-31 21:41:16'),
(7, 15, 15, '2021-02-01 14:06:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_preferences`
--
ALTER TABLE `admin_preferences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_attendees`
--
ALTER TABLE `event_attendees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_category`
--
ALTER TABLE `event_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_cat_match`
--
ALTER TABLE `event_cat_match`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_invites`
--
ALTER TABLE `event_invites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_lang`
--
ALTER TABLE `event_lang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_lang_match`
--
ALTER TABLE `event_lang_match`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_timezone`
--
ALTER TABLE `event_timezone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- Indexes for table `user_fav_events`
--
ALTER TABLE `user_fav_events`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_preferences`
--
ALTER TABLE `admin_preferences`
  MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `event_attendees`
--
ALTER TABLE `event_attendees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `event_category`
--
ALTER TABLE `event_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `event_cat_match`
--
ALTER TABLE `event_cat_match`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `event_invites`
--
ALTER TABLE `event_invites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `event_lang`
--
ALTER TABLE `event_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `event_lang_match`
--
ALTER TABLE `event_lang_match`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `event_timezone`
--
ALTER TABLE `event_timezone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_fav_events`
--
ALTER TABLE `user_fav_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
