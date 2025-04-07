-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
<<<<<<< HEAD
-- Generation Time: Apr 07, 2025 at 07:37 AM
=======
-- Generation Time: Apr 04, 2025 at 08:03 AM
>>>>>>> origin/contact-page
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iconnex_thailand_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('superadmin','subadmin','admin') DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password_hash`, `role`) VALUES
(11, 'admin', 'admin@gmail.com', '$2y$10$yeJRmkUZGgMiZGVXzz8i6uj3XYX3Gv8FFqJ5h7OtkkbWnc.orj4/G', 'admin'),
(12, 'admin02', 'admin02@gmail.com', '$2y$10$uRWDjeNB3yABBeO/URdvnul6ZzycRUiyjG2fEBGpAbeWd1xLP6aAO', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `blocks`
--

CREATE TABLE `blocks` (
  `id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `title` varchar(100) NOT NULL,
  `detail1` varchar(255) NOT NULL,
  `detail2` varchar(255) NOT NULL,
  `detail3` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blocks`
--

INSERT INTO `blocks` (`id`, `image_url`, `title`, `detail1`, `detail2`, `detail3`, `description`) VALUES
(1, 'img/block_project_1.jpg', 'หัวข้อ 1', 'รายละเอียด 1', 'รายละเอียด 2', 'รายละเอียด 3', '. บริษัทของเราภูมิใจที่ได้ร่วมงาน Iconnex Thailand เพื่อนำเสนอ Handy Broth น้ำซุปญี่ปุ่นแท้ที่พร้อมให้ทุกคนได้ลิ้มลอง! ภาพนี้บันทึกช่วงเวลาที่ทีมงานของเราร่วมกับสื่อมวลชนจัดแสดงการสาธิตการใช้งานผลิตภัณฑ์ ด้วยรอยยิ้มและความมุ่งมั่น เราได้สร้างประสบการณ์ที่ทุกคนสามารถสัมผัสถึงรสชาติและคุณภาพของน้ำซุปที่เหมาะสำหรับทุกเมนู เรียนรู้เพิ่มเติมเกี่ยวกับ Handy Broth และผลิตภัณฑ์อื่น ๆ ของเราได้ที่ [ลิงก์เว็บไซต์] #HandyBroth #IconnexThailand #ผลงานบริษัท #รสชาติญี่ปุ่น'),
(3, 'img/block_project_1.jpg', 'หัวข้อ 12', 'รายละเอียด 1', 'รายละเอียด 2', 'รายละเอียด 3', 'รายละเอียดเพิ่มเติมของ Block 1: Lorem ipsum dolor sit amet.'),
(4, 'img/block_project_1.jpg', 'หัวข้อ 3', 'รายละเอียด 1', 'รายละเอียด 2', 'รายละเอียด 3', 'รายละเอียดเพิ่มเติมของ Block 1: Lorem ipsum dolor sit amet.'),
(5, 'img/block_project_1.jpg', 'หัวข้อ 3', 'รายละเอียด 1', 'รายละเอียด 2', 'รายละเอียด 3', 'รายละเอียดเพิ่มเติมของ Block 1: Lorem ipsum dolor sit amet.'),
(6, 'img/block_project_1.jpg', 'หัวข้อ 3', 'รายละเอียด 1', 'รายละเอียด 2', 'รายละเอียด 3', 'รายละเอียดเพิ่มเติมของ Block 1: Lorem ipsum dolor sit amet.'),
(7, 'img/block_project_1.jpg', 'หัวข้อ 3', 'รายละเอียด 1', 'รายละเอียด 2', 'รายละเอียด 3', 'รายละเอียดเพิ่มเติมของ Block 1: Lorem ipsum dolor sit amet.'),
(8, '/iconnex_thailand_db_backup/img/67ee5e49922fa-ChatGPT Image Apr 3, 2025, 01_25_50 AM.png', 'test3', 't3', 't3', 't3t', 't3');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
<<<<<<< HEAD
  `submitted_at` datetime DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
=======
  `submitted_at` datetime DEFAULT current_timestamp()
>>>>>>> origin/contact-page
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

<<<<<<< HEAD
INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `submitted_at`, `is_read`) VALUES
(22, 'Kittiphat Suwannasri', 'kittiphat240449@gmail.com', 'นี่เป็นการเทสครั้งที่ 100', 'สวัสดีนี่เป็นการเทสครับที่ 100 100ล้านน่ะ', '2025-04-07 03:40:49', 0);
=======
INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `submitted_at`) VALUES
(1, 'test', 'test@gmail.com', 'สวัสดี', 'สวัสดี', '2025-04-02 15:54:32');
>>>>>>> origin/contact-page

-- --------------------------------------------------------

--
-- Table structure for table `logos`
--

CREATE TABLE `logos` (
  `id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `alt_text` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logos`
--

INSERT INTO `logos` (`id`, `image_url`, `alt_text`) VALUES
(2, 'https://e7.pngegg.com/pngimages/779/61/png-clipart-logo-idea-cute-eagle-leaf-logo-thumbnail.png', 'gap'),
(3, 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/Instagram_icon.png/640px-Instagram_icon.png', 'IG'),
(4, 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Wikimedia-logo.png/600px-Wikimedia-logo.png', '31312'),
(13, 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/05/Facebook_Logo_%282019%29.png/1024px-Facebook_Logo_%282019%29.png', 'facebook'),
(18, 'https://img.freepik.com/free-vector/quill-pen-logo-template_23-2149852429.jpg?semt=ais_hybrid', 'freepik'),
(19, 'https://img.freepik.com/free-vector/bird-colorful-logo-gradient-vector_343694-1365.jpg', 'freepik'),
(20, 'https://cdn.pixabay.com/photo/2017/03/16/21/18/logo-2150297_640.png', 'pixabay'),
(22, 'https://e7.pngegg.com/pngimages/779/61/png-clipart-logo-idea-cute-eagle-leaf-logo-thumbnail.png', 'asdf'),
(26, 'https://img.freepik.com/free-vector/quill-pen-logo-template_23-2149852429.jpg?semt=ais_hybrid', 'asdf');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `token` varchar(32) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `icon_url` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `list_item1` varchar(255) DEFAULT NULL,
  `list_item2` varchar(255) DEFAULT NULL,
  `list_item3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `icon_url`, `title`, `list_item1`, `list_item2`, `list_item3`) VALUES
