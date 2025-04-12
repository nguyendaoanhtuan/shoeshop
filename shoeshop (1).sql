-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 11, 2025 lúc 11:22 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `shoeshop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `role` enum('super_admin','admin','content_manager') DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `email`, `password_hash`, `full_name`, `role`, `created_at`) VALUES
(1, 'admin', 'admin1@domain.com', '123456', 'Nguyễn Văn A', 'admin', '2025-04-11 14:03:28');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `brands`
--

INSERT INTO `brands` (`brand_id`, `name`, `slug`, `description`, `logo_url`, `is_active`, `created_at`) VALUES
(2, 'Louis Vuitton', 'louis-vuitton', '', NULL, 1, '2025-04-11 19:26:14'),
(3, 'Balenciaga', 'balenciaga', '', NULL, 1, '2025-04-11 19:26:21'),
(4, 'Nike', 'nike', '', NULL, 1, '2025-04-11 19:26:26'),
(5, 'New Balance', 'new-balance', '', NULL, 1, '2025-04-11 19:26:33'),
(6, 'Adidas', 'adidas', '', NULL, 1, '2025-04-11 19:26:40'),
(7, 'Dior', 'dior', '', NULL, 1, '2025-04-11 19:26:52'),
(8, 'Gucci', 'gucci', '', NULL, 1, '2025-04-11 19:27:01'),
(9, 'Saint Laurent', 'saint-laurent', '', NULL, 1, '2025-04-11 19:27:36'),
(10, 'La Sportiva', 'la-sportiva', '', NULL, 1, '2025-04-11 19:27:56'),
(11, 'Merrell', 'merrell', '', NULL, 1, '2025-04-11 19:28:03'),
(12, 'Salonmon', 'salonmon', '', NULL, 1, '2025-04-11 19:28:13'),
(13, 'Scarpa', 'scarpa', '', NULL, 1, '2025-04-11 19:28:22'),
(14, 'The North Face', 'the-north-face', '', NULL, 1, '2025-04-11 19:28:27'),
(15, 'Asics', 'asics', '', NULL, 1, '2025-04-11 19:28:36'),
(17, 'Puma', 'puma', '', NULL, 1, '2025-04-11 19:29:02'),
(18, 'Allen Edmonds', 'allen-edmonds', '', NULL, 1, '2025-04-11 19:29:17'),
(19, 'Clarks', 'clarks', '', NULL, 1, '2025-04-11 19:29:24'),
(20, 'Cole Haan', 'cole-haan', '', NULL, 1, '2025-04-11 19:29:32'),
(21, 'Ecco', 'ecco', '', NULL, 1, '2025-04-11 19:29:38'),
(22, 'Geox', 'geox', '', NULL, 1, '2025-04-11 19:29:45');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_items`
--

CREATE TABLE `cart_items` (
  `item_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `variant_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `slug`, `parent_id`, `description`, `image_url`, `is_active`, `created_at`) VALUES
