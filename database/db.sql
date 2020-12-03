-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Des 2020 pada 03.03
-- Versi server: 10.4.16-MariaDB
-- Versi PHP: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `quiz`
--

CREATE TABLE `quiz` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `question_type` varchar(20) NOT NULL,
  `options` text DEFAULT NULL,
  `image_path` varchar(200) DEFAULT NULL,
  `images` varchar(300) DEFAULT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `quiz`
--

INSERT INTO `quiz` (`id`, `question`, `question_type`, `options`, `image_path`, `images`, `answer`) VALUES
(1, 'What are the three primary colours? (Apa saja tiga warna  primer?)', 'multiple', 'Blue$$Red$$Yellow$$Black', NULL, NULL, 'Blue$$Red$$Yellow'),
(2, 'A clock strikes once at 1 o’clock, twice at 2 o’clock, thrice at 3 o’clock and so on. How many times will it strike in 24 hours? (Sebuah jam berdering sekali saat pukul 1, dua kali saat pukul 2, tiga kali saat pukul 3 dan seterusnya. Berapa banyak deringan yang terjadi selama 24 jam?) ', 'single', '78$$136$$156$$196', NULL, NULL, '156'),
(3, 'What is the next prime number after 7? (Apa bilangan prima setelah 7?)', 'text', NULL, NULL, NULL, '11'),
(4, 'Place the following numbers in ascending order (Urutkan bilangan berikut dalam urutan naik)', 'dragndrop', NULL, 'images', '49.jpg$$23.jpg$$5.jpg$$37.jpg$$84.jpg$$78.jpg', '5.jpg$$23.jpg$$37.jpg$$49.jpg$$78.jpg$$84.jpg'),
(5, 'In which direction do we see the sunrise? (Di arah mana matahari terbit?)', 'single', 'West$$South$$East$$North', 'images', 'sunrise.jpg', 'East'),
(6, 'Which of these countries is NOT a part of the Asian continent? (Negara mana saja yang bukan di benua Asia?)', 'multiple', 'Japan$$Canada$$Hong Kong$$Brazil', NULL, NULL, 'Canada$$Brazil'),
(7, 'Which of these is NOT a province in Indonesia? (Provinsi mana saja yang bukan provinsi di Indonesia?)', 'multiple', 'South Kalimantan$$Yangtze$$Alberta$$Victoria', NULL, NULL, 'Yangtze$$Alberta$$Victoria'),
(8, 'What is the capital of Indonesia? (Apa ibukota dari Indonesia?)', 'single', 'Jakarta$$Bandung$$Medan$$Bogor', NULL, NULL, 'Jakarta'),
(9, 'Which of these numbers is a prime number? Place them in ascending order (Bilangan mana saja yang merupakan bilangan prima? Urutkan dalam urutan naik)', 'dragndrop', '', 'images', '49.jpg$$23.jpg$$5.jpg$$37.jpg$$84.jpg$$78.jpg', '5.jpg$$23.jpg$$37.jpg'),
(10, 'What is 1004 divided by 2? (Apa hasil dari 1004 dibagi 2?)', 'single', '52$$502$$520$$5002', NULL, NULL, '502'),
(11, '106 × 106 – 94 × 94 = ....', 'text', NULL, NULL, NULL, '2400'),
(12, 'What is the next number in the Fibonacci sequence: 0, 1, 1, 2, 3, 5, 8, 13, 21, 34, ? (Apa bilangan berikutnya dari barisan Fibonacci: 0, 1, 1, 2, 3, 5, 8, 13, 21, 34, ?)', 'text', NULL, NULL, NULL, '55'),
(13, '5 to the power of 0 equals what? (Berapa hasil dari 5 pangkat 0?)', 'text', NULL, NULL, NULL, '1'),
(14, 'Which of these numbers is a even number? Place them in ascending order', 'dragndrop', NULL, 'images', '49.jpg$$23.jpg$$5.jpg$$37.jpg$$84.jpg$$78.jpg', '78.jpg$$84.jpg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
