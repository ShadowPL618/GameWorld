-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2026 at 03:21 PM
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
-- Database: `gameworld`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_content`
--

CREATE TABLE `about_content` (
  `content_id` int(11) NOT NULL,
  `section_title` varchar(200) NOT NULL,
  `section_content` text NOT NULL,
  `section_image` varchar(255) DEFAULT NULL,
  `section_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about_content`
--

INSERT INTO `about_content` (`content_id`, `section_title`, `section_content`, `section_image`, `section_order`, `created_at`) VALUES
(1, 'Welcome to GameWorld', 'GameWorld has been your trusted destination for premium gaming experiences since 2026. We pride ourselves on offering the best selection of games across all major platforms including PC, PlayStation, and Xbox.', 'images/about/welcome.jpg', 1, '2026-02-03 13:08:45'),
(2, 'Our Mission', 'Our mission is to connect gamers with the titles they love at competitive prices. We believe gaming brings people together and creates unforgettable experiences. That\'s why we carefully curate our collection to include only the best games across all genres.', 'images/about/mission.jpg', 2, '2026-02-03 13:08:45'),
(3, 'Why Choose Us', 'With instant digital delivery, 24/7 customer support, and competitive pricing, GameWorld is the smart choice for gamers. Our platform is secure, user-friendly, and designed with gamers in mind. Join thousands of satisfied customers who trust GameWorld for their gaming needs.', 'images/about/why-us.jpg', 3, '2026-02-03 13:08:45');

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE `blog_comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_comments`
--

INSERT INTO `blog_comments` (`comment_id`, `post_id`, `name`, `comment_text`, `created_at`) VALUES
(1, 1, 'John Doe', 'New Vegas is still my favorite Fallout game. The choices actually matter.', '2026-04-07 17:29:58'),
(2, 1, 'Jane Smith', 'Amazing review! The story depth is unmatched.', '2026-04-07 17:29:58'),
(3, 2, 'John Doe', 'This game made me emotional. Truly a masterpiece.', '2026-04-07 17:29:58'),
(4, 2, 'Jane Smith', 'The attention to detail is insane. Rockstar at its best.', '2026-04-07 17:29:58'),
(5, 2, 'Alex Admin', 'Glad you enjoyed the review!', '2026-04-07 17:29:58'),
(6, 3, 'Jane Smith', 'Still playing GTA Online after all these years!', '2026-04-07 17:29:58'),
(7, 3, 'John Doe', 'The world feels alive even today.', '2026-04-07 17:29:58'),
(8, 4, 'John Doe', 'Anno 1800 is incredibly addictive. Time just flies.', '2026-04-07 17:29:58'),
(9, 4, 'Jane Smith', 'Great breakdown of why this game works so well.', '2026-04-07 17:29:58'),
(10, 5, 'John Doe', 'Amazing to see this game still getting updates.', '2026-04-08 06:50:21'),
(11, 5, 'Jane Smith', 'Installed the patch and it runs much smoother now.', '2026-04-08 06:50:21'),
(12, 6, 'Jane Smith', 'Nice! Performance was already good, but this helps.', '2026-04-08 06:50:21'),
(13, 6, 'John Doe', 'Rockstar still supporting this game is great.', '2026-04-08 06:50:21'),
(14, 7, 'John Doe', 'Great deal with all DLC included!', '2026-04-08 06:50:21'),
(15, 7, 'Jane Smith', 'Perfect excuse to replay this classic.', '2026-04-08 06:50:21'),
(16, 8, 'Jane Smith', 'Finally everything in one bundle.', '2026-04-08 06:50:21'),
(17, 8, 'John Doe', 'Bought it immediately, love this game.', '2026-04-08 06:50:21'),
(18, 8, 'Alex Admin', 'Enjoy building your empire!', '2026-04-08 06:50:21'),
(19, 7, 'Admin', 'Even more reason to play it again, not that i needed it', '2026-04-08 06:51:14');

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `post_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(150) NOT NULL,
  `post_date` date NOT NULL,
  `category_id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`post_id`, `title`, `author`, `post_date`, `category_id`, `content`, `created_at`) VALUES
(1, 'Fallout: New Vegas – A Timeless RPG Masterpiece', 'Alex Admin', '2026-03-20', 4, 'Fallout: New Vegas remains one of the most beloved RPGs ever created. Its deep faction system, player-driven choices, and excellent writing still hold up years later. The Mojave Wasteland feels alive, and almost every decision impacts the world in meaningful ways. Even today, it stands as a benchmark for narrative freedom in gaming.', '2026-04-07 17:29:22'),
(2, 'Red Dead Redemption 2 – Gaming at Its Finest', 'Alex Admin', '2026-03-18', 4, 'Red Dead Redemption 2 delivers one of the most emotional and immersive stories in gaming history. Rockstar’s attention to detail is unmatched, from dynamic NPC interactions to breathtaking environments. Arthur Morgan’s journey is powerful, memorable, and deeply human.', '2026-04-07 17:29:22'),
(3, 'Grand Theft Auto V – Still King of Open Worlds', 'Alex Admin', '2026-03-15', 4, 'GTA V continues to dominate the open-world genre. With three distinct protagonists, a massive city to explore, and constant online content, the game still feels fresh more than a decade later. Few games balance chaos, satire, and gameplay this well.', '2026-04-07 17:29:22'),
(4, 'Anno 1800 – The Ultimate City Builder', 'Alex Admin', '2026-03-10', 4, 'Anno 1800 is a brilliantly designed city-building game that blends economics, strategy, and visual beauty. Managing complex production chains while expanding your empire feels incredibly satisfying. It’s a must-play for fans of strategy games.', '2026-04-07 17:29:22'),
(5, 'Fallout: New Vegas Community Patch Released', 'Alex Admin', '2026-03-22', 5, 'A new community-driven patch has been released for Fallout: New Vegas, improving stability, fixing long-standing bugs, and enhancing performance on modern systems.', '2026-04-08 06:49:38'),
(6, 'Red Dead Redemption 2 Receives Performance Improvements', 'Alex Admin', '2026-03-19', 5, 'Rockstar has released a small update aimed at improving performance and stability on newer hardware, making the experience even smoother.', '2026-04-08 06:49:38'),
(7, 'Now Available: Fallout: New Vegas Ultimate Edition', 'Alex Admin', '2026-03-25', 6, 'The Ultimate Edition of Fallout: New Vegas is now available on GameWorld, including all DLCs and bonus content.', '2026-04-08 06:49:38'),
(8, 'New Arrival: Anno 1800 Complete Edition', 'Alex Admin', '2026-03-23', 6, 'Anno 1800 Complete Edition has arrived, offering all expansions and the full city-building experience in one package.', '2026-04-08 06:49:38');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `quantity`) VALUES
(1, 1, 8, 2);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_slug` varchar(100) NOT NULL,
  `theme_color` varchar(7) DEFAULT '#333333',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_slug`, `theme_color`, `created_at`) VALUES
(1, 'PlayStation', 'playstation', '#003791', '2026-02-03 13:08:45'),
(2, 'Xbox', 'xbox', '#107C10', '2026-02-03 13:08:45'),
(3, 'PC', 'pc', '#FF6600', '2026-02-03 13:08:45'),
(4, 'Game Reviews', 'game-reviews', '#333333', '2026-04-07 17:28:51'),
(5, 'Game Updates', 'game-updates', '#333333', '2026-04-07 17:28:51'),
(6, 'New Products', 'new-products', '#333333', '2026-04-07 17:28:51');

-- --------------------------------------------------------

--
-- Table structure for table `download_codes`
--

CREATE TABLE `download_codes` (
  `code_id` int(11) NOT NULL,
  `code_phrase` varchar(100) NOT NULL,
  `game_file` varchar(255) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `download_codes`
--

INSERT INTO `download_codes` (`code_id`, `code_phrase`, `game_file`, `is_active`, `created_at`) VALUES
(1, 'ASTRO2024ROCKS', 'downloads/astroidinator.exe', 1, '2026-02-03 13:08:45'),
(2, 'SPACEGAME123', 'downloads/astroidinator.exe', 1, '2026-02-03 13:08:45');

-- --------------------------------------------------------

--
-- Table structure for table `easter_eggs`
--

CREATE TABLE `easter_eggs` (
  `egg_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_index` int(11) NOT NULL,
  `theme` varchar(50) NOT NULL,
  `character_name` varchar(100) NOT NULL,
  `character_image` varchar(255) NOT NULL,
  `quote` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `easter_eggs`
--

INSERT INTO `easter_eggs` (`egg_id`, `product_id`, `image_index`, `theme`, `character_name`, `character_image`, `quote`) VALUES
(1, 8, 10, 'newvegas', 'Mr. House', 'images/characters/mr_house.jpg', 'They gallivant around the Mojave pretending to be Knights of Yore. Or did, until the NCR showed them that ideological purity and shiny power armor don\'t count for much when you\'re outnumbered 15:1.');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `short_description` text DEFAULT NULL,
  `long_description` text DEFAULT NULL,
  `main_image` varchar(255) NOT NULL,
  `is_popular` tinyint(1) DEFAULT 0,
  `stock_quantity` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `price`, `short_description`, `long_description`, `main_image`, `is_popular`, `stock_quantity`, `created_at`) VALUES
(1, 3, 'Grand Theft Auto V', 39.99, 'Open-world action-adventure game set in Los Santos', 'Experience Rockstar Games’ critically acclaimed open-world phenomenon. When a young street hustler, a retired bank robber, and a terrifying psychopath find themselves entangled with some of the most frightening and deranged elements of the criminal underworld, the U.S. government, and the entertainment industry, they must pull off a series of dangerous heists to survive in a ruthless city in which they can trust nobody, least of all each other.', '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/gta5.jpg', 1, 50, '2026-02-03 13:08:45'),
(2, 3, 'Red Dead Redemption 2', 59.99, 'Epic tale of outlaw Arthur Morgan and the Van der Linde gang', 'Developed by the creators of Grand Theft Auto V and Red Dead Redemption, Red Dead Redemption 2 is an epic tale of life in America’s unforgiving heartland. The game’s vast and atmospheric world also provides the foundation for a brand-new online multiplayer experience. After a robbery goes badly wrong in the western town of Blackwater, Arthur Morgan and the Van der Linde gang are forced to flee. With federal agents and the best bounty hunters in the nation massing on their heels, the gang must rob, steal and fight their way across the rugged heartland of America in order to survive.', '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/rdr2.jpg', 1, 45, '2026-02-03 13:08:45'),
(3, 3, 'Anno 117', 69.99, 'Build your empire in ancient Rome', 'Become a Roman Governor in 117 AD and travel through the uncharted territories of the Roman Empire. Discover a vast, story-driven industrial city builder where your decisions as a governor matter to your citizens. Build, trade, and expand your influence. Will you lead with an iron fist or become a visionary architect of the Pax Romana? Anno 117: Pax Romana combines the deep economy-building the series is known for with the unique historical flavor of ancient Rome.', '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/anno117.jpg', 0, 30, '2026-02-03 13:08:45'),
(4, 3, 'Anno 1800', 49.99, 'Lead the Industrial Revolution', 'Welcome to the dawn of the Industrial Age. The path you choose will define your world. Are you an innovator or an exploiter? A conqueror or a liberator? Anno 1800 puts players at the helm of their own destiny as they navigate the rapidly evolving technological landscape and malicious political arena of the 19th century in their quest to build an empire that will stand the test of time.', '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/anno1800.jpg', 1, 40, '2026-02-03 13:08:45'),
(5, 3, 'Total War: Attila', 44.99, 'Command armies in the age of Attila the Hun', 'Against a darkening background of famine, disease and war, a new power is rising in the great steppes of the East. With a million horsemen at his back, the ultimate warrior king approaches, and his sights are set on Rome. Total War: ATTILA brings players back to 395 AD, a time of apocalyptic turmoil at the very dawn of the Dark Ages. How far will you go to survive? Will you sweep the scourge from the world and create a Barbarian or Eastern kingdom of your own?', '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/tw_attila.jpg', 0, 25, '2026-02-03 13:08:45'),
(6, 3, 'Total War: Rome 2', 39.99, 'Conquer the ancient world', 'Total War: ROME II - Emperor Edition is the definitive edition of ROME II, featuring an improved politics system, overhauled building chains, rebalanced battles and improved visuals in both campaign and battle. Become the world’s first superpower and command the Ancient World’s most incredible war machine. Dominate your enemies by military, economic and political means. Your rise will bring admiration from your followers but will attract greed and jealousy, even from your closest allies.', '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/tw_rome2.jpg', 1, 35, '2026-02-03 13:08:45'),
(7, 3, 'Fallout 3', 19.99, 'Survive the post-nuclear Capital Wasteland', 'Fallout 3 is a genre-defining post-apocalyptic RPG that thrusts you into the ruins of Washington D.C., now known as the Capital Wasteland. Two hundred years after the Great War of 2077, you emerge from the sealed sanctuary of Vault 101 as the Lone Wanderer, forced into a desolate world to find your missing father. The story is a desperate journey through a shattered landscape where the remnants of the United States government—the Enclave—clash with the Brotherhood of Steel for control over the region\'s future. From the iconic ruins of the Washington Monument to the irradiated depths of the D.C. Metro, every corner of the wasteland offers a grim story of survival. Experience the revolutionary V.A.T.S. combat system, allowing you to pause time and rain down tactical destruction on Super Mutants, Feral Ghouls, and ruthless Raiders. Whether you choose to be the savior of the wastes by bringing clean water to the masses, or a harbinger of chaos by detonating the nuclear heart of Megaton, your choices define the morality of a dying world. In the Capital Wasteland, life is cheap, resources are scarce, and the shadow of the Great War looms over every rusted skyscraper—but for the first time in centuries, the fate of the capital is in your hands.', '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/fallout3.jpg', 0, 40, '2026-02-03 13:08:45'),
(8, 3, 'Fallout: New Vegas', 14.99, 'Experience the Mojave Wasteland as mailman!', 'Fallout: New Vegas is a post-post-apocalyptic role-playing game set in the Mojave Wasteland where vast nations rise to save the wasteland in their own unique way, primarily centered around a rebuilt Las Vegas. You play as the Courier, a character who is shot in the head and left for dead while attempting to deliver a mysterious package known as the Platinum Chip. After surviving the attack, your initial journey is a quest for revenge and answers against the man who tried to kill you. The story takes place in the year 2281, during a massive power struggle between four major factions: the New California Republic (NCR) under it\'s elected president-general Aaron Kimball, The Legion led by Caesar a brutal but highly intelligent and ideologically driven leader, The New Vegas Strip with the enigmatic pre-war genius Robert Edwin House, or your own anarchic kingdom with the rogue securitron Yes Man. Each faction has a vastly different vision for the future of the Mojave, ranging from a failing democratic bureaucracy based on freedom and morals, whilst failing to deliver on promises. To brutally efficient totalitarianism that brings safety and order at the cost of freedom and individuality. From a technocratic robot state, based on technological advancement at the cost of it\'s soul. An independent New Vegas in which centralized authority is removed, leaving the future of the region to the Courier and the balance of local factions. A central conflict involves control of the Hoover Dam, which serves as the primary source of clean water and electricity for the region and the city of New Vegas itself. The game is highly praised for its deep storytelling, as almost every quest offers multiple ways to solve problems through combat, stealth, or persuasion. Your choices throughout the game carry significant weight, ultimately determining the fate of various towns and the final outcome of the Second Battle for Hoover Dam. Beyond the main plot, the wasteland is filled with eccentric characters, mutated creatures, and remnants of pre-war technology. It remains a fan favorite in the series because it allows for total player freedom in a world where \"the house always wins\"—unless you decide otherwise.', '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/fallout_nv.jpg', 1, 38, '2026-02-03 13:08:45'),
(9, 1, 'Grand Theft Auto V - PS5', 39.99, 'Enhanced and expanded for PlayStation 5', 'Experience Rockstar Games’ critically acclaimed open-world phenomenon. When a young street hustler, a retired bank robber, and a terrifying psychopath find themselves entangled with some of the most frightening and deranged elements of the criminal underworld, the U.S. government, and the entertainment industry, they must pull off a series of dangerous heists to survive in a ruthless city in which they can trust nobody, least of all each other.', '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/gta5_ps5.jpg', 1, 60, '2026-02-03 13:08:45'),
(10, 1, 'Red Dead Redemption 2 - PS4', 59.99, 'Epic Western adventure for PlayStation', 'Developed by the creators of Grand Theft Auto V and Red Dead Redemption, Red Dead Redemption 2 is an epic tale of life in America’s unforgiving heartland. The game’s vast and atmospheric world also provides the foundation for a brand-new online multiplayer experience. After a robbery goes badly wrong in the western town of Blackwater, Arthur Morgan and the Van der Linde gang are forced to flee. With federal agents and the best bounty hunters in the nation massing on their heels, the gang must rob, steal and fight their way across the rugged heartland of America in order to survive.', '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/rdr2_ps4.jpg', 1, 55, '2026-02-03 13:08:45'),
(11, 2, 'Grand Theft Auto V - Xbox Series X', 39.99, 'Optimized for Xbox Series X|S', 'Experience Rockstar Games’ critically acclaimed open-world phenomenon. When a young street hustler, a retired bank robber, and a terrifying psychopath find themselves entangled with some of the most frightening and deranged elements of the criminal underworld, the U.S. government, and the entertainment industry, they must pull off a series of dangerous heists to survive in a ruthless city in which they can trust nobody, least of all each other.', '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/gta5_xbox.jpg', 1, 55, '2026-02-03 13:08:45'),
(12, 2, 'Red Dead Redemption 2 - Xbox One', 59.99, 'The ultimate Western epic for Xbox', 'Developed by the creators of Grand Theft Auto V and Red Dead Redemption, Red Dead Redemption 2 is an epic tale of life in America’s unforgiving heartland. The game’s vast and atmospheric world also provides the foundation for a brand-new online multiplayer experience. After a robbery goes badly wrong in the western town of Blackwater, Arthur Morgan and the Van der Linde gang are forced to flee. With federal agents and the best bounty hunters in the nation massing on their heels, the gang must rob, steal and fight their way across the rugged heartland of America in order to survive.', '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/rdr2_xbox.jpg', 1, 50, '2026-02-03 13:08:45'),
(13, 1, 'Marvel\'s Spider-Man', 39.99, 'Be Greater. Swing through Manhattan as Spider-Man', 'Starring one of the world’s most iconic Super Heroes, Marvel’s Spider-Man features the acrobatic abilities, improvisation and web-slinging that the wall-crawler is famous for, while also introducing elements never-before-seen in a Spider-Man game. From traversing with parkour and unique environmental interactions, to new combat and blockbuster set pieces, it’s Spider-Man unlike any you’ve played before.', '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/spiderman_ps4.jpg', 1, 50, '2026-02-04 12:51:07'),
(14, 1, 'The Last of Us Part II', 59.99, 'Ellie\'s journey of revenge in a post-apocalyptic America', 'Five years after their dangerous journey across the post-pandemic United States, Ellie and Joel have settled down in Jackson, Wyoming. Living amongst a thriving community of survivors has allowed them peace and stability, despite the constant threat of the infected and other, more desperate survivors. When a violent event disrupts that peace, Ellie embarks on a relentless journey to carry out justice and find closure.', '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/TLOS_part2_ps4.jpg', 1, 45, '2026-02-04 12:51:07'),
(15, 1, 'The Last of Us Remastered', 19.99, 'The genre-defining masterpiece, rebuilt for PS4', 'Winner of over 200 Game of the Year awards, The Last of Us has been rebuilt for the PlayStation 4 system. Now featuring full 1080p, higher resolution character models, improved shadows and lighting, in addition to several other gameplay improvements. Abandoned cities reclaimed by nature. A population decimated by a modern plague. Survivors are killing each other for food, weapons; whatever they can get their hands on.', '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/TLOS_remasterd_ps4.jpg', 1, 40, '2026-02-04 12:51:07'),
(16, 1, 'God of War', 49.99, 'A new beginning for Kratos in the realm of Norse Gods', 'His vengeance against the Gods of Olympus years behind him, Kratos now lives as a man in the realm of Norse Gods and monsters. It is in this harsh, unforgiving world that he must fight to survive… and teach his son to do the same. This startling reimagining of God of War deconstructs the core elements that defined the series—satisfying combat, breathtaking scale, and a powerful narrative—and fuses them anew.', '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/god_of_war_ps4.jpg', 1, 55, '2026-02-04 12:51:07');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `image_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`image_id`, `product_id`, `image_path`, `image_order`) VALUES
(1, 1, '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/gta5_1.jpg', 1),
(2, 1, '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/gta5_2.jpg', 2),
(3, 1, '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/gta5_3.jpg', 3),
(4, 2, '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/rdr2_1.jpg', 1),
(5, 2, '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/rdr2_2.jpg', 2),
(6, 2, '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/rdr2_3.jpg', 3),
(7, 4, '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/anno1800_1.jpg', 1),
(8, 4, '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/anno1800_2.jpg', 2),
(9, 4, '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/anno1800_3.jpg', 3),
(10, 8, '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/fallout_nv_1.jpg', 1),
(11, 8, '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/fallout_nv_2.jpg', 2),
(12, 8, '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/fallout_nv_3.jpg', 3),
(13, 8, '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/fallout_nv_4.jpg', 4),
(14, 8, '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/fallout_nv_5.jpg', 5),
(15, 8, '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/fallout_nv_6.jpg', 6),
(16, 8, '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/fallout_nv_7.jpg', 7),
(17, 8, '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/fallout_nv_8.jpg', 8),
(18, 8, '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/fallout_nv_9.jpg', 9),
(19, 9, '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/gta5_1.jpg', 1),
(20, 9, '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/gta5_2.jpg', 2),
(21, 9, '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/gta5_3.jpg', 3),
(22, 7, '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/fallout3_1.jpg', 1),
(23, 7, '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/fallout3_2.jpg\r\n', 2),
(24, 7, '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/fallout3_3.jpg', 3),
(25, 8, '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/fallout_nv_10.jpg', 10),
(26, 8, '/WD/Web_Development/School_Projects/GameWorld(Steam_2.0)/GameWorld(Final)/images/products/fallout_nv_11.jpg', 11);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Alex', 'Admin', 'admin@gameworld.com', 'Password789', 'admin', '2026-02-23 08:13:36'),
(2, 'John', 'Doe', 'john@example.com', 'Password456', 'customer', '2026-02-23 08:13:36'),
(3, 'Jane', 'Smith', 'jane@example.com', 'Password123', 'customer', '2026-02-23 08:13:36'),
(4, 'Juliusz', 'Krajewski', 'juliusz@gameworld.com', '$2y$10$hfcbcHpwI/7065AkMsf0ue6JL6Fyblm.qJ3q0j6XNM6sspMP0Ap5e', 'customer', '2026-04-10 09:40:12');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wishlist_id`, `user_id`, `product_id`) VALUES
(1, 1, 7),
(2, 1, 8),
(6, 2, 4),
(7, 3, 5),
(8, 3, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_content`
--
ALTER TABLE `about_content`
  ADD PRIMARY KEY (`content_id`);

--
-- Indexes for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `download_codes`
--
ALTER TABLE `download_codes`
  ADD PRIMARY KEY (`code_id`),
  ADD UNIQUE KEY `code_phrase` (`code_phrase`);

--
-- Indexes for table `easter_eggs`
--
ALTER TABLE `easter_eggs`
  ADD PRIMARY KEY (`egg_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_content`
--
ALTER TABLE `about_content`
  MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blog_comments`
--
ALTER TABLE `blog_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `download_codes`
--
ALTER TABLE `download_codes`
  MODIFY `code_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `easter_eggs`
--
ALTER TABLE `easter_eggs`
  MODIFY `egg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD CONSTRAINT `blog_comments_post_fk` FOREIGN KEY (`post_id`) REFERENCES `blog_posts` (`post_id`) ON DELETE CASCADE;

--
-- Constraints for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD CONSTRAINT `blog_posts_category_fk` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `easter_eggs`
--
ALTER TABLE `easter_eggs`
  ADD CONSTRAINT `easter_eggs_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