(6, 'Giày cao cấp', 'nam-gi-y-cao-c-p', 1, NULL, NULL, 1, '2025-04-11 19:23:39'),
(7, 'Giày leo núi và ngoài trời', 'nam-gi-y-leo-n-i-v-ngo-i-tr-i', 1, NULL, NULL, 1, '2025-04-11 19:24:23'),
(8, 'Giày thể thao', 'nam-gi-y-th-thao', 1, NULL, NULL, 1, '2025-04-11 19:24:40'),
(9, 'Giày văn phòng và công sở', 'nam-gi-y-v-n-ph-ng-v-c-ng-s-', 1, NULL, NULL, 1, '2025-04-11 19:24:45'),
(10, 'Giày cao cấp', 'nu-gi-y-cao-c-p', 2, NULL, NULL, 1, '2025-04-11 19:25:03'),
(11, 'Giày leo núi và ngoài trời', 'nu-gi-y-leo-n-i-v-ngo-i-tr-i', 2, NULL, NULL, 1, '2025-04-11 19:25:13'),
(12, 'Giày văn phòng và công sở', 'nu-gi-y-v-n-ph-ng-v-c-ng-s-', 2, NULL, NULL, 1, '2025-04-11 19:25:31'),
(13, 'Giày thể thao', 'nu-gi-y-th-thao', 2, NULL, NULL, 1, '2025-04-11 19:25:49');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled','refunded') DEFAULT 'pending',
  `total_amount` decimal(10,2) NOT NULL,
  `shipping_fee` decimal(10,2) DEFAULT 0.00,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` enum('pending','paid','failed','refunded') DEFAULT 'pending',
  `shipping_address` text NOT NULL,
  `billing_address` text DEFAULT NULL,
  `customer_note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_number`, `status`, `total_amount`, `shipping_fee`, `payment_method`, `payment_status`, `shipping_address`, `billing_address`, `customer_note`, `created_at`, `updated_at`) VALUES
(8, 1, 'ORD-1744401826', 'pending', 45520000.00, 20000.00, 'vnpay', 'pending', 'Nguyễn Quốc Đạt, Hoài Hải, SĐT: 0971898437, Email: ductuan@gmail.com', 'Nguyễn Quốc Đạt, Hoài Hải, SĐT: 0971898437, Email: ductuan@gmail.com', 'dsadsa', '2025-04-11 20:03:46', '2025-04-11 20:03:46'),
(9, 1, 'ORD-1744405614', 'shipped', 44020000.00, 20000.00, 'cod', 'failed', 'Nguyễn Quốc Đạt, Hoài Hải, SĐT: 0971898437, Email: anktuan344@gmail.com', 'Nguyễn Quốc Đạt, Hoài Hải, SĐT: 0971898437, Email: anktuan344@gmail.com', '', '2025-04-11 21:06:54', '2025-04-11 21:17:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `variant_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `size_name` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `variant_id`, `product_name`, `size_name`, `quantity`, `price`, `discount_price`, `total_price`) VALUES
(8, 8, 22, 'Balenciaga Defender', '35', 1, 23500000.00, 23500000.00, 0.00),
(9, 8, 18, 'Balenciaga Triple S', '43', 1, 22000000.00, 22000000.00, 0.00),
(10, 9, 15, 'Balenciaga Triple S', '40', 2, 22000000.00, 22000000.00, 0.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `stock_quantity` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`product_id`, `name`, `slug`, `description`, `short_description`, `category_id`, `brand_id`, `price`, `discount_price`, `sku`, `is_featured`, `is_active`, `created_at`, `updated_at`, `stock_quantity`) VALUES
(3, 'Balenciaga Triple S', 'balenciaga-triple-s-6', 'Balenciaga Triple S là mẫu sneaker biểu tượng của nhà mốt Balenciaga, nổi bật với:\r\n\r\nThiết kế đế ba lớp (Triple Sole) dày và êm ái.\r\n\r\nChất liệu: da thật, lưới thoáng khí, cao su cao cấp.\r\n\r\nMàu sắc: Đen, xám, be,...\r\n\r\nForm giày rộng, cá tính – phù hợp cho phong cách streetwear.\r\n\r\nHàng chính hãng nhập khẩu từ châu Âu.\r\n\r\nDòng sản phẩm dành riêng cho nam.', 'Giày thể thao cao cấp Balenciaga Triple S dành cho nam với thiết kế đế chunky 3 lớp đặc trưng, tạo nên phong cách mạnh mẽ và cá tính.', 6, 3, 25000000.00, 22000000.00, NULL, 1, 1, '2025-04-11 19:34:03', '2025-04-11 21:06:54', 42),
(4, 'Balenciaga Defender', 'balenciaga-defender-10', 'Thiết kế Defender dành cho nữ được điều chỉnh để phù hợp hơn với dáng chân và gu thẩm mỹ của phái đẹp:\r\n\r\nĐế dày nhưng được làm nhẹ hơn, giúp dễ di chuyển.\r\n\r\nChất liệu: Cao su chất lượng cao, vải lưới mềm, lớp lót êm ái.\r\n\r\nMàu sắc: Trắng xám, hồng pastel, xanh nhạt,...\r\n\r\nPhù hợp với phong cách thời trang cá tính, năng động, phá cách.\r\n\r\nHàng chính hãng Balenciaga, có đầy đủ tag và hộp.\r\n\r\nĐược ưa chuộng trong giới fashionista.', 'Balenciaga Defender phiên bản nữ với đế giày cá tính nhưng vẫn giữ được sự hài hoà và thanh thoát cho phong cách thời trang cá nhân.', 10, 3, 26500000.00, 23500000.00, NULL, 0, 1, '2025-04-11 19:36:37', '2025-04-11 20:03:46', 22),
(5, 'Dior CD1', 'dior-cd1-6', 'Dior CD1 là dòng sneaker đình đám của Dior mang vẻ ngoài thời thượng và kỹ thuật chế tác tỉ mỉ:\r\n\r\nChất liệu: Da bê, vải lưới, cao su cao cấp.\r\n\r\nThiết kế chunky pha chút futuristic (tương lai).\r\n\r\nMàu sắc: Ghi xám, trắng xanh, đen trắng.\r\n\r\nPhần đế to bản, nâng đỡ tốt, tạo cảm giác êm ái khi vận động.\r\n\r\nForm dáng dành cho nam, khoẻ khoắn, thời thượng.\r\n\r\nNhập khẩu chính hãng từ Dior Paris, có đầy đủ tag và phụ kiện.', 'Dior CD1 Sneakers phiên bản nam kết hợp thiết kế hiện đại và chất liệu cao cấp, tạo nên sự đẳng cấp và khác biệt trong từng bước chân.', 6, 7, 27000000.00, 24500000.00, NULL, 1, 1, '2025-04-11 19:38:54', '2025-04-11 19:38:54', 31),
(6, 'Dior Walk\'n\'Dior', 'dior-walk-n-dior-10', 'Thiết kế sneaker nhẹ nhàng, cổ điển pha nét hiện đại.\r\n\r\nChất liệu: Vải canvas mềm mại phối da, đế cao su siêu nhẹ.\r\n\r\nDây giày in “Christian Dior J’Adior” – tinh tế và đắt giá.\r\n\r\nMàu sắc: Trắng kem, hồng phấn, pastel xanh baby,...\r\n\r\nCực dễ phối cùng váy, quần short hay outfit dạo phố.\r\n\r\nChính hãng Dior Paris, nguyên hộp và thẻ bảo hành.\r\n\r\nDành cho nữ yêu phong cách thời trang tinh tế, sang trọng.', 'Dior Walk’n’Dior phiên bản nữ sở hữu vẻ ngoài thanh lịch, nhẹ nhàng nhưng vẫn nổi bật cá tính thời trang đậm chất Dior.', 10, 7, 22000000.00, 19800000.00, NULL, 0, 1, '2025-04-11 19:40:34', '2025-04-11 19:40:34', 37),
(7, 'Gucci Jordaan Loafers', 'gucci-jordaan-loafers-6', 'Dòng giày lười cao cấp với thiết kế slim-fit sang trọng.\r\n\r\nChất liệu: Da thật (da bê hoặc da bóng).\r\n\r\nBiểu tượng Horsebit đặc trưng của Gucci ở mặt trước.\r\n\r\nMàu sắc: Đen, nâu trầm, burgundy.\r\n\r\nĐế da, lót trong êm ái – lý tưởng cho môi trường công sở hoặc sự kiện formal.\r\n\r\nSản phẩm chính hãng Gucci, nhập khẩu từ Ý.\r\n\r\nTỉ mỉ trong từng đường may, form dáng chuẩn quý ông hiện đại.', 'Gucci Jordaan Loafers nam mang vẻ đẹp cổ điển kết hợp tinh thần hiện đại, phù hợp cho doanh nhân và quý ông yêu thích sự thanh lịch.', 6, 8, 26500000.00, 24000000.00, NULL, 1, 1, '2025-04-11 19:42:11', '2025-04-11 19:42:11', 45),
(8, 'Gucci Rhyton Sneaker', 'gucci-rhyton-sneaker-10', 'Form chunky nhẹ nhàng, tôn dáng.\r\n\r\nChất liệu: Da thật mềm, êm ái – không gây đau chân khi di chuyển nhiều.\r\n\r\nLogo Gucci cổ điển hoặc hoạ tiết hoa, Mickey (tuỳ phiên bản).\r\n\r\nMàu sắc: Trắng sữa, be nhạt, hồng pastel (tùy bộ sưu tập).\r\n\r\nPhối hợp được với cả chân váy, jeans hay đồ thể thao.\r\n\r\nHàng chính hãng Gucci Ý, có đầy đủ phụ kiện đi kèm.\r\n\r\nSize từ 35 đến 40.', 'Gucci Rhyton Sneaker nữ kết hợp hoàn hảo giữa sự năng động và sang trọng, dễ dàng mix với các trang phục nữ tính hoặc cá tính.', 10, 8, 23900000.00, 21000000.00, NULL, 1, 1, '2025-04-11 19:43:50', '2025-04-11 19:43:50', 18),
(9, 'Louis Vuitton Run Away', 'louis-vuitton-run-away-6', 'Thiết kế sneaker dáng running, form gọn ôm chân.\r\n\r\nChất liệu: Da cao cấp kết hợp vải canvas Monogram đặc trưng.\r\n\r\nLớp đệm êm ái, đế cao su cao cấp bám tốt.\r\n\r\nLogo LV nổi bật ở gót và bên hông giày.\r\n\r\nMàu sắc: Đen, nâu Monogram, xanh navy, phối trắng-xám.\r\n\r\nPhù hợp với phong cách streetwear sang trọng hoặc semi-casual.\r\n\r\nSản phẩm chính hãng Louis Vuitton, nhập từ Pháp/Ý.', 'Giày Louis Vuitton Run Away phiên bản nam – phong cách thể thao kết hợp với sự sang trọng đặc trưng của LV, dành cho quý ông yêu thời trang cao cấp.', 6, 2, 29500000.00, 26500000.00, NULL, 0, 1, '2025-04-11 19:46:03', '2025-04-11 19:46:03', 65),
(10, 'Louis Vuitton Time Out', 'louis-vuitton-time-out-10', 'Dáng giày nữ low-top cổ điển, đế nâng nhẹ (~3.5cm).\r\n\r\nChất liệu: Da bê mềm mịn, chi tiết Monogram ánh kim hoặc pastel.\r\n\r\nLogo Louis Vuitton dập nổi hoặc in màu ở gót và lưỡi giày.\r\n\r\nĐế cao su trắng, có hoạ tiết hoa Monogram quanh đế.\r\n\r\nMàu sắc: Trắng tinh khôi, trắng phối hồng baby, đen-trắng.\r\n\r\nDễ phối đồ, từ váy đến jeans, cho phong cách thanh lịch hoặc sporty-chic.\r\n\r\nHàng chính hãng nhập từ Louis Vuitton.', 'Louis Vuitton Time Out Sneaker nữ mang đậm tinh thần trẻ trung, hiện đại, là lựa chọn lý tưởng cho các tín đồ thời trang cao cấp.', 10, 2, 30500000.00, 27500000.00, NULL, 1, 1, '2025-04-11 19:47:42', '2025-04-11 19:47:42', 0),
(11, 'Saint Laurent Court Classic', 'saint-laurent-court-classic-6', 'Phom dáng sneaker cổ thấp cổ điển.\r\n\r\nChất liệu: Da bê cao cấp, đế cao su.\r\n\r\nLogo “Saint Laurent” được thêu tay hoặc in nổi ở bên hông.\r\n\r\nMàu sắc: Trắng, trắng-kem, đen.\r\n\r\nĐế giày thiết kế chống trượt, độ bền cao.\r\n\r\nPhù hợp phong cách tối giản, thanh lịch, phối đồ dễ dàng.\r\n\r\nSản phẩm chính hãng Saint Laurent – made in Italy.', 'Saint Laurent Court Classic phiên bản nam với thiết kế tối giản, tinh tế nhưng vẫn toát lên sự đẳng cấp đặc trưng của nhà mốt Pháp.', 6, 9, 19500000.00, 17500000.00, NULL, 1, 1, '2025-04-11 19:49:29', '2025-04-11 19:49:29', 57),
(12, 'Saint Laurent Opyum Pumps', 'saint-laurent-opyum-pumps-10', 'Thiết kế mũi nhọn, gót cao 10.5cm.\r\n\r\nChất liệu: Da bóng patent hoặc da lỳ (matte leather).\r\n\r\nGót giày là biểu tượng logo YSL kim loại cứng cáp, đầy nghệ thuật.\r\n\r\nMàu sắc: Đen bóng, nude, trắng, đỏ đô,…\r\n\r\nLớp lót da êm ái, tạo cảm giác thoải mái khi di chuyển.\r\n\r\nPhù hợp với các outfit dạ tiệc, sự kiện, hoặc phong cách thời trang high-fashion.\r\n\r\nSản phẩm chính hãng – Made in Italy / France.', 'Giày cao gót Saint Laurent Opyum nổi bật với phần gót chữ YSL mang tính biểu tượng, tôn lên vẻ sang trọng, thời thượng cho phái đẹp.', 10, 9, 28500000.00, 25900000.00, NULL, 1, 1, '2025-04-11 19:51:09', '2025-04-11 19:51:09', 45),
(13, 'La Sportiva Katana Laces', 'la-sportiva-katana-laces-7', 'Thiết kế đối xứng vừa phải, phù hợp cho cả leo đá ngoài trời lẫn trong nhà.\r\n\r\nChất liệu: Da lộn + microfiber, lót lưới thoáng khí.\r\n\r\nHệ thống buộc dây giúp điều chỉnh độ ôm chân chính xác.\r\n\r\nĐế Vibram XS Edge dày 4mm – độ bám và bền cực cao.\r\n\r\nMũi giày nhọn hỗ trợ đặt chân trên những điểm bám nhỏ.\r\n\r\nMàu sắc: Vàng/Đen.\r\n\r\nTrọng lượng: ~470g/đôi (size 40½ EU).\r\n\r\nSản phẩm chính hãng La Sportiva – Made in Italy.', 'Giày leo núi La Sportiva Katana Laces – thiết kế buộc dây chính xác, hiệu suất cao, phù hợp cho các tuyến đường thể thao và leo tường kỹ thuật.', 7, 10, 4300000.00, 3990000.00, NULL, 1, 1, '2025-04-11 19:53:01', '2025-04-11 19:53:01', 75);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_images`
--

CREATE TABLE `product_images` (
  `image_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `is_primary` tinyint(1) DEFAULT 0,
  `display_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_images`
