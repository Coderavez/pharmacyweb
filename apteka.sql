-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Мар 18 2025 г., 08:54
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `mysql`
--

-- --------------------------------------------------------

--
-- Структура таблицы `chek`
--

CREATE TABLE `chek` (
  `id` int(11) NOT NULL,
  `all_sum` decimal(10,2) DEFAULT NULL,
  `date_buy` date DEFAULT NULL,
  `id_pokypatelya` int(11) DEFAULT NULL,
  `id_trydyaga` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `chek`
--

INSERT INTO `chek` (`id`, `all_sum`, `date_buy`, `id_pokypatelya`, `id_trydyaga`) VALUES
(1, 350.25, '2023-10-27', 1, 1),
(2, 200.00, '2023-10-27', 2, 2),
(3, 125.50, '2023-10-28', 3, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `lekarstvo`
--

CREATE TABLE `lekarstvo` (
  `id` int(11) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `storage_life` date DEFAULT NULL,
  `recipe` tinyint(1) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `name_drug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `lekarstvo`
--

INSERT INTO `lekarstvo` (`id`, `country`, `storage_life`, `recipe`, `price`, `name_drug`) VALUES
(1, 'Россия', '2024-12-31', 1, 150.50, 'Аспирин'),
(2, 'Германия', '2025-06-30', 0, 200.75, 'Ибупрофен'),
(3, 'Индия', '2024-03-15', 1, 100.00, 'Парацетамол');

-- --------------------------------------------------------

--
-- Структура таблицы `pokypatel`
--

CREATE TABLE `pokypatel` (
  `id` int(11) NOT NULL,
  `name_shoper` varchar(255) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `pokypatel`
--

INSERT INTO `pokypatel` (`id`, `name_shoper`, `number`, `password`) VALUES
(1, 'Иванов Иван', '1234567890', 'password123'),
(2, 'Петрова Анна', '9876543210', 'securepass'),
(3, 'Сидоров Сергей', '5551234567', 'mysecret');

-- --------------------------------------------------------

--
-- Структура таблицы `tovarcheka`
--

CREATE TABLE `tovarcheka` (
  `id` int(11) NOT NULL,
  `id_lekarstva` int(11) DEFAULT NULL,
  `id_cheka` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `tovarcheka`
--

INSERT INTO `tovarcheka` (`id`, `id_lekarstva`, `id_cheka`) VALUES
(1, 1, 1),
(4, 1, 3),
(2, 2, 1),
(5, 2, 3),
(3, 3, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `trydyaga`
--

CREATE TABLE `trydyaga` (
  `id` int(11) NOT NULL,
  `name_worker` varchar(255) DEFAULT NULL,
  `work_experience` int(11) DEFAULT NULL,
  `post` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `trydyaga`
--

INSERT INTO `trydyaga` (`id`, `name_worker`, `work_experience`, `post`) VALUES
(1, 'Сидорова Мария', 5, 'Фармацевт'),
(2, 'Козлов Петр', 2, 'Продавец'),
(3, 'Смирнова Елена', 8, 'Старший фармацевт');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `chek`
--
ALTER TABLE `chek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pokypatelya` (`id_pokypatelya`),
  ADD KEY `id_trydyaga` (`id_trydyaga`);

--
-- Индексы таблицы `lekarstvo`
--
ALTER TABLE `lekarstvo`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pokypatel`
--
ALTER TABLE `pokypatel`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tovarcheka`
--
ALTER TABLE `tovarcheka`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `TovarCheka_id_lekarstva_id_cheka_IDX` (`id_lekarstva`,`id_cheka`),
  ADD KEY `id_cheka` (`id_cheka`);

--
-- Индексы таблицы `trydyaga`
--
ALTER TABLE `trydyaga`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `chek`
--
ALTER TABLE `chek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `lekarstvo`
--
ALTER TABLE `lekarstvo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `pokypatel`
--
ALTER TABLE `pokypatel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `tovarcheka`
--
ALTER TABLE `tovarcheka`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `trydyaga`
--
ALTER TABLE `trydyaga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `chek`
--
ALTER TABLE `chek`
  ADD CONSTRAINT `chek_ibfk_1` FOREIGN KEY (`id_pokypatelya`) REFERENCES `pokypatel` (`id`),
  ADD CONSTRAINT `chek_ibfk_2` FOREIGN KEY (`id_trydyaga`) REFERENCES `trydyaga` (`id`);

--
-- Ограничения внешнего ключа таблицы `tovarcheka`
--
ALTER TABLE `tovarcheka`
  ADD CONSTRAINT `tovarcheka_ibfk_1` FOREIGN KEY (`id_lekarstva`) REFERENCES `lekarstvo` (`id`),
  ADD CONSTRAINT `tovarcheka_ibfk_2` FOREIGN KEY (`id_cheka`) REFERENCES `chek` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
