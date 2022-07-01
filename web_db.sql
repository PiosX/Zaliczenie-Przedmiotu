-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 01 Lip 2022, 11:56
-- Wersja serwera: 10.4.19-MariaDB
-- Wersja PHP: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `web_db`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `avatars`
--

CREATE TABLE `avatars` (
  `id` int(11) NOT NULL,
  `login` varchar(30) NOT NULL,
  `image` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `avatars`
--

INSERT INTO `avatars` (`id`, `login`, `image`) VALUES
(1, 'test', '2b02a53e5da68004d5c310c69bde486cfootball-fans-stadium-from.jpg'),
(2, 'max', 'caee33677fbc08b157bac3d56949bdcacrowd-fans-concert.jpg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `check_status`
--

CREATE TABLE `check_status` (
  `id` int(11) NOT NULL,
  `login` varchar(30) NOT NULL,
  `set_to` varchar(30) NOT NULL,
  `check_status` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `check_status`
--

INSERT INTO `check_status` (`id`, `login`, `set_to`, `check_status`) VALUES
(1, 'max', 'test', 1),
(2, 'test', 'max', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `send_by` varchar(30) NOT NULL,
  `send_to` varchar(30) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `messages`
--

INSERT INTO `messages` (`id`, `send_by`, `send_to`, `message`) VALUES
(1, 'max', 'test', 'Cześć!'),
(2, 'test', 'max', 'Siemanko!');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `online_users`
--

CREATE TABLE `online_users` (
  `id` int(11) NOT NULL,
  `login` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `online_users`
--

INSERT INTO `online_users` (`id`, `login`) VALUES
(5, 'test'),
(6, 'max');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `login`, `email`, `password`) VALUES
(6, 'test', 'test@wp.pl', '$2y$12$QFkuPOm8cNu4i0qN/bZpYuASMbpk4UR671RH.wMERcM0riXTxeepS'),
(7, 'max', 'max@wp.pl', '$2y$12$c5eYFXLTtqJer6sWksh2PeXt7H7/iyDTp8sXzk/nAx00h2iCTmP.e');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_stats`
--

CREATE TABLE `user_stats` (
  `id` int(11) NOT NULL,
  `login` varchar(30) NOT NULL,
  `watchers` int(30) NOT NULL,
  `posts` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `avatars`
--
ALTER TABLE `avatars`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `check_status`
--
ALTER TABLE `check_status`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `online_users`
--
ALTER TABLE `online_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `user_stats`
--
ALTER TABLE `user_stats`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `avatars`
--
ALTER TABLE `avatars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `check_status`
--
ALTER TABLE `check_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `online_users`
--
ALTER TABLE `online_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `user_stats`
--
ALTER TABLE `user_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