--

INSERT INTO `product_images` (`image_id`, `product_id`, `image_url`, `is_primary`, `display_order`) VALUES
(3, 3, 'admin/assets/img/product-img/1744400093_12. Balenciaga Triple S.png', 1, 0),
(4, 4, 'admin/assets/img/product-img/1744400217_Balenciaga Defender.png', 1, 0),
(5, 5, 'admin/assets/img/product-img/1744400349_Dior CD1 Sneakers.png', 1, 0),
(6, 6, 'admin/assets/img/product-img/1744400443_Dior Walk\'n\'Dior.png', 1, 0),
(7, 7, 'admin/assets/img/product-img/1744400552_Gucci Horsebit Loafers.png', 1, 0),
(8, 8, 'admin/assets/img/product-img/1744400639_Gucci Rhyton Sneaker.png', 1, 0),
(9, 9, 'admin/assets/img/product-img/1744400780_Louis Vuitton Run Away.png', 1, 0),
(10, 10, 'admin/assets/img/product-img/1744400876_Louis Vuitton Time Out.png', 1, 0),
(11, 11, 'admin/assets/img/product-img/1744400982_Saint Laurent Court Classic.png', 1, 0),
(12, 12, 'admin/assets/img/product-img/1744401078_Saint Laurent Opyum Pumps.png', 1, 0),
(13, 13, 'admin/assets/img/product-img/1744401212_La Sportiva Katana Laces.png', 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_variants`
--

CREATE TABLE `product_variants` (
  `variant_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_variants`
--

INSERT INTO `product_variants` (`variant_id`, `product_id`, `size_id`) VALUES
(14, 3, 6),
(15, 3, 7),
(16, 3, 8),
(17, 3, 9),
(18, 3, 10),
(19, 3, 11),
(20, 3, 12),
(21, 4, 1),
(22, 4, 2),
(23, 4, 3),
(24, 4, 4),
(25, 4, 5),
(26, 4, 6),
(27, 5, 7),
(28, 5, 8),
(29, 5, 9),
(30, 5, 10),
(31, 5, 11),
(32, 5, 12),
(33, 6, 1),
(34, 6, 2),
(35, 6, 3),
(36, 6, 4),
(37, 6, 5),
(38, 7, 7),
(39, 7, 8),
(40, 7, 9),
(41, 7, 10),
(42, 7, 11),
(43, 7, 12),
(44, 8, 1),
(45, 8, 2),
(46, 8, 3),
(47, 8, 4),
(48, 8, 5),
(49, 8, 6),
(50, 9, 7),
(51, 9, 8),
(52, 9, 9),
(53, 9, 10),
(54, 9, 11),
(55, 9, 12),
(56, 10, 1),
(57, 10, 2),
(58, 10, 3),
(59, 10, 4),
(60, 10, 5),
(61, 10, 6),
(62, 11, 7),
(63, 11, 8),
(64, 11, 9),
(65, 11, 10),
(66, 11, 11),
(67, 12, 1),
(68, 12, 2),
(69, 12, 3),
(70, 12, 4),
(71, 12, 5),
(72, 12, 6),
(73, 13, 7),
(74, 13, 8),
(75, 13, 9),
(76, 13, 10),
(77, 13, 11),
(78, 13, 12);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `shopping_cart`
--

INSERT INTO `shopping_cart` (`cart_id`, `user_id`, `created_at`, `updated_at`) VALUES
(15, 1, '2025-04-11 14:18:44', '2025-04-11 14:18:44'),
(16, 2, '2025-04-11 20:55:10', '2025-04-11 20:55:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sizes`
--

CREATE TABLE `sizes` (
  `size_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sizes`
--

INSERT INTO `sizes` (`size_id`, `name`, `description`) VALUES
(1, '34', 'Size 34 - Nữ (chân dài ~21.5cm)'),
(2, '35', 'Size 35 - Nữ (chân dài ~22cm)'),
(3, '36', 'Size 36 - Nữ (chân dài ~22.5cm)'),
(4, '37', 'Size 37 - Nữ (chân dài ~23cm)'),
(5, '38', 'Size 38 - Nữ (chân dài ~23.5cm)'),
(6, '39', 'Size 39 - Nam (chân dài ~24.5cm)'),
(7, '40', 'Size 40 - Nam (chân dài ~25cm)'),
(8, '41', 'Size 41 - Nam (chân dài ~25.5cm)'),
(9, '42', 'Size 42 - Nam (chân dài ~26cm)'),
(10, '43', 'Size 43 - Nam (chân dài ~26.5cm)'),
(11, '44', 'Size 44 - Nam (chân dài ~27cm)'),
(12, '45', 'Size 45 - Nam (chân dài ~27.5cm)');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `dob` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `email`, `password_hash`, `full_name`, `phone_number`, `address`, `avatar_url`, `created_at`, `last_login`, `is_active`, `dob`) VALUES
(1, 'ductuan@gmail.com', '$2y$10$O/mH3LqjggeefiocrnLq.epb7WHqdSGsxwFlg9sBOfexA252QVf/m', 'Nguyễn Đức Tuấn', '0971898437', NULL, NULL, '2025-04-11 14:14:36', '2025-04-11 21:05:47', 1, '2011-11-11'),
(2, 'anktuan345@gmail.com', '$2y$10$gp5KhYHdReRYKXtZeg1roe5o2kqIoHTy2fRTgOMEcBiZ2Sf4d2gAq', 'Nguyễn Hải Đăng ', NULL, NULL, NULL, '2025-04-11 20:45:00', '2025-04-11 21:05:36', 1, '2010-11-11');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Chỉ mục cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `variant_id` (`variant_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `variant_id` (`variant_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Chỉ mục cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`variant_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `size_id` (`size_id`);

--
-- Chỉ mục cho bảng `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`size_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `product_images`
--
ALTER TABLE `product_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `variant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT cho bảng `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `sizes`
--
ALTER TABLE `sizes`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `shopping_cart` (`cart_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`variant_id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`variant_id`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`brand_id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_variants_ibfk_2` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`size_id`);

--
-- Các ràng buộc cho bảng `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD CONSTRAINT `shopping_cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
