-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2026 at 07:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.5.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rpl_forit`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `bookmark_id` char(26) NOT NULL,
  `user_id` char(26) NOT NULL,
  `thread_id` char(26) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookmarks`
--

INSERT INTO `bookmarks` (`bookmark_id`, `user_id`, `thread_id`, `created_at`) VALUES
('01KRWP4YBPHPM1SMMG3N09PQH2', '01KRWNT7E7B2X87HKWT8FQ735M', '01KRWNV0DDMY5TE56XVSPF6C8S', '2026-05-18 04:40:15');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` char(26) NOT NULL,
  `content` text NOT NULL,
  `parent_comment_id` char(26) DEFAULT NULL,
  `thread_id` char(26) NOT NULL,
  `author_id` char(26) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `content`, `parent_comment_id`, `thread_id`, `author_id`, `is_active`, `created_at`, `updated_at`) VALUES
('01KRWNP3YPYM365X7D4D8KXVWZ', 'haa', NULL, '01KRWNNVA7Q02QYTXQ7283KHA8', '01KRWNMD4YGSGNTGJKW803HGEB', 1, '2026-05-18 04:32:09', '2026-05-18 04:32:09'),
('01KRWNPARP4QHRKG8V172GTZNN', 'iya', '01KRWNP3YPYM365X7D4D8KXVWZ', '01KRWNNVA7Q02QYTXQ7283KHA8', '01KRWNMD4YGSGNTGJKW803HGEB', 1, '2026-05-18 04:32:16', '2026-05-18 04:32:16'),
('01KRWP165VSNY4X3R8CBG98XPN', 'baca', NULL, '01KRWNV0DDMY5TE56XVSPF6C8S', '01KRWNT7E7B2X87HKWT8FQ735M', 1, '2026-05-18 04:38:12', '2026-05-18 04:38:12'),
('01KRWPFX61GH5AYRE5KWZ8X579', 'kkkkk', NULL, '01KRWPEVVHWM2QHKZY7NT8W1PS', '01HWXXXXXXXXXXXXXXXXSADMIN', 1, '2026-05-18 04:46:14', '2026-05-18 04:46:14');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` char(26) NOT NULL,
  `thread_id` char(26) DEFAULT NULL,
  `comment_id` char(26) DEFAULT NULL,
  `reporter_id` char(26) NOT NULL,
  `reason` text NOT NULL,
  `status` enum('pending','takedown','warning','dismissed') DEFAULT 'pending',
  `reviewed_by` char(26) DEFAULT NULL,
  `reported_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reviewed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`report_id`, `thread_id`, `comment_id`, `reporter_id`, `reason`, `status`, `reviewed_by`, `reported_at`, `reviewed_at`) VALUES
('01KRWNXN1648TB3MJ15WE93TX2', '01KRWNV0DDMY5TE56XVSPF6C8S', NULL, '01KRWNX1KXGXVD9G1YFPVPNBGS', 'gak papa', 'warning', '01KRWNMD4YGSGNTGJKW803HGEB', '2026-05-18 04:36:16', '2026-05-18 04:37:00'),
('01KRWP1W8KD20GTYWJZK9Z0F6N', '01KRWP0KWBDS57PHNE8BATH4WT', NULL, '01KRWNX1KXGXVD9G1YFPVPNBGS', 'gk pp', 'takedown', '01KRWNMD4YGSGNTGJKW803HGEB', '2026-05-18 04:38:35', '2026-05-18 04:38:56');

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE `threads` (
  `thread_id` char(26) NOT NULL,
  `thread_title` varchar(100) NOT NULL,
  `thread_description` text NOT NULL,
  `author_id` char(26) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `threads`
--

INSERT INTO `threads` (`thread_id`, `thread_title`, `thread_description`, `author_id`, `is_active`, `created_at`, `updated_at`) VALUES
('01KRWNNVA7Q02QYTXQ7283KHA8', 'Pencegahan', 'penceaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '01KRWNMD4YGSGNTGJKW803HGEB', 1, '2026-05-18 04:32:00', '2026-05-18 04:32:00'),
('01KRWNV0DDMY5TE56XVSPF6C8S', 'bnnnnnnnnnnnnnnnnnnas', 'asppppppppppppppppdaaaaaaaaaaaaaaaaaaaaaaaa', '01KRWNT7E7B2X87HKWT8FQ735M', 1, '2026-05-18 04:34:49', '2026-05-18 04:34:49'),
('01KRWP0KWBDS57PHNE8BATH4WT', 'sdjfbaik', 'tvybunimo,pkojihuyvuijjbjoknasjnddasfasds', '01KRWNT7E7B2X87HKWT8FQ735M', 0, '2026-05-18 04:37:53', '2026-05-18 04:38:56'),
('01KRWPEVVHWM2QHKZY7NT8W1PS', 'Pencegahan', 'kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk', '01HWXXXXXXXXXXXXXXXXSADMIN', 1, '2026-05-18 04:45:40', '2026-05-18 04:45:40'),
('01THRD00000000000000000001', 'Diskusi dasar tentang Pemrograman #1', 'Saya ingin berdiskusi mengenai konsep dasar Pemrograman. Menurut kalian, apa hal paling penting yang harus dipahami oleh pemula?', '01USER00000000000000000001', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000002', 'Rekomendasi belajar Jaringan & Sistem #2', 'Bagikan rekomendasi materi, tools, atau pengalaman belajar yang berkaitan dengan Jaringan & Sistem.', '01USER00000000000000000002', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000003', 'Masalah umum pada Keamanan Siber #3', 'Saya sering menemukan kendala saat mempelajari Keamanan Siber. Apa solusi atau tips dari teman-teman?', '01USER00000000000000000003', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000004', 'Tips memahami Kecerdasan Buatan #4', 'Topik Kecerdasan Buatan semakin banyak dibahas. Apa tips agar lebih mudah memahami konsepnya?', '01USER00000000000000000004', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000005', 'Pengalaman menggunakan Database #5', 'Saya ingin berbagi pengalaman tentang Database. Silakan tambahkan pengalaman atau pendapat kalian.', '01USER00000000000000000005', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000006', 'Pertanyaan seputar Web Development #6', 'Saya punya beberapa pertanyaan tentang Web Development. Bagaimana cara terbaik untuk mulai mempelajarinya?', '01USER00000000000000000006', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000007', 'Roadmap belajar Mobile Development #7', 'Menurut kalian, roadmap belajar Mobile Development yang cocok untuk mahasiswa seperti apa?', '01USER00000000000000000007', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000008', 'Tools favorit untuk Cloud Computing #8', 'Apa tools yang sering kalian gunakan saat belajar atau mengerjakan proyek Cloud Computing?', '01USER00000000000000000008', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000009', 'Cara membuat proyek Open Source #9', 'Saya ingin membuat proyek sederhana tentang Open Source. Fitur apa saja yang cocok untuk pemula?', '01USER00000000000000000009', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000010', 'Sharing pengalaman Diskusi Umum #10', 'Silakan berbagi pengalaman, kendala, atau insight menarik seputar Diskusi Umum.', '01USER00000000000000000010', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000011', 'Diskusi dasar tentang Pemrograman #11', 'Saya ingin berdiskusi mengenai konsep dasar Pemrograman. Menurut kalian, apa hal paling penting yang harus dipahami oleh pemula?', '01USER00000000000000000011', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000012', 'Rekomendasi belajar Jaringan & Sistem #12', 'Bagikan rekomendasi materi, tools, atau pengalaman belajar yang berkaitan dengan Jaringan & Sistem.', '01USER00000000000000000012', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000013', 'Masalah umum pada Keamanan Siber #13', 'Saya sering menemukan kendala saat mempelajari Keamanan Siber. Apa solusi atau tips dari teman-teman?', '01USER00000000000000000013', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000014', 'Tips memahami Kecerdasan Buatan #14', 'Topik Kecerdasan Buatan semakin banyak dibahas. Apa tips agar lebih mudah memahami konsepnya?', '01USER00000000000000000014', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000015', 'Pengalaman menggunakan Database #15', 'Saya ingin berbagi pengalaman tentang Database. Silakan tambahkan pengalaman atau pendapat kalian.', '01USER00000000000000000015', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000016', 'Pertanyaan seputar Web Development #16', 'Saya punya beberapa pertanyaan tentang Web Development. Bagaimana cara terbaik untuk mulai mempelajarinya?', '01USER00000000000000000016', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000017', 'Roadmap belajar Mobile Development #17', 'Menurut kalian, roadmap belajar Mobile Development yang cocok untuk mahasiswa seperti apa?', '01USER00000000000000000017', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000018', 'Tools favorit untuk Cloud Computing #18', 'Apa tools yang sering kalian gunakan saat belajar atau mengerjakan proyek Cloud Computing?', '01USER00000000000000000018', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000019', 'Cara membuat proyek Open Source #19', 'Saya ingin membuat proyek sederhana tentang Open Source. Fitur apa saja yang cocok untuk pemula?', '01USER00000000000000000019', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000020', 'Sharing pengalaman Diskusi Umum #20', 'Silakan berbagi pengalaman, kendala, atau insight menarik seputar Diskusi Umum.', '01USER00000000000000000020', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000021', 'Tutorial singkat Pemrograman #21', 'Adakah yang punya tutorial singkat dan mudah dipahami tentang Pemrograman untuk pemula?', '01USER00000000000000000021', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000022', 'Kesalahan pemula saat belajar Jaringan & Sistem #22', 'Apa saja kesalahan yang sering dilakukan pemula ketika mempelajari Jaringan & Sistem?', '01USER00000000000000000022', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000023', 'Contoh kasus Keamanan Siber #23', 'Saya ingin membahas contoh kasus sederhana yang berkaitan dengan Keamanan Siber.', '01USER00000000000000000023', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000024', 'Referensi terbaik tentang Kecerdasan Buatan #24', 'Apa referensi buku, website, atau video terbaik untuk belajar Kecerdasan Buatan?', '01USER00000000000000000024', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000025', 'Implementasi Database di proyek kecil #25', 'Bagaimana contoh implementasi Database pada proyek kecil untuk latihan?', '01USER00000000000000000025', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000026', 'Framework populer untuk Web Development #26', 'Menurut kalian, framework apa yang cocok dipelajari untuk Web Development saat ini?', '01USER00000000000000000026', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000027', 'Ide aplikasi Mobile Development #27', 'Berikan ide aplikasi sederhana yang cocok dibuat untuk belajar Mobile Development.', '01USER00000000000000000027', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000028', 'Perbandingan layanan Cloud Computing #28', 'Bagaimana perbandingan layanan Cloud Computing yang sering digunakan untuk belajar?', '01USER00000000000000000028', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000029', 'Kontribusi pertama di Open Source #29', 'Bagaimana cara melakukan kontribusi pertama pada proyek Open Source?', '01USER00000000000000000029', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000030', 'Topik bebas Diskusi Umum #30', 'Thread ini dibuat untuk membahas topik bebas yang masih relevan dengan komunitas.', '01USER00000000000000000030', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000031', 'Tutorial singkat Pemrograman #31', 'Adakah yang punya tutorial singkat dan mudah dipahami tentang Pemrograman untuk pemula?', '01USER00000000000000000031', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000032', 'Kesalahan pemula saat belajar Jaringan & Sistem #32', 'Apa saja kesalahan yang sering dilakukan pemula ketika mempelajari Jaringan & Sistem?', '01USER00000000000000000032', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000033', 'Contoh kasus Keamanan Siber #33', 'Saya ingin membahas contoh kasus sederhana yang berkaitan dengan Keamanan Siber.', '01USER00000000000000000033', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000034', 'Referensi terbaik tentang Kecerdasan Buatan #34', 'Apa referensi buku, website, atau video terbaik untuk belajar Kecerdasan Buatan?', '01USER00000000000000000034', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000035', 'Implementasi Database di proyek kecil #35', 'Bagaimana contoh implementasi Database pada proyek kecil untuk latihan?', '01USER00000000000000000035', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000036', 'Framework populer untuk Web Development #36', 'Menurut kalian, framework apa yang cocok dipelajari untuk Web Development saat ini?', '01USER00000000000000000036', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000037', 'Ide aplikasi Mobile Development #37', 'Berikan ide aplikasi sederhana yang cocok dibuat untuk belajar Mobile Development.', '01USER00000000000000000037', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000038', 'Perbandingan layanan Cloud Computing #38', 'Bagaimana perbandingan layanan Cloud Computing yang sering digunakan untuk belajar?', '01USER00000000000000000038', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000039', 'Kontribusi pertama di Open Source #39', 'Bagaimana cara melakukan kontribusi pertama pada proyek Open Source?', '01USER00000000000000000039', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000040', 'Topik bebas Diskusi Umum #40', 'Thread ini dibuat untuk membahas topik bebas yang masih relevan dengan komunitas.', '01USER00000000000000000040', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000041', 'Diskusi lanjutan Pemrograman #41', 'Mari berdiskusi lebih lanjut mengenai penggunaan Pemrograman dalam dunia kerja dan proyek nyata.', '01USER00000000000000000041', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000042', 'Studi kasus Jaringan & Sistem #42', 'Saya ingin meminta pendapat tentang studi kasus yang berkaitan dengan Jaringan & Sistem.', '01USER00000000000000000042', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000043', 'Materi penting Keamanan Siber #43', 'Menurut kalian, materi paling penting dalam Keamanan Siber yang wajib dipelajari apa saja?', '01USER00000000000000000043', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000044', 'Penerapan Kecerdasan Buatan #44', 'Bagaimana contoh penerapan Kecerdasan Buatan dalam kehidupan sehari-hari atau bisnis?', '01USER00000000000000000044', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000045', 'Optimasi performa Database #45', 'Apa saja cara sederhana untuk mengoptimalkan performa Database?', '01USER00000000000000000045', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000046', 'Struktur folder Web Development #46', 'Bagaimana struktur folder yang rapi untuk proyek Web Development?', '01USER00000000000000000046', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000047', 'UI/UX pada Mobile Development #47', 'Apa yang harus diperhatikan dalam UI/UX ketika membuat aplikasi Mobile Development?', '01USER00000000000000000047', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000048', 'Deploy aplikasi ke Cloud Computing #48', 'Bagaimana langkah awal untuk melakukan deploy aplikasi sederhana ke Cloud Computing?', '01USER00000000000000000048', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000049', 'Lisensi dalam Open Source #49', 'Apa saja jenis lisensi yang umum digunakan dalam proyek Open Source?', '01USER00000000000000000049', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000050', 'Diskusi santai Diskusi Umum #50', 'Silakan gunakan thread ini untuk diskusi santai namun tetap sopan dan bermanfaat.', '01USER00000000000000000050', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000051', 'Diskusi lanjutan Pemrograman #51', 'Mari berdiskusi lebih lanjut mengenai penggunaan Pemrograman dalam dunia kerja dan proyek nyata.', '01USER00000000000000000001', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000052', 'Studi kasus Jaringan & Sistem #52', 'Saya ingin meminta pendapat tentang studi kasus yang berkaitan dengan Jaringan & Sistem.', '01USER00000000000000000002', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000053', 'Materi penting Keamanan Siber #53', 'Menurut kalian, materi paling penting dalam Keamanan Siber yang wajib dipelajari apa saja?', '01USER00000000000000000003', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000054', 'Penerapan Kecerdasan Buatan #54', 'Bagaimana contoh penerapan Kecerdasan Buatan dalam kehidupan sehari-hari atau bisnis?', '01USER00000000000000000004', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000055', 'Optimasi performa Database #55', 'Apa saja cara sederhana untuk mengoptimalkan performa Database?', '01USER00000000000000000005', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000056', 'Struktur folder Web Development #56', 'Bagaimana struktur folder yang rapi untuk proyek Web Development?', '01USER00000000000000000006', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000057', 'UI/UX pada Mobile Development #57', 'Apa yang harus diperhatikan dalam UI/UX ketika membuat aplikasi Mobile Development?', '01USER00000000000000000007', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000058', 'Deploy aplikasi ke Cloud Computing #58', 'Bagaimana langkah awal untuk melakukan deploy aplikasi sederhana ke Cloud Computing?', '01USER00000000000000000008', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000059', 'Lisensi dalam Open Source #59', 'Apa saja jenis lisensi yang umum digunakan dalam proyek Open Source?', '01USER00000000000000000009', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000060', 'Diskusi santai Diskusi Umum #60', 'Silakan gunakan thread ini untuk diskusi santai namun tetap sopan dan bermanfaat.', '01USER00000000000000000010', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000061', 'Pertanyaan tugas Pemrograman #61', 'Saya sedang mengerjakan tugas yang berkaitan dengan Pemrograman. Mohon saran dari teman-teman.', '01USER00000000000000000011', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000062', 'Konsep penting Jaringan & Sistem #62', 'Konsep apa yang harus dikuasai terlebih dahulu sebelum lanjut mendalami Jaringan & Sistem?', '01USER00000000000000000012', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000063', 'Tools pembelajaran Keamanan Siber #63', 'Apa tools yang aman dan legal untuk belajar Keamanan Siber sebagai pemula?', '01USER00000000000000000013', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000064', 'Project sederhana Kecerdasan Buatan #64', 'Apa contoh project sederhana yang bisa dibuat untuk memahami Kecerdasan Buatan?', '01USER00000000000000000014', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000065', 'Desain tabel Database #65', 'Bagaimana cara membuat desain tabel Database yang baik dan mudah dikembangkan?', '01USER00000000000000000015', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000066', 'Belajar HTML CSS JavaScript #66', 'Bagaimana urutan belajar HTML, CSS, dan JavaScript untuk Web Development?', '01USER00000000000000000016', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000067', 'Native vs hybrid Mobile Development #67', 'Menurut kalian, lebih baik belajar native atau hybrid untuk Mobile Development?', '01USER00000000000000000017', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000068', 'Dasar-dasar Cloud Computing #68', 'Apa saja konsep dasar Cloud Computing yang perlu dipahami pemula?', '01USER00000000000000000018', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000069', 'Manajemen komunitas Open Source #69', 'Bagaimana cara mengelola komunitas kecil untuk proyek Open Source?', '01USER00000000000000000019', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000070', 'Saran fitur forum Diskusi Umum #70', 'Fitur apa yang menurut kalian penting untuk forum Diskusi Umum?', '01USER00000000000000000020', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000071', 'Pertanyaan tugas Pemrograman #71', 'Saya sedang mengerjakan tugas yang berkaitan dengan Pemrograman. Mohon saran dari teman-teman.', '01USER00000000000000000021', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000072', 'Konsep penting Jaringan & Sistem #72', 'Konsep apa yang harus dikuasai terlebih dahulu sebelum lanjut mendalami Jaringan & Sistem?', '01USER00000000000000000022', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000073', 'Tools pembelajaran Keamanan Siber #73', 'Apa tools yang aman dan legal untuk belajar Keamanan Siber sebagai pemula?', '01USER00000000000000000023', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000074', 'Project sederhana Kecerdasan Buatan #74', 'Apa contoh project sederhana yang bisa dibuat untuk memahami Kecerdasan Buatan?', '01USER00000000000000000024', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000075', 'Desain tabel Database #75', 'Bagaimana cara membuat desain tabel Database yang baik dan mudah dikembangkan?', '01USER00000000000000000025', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000076', 'Belajar HTML CSS JavaScript #76', 'Bagaimana urutan belajar HTML, CSS, dan JavaScript untuk Web Development?', '01USER00000000000000000026', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000077', 'Native vs hybrid Mobile Development #77', 'Menurut kalian, lebih baik belajar native atau hybrid untuk Mobile Development?', '01USER00000000000000000027', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000078', 'Dasar-dasar Cloud Computing #78', 'Apa saja konsep dasar Cloud Computing yang perlu dipahami pemula?', '01USER00000000000000000028', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000079', 'Manajemen komunitas Open Source #79', 'Bagaimana cara mengelola komunitas kecil untuk proyek Open Source?', '01USER00000000000000000029', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000080', 'Saran fitur forum Diskusi Umum #80', 'Fitur apa yang menurut kalian penting untuk forum Diskusi Umum?', '01USER00000000000000000030', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000081', 'Best practice dalam Pemrograman #81', 'Menurut kalian, apa saja praktik terbaik yang perlu diperhatikan saat mengerjakan sesuatu yang berkaitan dengan Pemrograman?', '01USER00000000000000000031', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000082', 'Best practice dalam Jaringan & Sistem #82', 'Menurut kalian, apa saja praktik terbaik yang perlu diperhatikan saat mengerjakan sesuatu yang berkaitan dengan Jaringan & Sistem?', '01USER00000000000000000032', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000083', 'Best practice dalam Keamanan Siber #83', 'Menurut kalian, apa saja praktik terbaik yang perlu diperhatikan saat mengerjakan sesuatu yang berkaitan dengan Keamanan Siber?', '01USER00000000000000000033', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000084', 'Best practice dalam Kecerdasan Buatan #84', 'Menurut kalian, apa saja praktik terbaik yang perlu diperhatikan saat mengerjakan sesuatu yang berkaitan dengan Kecerdasan Buatan?', '01USER00000000000000000034', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000085', 'Best practice dalam Database #85', 'Menurut kalian, apa saja praktik terbaik yang perlu diperhatikan saat mengerjakan sesuatu yang berkaitan dengan Database?', '01USER00000000000000000035', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000086', 'Best practice dalam Web Development #86', 'Menurut kalian, apa saja praktik terbaik yang perlu diperhatikan saat mengerjakan sesuatu yang berkaitan dengan Web Development?', '01USER00000000000000000036', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000087', 'Best practice dalam Mobile Development #87', 'Menurut kalian, apa saja praktik terbaik yang perlu diperhatikan saat mengerjakan sesuatu yang berkaitan dengan Mobile Development?', '01USER00000000000000000037', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000088', 'Best practice dalam Cloud Computing #88', 'Menurut kalian, apa saja praktik terbaik yang perlu diperhatikan saat mengerjakan sesuatu yang berkaitan dengan Cloud Computing?', '01USER00000000000000000038', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000089', 'Best practice dalam Open Source #89', 'Menurut kalian, apa saja praktik terbaik yang perlu diperhatikan saat mengerjakan sesuatu yang berkaitan dengan Open Source?', '01USER00000000000000000039', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000090', 'Best practice dalam Diskusi Umum #90', 'Menurut kalian, apa saja praktik terbaik yang perlu diperhatikan saat mengerjakan sesuatu yang berkaitan dengan Diskusi Umum?', '01USER00000000000000000040', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000091', 'Best practice dalam Pemrograman #91', 'Menurut kalian, apa saja praktik terbaik yang perlu diperhatikan saat mengerjakan sesuatu yang berkaitan dengan Pemrograman?', '01USER00000000000000000041', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000092', 'Best practice dalam Jaringan & Sistem #92', 'Menurut kalian, apa saja praktik terbaik yang perlu diperhatikan saat mengerjakan sesuatu yang berkaitan dengan Jaringan & Sistem?', '01USER00000000000000000042', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000093', 'Best practice dalam Keamanan Siber #93', 'Menurut kalian, apa saja praktik terbaik yang perlu diperhatikan saat mengerjakan sesuatu yang berkaitan dengan Keamanan Siber?', '01USER00000000000000000043', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000094', 'Best practice dalam Kecerdasan Buatan #94', 'Menurut kalian, apa saja praktik terbaik yang perlu diperhatikan saat mengerjakan sesuatu yang berkaitan dengan Kecerdasan Buatan?', '01USER00000000000000000044', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000095', 'Best practice dalam Database #95', 'Menurut kalian, apa saja praktik terbaik yang perlu diperhatikan saat mengerjakan sesuatu yang berkaitan dengan Database?', '01USER00000000000000000045', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000096', 'Best practice dalam Web Development #96', 'Menurut kalian, apa saja praktik terbaik yang perlu diperhatikan saat mengerjakan sesuatu yang berkaitan dengan Web Development?', '01USER00000000000000000046', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000097', 'Best practice dalam Mobile Development #97', 'Menurut kalian, apa saja praktik terbaik yang perlu diperhatikan saat mengerjakan sesuatu yang berkaitan dengan Mobile Development?', '01USER00000000000000000047', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000098', 'Best practice dalam Cloud Computing #98', 'Menurut kalian, apa saja praktik terbaik yang perlu diperhatikan saat mengerjakan sesuatu yang berkaitan dengan Cloud Computing?', '01USER00000000000000000048', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000099', 'Best practice dalam Open Source #99', 'Menurut kalian, apa saja praktik terbaik yang perlu diperhatikan saat mengerjakan sesuatu yang berkaitan dengan Open Source?', '01USER00000000000000000049', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01THRD00000000000000000100', 'Best practice dalam Diskusi Umum #100', 'Menurut kalian, apa saja praktik terbaik yang perlu diperhatikan saat mengerjakan sesuatu yang berkaitan dengan Diskusi Umum?', '01USER00000000000000000050', 1, '2026-05-23 17:08:28', '2026-05-23 17:08:28');

-- --------------------------------------------------------

--
-- Table structure for table `thread_topic`
--

CREATE TABLE `thread_topic` (
  `thread_id` char(26) NOT NULL,
  `topic_id` char(26) NOT NULL,
  `assigned_by` char(26) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `thread_topic`
--

INSERT INTO `thread_topic` (`thread_id`, `topic_id`, `assigned_by`) VALUES
('01THRD00000000000000000001', '01HWXXXXXXXXXXXXXXXXTOPIC1', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000002', '01HWXXXXXXXXXXXXXXXXTOPIC2', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000003', '01HWXXXXXXXXXXXXXXXXTOPIC3', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000004', '01HWXXXXXXXXXXXXXXXXTOPIC4', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000005', '01HWXXXXXXXXXXXXXXXXTOPIC5', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000006', '01HWXXXXXXXXXXXXXXXXTOPIC6', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000007', '01HWXXXXXXXXXXXXXXXXTOPIC7', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000008', '01HWXXXXXXXXXXXXXXXXTOPIC8', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000009', '01HWXXXXXXXXXXXXXXXXTOPIC9', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000010', '01HWXXXXXXXXXXXXXXXXTOPIC0', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000011', '01HWXXXXXXXXXXXXXXXXTOPIC1', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000012', '01HWXXXXXXXXXXXXXXXXTOPIC2', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000013', '01HWXXXXXXXXXXXXXXXXTOPIC3', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000014', '01HWXXXXXXXXXXXXXXXXTOPIC4', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000015', '01HWXXXXXXXXXXXXXXXXTOPIC5', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000016', '01HWXXXXXXXXXXXXXXXXTOPIC6', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000017', '01HWXXXXXXXXXXXXXXXXTOPIC7', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000018', '01HWXXXXXXXXXXXXXXXXTOPIC8', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000019', '01HWXXXXXXXXXXXXXXXXTOPIC9', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000020', '01HWXXXXXXXXXXXXXXXXTOPIC0', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000021', '01HWXXXXXXXXXXXXXXXXTOPIC1', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000022', '01HWXXXXXXXXXXXXXXXXTOPIC2', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000023', '01HWXXXXXXXXXXXXXXXXTOPIC3', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000024', '01HWXXXXXXXXXXXXXXXXTOPIC4', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000025', '01HWXXXXXXXXXXXXXXXXTOPIC5', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000026', '01HWXXXXXXXXXXXXXXXXTOPIC6', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000027', '01HWXXXXXXXXXXXXXXXXTOPIC7', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000028', '01HWXXXXXXXXXXXXXXXXTOPIC8', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000029', '01HWXXXXXXXXXXXXXXXXTOPIC9', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000030', '01HWXXXXXXXXXXXXXXXXTOPIC0', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000031', '01HWXXXXXXXXXXXXXXXXTOPIC1', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000032', '01HWXXXXXXXXXXXXXXXXTOPIC2', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000033', '01HWXXXXXXXXXXXXXXXXTOPIC3', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000034', '01HWXXXXXXXXXXXXXXXXTOPIC4', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000035', '01HWXXXXXXXXXXXXXXXXTOPIC5', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000036', '01HWXXXXXXXXXXXXXXXXTOPIC6', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000037', '01HWXXXXXXXXXXXXXXXXTOPIC7', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000038', '01HWXXXXXXXXXXXXXXXXTOPIC8', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000039', '01HWXXXXXXXXXXXXXXXXTOPIC9', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000040', '01HWXXXXXXXXXXXXXXXXTOPIC0', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000041', '01HWXXXXXXXXXXXXXXXXTOPIC1', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000042', '01HWXXXXXXXXXXXXXXXXTOPIC2', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000043', '01HWXXXXXXXXXXXXXXXXTOPIC3', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000044', '01HWXXXXXXXXXXXXXXXXTOPIC4', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000045', '01HWXXXXXXXXXXXXXXXXTOPIC5', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000046', '01HWXXXXXXXXXXXXXXXXTOPIC6', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000047', '01HWXXXXXXXXXXXXXXXXTOPIC7', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000048', '01HWXXXXXXXXXXXXXXXXTOPIC8', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000049', '01HWXXXXXXXXXXXXXXXXTOPIC9', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000050', '01HWXXXXXXXXXXXXXXXXTOPIC0', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000051', '01HWXXXXXXXXXXXXXXXXTOPIC1', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000052', '01HWXXXXXXXXXXXXXXXXTOPIC2', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000053', '01HWXXXXXXXXXXXXXXXXTOPIC3', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000054', '01HWXXXXXXXXXXXXXXXXTOPIC4', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000055', '01HWXXXXXXXXXXXXXXXXTOPIC5', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000056', '01HWXXXXXXXXXXXXXXXXTOPIC6', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000057', '01HWXXXXXXXXXXXXXXXXTOPIC7', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000058', '01HWXXXXXXXXXXXXXXXXTOPIC8', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000059', '01HWXXXXXXXXXXXXXXXXTOPIC9', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000060', '01HWXXXXXXXXXXXXXXXXTOPIC0', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000061', '01HWXXXXXXXXXXXXXXXXTOPIC1', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000062', '01HWXXXXXXXXXXXXXXXXTOPIC2', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000063', '01HWXXXXXXXXXXXXXXXXTOPIC3', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000064', '01HWXXXXXXXXXXXXXXXXTOPIC4', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000065', '01HWXXXXXXXXXXXXXXXXTOPIC5', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000066', '01HWXXXXXXXXXXXXXXXXTOPIC6', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000067', '01HWXXXXXXXXXXXXXXXXTOPIC7', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000068', '01HWXXXXXXXXXXXXXXXXTOPIC8', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000069', '01HWXXXXXXXXXXXXXXXXTOPIC9', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000070', '01HWXXXXXXXXXXXXXXXXTOPIC0', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000071', '01HWXXXXXXXXXXXXXXXXTOPIC1', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000072', '01HWXXXXXXXXXXXXXXXXTOPIC2', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000073', '01HWXXXXXXXXXXXXXXXXTOPIC3', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000074', '01HWXXXXXXXXXXXXXXXXTOPIC4', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000075', '01HWXXXXXXXXXXXXXXXXTOPIC5', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000076', '01HWXXXXXXXXXXXXXXXXTOPIC6', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000077', '01HWXXXXXXXXXXXXXXXXTOPIC7', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000078', '01HWXXXXXXXXXXXXXXXXTOPIC8', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000079', '01HWXXXXXXXXXXXXXXXXTOPIC9', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000080', '01HWXXXXXXXXXXXXXXXXTOPIC0', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000081', '01HWXXXXXXXXXXXXXXXXTOPIC1', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000082', '01HWXXXXXXXXXXXXXXXXTOPIC2', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000083', '01HWXXXXXXXXXXXXXXXXTOPIC3', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000084', '01HWXXXXXXXXXXXXXXXXTOPIC4', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000085', '01HWXXXXXXXXXXXXXXXXTOPIC5', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000086', '01HWXXXXXXXXXXXXXXXXTOPIC6', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000087', '01HWXXXXXXXXXXXXXXXXTOPIC7', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000088', '01HWXXXXXXXXXXXXXXXXTOPIC8', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000089', '01HWXXXXXXXXXXXXXXXXTOPIC9', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000090', '01HWXXXXXXXXXXXXXXXXTOPIC0', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000091', '01HWXXXXXXXXXXXXXXXXTOPIC1', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000092', '01HWXXXXXXXXXXXXXXXXTOPIC2', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000093', '01HWXXXXXXXXXXXXXXXXTOPIC3', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000094', '01HWXXXXXXXXXXXXXXXXTOPIC4', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000095', '01HWXXXXXXXXXXXXXXXXTOPIC5', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000096', '01HWXXXXXXXXXXXXXXXXTOPIC6', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000097', '01HWXXXXXXXXXXXXXXXXTOPIC7', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000098', '01HWXXXXXXXXXXXXXXXXTOPIC8', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000099', '01HWXXXXXXXXXXXXXXXXTOPIC9', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01THRD00000000000000000100', '01HWXXXXXXXXXXXXXXXXTOPIC0', '01HWXXXXXXXXXXXXXXXXSADMIN'),
('01KRWNNVA7Q02QYTXQ7283KHA8', '01HWXXXXXXXXXXXXXXXXTOPIC8', '01KRWNMD4YGSGNTGJKW803HGEB'),
('01KRWNV0DDMY5TE56XVSPF6C8S', '01HWXXXXXXXXXXXXXXXXTOPIC8', '01KRWNT7E7B2X87HKWT8FQ735M');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `topic_id` char(26) NOT NULL,
  `topic_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`topic_id`, `topic_name`, `created_at`, `updated_at`) VALUES
