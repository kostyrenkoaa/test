-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 05 2019 г., 23:51
-- Версия сервера: 5.7.23
-- Версия PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `testw`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `summ` varchar(11) NOT NULL,
  `token_block` varchar(32) NOT NULL DEFAULT '',
  `date_block` timestamp NULL DEFAULT NULL,
  `currency` varchar(4) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `bank_accounts`
--

INSERT INTO `bank_accounts` (`id`, `user_id`, `summ`, `token_block`, `date_block`, `currency`) VALUES
(7, 1, '85324.46', '', '2019-08-05 19:51:22', 'AMD'),
(8, 1, '999999900', '', '2019-07-28 11:11:58', 'BRL'),
(9, 1, '25.5', '', '2019-08-05 19:28:41', 'RUB');

-- --------------------------------------------------------

--
-- Структура таблицы `currency`
--

CREATE TABLE `currency` (
  `id` int(2) NOT NULL,
  `date` datetime NOT NULL,
  `currency` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `currency`
--

INSERT INTO `currency` (`id`, `date`, `currency`) VALUES
(1, '2019-08-04 22:43:00', '{\"AMD\": {\"Name\": \"Армянских драмов\", \"Value\": \"13,5840\", \"Nominal\": \"100\", \"NumCode\": \"051\", \"CharCode\": \"AMD\"}, \"AUD\": {\"Name\": \"Австралийский доллар\", \"Value\": \"43,9051\", \"Nominal\": \"1\", \"NumCode\": \"036\", \"CharCode\": \"AUD\"}, \"AZN\": {\"Name\": \"Азербайджанский манат\", \"Value\": \"38,1033\", \"Nominal\": \"1\", \"NumCode\": \"944\", \"CharCode\": \"AZN\"}, \"BGN\": {\"Name\": \"Болгарский лев\", \"Value\": \"36,6786\", \"Nominal\": \"1\", \"NumCode\": \"975\", \"CharCode\": \"BGN\"}, \"BRL\": {\"Name\": \"Бразильский реал\", \"Value\": \"16,8392\", \"Nominal\": \"1\", \"NumCode\": \"986\", \"CharCode\": \"BRL\"}, \"BYN\": {\"Name\": \"Белорусский рубль\", \"Value\": \"31,4087\", \"Nominal\": \"1\", \"NumCode\": \"933\", \"CharCode\": \"BYN\"}, \"CAD\": {\"Name\": \"Канадский доллар\", \"Value\": \"48,8937\", \"Nominal\": \"1\", \"NumCode\": \"124\", \"CharCode\": \"CAD\"}, \"CHF\": {\"Name\": \"Швейцарский франк\", \"Value\": \"65,5402\", \"Nominal\": \"1\", \"NumCode\": \"756\", \"CharCode\": \"CHF\"}, \"CNY\": {\"Name\": \"Китайских юаней\", \"Value\": \"93,1351\", \"Nominal\": \"10\", \"NumCode\": \"156\", \"CharCode\": \"CNY\"}, \"CZK\": {\"Name\": \"Чешских крон\", \"Value\": \"27,8091\", \"Nominal\": \"10\", \"NumCode\": \"203\", \"CharCode\": \"CZK\"}, \"DKK\": {\"Name\": \"Датских крон\", \"Value\": \"96,0895\", \"Nominal\": \"10\", \"NumCode\": \"208\", \"CharCode\": \"DKK\"}, \"EUR\": {\"Name\": \"Евро\", \"Value\": \"71,7077\", \"Nominal\": \"1\", \"NumCode\": \"978\", \"CharCode\": \"EUR\"}, \"GBP\": {\"Name\": \"Фунт стерлингов Соединенного королевства\", \"Value\": \"78,3982\", \"Nominal\": \"1\", \"NumCode\": \"826\", \"CharCode\": \"GBP\"}, \"HKD\": {\"Name\": \"Гонконгских долларов\", \"Value\": \"82,6543\", \"Nominal\": \"10\", \"NumCode\": \"344\", \"CharCode\": \"HKD\"}, \"HUF\": {\"Name\": \"Венгерских форинтов\", \"Value\": \"21,8893\", \"Nominal\": \"100\", \"NumCode\": \"348\", \"CharCode\": \"HUF\"}, \"INR\": {\"Name\": \"Индийских рупий\", \"Value\": \"92,8569\", \"Nominal\": \"100\", \"NumCode\": \"356\", \"CharCode\": \"INR\"}, \"JPY\": {\"Name\": \"Японских иен\", \"Value\": \"60,4388\", \"Nominal\": \"100\", \"NumCode\": \"392\", \"CharCode\": \"JPY\"}, \"KGS\": {\"Name\": \"Киргизских сомов\", \"Value\": \"92,6904\", \"Nominal\": \"100\", \"NumCode\": \"417\", \"CharCode\": \"KGS\"}, \"KRW\": {\"Name\": \"Вон Республики Корея\", \"Value\": \"53,8170\", \"Nominal\": \"1000\", \"NumCode\": \"410\", \"CharCode\": \"KRW\"}, \"KZT\": {\"Name\": \"Казахстанских тенге\", \"Value\": \"16,7435\", \"Nominal\": \"100\", \"NumCode\": \"398\", \"CharCode\": \"KZT\"}, \"MDL\": {\"Name\": \"Молдавских леев\", \"Value\": \"36,2619\", \"Nominal\": \"10\", \"NumCode\": \"498\", \"CharCode\": \"MDL\"}, \"NOK\": {\"Name\": \"Норвежских крон\", \"Value\": \"72,4235\", \"Nominal\": \"10\", \"NumCode\": \"578\", \"CharCode\": \"NOK\"}, \"PLN\": {\"Name\": \"Польский злотый\", \"Value\": \"16,6458\", \"Nominal\": \"1\", \"NumCode\": \"985\", \"CharCode\": \"PLN\"}, \"RON\": {\"Name\": \"Румынский лей\", \"Value\": \"15,1497\", \"Nominal\": \"1\", \"NumCode\": \"946\", \"CharCode\": \"RON\"}, \"RUB\": {\"Name\": \"Российский рубль \", \"Value\": 1, \"Nominal\": 1, \"NumCode\": 643, \"CharCode\": \"RUB\"}, \"SEK\": {\"Name\": \"Шведских крон\", \"Value\": \"66,8794\", \"Nominal\": \"10\", \"NumCode\": \"752\", \"CharCode\": \"SEK\"}, \"SGD\": {\"Name\": \"Сингапурский доллар\", \"Value\": \"46,9273\", \"Nominal\": \"1\", \"NumCode\": \"702\", \"CharCode\": \"SGD\"}, \"TJS\": {\"Name\": \"Таджикских сомони\", \"Value\": \"68,4785\", \"Nominal\": \"10\", \"NumCode\": \"972\", \"CharCode\": \"TJS\"}, \"TMT\": {\"Name\": \"Новый туркменский манат\", \"Value\": \"18,4957\", \"Nominal\": \"1\", \"NumCode\": \"934\", \"CharCode\": \"TMT\"}, \"TRY\": {\"Name\": \"Турецкая лира\", \"Value\": \"11,5420\", \"Nominal\": \"1\", \"NumCode\": \"949\", \"CharCode\": \"TRY\"}, \"UAH\": {\"Name\": \"Украинских гривен\", \"Value\": \"25,3112\", \"Nominal\": \"10\", \"NumCode\": \"980\", \"CharCode\": \"UAH\"}, \"USD\": {\"Name\": \"Доллар США\", \"Value\": \"64,6423\", \"Nominal\": \"1\", \"NumCode\": \"840\", \"CharCode\": \"USD\"}, \"UZS\": {\"Name\": \"Узбекских сумов\", \"Value\": \"74,5870\", \"Nominal\": \"10000\", \"NumCode\": \"860\", \"CharCode\": \"UZS\"}, \"XDR\": {\"Name\": \"СДР (специальные права заимствования)\", \"Value\": \"88,5360\", \"Nominal\": \"1\", \"NumCode\": \"960\", \"CharCode\": \"XDR\"}, \"ZAR\": {\"Name\": \"Южноафриканских рэндов\", \"Value\": \"43,9409\", \"Nominal\": \"10\", \"NumCode\": \"710\", \"CharCode\": \"ZAR\"}}');

-- --------------------------------------------------------

--
-- Структура таблицы `opiration_logs`
--

CREATE TABLE `opiration_logs` (
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `summ` varchar(11) NOT NULL,
  `currency` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `opiration_logs`
--

INSERT INTO `opiration_logs` (`date`, `user_id`, `summ`, `currency`) VALUES
('2019-08-05 20:27:36', 1, '22', 'AMD'),
('2019-08-05 20:28:45', 1, '5', 'RUB'),
('2019-08-05 20:30:24', 1, '20', 'AMD'),
('2019-08-05 20:30:30', 1, '20', 'AMD'),
('2019-08-05 20:40:33', 1, '60', 'AMD'),
('2019-08-05 20:40:40', 1, '50', 'AMD'),
('2019-08-05 20:49:15', 1, '50', 'AMD'),
('2019-08-05 20:49:27', 1, '21', 'RUB'),
('2019-08-05 20:49:30', 1, '10', 'AMD'),
('2019-08-05 20:49:34', 1, '10', 'AMD'),
('2019-08-05 20:49:45', 1, '10', 'RUB'),
('2019-08-05 20:50:14', 1, '41', 'AMD'),
('2019-08-05 20:50:30', 1, '10', 'RUB'),
('2019-08-05 20:51:17', 1, '23', 'AMD'),
('2019-08-05 20:51:22', 1, '0,14', 'EUR');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `token` varchar(32) DEFAULT NULL,
  `sol` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `token`, `sol`) VALUES
(1, 'admin', '$2y$10$NH4PFKPYyHwQtB4mVKaV5usBViaRhEumguxfU0niX3Zy911Xm85eK', '2276a54b2412b848b76a2ba08849ec77', '55deb7fd23a25aa863fb912ff7fc21d8');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `opiration_logs`
--
ALTER TABLE `opiration_logs`
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `token` (`token`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