(1, 'img/icon-document.png', 'การบริการครอบคลุม 360°', 'บริการครบวงจร', 'การวิเคราะห์ข้อมูล', 'การสนับสนุนตลอด 24/7'),
(9, 'img/icon-growth.png', 'ลูกค้ากว่า 3,800 ราย', 'ความพึงพอใจสูง', 'การเติบโตอย่างยั่งยืน', 'ผลลัพธ์ที่พิสูจน์แล้ว'),
(10, 'img/icon-user.png', 'ประสบการณ์ผู้ใช้ที่ยอดเยี่ยม', 'อินเตอร์เฟซที่ใช้งานง่าย', 'การสนับสนุนส่วนบุคคล', 'การปรับแต่งได้'),
(11, 'img/icon-funnel.png', 'การตลาด Full-Funnel', 'กลยุทธ์ครบวงจร', 'การติดตามผล', 'การเพิ่มยอดขาย'),
(18, 'https://static.vecteezy.com/system/resources/previews/043/962/820/original/icon-icons-design-vector.jpg', 'adf', 'adsf', 'asdf', 'asdf'),
(19, '/uploads/67eb6fba7c813-ChatGPT Image Mar 31, 2025, 03_00_24 PM.png', 'it', 'it', 'it', 'it'),
(20, '/uploads/67ee5c18b2027-ChatGPT Image Apr 3, 2025, 01_25_50 AM.png', 'it', 'it', 'it', 'it'),
(21, 'https://cdn-icons-png.flaticon.com/512/535/535239.png', 'สวัสดี', 'dhsghf', 'sghfsghs', 'hsgfgfs');

