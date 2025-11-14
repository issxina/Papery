-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2025 at 04:34 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `books_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_books`
--

CREATE TABLE `tbl_books` (
  `id` int(6) NOT NULL,
  `book_title` varchar(200) NOT NULL,
  `book_author` varchar(100) NOT NULL,
  `book_price` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `book_stock_qty` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `book_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `category_id` int(6) NOT NULL,
  `book_img` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_books`
--

INSERT INTO `tbl_books` (`id`, `book_title`, `book_author`, `book_price`, `book_stock_qty`, `book_created`, `category_id`, `book_img`) VALUES
(1, 'เด็กชายในชุดนอนลายทาง ฉบับปรับปรุง', 'จอห์น บอยน์/ วารี ตัณฑุลากร', 175.00, 10, '2025-09-02 02:46:32', 3, 'uploads/book/t7cSSmCHwOfHhy3TwW3HH5sFa01yZybnb0DDtQG9.jpg'),
(2, 'เลขาฯ คนนี้เป็นสามีบอส', 'อุณหภูมิปกติ', 410.00, 10, '2025-08-28 09:48:24', 3, 'uploads/book/AqnegW2H2s5kDEou6rbvvV0BHz0pF8zESIim6vXg.jpg'),
(3, 'TAIWAN : ไต้หวัน เล่มเดียวเที่ยวได้จริง (Edition 3)', 'สิรภพ มหรรฆสุวรรณ', 375.00, 15, '2025-08-28 09:50:27', 4, 'uploads/book/C4mMJW1I1VjkpDvo7JpkpzGuMfalA1GuMxJOIPiO.jpg'),
(4, 'คุณชายแสนขี้เกียจก็แค่อยากกลับใจ', 'จูนิเบลล์96', 459.00, 7, '2025-09-02 02:37:35', 3, 'uploads/book/fY1ozK28FBL3rCzIRkghUXhxOs44hlAUm5NpKZ53.jpg'),
(5, 'Nippon Sweetie รักหวานใสหัวใจสีซากุระ', 'เจ้าหญิงผู้เลอโฉม', 239.00, 10, '2025-09-02 02:37:35', 3, 'uploads/book/utOQUOEC6EWev6c6GQ2DvCvp7phiLuqdDGEA0ku0.jpg'),
(6, 'ฉันคือวิวาห์ต้องห้าม', 'เถาไอวี', 429.00, 16, '2025-09-02 02:39:56', 3, 'uploads/book/0iIu6uXZkYAanlCv9sG8CcLICsG1KQH0vCCzQlH5.jpg'),
(8, 'ขอต้อนรับสู่ห้องเรียนนิยม (เฉพาะ) ยอดคน ปีสอง เล่ม 1 (ฉบับนิยาย)', 'คินุงาสะ โชโงะ', 315.00, 6, '2025-09-02 02:40:48', 3, 'uploads/book/Nk4RQDaiWMtk5Hgtft63LDAFebPxAp9gH9Lcc90K.jpg'),
(9, 'บันทึกต้องห้ามของอดีตฆาตกรโรคจิตกลับชาติมาเกิด เล่ม1', 'Raragi bk', 270.00, 11, '2025-09-02 02:41:51', 3, 'uploads/book/TQiowkWDpm1gaWuxLrIRsHeAEPJEzaoeMnKjjiid.jpg'),
(10, 'บันทึกต้องห้ามของอดีตฆาตกรโรคจิตกลับชาติมาเกิด เล่ม2', 'Raragi bk', 330.00, 10, '2025-09-02 02:41:51', 3, 'uploads/book/aoszlKLk7hJVFlKSugYxcliWqipoEH2PKlyaR7jG.jpg'),
(11, 'ผมที่ไม่อยากทำงานไปชั่วชีวิต ได้สนิทสนมกับไอดอลชื่อดังที่เป็นเพื่อนร่วมชั้น เล่ม 1', 'คาซึฮะ คิชิโมโตะ', 300.00, 14, '2025-09-02 02:45:33', 3, 'uploads/book/72FWd72zLOnXNTOKlyBcFElB0QDflEIzblZPueq2.jpg'),
(12, 'เที่ยวญี่ปุ่น Okinawa', 'DPLUS Guide Team', 345.00, 50, '2025-09-02 02:48:30', 4, 'uploads/book/M1BVlfTphmCnrFFfg7zxwC8hS5fXtUdT7Oue7a21.jpg'),
(13, 'เที่ยวตามใจชอบ ไต้หวัน ไทเปและเมืองโดยรอบ', 'Jojohakone และกองบรรณาธิการ tibbook', 365.00, 52, '2025-09-02 02:48:30', 4, 'uploads/book/zwnsFqCUlGIQOj1uUjVHZkTm65JxOrynrskPSpzA.jpg'),
(14, 'LET\'S GO ITALY', 'ตะวัน พันธ์แก้ว', 385.00, 17, '2025-09-02 02:49:24', 4, 'uploads/book/SOqtwbq1TCL2kMqIDoGv7vmymF1IYmLTLfyojCQm.jpg'),
(15, 'เรื่องเล่าอินเดียเล่ม 2 เที่ยวชัยปุระ จอร์ดปูร์ และชิมลา', 'หญิงเถื่อน', 159.00, 6, '2025-09-02 02:49:24', 4, 'uploads/book/wPgX2edMNfuu5ZLByBbJZShLWkUmBVz4rHWrr9qL.jpg'),
(16, 'แมนชั่น...ขวัญผวา', 'ปรมินทร์', 59.00, 33, '2025-09-02 02:47:24', 3, 'uploads/book/QgjOjCRkE3dtKXuoEDayFEwcLAksrueNM0ofeAvu.jpg'),
(17, 'ภาพวาดปริศนากับการตามหาฆาตกร', 'อุเก็ตสึ/ ฉัตรขวัญ อดิศัย', 335.00, 6, '2025-09-02 02:47:24', 3, 'uploads/book/sdveZEOvrsTcIUjcjxalrOD1sfpvxAxLEMekF4u6.jpg'),
(18, 'สารคดีล่องแม่น้ำดานูบ (ฮังการี)', 'ชัยชนะ โพธิวาระ', 120.00, 42, '2025-09-02 02:50:56', 4, 'uploads/book/Edjrmj1qj0iQ0gtK7m1asNEU1mMlOxXEjxoOIj1p.jpg'),
(19, 'เที่ยวเองง่าย ๆ ตรงใจสุด ๆ อินชอน [เกาหลีใต้]', 'ฐิติกานต์ นิธิอุทัย (เมซี่)', 277.00, 26, '2025-09-02 02:50:56', 4, 'uploads/book/zZRQOA0xoLA6irnkDbR2l49pO6EZgkYP7Il2gy5S.jpg'),
(20, 'SWISS สวิตเซอร์แลนด์ เที่ยวเมืองเก่า ขุนเขาเสียดฟ้า หลังคายุโรป', 'วศิน เพิ่มทรัพย์ และ วงศ์ประชา จันทร์สมวงศ์', 385.00, 26, '2025-09-02 02:52:02', 4, 'uploads/book/7WJX1bST4lyFEc8pYu0uZLDxGQ9AcoYXnCnTsU3b.jpg'),
(21, 'ของดี 77 จังหวัดทั่วไทย', 'ปิยะกร ไชยพร', 119.00, 56, '2025-09-02 02:52:02', 4, 'uploads/book/DdnLZwFH3XAR4voUgST05eAWvcaz80bSV65OapEm.jpg'),
(22, 'Trip To ยุโรปตะวันออก', 'อดิศักดิ์ จันทร์ดวง', 370.00, 50, '2025-09-02 02:53:35', 4, 'uploads/book/s1J3vaudxONfvVlZwtIPVtvr7jHMJZP4fkYDj8tp.jpg'),
(23, 'ชีวิต 70 คะแนนก็โอเคแล้ว', 'Poche / โมกุโมกุจัง / เมธี ธรรมพิภพ แปล', 265.00, 11, '2025-09-02 02:53:35', 5, 'uploads/book/XfsfrLhWfGebmMRSWpa7mgIkJFgY5VG6Im5JVHJI.jpg'),
(24, 'ฮีลใจ', 'สร้อยสิรินทร์', 159.00, 25, '2025-09-02 02:55:02', 5, 'uploads/book/nZ6kPhNqaD0l0se9bPWSHu3xOUKgnicIwbH1uIkT.jpg'),
(25, 'จิตวิทยาตีเนียน (เพื่อจัดการคนน่ารำคาญ)', 'อิโนะอุเอะ โทโมะสุเกะ/ กมลวรรณ เพ็ญอร่าม', 235.00, 20, '2025-09-02 02:55:02', 5, 'uploads/book/yNQOnAlzxItjXIq7R9ivbnQoEUxlo6BV7Vh7yolx.jpg'),
(26, 'All about MBTI ฉบับการ์ตูน', 'นาอูจิน, คิมจุนฮวัน, และอีจีฮี', 389.00, 30, '2025-09-02 02:55:02', 5, 'uploads/book/gQSso06SvpEU7lm0nrw06f98UUXU2o5y9TVjHUrC.jpg'),
(27, 'ศิลปะการอยู่กับคน (The Art of People)', 'Dave Kerpen', 260.00, 7, '2025-09-02 02:56:30', 5, 'uploads/book/JIDbRSyVcGPmSBxOMlSjHLIwevZ1MnpYCeqMvKMl.jpg'),
(28, 'โอบกอดหัวใจในวันที่น้องกลับดาว', 'สัตวแพทย์ ชิมย็องฮี / กนกพร เรืองสา แปล', 295.00, 11, '2025-09-02 02:56:30', 5, 'uploads/book/x5uYr3x8aX0gXzTLXM7fKMenjFOSeLtw7zHwyqwU.jpg'),
(29, 'MAKE TIME เทคนิคออกแบบชีวิต คืนเวลาให้ตัวเอง', 'Jake Knapp and John Zeratsky / นวบุ', 295.00, 20, '2025-09-02 02:56:30', 5, 'uploads/book/DgQY5GadK8sm8ZDY7AvFnPm2BHWttv5FCDcP3QAa.jpg'),
(30, 'คำพูด Toxic เหมือนหวังดีแต่มีพิษ', 'โนริทากะ โมริยามะ', 247.00, 11, '2025-09-02 02:58:52', 5, 'uploads/book/IRhWC0u9Jn2zoU2xGKzR5G0rJYsG4bTz6BkB1SOL.jpg'),
(31, 'เวลาไม่เคยคอยใคร แต่เวลาให้คำตอบที่เรารอคอยเสมอ Only Time Will Tell (New Edition)', 'วิไลรัตน์ เอมเอี่ยม', 275.00, 30, '2025-09-02 02:58:52', 5, 'uploads/book/YddVXOmXI2tlGRmKQqLaSh5mxT7JJh4y6WPuQHke.jpg'),
(32, 'เพราะเธอมีค่าเกินกว่าจะเป็น \'คนสุดท้าย\'', 'ทิง (วันนี้เจอนั่น)', 215.00, 16, '2025-09-02 02:58:52', 5, 'uploads/book/taiZvrHKWi64w9Tt2DTt68Ow6c7mYUcC7RQ9OfjG.jpg'),
(33, 'บทเพลงรักของผู้ทรยศ เล่ม 1(18+)', 'โมตตาสึ โทโนกะ', 220.00, 4, '2025-09-02 02:58:52', 2, 'uploads/book/8KwL4b1qvwEZfYb5MG6YdwgPAcMUexonb0MuWBTE.jpg'),
(34, 'Radiation House 14', 'Tomohiro Yokomaku, Taishi Mori', 215.00, 16, '2025-09-02 03:00:18', 2, 'uploads/book/0YEvjnFtBVFvdD5XtUXdrdEMraZrzRzfucnHuY7q.jpg'),
(35, 'เกิดใหม่เป็นหนุ่มสวะในการ์ตูน NTR ทั้งที แต่นางเอกดันรุกใส่เองซะงั้น เล่ม 1(18+)', 'Myon', 180.00, 20, '2025-09-02 03:00:18', 2, 'uploads/book/J1ssG47zoGSxgPnsNRIOXqEernHfxmvV0MHhXcEp.jpg'),
(36, 'เกิดใหม่เป็นหนุ่มสวะในการ์ตูน NTR ทั้งที แต่นางเอกดันรุกใส่เองซะงั้น เล่ม 2(18+)', 'Myon', 180.00, 25, '2025-09-02 03:00:18', 2, 'uploads/book/rEe7rGkz6Tg2q4Vb0jaFrrXq5BYGgRWqtqMZZ9yG.jpg'),
(37, 'ผมเทพสุดจริงเหรอ? เล่ม 1', 'Sai Sumimori / Ai Takahashi', 99.00, 74, '2025-09-02 03:02:34', 2, 'uploads/book/VllteQIGRXToqDxI5ZJs3BUZspjE1yp993DpQ2Wx.jpg'),
(38, 'คำลาแด่เวลาที่ล่วงเลย', 'Cocomi', 180.00, 60, '2025-09-02 03:02:34', 2, 'uploads/book/koChBE3vvt24RDACOx5seli6JAqSH3yvqJZZT973.jpg'),
(40, 'พอยต์ ออฟ โน รีเทิร์น (point of no return) (จบในเล่ม)', 'อินุโอกะ นิอิ', 200.00, 15, '2025-09-02 03:02:34', 2, 'uploads/book/zPQtewCagUk2Y0hyM01VpTggPIvap4caBT7AchbX.jpg'),
(41, 'ด้วยรักและพังทลาย เล่ม 1 (ฉบับการ์ตูน)', 'ทาโมสึ คุวาบาระ', 185.00, 20, '2025-09-02 03:02:34', 2, 'uploads/book/L3AzmOmrPIyF5CTPJ0dcJsE4lsFOSCq5WTTrATrm.jpg'),
(42, 'ด้วยรักและพังทลาย เล่ม 2 (ฉบับการ์ตูน)', 'ทาโมสึ คุวาบาระ', 185.00, 20, '2025-09-02 03:05:07', 2, 'uploads/book/TP2FckoHnEMqnowlixDT5qcRCNLzGWYqwX9Sbq90.jpg'),
(43, 'ด้วยรักและพังทลาย เล่ม 3 (ฉบับการ์ตูน)', 'ทาโมสึ คุวาบาระ', 185.00, 20, '2025-09-02 03:05:07', 2, 'uploads/book/NKYL73ZaQDmxc7JAKHzPICApSLb2xR0pQ6oEg19x.jpg'),
(44, 'หนุ่มเย็บผ้ากับสาวนักคอสเพลย์ เล่ม 01', 'Shinichi Fukuda', 125.00, 30, '2025-09-02 03:05:07', 2, 'uploads/book/C8NGpWapxQJSHeYMhAxQfBkCiEqZCWLIkSLebDUP.jpg'),
(57, 'ชิโนะกับเร็น เล่ม 1 (ฉบับการ์ตูน)', 'มิโนริ จิงุสะ', 295.00, 22, '2025-09-28 15:45:39', 2, 'uploads/book/mdl8mZeQ7LAIxl0S5sInx64C9mYi6EKbOR3nLN31.jpg'),
(58, 'หารายได้เสริมทางอินเตอร์เน็ต โดยไม่ต้องลงทุน', 'M.RUTCHAPONG', 69.00, 84, '2025-09-28 20:45:45', 8, 'uploads/book/th0u1ysv5PBcBLbbqmssx51KxRKAp26S3v8oZ7YU.jpg'),
(59, 'เรื่องราวของวัยทีนที่อยากประสบความสำเร็จ SUCCESS', 'สตาร์ทีน', 199.00, 76, '2025-09-28 20:46:40', 8, 'uploads/book/R2H59AtfK0VOwf3XwG2Id6zSbeTa40AXNv6k0VIF.jpg'),
(60, 'ความรู้เกี่ยวกับประชาคมอาเซียนเล่ม 1', 'ทีมวิชาการนิช', 360.00, 74, '2025-09-28 20:47:45', 8, 'uploads/book/sKIL6zz6DhFEPzEesHIvKKvvgJc6TUXg1XYw3w1Q.jpg'),
(61, 'ความรู้เกี่ยวกับประชาคมอาเซียนเล่ม 2', 'ทีมวิชาการนิช', 360.00, 86, '2025-09-28 20:48:29', 8, 'uploads/book/QokbZSeMFZXW6GMSVgbgPDnJNfEX5tcDhsgBNl27.jpg'),
(62, 'แมงกะพรุนย้อนวัย (Jellyfish Age Backwards)', 'Nicklas Brendborg/ เขมลักขณ์ ดีประวัติ แปล', 335.00, 20, '2025-09-28 20:48:56', 8, 'uploads/book/WPiUzN9uyYZrNCGFgG3TRSBbrLZCkij8z10vZtkp.jpg'),
(63, 'มนุษย์กับสังคม', 'คณะกรรมการวิชามนุษย์กับสังคม ฝ่ายวิชาบูรณาการ หมวดวิชาศึกษาทั่วไป มหาวิทยาลัยเกษตรศาสตร์', 160.00, 70, '2025-09-28 20:49:45', 8, 'uploads/book/DdTkK0I4ox9kl7LEotMutRsxqNMbXZxFIWAGFraj.jpg'),
(64, 'หลักการประชาสัมพันธ์', 'ณัฏฐ์ชุดา วิจิตรจามรี', 290.00, 68, '2025-09-28 20:50:11', 8, 'uploads/book/JImBHaaTkXRA4PtldmJMxi8E81sCNBetpwFeScdJ.jpg'),
(65, 'วิธีทำอีบุ๊กในมือถือ', 'ดอกไม้หนาม', 19.00, 80, '2025-09-28 20:50:34', 8, 'uploads/book/sQaxx0aobfuRiOmcud1PeGYscE1wsZMGZuWy4NQ2.jpg'),
(66, 'เคล็ดไม่สับ..แบบฉบับจับมือทำ สอนเขียนนิยายสำหรับนักเขียนมือใหม่', 'Blue Butterfly', 219.00, 78, '2025-09-28 20:50:54', 8, 'uploads/book/ZltncyjgFUZBexYjBNeMUuFDczneWMNmzHyVsaRD.jpg'),
(67, 'โครงเรื่องขายดีตลอดกาลในนิยาย', 'คืนวันเสาร์', 390.00, 70, '2025-09-28 20:51:16', 8, 'uploads/book/B7nsXJtyiLRRC6QxtdLvOYy7eWK7QqipfXYcrQCS.jpg'),
(68, 'คนโปรดของแม่มด', 'Galaxy', 360.00, 15, '2025-10-02 07:58:36', 3, 'uploads/book/pjht8pinmFdNk20WONBpxP9hMNgDGGhOeh9OMuWr.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

CREATE TABLE `tbl_categories` (
  `id` int(6) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_slug` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`id`, `category_name`, `category_slug`) VALUES
(2, 'การ์ตูน', 'cartoon'),
(3, 'นิยาย/วรรณกรรม', 'fiction'),
(4, 'ท่องเที่ยว', 'travel'),
(5, 'จิตวิทยา', 'psychology'),
(8, 'ความรู้ทั่วไป', 'knowledge');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

CREATE TABLE `tbl_orders` (
  `id` int(6) NOT NULL,
  `user_id` int(6) NOT NULL,
  `order_status` enum('pending','paid','packed','shipped','completed','cancelled') NOT NULL DEFAULT 'pending',
  `order_subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `order_discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `order_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_shipping_address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_orders`
--

INSERT INTO `tbl_orders` (`id`, `user_id`, `order_status`, `order_subtotal`, `order_discount`, `order_amount`, `order_date`, `order_shipping_address`) VALUES
(45, 12, 'shipped', 2662.00, 0.00, 2662.00, '2025-09-30 03:52:00', 'djwjwoijcwinciwojfwoif'),
(46, 12, 'shipped', 1750.00, 0.00, 1750.00, '2025-09-30 03:52:00', 'djwjwoijcwinciwojfwoif'),
(47, 12, 'paid', 365.00, 0.00, 365.00, '2025-09-30 03:52:57', 'djwjwoijcwinciwojfwoif'),
(48, 12, 'completed', 200.00, 0.00, 200.00, '2025-09-30 03:53:00', 'djwjwoijcwinciwojfwoif'),
(49, 12, 'paid', 390.00, 0.00, 390.00, '2025-09-30 03:53:26', 'djwjwoijcwinciwojfwoif'),
(50, 12, 'paid', 219.00, 0.00, 219.00, '2025-09-30 03:53:39', 'djwjwoijcwinciwojfwoif'),
(52, 12, 'paid', 910.00, 0.00, 910.00, '2025-09-30 03:53:54', 'djwjwoijcwinciwojfwoif'),
(53, 12, 'paid', 730.00, 0.00, 730.00, '2025-09-30 03:54:37', 'djwjwoijcwinciwojfwoif'),
(54, 12, 'pending', 370.00, 0.00, 370.00, '2025-09-30 03:54:00', 'djwjwoijcwinciwojfwoif'),
(55, 12, 'paid', 385.00, 0.00, 385.00, '2025-09-30 03:54:59', 'djwjwoijcwinciwojfwoif'),
(56, 13, 'completed', 565.00, 0.00, 565.00, '2025-09-30 06:34:00', 'mdifowkfopwfmp,cvs'),
(57, 13, 'paid', 645.00, 0.00, 645.00, '2025-09-30 06:35:47', 'mdifowkfopwfmp,cvs'),
(58, 13, 'paid', 374.00, 0.00, 374.00, '2025-09-30 08:42:24', 'mdifowkfopwfmp,cvs'),
(59, 13, 'paid', 2824.00, 0.00, 2824.00, '2025-10-01 07:01:47', 'mdifowkfopwfmp,cvs'),
(60, 13, 'paid', 1098.00, 0.00, 1098.00, '2025-10-01 07:02:25', 'mdifowkfopwfmp,cvs'),
(61, 13, 'paid', 2485.00, 0.00, 2485.00, '2025-10-01 07:02:51', 'mdifowkfopwfmp,cvs'),
(62, 13, 'paid', 2309.00, 0.00, 2309.00, '2025-10-01 07:03:21', 'mdifowkfopwfmp,cvs'),
(63, 13, 'paid', 1600.00, 0.00, 1600.00, '2025-10-01 07:03:40', 'mdifowkfopwfmp,cvs'),
(64, 12, 'paid', 839.00, 0.00, 839.00, '2025-10-02 07:06:29', 'ram 69'),
(68, 13, 'paid', 318.00, 0.00, 318.00, '2025-10-02 07:20:08', 'mdifowkfopwfmp,cvs');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_details`
--

CREATE TABLE `tbl_order_details` (
  `id` int(20) NOT NULL,
  `order_id` int(6) NOT NULL,
  `book_id` int(6) NOT NULL,
  `orderdetails_qty` int(10) NOT NULL,
  `orderdetails_unit_price` decimal(10,2) NOT NULL,
  `orderdetails_total_price` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_order_details`
--

INSERT INTO `tbl_order_details` (`id`, `order_id`, `book_id`, `orderdetails_qty`, `orderdetails_unit_price`, `orderdetails_total_price`) VALUES
(104, 45, 57, 2, 295.00, 590.00),
(106, 45, 31, 2, 275.00, 550.00),
(108, 45, 27, 1, 260.00, 260.00),
(109, 45, 28, 1, 295.00, 295.00),
(110, 45, 66, 2, 219.00, 438.00),
(111, 45, 63, 3, 160.00, 480.00),
(113, 46, 67, 3, 390.00, 1170.00),
(114, 47, 41, 1, 185.00, 185.00),
(115, 47, 36, 1, 180.00, 180.00),
(116, 48, 40, 1, 200.00, 200.00),
(117, 49, 67, 1, 390.00, 390.00),
(118, 50, 66, 1, 219.00, 219.00),
(120, 52, 3, 2, 375.00, 750.00),
(121, 52, 63, 1, 160.00, 160.00),
(122, 53, 13, 2, 365.00, 730.00),
(123, 54, 22, 1, 370.00, 370.00),
(124, 55, 14, 1, 385.00, 385.00),
(125, 56, 43, 1, 185.00, 185.00),
(126, 56, 40, 1, 200.00, 200.00),
(127, 56, 35, 1, 180.00, 180.00),
(128, 57, 10, 1, 330.00, 330.00),
(129, 57, 8, 1, 315.00, 315.00),
(130, 58, 37, 1, 99.00, 99.00),
(131, 58, 31, 1, 275.00, 275.00),
(132, 59, 2, 2, 410.00, 820.00),
(133, 59, 11, 1, 300.00, 300.00),
(134, 59, 10, 1, 330.00, 330.00),
(135, 59, 6, 1, 429.00, 429.00),
(137, 59, 8, 1, 315.00, 315.00),
(138, 59, 9, 1, 270.00, 270.00),
(139, 60, 11, 1, 300.00, 300.00),
(141, 60, 5, 1, 239.00, 239.00),
(142, 60, 59, 1, 199.00, 199.00),
(143, 61, 44, 1, 125.00, 125.00),
(144, 61, 40, 1, 200.00, 200.00),
(145, 61, 36, 1, 180.00, 180.00),
(146, 61, 10, 6, 330.00, 1980.00),
(148, 62, 2, 1, 410.00, 410.00),
(149, 62, 6, 1, 429.00, 429.00),
(150, 62, 43, 6, 185.00, 1110.00),
(151, 63, 40, 8, 200.00, 1600.00),
(152, 64, 2, 1, 410.00, 410.00),
(153, 64, 6, 1, 429.00, 429.00),
(158, 68, 24, 2, 159.00, 318.00),
(161, 49, 68, 2, 360.00, 720.00),
(165, 52, 20, 1, 385.00, 385.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payments`
--

CREATE TABLE `tbl_payments` (
  `id` int(15) NOT NULL,
  `order_id` int(6) NOT NULL,
  `pay_method` enum('promptpay') NOT NULL DEFAULT 'promptpay',
  `pay_amount` decimal(10,2) NOT NULL,
  `pay_proof_path` varchar(255) DEFAULT NULL,
  `pay_paid_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_payments`
--

INSERT INTO `tbl_payments` (`id`, `order_id`, `pay_method`, `pay_amount`, `pay_proof_path`, `pay_paid_at`) VALUES
(44, 46, 'promptpay', 1750.00, 'payments/ZV2dtZbezkb5o09BVEueccSi9rn1ATvNVmeyqWd4.jpg', '2025-09-30 10:52:48'),
(45, 47, 'promptpay', 365.00, 'payments/lK90fXw7tWaLUmfDlfoEHFMva9eBy5EmN3954tIH.jpg', '2025-09-30 10:52:57'),
(46, 48, 'promptpay', 200.00, 'payments/SSjOxiBmbCASv3sACV1nuH0sT4lK71Yed6fKbIQK.png', '2025-09-30 10:53:05'),
(47, 49, 'promptpay', 390.00, 'payments/hO29Fd8KmUxnw9cjB78V8Fb2pEz7DRj4CTCAymsN.jpg', '2025-09-30 10:53:26'),
(48, 50, 'promptpay', 219.00, 'payments/Ngb57U9wwRun1nQtEM5R9xt3lHWEEdVJ80o9QfMy.jpg', '2025-09-30 10:53:39'),
(50, 52, 'promptpay', 910.00, 'payments/1N9j5l2Yvb9XPujCZAz9PKEow4U04o1T31b2GQih.png', '2025-09-30 10:53:54'),
(51, 53, 'promptpay', 730.00, 'payments/dW1xNxbmCCRFwd7cZ0Ff9sYxEKjn7nAzOKmehj9J.jpg', '2025-09-30 10:54:37'),
(52, 54, 'promptpay', 370.00, 'payments/DpbcfSmowQTLM3LjOZhyRYQ414IXLtO6vK46kisl.jpg', '2025-09-30 10:54:50'),
(53, 55, 'promptpay', 385.00, 'payments/pDfyR9bdUjLoIQwkAJSrYRXphm3EZxpNdqZyxxP7.png', '2025-09-30 10:54:59'),
(54, 56, 'promptpay', 565.00, 'payments/07qBjdhVfu0ipxWL83OBgm4RZdyCGNeUsYdm3l6e.png', '2025-09-30 13:34:54'),
(55, 57, 'promptpay', 645.00, 'payments/6zrW3P3EHnC3ieCzmBWx6JHGzOpVX2XLCyE8vaVc.png', '2025-09-30 13:35:47'),
(56, 58, 'promptpay', 374.00, 'payments/PTK7FWLaKhZDlHTl3xTQxaCE1MzyJNWj2o5yiAFr.png', '2025-09-30 15:42:24'),
(57, 59, 'promptpay', 2824.00, 'payments/LEOv2ZZ0HOq6hUeIfJ7SwzCHnTKpvQZkOzUfT3yQ.png', '2025-10-01 14:01:47'),
(58, 60, 'promptpay', 1098.00, 'payments/hxZMDaAMKj5eRooBF8cwkD5Xep0BlxGlzZyDS4Ay.png', '2025-10-01 14:02:25'),
(59, 61, 'promptpay', 2485.00, 'payments/UXQnwBUEc5HuFLhzhtRlZj19w2t14Rh7Rhe7SXP5.png', '2025-10-01 14:02:51'),
(60, 62, 'promptpay', 2309.00, 'payments/C8IAn2PrT9F4cHCVuweeEHlwxMDm6jsROTlfDOWU.png', '2025-10-01 14:03:21'),
(61, 63, 'promptpay', 1600.00, 'payments/fzQ5zAxyqafAASzHrfbkjQJEgw2IASp2eLCpgrYj.png', '2025-10-01 14:03:40'),
(62, 64, 'promptpay', 839.00, 'payments/ksjt1aAYUYT5JI9Or124hcXrfHL2yTnWjzmzYr2c.png', '2025-10-02 14:06:29'),
(64, 68, 'promptpay', 318.00, 'payments/4JeZok7iX3ydW8rFp74KU4925Q34qaU0K3ivcW2u.png', '2025-10-02 14:20:08');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff`
--

CREATE TABLE `tbl_staff` (
  `id` int(6) NOT NULL,
  `st_name` varchar(100) NOT NULL,
  `st_email` varchar(200) NOT NULL,
  `st_password` varchar(255) NOT NULL,
  `st_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_staff`
--

INSERT INTO `tbl_staff` (`id`, `st_name`, `st_email`, `st_password`, `st_timestamp`) VALUES
(6, 'Pattarapa', 'ja.pattarapa_st@tni.ac.th', '$2y$12$3NZILpVnVyHO5o01CYjQ4Opg/Yz3ntNU/XsbTmN5byp68pxXOi.bW', '2025-09-30 07:33:00'),
(8, 'Achiraya', 'ph.achiraya_st@tni.ac.th', '$2y$12$SYnPNuV37QRgUff5QLrPuOjNaJT9kxvT7uAZTP/E50cm.lySWIZYK', '2025-09-30 07:50:31');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(6) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `user_phone` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `user_name`, `user_email`, `user_password`, `user_address`, `user_phone`) VALUES
(12, 'Sleepy', 'sleepy@gmail.com', '$2y$12$5gIUolwHQ2xYaDdi/iNPQuWjbKuzAYX.Yst.qGEADPNj28433S3Tm', 'ram 69', '0981951566'),
(13, 'SkyRORO', 'sky@gmail.com', '$2y$12$AQ34lSoe/BV8w9S24e50quNe/BYk9JlWBNdXNw5HehDg8sf2y6MIS', 'mdifowkfopwfmp,cvs', '0941230025'),
(14, 'June', 'june@gmail.com', '$2y$12$Ua8iMfONkjmr8OMKCpSr/.zaw0UUDNBVdreB6VNCMePeGfCid8SHm', 'sakdq 25 rem', '0641235899'),
(15, 'Apsorn', 'apsorn@gmail.com', '$2y$12$wkF7lZPV9wy64WOG8mL8Pe8fmY7klQtbgnrAcU16rZI/s/SWlMBCa', 'eam 14/22 lapldaw', '0974452455'),
(22, 'ashi', 'ashi@gmail.com', '$2y$12$./CdD.DukLX0Kyw7L19fReQUhcvyRS9gXLNklogA05se9R5ZZXsa6', 'chaantaburi', '0981951566');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_books`
--
ALTER TABLE `tbl_books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_books_category` (`category_id`);

--
-- Indexes for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fk_category_name` (`category_name`),
  ADD UNIQUE KEY `category_slug` (`category_slug`);

--
-- Indexes for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_orders_user` (`user_id`);

--
-- Indexes for table `tbl_order_details`
--
ALTER TABLE `tbl_order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orders_orderdetails` (`order_id`),
  ADD KEY `fk_books_orderdetails` (`book_id`);

--
-- Indexes for table `tbl_payments`
--
ALTER TABLE `tbl_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pay_order_cascade` (`order_id`);

--
-- Indexes for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ad_email` (`st_email`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_books`
--
ALTER TABLE `tbl_books`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `tbl_order_details`
--
ALTER TABLE `tbl_order_details`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `tbl_payments`
--
ALTER TABLE `tbl_payments`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_books`
--
ALTER TABLE `tbl_books`
  ADD CONSTRAINT `fk_books_category` FOREIGN KEY (`category_id`) REFERENCES `tbl_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_order_details`
--
ALTER TABLE `tbl_order_details`
  ADD CONSTRAINT `fk_books_orderdetails` FOREIGN KEY (`book_id`) REFERENCES `tbl_books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_orders_orderdetails` FOREIGN KEY (`order_id`) REFERENCES `tbl_orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_payments`
--
ALTER TABLE `tbl_payments`
  ADD CONSTRAINT `fk_pay_order_cascade` FOREIGN KEY (`order_id`) REFERENCES `tbl_orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