('01HWXXXXXXXXXXXXXXXXTOPIC0', 'Diskusi Umum', '2026-05-18 04:28:28', '2026-05-18 04:28:28'),
('01HWXXXXXXXXXXXXXXXXTOPIC1', 'Pemrograman', '2026-05-18 04:28:28', '2026-05-18 04:28:28'),
('01HWXXXXXXXXXXXXXXXXTOPIC2', 'Jaringan & Sistem', '2026-05-18 04:28:28', '2026-05-18 04:28:28'),
('01HWXXXXXXXXXXXXXXXXTOPIC3', 'Keamanan Siber', '2026-05-18 04:28:28', '2026-05-18 04:28:28'),
('01HWXXXXXXXXXXXXXXXXTOPIC4', 'Kecerdasan Buatan', '2026-05-18 04:28:28', '2026-05-18 04:28:28'),
('01HWXXXXXXXXXXXXXXXXTOPIC5', 'Database', '2026-05-18 04:28:28', '2026-05-18 04:28:28'),
('01HWXXXXXXXXXXXXXXXXTOPIC6', 'Web Development', '2026-05-18 04:28:28', '2026-05-18 04:28:28'),
('01HWXXXXXXXXXXXXXXXXTOPIC7', 'Mobile Development', '2026-05-18 04:28:28', '2026-05-18 04:28:28'),
('01HWXXXXXXXXXXXXXXXXTOPIC8', 'Cloud Computing', '2026-05-18 04:28:28', '2026-05-18 04:28:28'),
('01HWXXXXXXXXXXXXXXXXTOPIC9', 'Open Source', '2026-05-18 04:28:28', '2026-05-18 04:28:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` char(26) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(254) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `password` char(60) NOT NULL,
  `role` enum('superadmin','moderator','user') DEFAULT 'user',
  `status` enum('active','banned','restricted') DEFAULT 'active',
  `avatar_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `fullname`, `password`, `role`, `status`, `avatar_url`, `created_at`, `updated_at`) VALUES
('01HWXXXXXXXXXXXXXXXXSADMIN', 'superadmin', 'admin@forit.id', 'Super Administrator', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'superadmin', 'active', NULL, '2026-05-18 04:28:28', '2026-05-18 04:28:28'),
('01KRWNMD4YGSGNTGJKW803HGEB', 'buatbuat', 'buat@gmail.com', 'buat', '$2y$12$SmSk1acNjs8ND9zSPa2vCuAB9Eo5E7n1mzlmdzI76vMgleGpPesHO', 'moderator', 'active', NULL, '2026-05-18 04:31:14', '2026-05-18 04:45:03'),
('01KRWNT7E7B2X87HKWT8FQ735M', 'buatbuat2', 'buat2@gmail.com', 'buatbuat2', '$2y$12$SYBUnb9JdXmxexYR4MHGsu4ghV90FHv2040S3HvJC/AcW.eemuTbW', 'user', 'active', NULL, '2026-05-18 04:34:24', '2026-05-18 04:34:24'),
('01KRWNX1KXGXVD9G1YFPVPNBGS', 'buatbuat3', 'buat3@gmail.com', 'buatbuat3', '$2y$12$nZCrWQyUNvHW1j8RpoQtBek203VRzXK0t7bJAfQ5P0DiKscXeiIxi', 'user', 'active', NULL, '2026-05-18 04:35:57', '2026-05-18 04:35:57'),
('01USER00000000000000000001', 'user01', 'user01@forit.id', 'Andi Saputra', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Andi+Saputra', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000002', 'user02', 'user02@forit.id', 'Budi Santoso', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Budi+Santoso', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000003', 'user03', 'user03@forit.id', 'Citra Lestari', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Citra+Lestari', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000004', 'user04', 'user04@forit.id', 'Dewi Anggraini', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Dewi+Anggraini', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000005', 'user05', 'user05@forit.id', 'Eko Prasetyo', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'moderator', 'active', 'https://ui-avatars.com/api/?name=Eko+Prasetyo', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000006', 'user06', 'user06@forit.id', 'Fajar Nugroho', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Fajar+Nugroho', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000007', 'user07', 'user07@forit.id', 'Gita Maharani', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Gita+Maharani', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000008', 'user08', 'user08@forit.id', 'Hadi Wijaya', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Hadi+Wijaya', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000009', 'user09', 'user09@forit.id', 'Indah Permata', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Indah+Permata', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000010', 'user10', 'user10@forit.id', 'Joko Susilo', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'restricted', 'https://ui-avatars.com/api/?name=Joko+Susilo', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000011', 'user11', 'user11@forit.id', 'Kurniawan Putra', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Kurniawan+Putra', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000012', 'user12', 'user12@forit.id', 'Lina Marlina', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Lina+Marlina', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000013', 'user13', 'user13@forit.id', 'Maya Sari', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Maya+Sari', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000014', 'user14', 'user14@forit.id', 'Nanda Pratama', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Nanda+Pratama', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000015', 'user15', 'user15@forit.id', 'Oki Ramadhan', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'moderator', 'active', 'https://ui-avatars.com/api/?name=Oki+Ramadhan', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000016', 'user16', 'user16@forit.id', 'Putri Aulia', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Putri+Aulia', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000017', 'user17', 'user17@forit.id', 'Qori Maulana', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Qori+Maulana', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000018', 'user18', 'user18@forit.id', 'Rani Oktaviani', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Rani+Oktaviani', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000019', 'user19', 'user19@forit.id', 'Satria Wibowo', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Satria+Wibowo', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000020', 'user20', 'user20@forit.id', 'Tina Amalia', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Tina+Amalia', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000021', 'user21', 'user21@forit.id', 'Umar Faruq', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Umar+Faruq', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000022', 'user22', 'user22@forit.id', 'Vina Febriani', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Vina+Febriani', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000023', 'user23', 'user23@forit.id', 'Wahyu Hidayat', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Wahyu+Hidayat', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000024', 'user24', 'user24@forit.id', 'Yuni Kartika', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Yuni+Kartika', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000025', 'user25', 'user25@forit.id', 'Zaki Firdaus', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'restricted', 'https://ui-avatars.com/api/?name=Zaki+Firdaus', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000026', 'user26', 'user26@forit.id', 'Alya Rahma', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Alya+Rahma', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000027', 'user27', 'user27@forit.id', 'Bagas Aditya', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Bagas+Aditya', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000028', 'user28', 'user28@forit.id', 'Clara Monika', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Clara+Monika', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000029', 'user29', 'user29@forit.id', 'Dimas Arya', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Dimas+Arya', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000030', 'user30', 'user30@forit.id', 'Elsa Fitri', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'moderator', 'active', 'https://ui-avatars.com/api/?name=Elsa+Fitri', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000031', 'user31', 'user31@forit.id', 'Farhan Akbar', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Farhan+Akbar', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000032', 'user32', 'user32@forit.id', 'Gracia Putri', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Gracia+Putri', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000033', 'user33', 'user33@forit.id', 'Hilmi Fauzan', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Hilmi+Fauzan', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000034', 'user34', 'user34@forit.id', 'Intan Nuraini', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Intan+Nuraini', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000035', 'user35', 'user35@forit.id', 'Kevin Ardiansyah', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Kevin+Ardiansyah', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000036', 'user36', 'user36@forit.id', 'Lukman Hakim', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Lukman+Hakim', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000037', 'user37', 'user37@forit.id', 'Mira Anindya', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Mira+Anindya', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000038', 'user38', 'user38@forit.id', 'Naufal Rizky', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Naufal+Rizky', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000039', 'user39', 'user39@forit.id', 'Olivia Maharani', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Olivia+Maharani', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000040', 'user40', 'user40@forit.id', 'Pandu Permana', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'banned', 'https://ui-avatars.com/api/?name=Pandu+Permana', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000041', 'user41', 'user41@forit.id', 'Rizka Febiola', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Rizka+Febiola', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000042', 'user42', 'user42@forit.id', 'Syifa Zahra', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Syifa+Zahra', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000043', 'user43', 'user43@forit.id', 'Teguh Prakoso', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Teguh+Prakoso', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000044', 'user44', 'user44@forit.id', 'Utami Larasati', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Utami+Larasati', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000045', 'user45', 'user45@forit.id', 'Vito Alfarizi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Vito+Alfarizi', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000046', 'user46', 'user46@forit.id', 'Wulan Salsabila', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Wulan+Salsabila', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000047', 'user47', 'user47@forit.id', 'Yusuf Ramadhan', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Yusuf+Ramadhan', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000048', 'user48', 'user48@forit.id', 'Zahra Amelia', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Zahra+Amelia', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000049', 'user49', 'user49@forit.id', 'Arif Maulana', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Arif+Maulana', '2026-05-23 17:08:28', '2026-05-23 17:08:28'),
('01USER00000000000000000050', 'user50', 'user50@forit.id', 'Bella Safitri', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'active', 'https://ui-avatars.com/api/?name=Bella+Safitri', '2026-05-23 17:08:28', '2026-05-23 17:08:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`bookmark_id`),
  ADD UNIQUE KEY `uq_bookmark` (`user_id`,`thread_id`),
  ADD KEY `thread_id` (`thread_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `thread_id` (`thread_id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `parent_comment_id` (`parent_comment_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `thread_id` (`thread_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `reporter_id` (`reporter_id`),
  ADD KEY `reviewed_by` (`reviewed_by`);

--
-- Indexes for table `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`thread_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `thread_topic`
--
ALTER TABLE `thread_topic`
  ADD PRIMARY KEY (`thread_id`,`topic_id`),
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `assigned_by` (`assigned_by`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`topic_id`),
  ADD UNIQUE KEY `topic_name` (`topic_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD CONSTRAINT `bookmarks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `bookmarks_ibfk_2` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`thread_id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`thread_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`parent_comment_id`) REFERENCES `comments` (`comment_id`);

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`thread_id`),
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`comment_id`),
  ADD CONSTRAINT `reports_ibfk_3` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `reports_ibfk_4` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `threads`
--
ALTER TABLE `threads`
  ADD CONSTRAINT `threads_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `thread_topic`
--
ALTER TABLE `thread_topic`
  ADD CONSTRAINT `thread_topic_ibfk_1` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`thread_id`),
  ADD CONSTRAINT `thread_topic_ibfk_2` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`topic_id`),
  ADD CONSTRAINT `thread_topic_ibfk_3` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