-- --------------------------------------------------------

--
-- Table structure for table `service_cards`
--

CREATE TABLE `service_cards` (
  `id` int(11) NOT NULL,
  `icon_url` varchar(255) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `list_item1` varchar(255) NOT NULL,
  `list_item2` varchar(255) NOT NULL,
  `list_item3` varchar(255) NOT NULL,
  `list_item4` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_cards`
--

INSERT INTO `service_cards` (`id`, `icon_url`, `title`, `description`, `list_item1`, `list_item2`, `list_item3`, `list_item4`) VALUES
(1, 'img/icon-funnel.png', 'การตลาด Full-Funnel', 'เพิ่มยอดขายด้วยกลยุทธ์ครบวงจร ตั้งแต่สร้างการรับรู้ไปจนถึงปิดการขาย ทีมงานของเราจะช่วยคุณออกแบบแคมเปญที่เข้าถึงกลุ่มเป้าหมายได้อย่างแม่นยำ', 'SEO & SEM Optimization', 'Social Media Advertising', 'Conversion Rate Optimization (CRO)', 'Remarketing Campaigns'),
(2, 'img/icon-document.png', 'การผลิตคอนเทนต์', 'สร้างคอนเทนต์คุณภาพสูงที่ดึงดูดและเพิ่มการมีส่วนร่วม ไม่ว่าจะเป็นวิดีโอ ภาพกราฟิก หรือบทความ เรามีทีมครีเอทีฟที่พร้อมนำเสนอไอเดียใหม่ ๆ', 'วิดีโอโปรโมทและแอนิเมชัน', 'กราฟิกดีไซน์สำหรับโซเชียลมีเดีย', 'บทความ SEO และ Blogging', 'Infographic และ Visual Storytelling'),
(3, 'img/icon-growth.png', 'การวิเคราะห์ข้อมูล', 'ตัดสินใจด้วยข้อมูลเชิงลึก เพื่อผลลัพธ์ที่ดีที่สุด เราใช้เครื่องมือล่าสุดในการวิเคราะห์พฤติกรรมลูกค้าและปรับปรุงกลยุทธ์แบบเรียลไทม์', 'Data Insights & Dashboard', 'Performance Reports รายสัปดาห์', 'A/B Testing และ Experimentation', 'Predictive Analytics'),
(4, 'img/icon-user.png', 'การสร้างแบรนด์', 'พัฒนาเอกลักษณ์แบรนด์ที่แข็งแกร่งและน่าจดจำ ด้วยการออกแบบโลโก้ การเล่าเรื่อง และกลยุทธ์ที่สร้างความแตกต่างในตลาด', 'Brand Identity & Logo Design', 'Storytelling และ Brand Voice', 'Visual Design และ Guidelines', 'Brand Positioning Strategy'),
(5, '/iconnex_thailand_db_backup/img/67ee5e05bba7a-ChatGPT Image Mar 31, 2025, 03_26_05 PM.png', 'test3', 'test3', 'test3', 'test3', 'test3', 'test3');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `session_token` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `admin_id`, `session_token`, `created_at`) VALUES
(1, 2, '7655f03ee43196746f4bbe1c8d6c697c', '2025-03-13 12:16:58'),
(2, 2, '4b3db2e10cfed6d9214f073f8d12d6a3', '2025-03-13 12:36:39'),
(3, 2, '314b9c035780363cfa7b305f8a3f8271', '2025-03-13 15:12:24'),
(4, 2, 'b4863ba78e198f60569a9e6501efb55e', '2025-03-13 15:13:09'),
(5, 2, '6b2ac1915c73ef403dc255ceab3cf29c', '2025-03-13 15:21:11'),
(12, 8, '2e0adcd57992709e094bd79b937cd5d8', '2025-03-16 21:14:34'),
(13, 8, '93a8c24cfd7f832a61060ee76f14f074', '2025-03-17 16:40:41'),
(14, 8, 'e2eb10519d57ac7dc72490977320d75b', '2025-03-17 17:31:21'),
(15, 10, '6c850aeb0a1bf38ad3f99bd6c57236d3', '2025-03-21 13:02:24'),
(32, 11, 'ffb78f56fbe38e03ff90072dbffa79d9', '2025-04-02 14:29:45'),
(33, 11, '5a42b0898f77e4c4d03fea70456f14ea', '2025-04-02 15:40:35'),
(34, 11, 'ec6381110afac7ba8b65521f640a9718', '2025-04-03 16:33:17'),
(35, 11, 'de9da1cb306962929942afb2f59e59b1', '2025-04-03 16:41:30'),
(36, 11, '73766215731fe8043131cba368671a9c', '2025-04-04 11:29:04');

-- --------------------------------------------------------

--
-- Table structure for table `social_posts`
--

CREATE TABLE `social_posts` (
  `platform` varchar(50) NOT NULL,
  `post_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `social_posts`
--

INSERT INTO `social_posts` (`platform`, `post_count`) VALUES
('Facebook', 10),
('Instagram', 7),
('YouTube', 5),
('Line', 2);

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `quote` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `author_name` varchar(100) NOT NULL,
  `author_location` varchar(100) NOT NULL,
  `avatar_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `quote`, `text`, `author_name`, `author_location`, `avatar_url`) VALUES
(1, 'The best restaurant', 'Last night, we dined at place and were simply blown away...', 'Sophie Robson', 'Los Angeles, CA', 'img/1.png'),
(4, 'เอาไปเลย 5 ดาว', 'นี่เป็นบริษที่ดีมากเลยครับ ทั้งการพูดคุยที่เป็นกันเอง การบริการ ให้ความร่วมมือทุกขั้นตอน อยากทำอะไรก็สนับสนุนทั้งหมด', 'Kittiphat Suwannasri', '-', '/iconnex_thailand_db/img/67ea737e4f2c0-ChatGPT Image Mar 30, 2025, 09_52_41 PM.png'),
(5, 'ชื่นชมการทำงาน', 'เป็นพาทเนอร์ทางธุรกิจที่ไว้ใจได้ เชื่อใจได้ ไม่ทำให้ผิดหวัง และมีความเป็นมืออาชีพอย่างแท้จริง ', 'พี่น้ำ', 'กทม', '/iconnex_thailand_db/img/67ea76f5cf079-ChatGPT Image Mar 31, 2025, 03_44_36 PM.png'),
(6, 'ชื่นชมจากใจค่ะ', 'เป็นทีมที่ทำงานอย่างมืออาชีพค่ะ แต่ว่ายังมีความเป็นกันเองอยู่ ทำให้ไม่มีความอึดอัดเลยค่ะ', 'Praewa', 'Loei, TH', 'https://scontent.fbkk22-2.fna.fbcdn.net/v/t39.30808-1/487470583_1485334562425733_4073561966148818897_n.jpg?stp=dst-jpg_s200x200_tt6&_nc_cat=106&ccb=1-7&_nc_sid=e99d92&_nc_eui2=AeGnlz88kmZt0lU_rhNPLagWOvOtpamePiI6862lqZ4-IivqkNuGDEBKw6gxdfO3er6nAR6y0387G-3'),
(7, 'ชื่นชมจากใจค่ะ', 'asdf', 'Praewa', 'Loei, TH', '/uploads/67ee5dd2d72e7-ChatGPT Image Apr 3, 2025, 01_25_50 AM.png');

-- --------------------------------------------------------

--
-- Table structure for table `why_choose_us`
--

CREATE TABLE `why_choose_us` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `why_choose_us`
--

INSERT INTO `why_choose_us` (`id`, `title`, `description`) VALUES
(1, 'ประสบการณ์กว่า 10 ปี', 'ด้วยประสบการณ์ในวงการการตลาดดิจิทัลมากว่า 10 ปี ทีมงานของเราได้ทำงานร่วมกับลูกค้าหลากหลายอุตสาหกรรม'),
(2, 'ทีมงานมืออาชีพ', 'เราคัดเลือกผู้เชี่ยวชาญในทุกสาขา เพื่อให้มั่นใจว่าทุกบริการจะส่งมอบผลลัพธ์ที่ยอดเยี่ยม'),
(3, 'ผลลัพธ์ที่วัดได้', 'ทุกแคมเปญมาพร้อมรายงานผลลัพธ์ที่ชัดเจนและเข้าใจง่าย'),
(4, 'โซลูชันเฉพาะตัว', 'กลยุทธ์ทุกชิ้นถูกออกแบบมาเพื่อธุรกิจของคุณโดยเฉพาะ'),
(5, 'test3', 'test3');

-- --------------------------------------------------------

--
-- Table structure for table `works`
--

CREATE TABLE `works` (
  `id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `list_item1` varchar(255) DEFAULT NULL,
  `list_item2` varchar(255) DEFAULT NULL,
  `list_item3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `works`
--

INSERT INTO `works` (`id`, `image_url`, `title`, `list_item1`, `list_item2`, `list_item3`) VALUES
(1, 'img/team-1.jpg', 'การทำงานร่วมกันเป็นทีม', 'การวางแผนเชิงกลยุทธ์', 'การประสานงานที่มีประสิทธิภาพ', 'ผลลัพธ์ที่ยอดเยี่ยม'),
(4, 'img/team-2.jpg', 'ความสำเร็จของลูกค้า', 'เพิ่มยอดขาย 200%', 'ลูกค้าพึงพอใจสูง', 'โครงการที่ส่งมอบตรงเวลา'),
(7, 'img/team-3.jpg', 'การออกแบบสร้างสรรค์', 'ดีไซน์ทันสมัย', 'แบรนด์ที่โดดเด่น', 'ความคิดสร้างสรรค์ไร้ขีดจำกัด'),
(8, 'img/team-4.jpg', 'การตลาดดิจิทัล', 'แคมเปญที่ทรงพลัง', 'การวิเคราะห์ข้อมูลเชิงลึก', 'เข้าถึงกลุ่มเป้าหมาย'),
(11, '/uploads/67ee5dc2ae0ee-ChatGPT Image Apr 3, 2025, 01_25_50 AM.png', 'rtyhrsth', 'srthsrhs', 'rthsrths', 'thsrth');

-- --------------------------------------------------------

--
-- Table structure for table `work_process`
--

CREATE TABLE `work_process` (
  `id` int(11) NOT NULL,
  `step` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `work_process`
--

INSERT INTO `work_process` (`id`, `step`, `title`, `description`) VALUES
(1, 'ขั้นตอนที่ 1', 'วิเคราะห์และวางแผน', 'ศึกษาและทำความเข้าใจธุรกิจของคุณอย่างลึกซึ้ง'),
(4, 'ขั้นตอนที่ 2', 'ออกแบบและพัฒนา', 'สร้างสรรค์คอนเทนต์และพัฒนาโซลูชันที่ตอบโจทย์'),
(5, 'ขั้นตอนที่ 3', 'ดำเนินการและปรับแต่ง', 'ดูแลแคมเปญและปรับแต่งแบบเรียลไทม์'),
(6, 'ขั้นตอนที่ 4', 'วัดผลและรายงาน', 'สรุปผลลัพธ์ด้วยรายงานที่ชัดเจน'),
(7, 'test3', 'test3', 'test3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logos`
--
ALTER TABLE `logos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_cards`
--
ALTER TABLE `service_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `why_choose_us`
--
ALTER TABLE `why_choose_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `works`
--
ALTER TABLE `works`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_process`
--
ALTER TABLE `work_process`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `blocks`
--
ALTER TABLE `blocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
<<<<<<< HEAD
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
=======
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
>>>>>>> origin/contact-page

--
-- AUTO_INCREMENT for table `logos`
--
ALTER TABLE `logos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `service_cards`
--
ALTER TABLE `service_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `why_choose_us`
--
ALTER TABLE `why_choose_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `works`
--
ALTER TABLE `works`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `work_process`
--
ALTER TABLE `work_process`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
