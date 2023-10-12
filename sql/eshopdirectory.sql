-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2023 at 09:28 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eshopdirectory`
--

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE `attachments` (
  `id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `file_size` bigint(22) NOT NULL DEFAULT 0,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attachments`
--

INSERT INTO `attachments` (`id`, `message_id`, `file_path`, `file_type`, `file_size`, `uploaded_at`) VALUES
(1, 7, '651ff3d7cc06b.pdf', 'application/pdf', 2234561, '2023-10-06 10:47:35'),
(2, 8, '651ff583721c0.docx', 'application/vnd.openxmlformats-officedocument.word', 874563, '2023-10-06 10:54:43'),
(3, 3, '651ff633719f8.pdf', 'application/pdf', 33456, '2023-10-06 11:57:39'),
(4, 12, '651ff7ca7263b.docx', 'application/vnd.openxmlformats-officedocument.word', 7655908, '2023-10-06 11:04:26'),
(5, 13, '6520082eade33.docx', 'application/vnd.openxmlformats-officedocument.word', 2147483647, '2023-10-06 12:14:22'),
(6, 17, '65200ca09294f.zip', 'application/x-zip-compressed', 655678, '2023-10-06 12:33:20'),
(7, 18, '65200cbde5ac7.xlsx', 'application/vnd.openxmlformats-officedocument.spre', 3455433276, '2023-10-06 12:33:49'),
(8, 19, '65200d0241669.txt', 'text/plain', 677890, '2023-10-06 12:34:58'),
(9, 21, '65244911ce40c.xlsx', 'application/vnd.openxmlformats-officedocument.spre', 1771854, '2023-10-09 17:40:17'),
(10, 23, '6524497fbb928.xlsx', 'application/vnd.openxmlformats-officedocument.spre', 14185, '2023-10-09 17:42:07'),
(11, 24, '65244c2aad186.pdf', 'application/pdf', 308261, '2023-10-09 17:53:30'),
(12, 55, '6526fa606400b.pdf', 'application/pdf', 202517, '2023-10-11 18:41:20'),
(14, 56, '65279741121fe.pdf', 'application/pdf', 202517, '2023-10-12 05:50:41');

-- --------------------------------------------------------

--
-- Table structure for table `blocked_users`
--

CREATE TABLE `blocked_users` (
  `id` int(11) NOT NULL,
  `blocker_id` int(11) NOT NULL,
  `blocked_id` int(11) NOT NULL,
  `blocked_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `is_group` tinyint(1) DEFAULT 0,
  `is_closed` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `subject`, `is_group`, `is_closed`, `created_at`) VALUES
(1, 'What the heck is going on in Washington?', 0, 1, '2023-10-05 13:36:54'),
(2, 'What was the eight Republicans’ beef with McCarthy?', 1, 0, '2023-10-05 16:44:46'),
(3, 'What does Congress need to do?', 1, 0, '2023-10-06 11:57:39'),
(4, 'What happened to the last House speaker?', 1, 1, '2023-10-06 12:01:36'),
(5, 'What happened to the last House speaker?', 1, 0, '2023-10-06 12:04:26'),
(6, 'SW7CIxUi3i', 0, 0, '2023-10-11 18:21:53'),
(7, 'y27KObbII3', 0, 0, '2023-10-11 18:23:08'),
(8, 'y27KObbII3', 0, 0, '2023-10-11 18:23:56'),
(9, 'kQ5ufcRdxe', 1, 0, '2023-10-11 18:42:13'),
(10, 'تجربة', 1, 0, '2023-10-11 18:43:35'),
(11, '8JEa3gT2Kf', 1, 0, '2023-10-11 18:54:42'),
(12, 'u8Vrvj5zbQ', 1, 1, '2023-10-11 19:01:15'),
(13, 'UT8DeUO1oB', 1, 0, '2023-10-11 19:08:11'),
(14, 'dbb1o9hZqd', 0, 0, '2023-10-11 19:09:21'),
(15, '2zV1Q9TxML', 1, 1, '2023-10-11 19:10:40'),
(16, 'TEst messaging', 1, 0, '2023-10-11 19:11:43'),
(17, '7cBgUpQWAP -- 1', 0, 0, '2023-10-11 19:17:37'),
(18, '7cBgUpQWAP -- 2', 1, 0, '2023-10-11 19:20:51'),
(19, '7cBgUpQWAP -- 4', 1, 0, '2023-10-11 19:23:39'),
(20, '7cBgUpQWAP -- 5', 0, 1, '2023-10-11 19:29:50'),
(21, '7cBgUpQWAP -- 99', 1, 1, '2023-10-11 19:39:46'),
(22, 'Message', 0, 0, '2023-10-11 19:41:20');

-- --------------------------------------------------------

--
-- Table structure for table `conversation_members`
--

CREATE TABLE `conversation_members` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conversation_members`
--

INSERT INTO `conversation_members` (`id`, `conversation_id`, `user_id`) VALUES
(1, 1, 14),
(2, 1, 4),
(3, 2, 3),
(4, 2, 4),
(5, 2, 8),
(6, 2, 10),
(7, 2, 14),
(8, 2, 26),
(9, 2, 92),
(10, 2, 93),
(11, 2, 101),
(12, 2, 1),
(13, 2, 104),
(14, 3, 48),
(15, 3, 54),
(16, 3, 58),
(17, 3, 59),
(18, 3, 60),
(19, 3, 1),
(20, 4, 128),
(21, 4, 137),
(22, 4, 147),
(23, 4, 7),
(24, 4, 12),
(25, 4, 15),
(26, 4, 16),
(27, 4, 1),
(28, 5, 128),
(29, 5, 137),
(30, 5, 147),
(31, 5, 7),
(32, 5, 12),
(33, 5, 15),
(34, 5, 16),
(35, 5, 1),
(39, 9, 4),
(40, 9, 5),
(41, 9, 6),
(42, 9, 4),
(44, 10, 4),
(51, 10, 4),
(52, 11, 1),
(53, 11, 10),
(54, 11, 26),
(55, 11, 4),
(56, 12, 1),
(57, 12, 3),
(58, 12, 3),
(59, 13, 6),
(60, 13, 8),
(61, 13, 10),
(62, 13, 12),
(63, 13, 4),
(64, 14, 6),
(65, 14, 4),
(66, 15, 5),
(67, 15, 6),
(68, 15, 7),
(69, 15, 8),
(70, 15, 9),
(71, 15, 10),
(72, 15, 4),
(73, 16, 8),
(74, 16, 9),
(75, 16, 10),
(76, 16, 11),
(77, 16, 12),
(78, 16, 13),
(79, 16, 14),
(80, 16, 4),
(81, 17, 5),
(82, 17, 4),
(83, 18, 1),
(84, 18, 3),
(85, 18, 4),
(86, 19, 1),
(87, 19, 4),
(88, 19, 10),
(89, 19, 26),
(90, 19, 73),
(91, 19, 4),
(92, 20, 3),
(93, 20, 4),
(94, 21, 3),
(95, 21, 4),
(96, 21, 5),
(108, 21, 18),
(131, 21, 50),
(132, 21, 51),
(133, 21, 52),
(134, 21, 53),
(135, 21, 54),
(136, 21, 55),
(137, 21, 57),
(138, 21, 58),
(139, 21, 59),
(140, 21, 60),
(141, 21, 61),
(142, 21, 62),
(143, 21, 63),
(144, 21, 65),
(145, 21, 66),
(146, 21, 67),
(147, 21, 68),
(148, 21, 69),
(149, 21, 71),
(150, 21, 72),
(151, 21, 73),
(152, 21, 74),
(153, 21, 75),
(154, 21, 76),
(155, 21, 78),
(156, 21, 79),
(157, 21, 81),
(158, 21, 82),
(159, 21, 83),
(160, 21, 84),
(161, 21, 85),
(162, 21, 86),
(163, 21, 87),
(164, 21, 88),
(165, 21, 89),
(166, 21, 90),
(167, 21, 91),
(168, 21, 92),
(169, 21, 93),
(170, 21, 95),
(171, 21, 96),
(172, 21, 97),
(173, 21, 98),
(174, 21, 99),
(175, 21, 101),
(176, 21, 102),
(177, 21, 103),
(178, 21, 104),
(179, 21, 105),
(180, 21, 106),
(181, 21, 107),
(182, 21, 109),
(183, 21, 110),
(184, 21, 111),
(185, 21, 112),
(186, 21, 113),
(187, 21, 115),
(188, 21, 116),
(189, 21, 117),
(190, 21, 118),
(191, 21, 119),
(192, 21, 122),
(193, 21, 123),
(194, 21, 124),
(195, 21, 125),
(196, 21, 126),
(197, 21, 127),
(198, 21, 128),
(199, 21, 129),
(200, 21, 130),
(201, 21, 132),
(202, 21, 133),
(203, 21, 134),
(204, 21, 135),
(205, 21, 136),
(206, 21, 137),
(207, 21, 138),
(208, 21, 139),
(209, 21, 140),
(210, 21, 141),
(211, 21, 142),
(212, 21, 143),
(213, 21, 144),
(214, 21, 145),
(215, 21, 146),
(216, 21, 147),
(217, 21, 148),
(218, 21, 149),
(219, 21, 150),
(228, 21, 158),
(229, 21, 4),
(230, 22, 5),
(231, 22, 4),
(232, 12, 4),
(233, 12, 7),
(237, 12, 58),
(238, 12, 97),
(239, 12, 15),
(240, 12, 18),
(241, 12, 28),
(242, 12, 29),
(243, 12, 30),
(244, 22, 1);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `content` text DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `conversation_id`, `content`, `is_read`, `sent_at`) VALUES
(1, 4, 1, 'The House is without a speaker, the person who, according to the Constitution, is required to be its leader. That means the chamber is essentially paralyzed until it can settle on a new speaker.\r\n\r\nFor now, a placeholder, Rep. Patrick McHenry, is what’s referred to as “speaker pro tempore,” which means the North Carolina Republican can essentially keep the lights on but has no power to move legislation through the House.\r\n\r\n', 0, '2023-10-05 13:36:54'),
(2, 1, 2, 'Most of the eight came from the ultra conservative Freedom Caucus. They were angry that McCarthy cut a deal with Democrats to avert a partial government shutdown and fund the government temporarily for 45 days. They were also frustrated at the terms of a deal he cut with President Joe Biden to raise the nation’s debt limit earlier this year. This wing of the GOP is absolutist in its view of federal spending and some have even expressed willingness to entertain a default or shutdown to get what they want.\r\n\r\nMany House Republicans who share some of these ideological views, however, continued to support McCarthy. Some of the people who voted to oust him, led by Gaetz, also had more personal conflicts with McCarthy, accusing him of not keeping his word.\r\n\r\n', 0, '2023-10-05 16:44:46'),
(3, 1, 2, 'Many House Republicans who share some of these ideological views, however, continued to support McCarthy. Some of the people who voted to oust him, led by Gaetz, also had more personal conflicts with McCarthy, accusing him of not keeping his word.\r\n', 0, '2023-10-06 11:00:17'),
(4, 1, 2, 'Why is this so hard for Republicans?\r\nTheir majority, which they won in last year’s midterms, is extremely small. Only four Republicans can break with the pack in order for a GOP speaker to be seated. When McCarthy was booted from the speaker’s office, he lost just eight Republicans of his 221-member conference.\r\n\r\n', 0, '2023-10-06 11:01:19'),
(5, 1, 2, 'Why didn’t any Democrats help McCarthy?\r\nSome did consider rescuing the California Republican. But the party also has a collective political interest in watching Republicans squirm. And McCarthy, while a genial guy, was also extremely partisan. While he cut deals to keep the government open and raise the debt ceiling, he also recently initiated an official impeachment inquiry against Biden. And he refused to put some bills that had widespread bipartisan support – such as a defense authorization bill – on the House floor without partisan additions.\r\n\r\n', 0, '2023-10-06 11:01:51'),
(6, 1, 2, 'Does Trump play a role here?\r\nFormer President Donald Trump and Trumpism are worth noting. McCarthy won the speakership with backing from Trump. He lost it after Trump pushed for a shutdown that McCarthy worked to avoid (and Trump also spent the week in court in New York).\r\n\r\nCNN’s Stephen Collinson put it this way: “McCarthy’s short speakership underscored how the Republican Party in the age of Donald Trump has turned into one of the great forces of instability in American life, and potentially the world.”\r\n\r\n', 0, '2023-10-06 11:40:17'),
(7, 1, 2, 'How does one get every Republican to agree on the same person?\r\nWith great care! McCarthy made concessions to the right wing in order to get the speaker’s job, and it took many rounds of voting to reach a majority, even though he did not face organized opposition.\r\n\r\nNow, with multiple announced GOP candidates and others considering a run, it’s not at all clear how one person will emerge to unify the party or what they’ll have to promise.\r\n\r\n', 0, '2023-10-06 11:47:35'),
(8, 1, 2, 'Who are the contenders to replace McCarthy?\r\nThere are a few who are actively looking for support and some others who are doing it more quietly.\r\n\r\nSteve Scalise – The Louisiana Republican, who is the House majority leader and had been McCarthy’s No. 2, is running.\r\n\r\nDiagnosed with multiple myeloma earlier this year, Scalise told reporters in September that in response to treatment, his cancer “has dropped dramatically.” In 2017, he was shot at a Republican congressional baseball game practice by a gunman who defined himself publicly by his hatred of conservatives.\r\n\r\nHe faced backlash in 2014 for a speech he gave in 2002 to a White supremacist group, although he later apologized and said he regretted it.\r\n\r\nJim Jordan – The Ohio Republican who chairs the House Judiciary Committee is running. He’s also a founding member of the Freedom Caucus, although he became a key McCarthy ally. Known for rarely wearing a jacket and being a loud and frequent critic of Democrats, he was a vocal defender of Trump during his two impeachment proceedings.\r\n\r\nKevin Hern – The Oklahoma Republican, who chairs a conservative group of lawmakers called the Republican Study Committee, is considering a run for leadership. His committee wields a large bloc of GOP members.\r\n\r\nPatrick McHenry – The North Carolina Republican, who was first elected to Congress at age 29, has been a McCarthy ally. Now he’s the interim speaker. A source close to McHenry told CNN that the congressman sees his role right now as a caretaker focused on getting the conference through another speaker’s race.\r\n\r\nRead more from CNN’s Capitol Hill team.\r\n\r\n', 0, '2023-10-06 11:54:43'),
(9, 1, 3, 'Its immediate list includes:\r\n\r\nKeep the government open. Temporary funding runs out on November 17 and a government shutdown, if one occurs, could affect every American. The next speaker will have to negotiate with the Senate and the White House to agree on spending that both Republicans in the House and Democrats in the Senate can stomach.\r\nDecide what to do abut Ukraine. There is a growing rift over additional aid to help Ukraine fend off Russia’s invasion. Ukraine is burning through ammunition at a fast pace and the US and other countries are becoming slower to resupply. The White House wants $24 billion in additional Ukraine funding, but read more on that from CNN’s Tim Lister.\r\nThe House adopted a package of organizing rules back in January, which means some effects of this paralysis are muted. Lawmakers’ offices can continue to function, helping constituents with passports and other services. But if there is a national, regional or local emergency, Congress will be unable to respond for the time being. And any time it would have spent on legislation is now being spent on this internal Republican fight.\r\n\r\n', 0, '2023-10-06 11:57:39'),
(10, 1, 4, 'Rep. Kevin McCarthy had been House speaker since January, when he won the gavel after 15 rounds of balloting. He was ousted on October 3 after a small minority of his narrow majority – just eight Republicans – voted to remove him.\r\n\r\nWhy such a short tenure?\r\nAs part of a series of deals with hardliners to win the speaker’s gavel in the first place, McCarthy agreed that just one member would be required to call for a vote to “vacate” him from office at any time. This week, Florida Rep. Matt Gaetz became that member.\r\n\r\nWhat was the eight Republicans’ beef with McCarthy?\r\n', 0, '2023-10-06 12:01:36'),
(11, 1, 5, 'Rep. Kevin McCarthy had been House speaker since January, when he won the gavel after 15 rounds of balloting. He was ousted on October 3 after a small minority of his narrow majority – just eight Republicans – voted to remove him.\r\n\r\nWhy such a short tenure?\r\nAs part of a series of deals with hardliners to win the speaker’s gavel in the first place, McCarthy agreed that just one member would be required to call for a vote to “vacate” him from office at any time. This week, Florida Rep. Matt Gaetz became that member.\r\n\r\nWhat was the eight Republicans’ beef with McCarthy?\r\n', 0, '2023-10-06 12:04:26'),
(12, 1, 5, 'Rep. Kevin McCarthy had been House speaker since January, when he won the gavel after 15 rounds of balloting. He was ousted on October 3 after a small minority of his narrow majority – just eight Republicans – voted to remove him.\r\n\r\nWhy such a short tenure?\r\nAs part of a series of deals with hardliners to win the speaker’s gavel in the first place, McCarthy agreed that just one member would be required to call for a vote to “vacate” him from office at any time. This week, Florida Rep. Matt Gaetz became that member.\r\n\r\nWhat was the eight Republicans’ beef with McCarthy?\r\n', 0, '2023-10-06 12:04:26'),
(13, 1, 5, 'UK weather: Parts of UK set for unseasonal 26C over weekend\r\nThe UK could see temperatures of up to 26C (79F) at the weekend in a spell of unusually warm October weather.\r\n\r\nIt will not be blue skies and sunshine for everyone, with heavy and persistent rain expected in Scotland.\r\n\r\nA Met Office yellow warning for heavy rain is in force over much of the nation from Friday night until 06:00 BST on Sunday.\r\n\r\nThere will be some \"stark contrasts\" across the UK, BBC Weather forecaster Matt Taylor said.\r\n\r\nADVERTISEMENT', 0, '2023-10-06 13:14:22'),
(14, 1, 5, 'General Form Elements\r\nThe message has been sent successfully!\r\n', 0, '2023-10-06 13:14:45'),
(15, 1, 5, 'There could even be snow over the highest Scottish mountains, he said.\r\n\r\n\"While it will feel like late summer in the south, it will be more like late autumn/early winter for many in Scotland.\r\n\r\n\"Not only will there be persistent rain for many but temperatures will struggle to reach 10C for a fair few.\"\r\n\r\nFour ways climate change affects extreme weather\r\nIs the UK getting hotter?\r\nA really simple guide to climate change\r\nThe period of heat for much of the UK is due to warm and humid air originating from north-west Africa and the Canaries, which has set many October records across Europe in recent days.\r\n\r\nOver the weekend, a high of 26C is expected in south-east England on Saturday - this is unusual for October and even a little above typical mid-summer highs.\r\n\r\n', 0, '2023-10-06 13:17:15'),
(16, 1, 5, 'The heavy rain in Scotland could lead to some flooding, with up to 150mm (5.9in) falling over the hills, Mr Taylor warned.\r\n\r\nThe Met Office has predicted widespread disruption for the west coast, parts of the central belt and the Highlands including Glasgow, Stirling and Fort William.\r\n\r\nIt warned of potential difficult driving conditions, flooding for homes and businesses and danger to life from fast flowing or deep flood water.\r\n\r\nIn Northern Ireland, highs of 21C are expected, while Scotland will likely top out in the high teens.\r\n\r\nMr Taylor said warm conditions will likely persist into the early part of next week, with temperatures continuing to reach the low to mid 20s, before things turn cooler from the middle of next week.\r\n\r\n', 0, '2023-10-06 13:17:56'),
(17, 1, 2, '\"While the cooler conditions in Scotland this weekend may bring on the autumn colours, overall it looks like temperatures will largely be at or above normal in most areas,\" he explained.\r\n\r\n', 0, '2023-10-06 13:33:20'),
(18, 1, 2, '\"We could continue to see a split in fortunes rainfall-wise though. As low pressure systems dominate to the west and north-west of the UK, parts of western Scotland especially could continue to experience above-average rainfall.\"\r\n\r\n', 0, '2023-10-06 13:33:49'),
(19, 1, 2, 'Unseasonal warm weather is likely to become more common due to climate change, which is having an increasing impact on all parts of the UK.\r\n\r\nIt played a key role in pushing last year\'s temperatures to record highs.\r\n\r\nThe Met Office says 2022\'s record-breaking UK heat will be regarded as a cool year by the end of this century.\r\n\r\n', 0, '2023-10-06 13:34:58'),
(20, 1, 5, 'Mr Taylor said warm conditions will likely persist into the early part of next week, with temperatures continuing to reach the low to mid 20s, before things turn cooler from the middle of next week.\r\n', 0, '2023-10-07 10:12:55'),
(21, 4, 2, 'Unseasonal warm weather is likely to become more common due to climate change, which is having an increasing impact on all parts of the UK.\r\n', 0, '2023-10-09 18:40:17'),
(22, 4, 2, 'Unseasonal warm weather is likely to become more common due to climate change, which is having an increasing impact on all parts of the UK.\r\n', 0, '2023-10-09 18:41:46'),
(23, 4, 2, 'Unseasonal warm weather is likely to become more common due to climate change, which is having an increasing impact on all parts of the UK.\r\n', 0, '2023-10-09 18:42:07'),
(24, 4, 2, 'Kevin Hern – The Oklahoma Republican, who chairs a conservative group of lawmakers called the Republican Study Committee, is considering a run for leadership. His committee wields a large bloc of GOP members.\r\n', 0, '2023-10-09 18:53:30'),
(25, 4, 1, 'For now, a placeholder, Rep. Patrick McHenry, is what’s referred to as “speaker pro tempore,” which means the North Carolina Republican can essentially keep the lights on but has no power to move legislation through the House.\r\n', 0, '2023-10-10 03:52:40'),
(26, 4, 1, 'For now, a placeholder, Rep. Patrick McHenry, is what’s referred to as “speaker pro tempore,” which means the North Carolina Republican can essentially keep the lights on but has no power to move legislation through the House.\r\n', 0, '2023-10-10 05:24:13'),
(27, 4, 1, 'The message has been sent successfully!\r\n', 0, '2023-10-10 05:29:26'),
(28, 1, 3, 'There is a growing rift over additional aid to help Ukraine fend off Russia’s invasion. Ukraine is burning through ammunition at a fast pace and the US and other countries are becoming slower to resupply. The White House wants $24 billion in additional Ukraine funding, but read more on that from CNN’s Tim Lister.', 0, '2023-10-10 05:30:20'),
(29, 1, 4, 'What was the eight Republicans’ beef with McCarthy?\r\n', 0, '2023-10-10 05:46:17'),
(30, 4, 9, 'RGXNzjKN1H', 0, '2023-10-11 18:42:13'),
(31, 4, 9, 'RGXNzjKN1H', 0, '2023-10-11 18:42:13'),
(32, 4, 10, 'تجربة ارسال جديدة', 0, '2023-10-11 18:43:35'),
(33, 4, 10, 'تجربة ارسال جديدة', 0, '2023-10-11 18:43:35'),
(34, 4, 11, '4aJNAHtwYX', 0, '2023-10-11 18:54:42'),
(35, 4, 11, '4aJNAHtwYX', 0, '2023-10-11 18:54:42'),
(36, 3, 12, 'm4XO5QlROD', 0, '2023-10-11 19:01:15'),
(37, 3, 12, 'm4XO5QlROD', 0, '2023-10-11 19:01:15'),
(38, 4, 13, '3vOzGTI0gB', 0, '2023-10-11 19:08:11'),
(39, 4, 13, '3vOzGTI0gB', 0, '2023-10-11 19:08:11'),
(40, 4, 14, 'ClhH1ogXzT', 0, '2023-10-11 19:09:21'),
(41, 4, 14, 'ClhH1ogXzT', 0, '2023-10-11 19:09:21'),
(42, 4, 15, 'IrZnJVNmWV', 0, '2023-10-11 19:10:40'),
(43, 4, 15, 'IrZnJVNmWV', 0, '2023-10-11 19:10:40'),
(44, 4, 15, 'Add message to this conversation\r\n', 0, '2023-10-11 19:10:58'),
(45, 4, 16, 'Hi I am robot', 0, '2023-10-11 19:11:43'),
(46, 4, 16, 'Hi I am robot', 0, '2023-10-11 19:11:43'),
(47, 4, 17, 'PWWWJUIF7w -- 1', 0, '2023-10-11 19:17:37'),
(48, 4, 17, 'PWWWJUIF7w -- 1', 0, '2023-10-11 19:17:37'),
(49, 4, 18, 'PWWWJUIF7w -- 2', 0, '2023-10-11 19:20:51'),
(50, 4, 18, 'PWWWJUIF7w -- 2', 0, '2023-10-11 19:20:51'),
(51, 4, 19, 'PWWWJUIF7w -- 4', 0, '2023-10-11 19:23:39'),
(52, 4, 19, '© Copyright NiceAdmin. All Rights Reserved\r\n', 0, '2023-10-11 19:23:55'),
(53, 4, 20, 'PWWWJUIF7w -- 5', 0, '2023-10-11 19:29:50'),
(54, 4, 21, 'PWWWJUIF7w -- 99', 0, '2023-10-11 19:39:47'),
(55, 4, 22, 'General Form Elements\r\n', 0, '2023-10-11 19:41:20'),
(56, 1, 19, '© Copyright NiceAdmin. All Rights Reserved\r\nDesigned by BootstrapMade\r\n', 0, '2023-10-12 06:50:41');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `notification_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_optional` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `notification_name`, `description`, `is_optional`) VALUES
(1, 'Changes made to your account', 'Notifies users of any changes made to their account', 1),
(2, 'Information on new products', 'Notifies users about new products and services', 1),
(3, 'Marketing and promo offers', 'Notifies users about marketing and promotional offers', 1),
(4, 'Security alerts', 'Notifies users about potential security risks or concerns', 0);

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `offer_link` varchar(255) NOT NULL,
  `valid_until` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` longtext DEFAULT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `discounted_price` decimal(10,2) DEFAULT NULL,
  `product_link` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `job` varchar(255) DEFAULT NULL,
  `address` mediumtext DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `bio` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `first_name`, `last_name`, `avatar`, `phone`, `job`, `address`, `company`, `country`, `website`, `twitter`, `facebook`, `instagram`, `linkedin`, `bio`) VALUES
(3, 3, 'FirstName1', 'LastName1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 4, 'Keven', 'Batista', NULL, '', 'Web Designer', 'A108 Adam Street, New York, NY 535022', '', 'KSA', '', 'https://twitter.com/#', 'https://facebook.com/#', 'https://instagram.com/#', 'https://linkedin.com/#', ''),
(5, 5, 'FirstName3', 'LastName3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 6, 'FirstName4', 'LastName4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 7, 'FirstName5', 'LastName5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 8, 'FirstName6', 'LastName6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 9, 'FirstName7', 'LastName7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 10, 'FirstName8', 'LastName8', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 11, 'FirstName9', 'LastName9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 12, 'FirstName10', 'LastName10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 13, 'FirstName11', 'LastName11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 14, 'FirstName12', 'LastName12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 15, 'FirstName13', 'LastName13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 16, 'FirstName14', 'LastName14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 18, 'FirstName16', 'LastName16', NULL, '', '', '', '', '', '', '', '', '', '', ''),
(19, 19, 'FirstName17', 'LastName17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 20, 'FirstName18', 'LastName18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 22, 'FirstName20', 'LastName20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 23, 'FirstName21', 'LastName21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 25, 'FirstName23', 'LastName23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 26, 'Power', 'Twin ', NULL, '', '', '', '', '', '', '', '', '', '', ''),
(28, 28, 'FirstName26', 'LastName26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 29, 'FirstName27', 'LastName27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 30, 'FirstName28', 'LastName28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 31, 'FirstName29', 'LastName29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 33, 'FirstName31', 'LastName31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 36, 'FirstName34', 'LastName34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 37, 'FirstName35', 'LastName35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 38, 'FirstName36', 'LastName36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 40, 'FirstName38', 'LastName38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 41, 'FirstName39', 'LastName39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 42, 'FirstName40', 'LastName40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 43, 'FirstName41', 'LastName41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 44, 'FirstName42', 'LastName42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 47, 'FirstName45', 'LastName45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 48, 'FirstName46', 'LastName46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 49, 'FirstName47', 'LastName47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 50, 'FirstName48', 'LastName48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, 51, 'FirstName49', 'LastName49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(52, 52, 'FirstName0', 'LastName0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(53, 53, 'FirstName1', 'LastName1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(54, 54, 'FirstName2', 'LastName2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(55, 55, 'FirstName3', 'LastName3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(57, 57, 'FirstName5', 'LastName5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(58, 58, 'FirstName6', 'LastName6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(59, 59, 'FirstName7', 'LastName7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(60, 60, 'FirstName8', 'LastName8', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(61, 61, 'FirstName9', 'LastName9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(62, 62, 'FirstName10', 'LastName10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(63, 63, 'FirstName11', 'LastName11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(65, 65, 'FirstName13', 'LastName13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(66, 66, 'FirstName14', 'LastName14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(67, 67, 'FirstName15', 'LastName15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(68, 68, 'FirstName16', 'LastName16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(69, 69, 'FirstName17', 'LastName17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(71, 71, 'FirstName19', 'LastName19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(72, 72, 'FirstName20', 'LastName20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(73, 73, 'FirstName21', 'LastName21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(74, 74, 'FirstName22', 'LastName22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(75, 75, 'FirstName23', 'LastName23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(76, 76, 'FirstName24', 'LastName24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(78, 78, 'FirstName26', 'LastName26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(79, 79, 'FirstName27', 'LastName27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(81, 81, 'FirstName29', 'LastName29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(82, 82, 'FirstName30', 'LastName30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(83, 83, 'FirstName31', 'LastName31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(84, 84, 'FirstName32', 'LastName32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(85, 85, 'FirstName33', 'LastName33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(86, 86, 'FirstName34', 'LastName34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(87, 87, 'FirstName35', 'LastName35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(88, 88, 'FirstName36', 'LastName36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(89, 89, 'FirstName37', 'LastName37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(90, 90, 'FirstName38', 'LastName38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(91, 91, 'FirstName39', 'LastName39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(92, 92, 'FirstName40', 'LastName40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(93, 93, 'FirstName41', 'LastName41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(95, 95, 'FirstName43', 'LastName43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(96, 96, 'FirstName44', 'LastName44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(97, 97, 'FirstName45', 'LastName45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(98, 98, 'FirstName46', 'LastName46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(99, 99, 'FirstName47', 'LastName47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(101, 101, 'FirstName49', 'LastName49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(102, 102, 'FirstName0', 'LastName0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(103, 103, 'FirstName1', 'LastName1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(104, 104, 'FirstName2', 'LastName2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(105, 105, 'FirstName3', 'LastName3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(106, 106, 'FirstName4', 'LastName4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(107, 107, 'FirstName5', 'LastName5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(109, 109, 'FirstName7', 'LastName7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(110, 110, 'FirstName8', 'LastName8', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(111, 111, 'FirstName9', 'LastName9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(112, 112, 'FirstName10', 'LastName10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(113, 113, 'FirstName11', 'LastName11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(115, 115, 'FirstName13', 'LastName13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(116, 116, 'FirstName14', 'LastName14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(117, 117, 'FirstName15', 'LastName15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(118, 118, 'FirstName16', 'LastName16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(119, 119, 'FirstName17', 'LastName17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(122, 122, 'FirstName20', 'LastName20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(123, 123, 'FirstName21', 'LastName21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(124, 124, 'FirstName22', 'LastName22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(125, 125, 'FirstName23', 'LastName23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(126, 126, 'FirstName24', 'LastName24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(127, 127, 'FirstName25', 'LastName25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(128, 128, 'FirstName26', 'LastName26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(129, 129, 'FirstName27', 'LastName27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(130, 130, 'FirstName28', 'LastName28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(132, 132, 'FirstName30', 'LastName30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(133, 133, 'FirstName31', 'LastName31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(134, 134, 'FirstName32', 'LastName32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(135, 135, 'FirstName33', 'LastName33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(136, 136, 'FirstName34', 'LastName34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(137, 137, 'FirstName35', 'LastName35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(138, 138, 'FirstName36', 'LastName36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(139, 139, 'FirstName37', 'LastName37', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(140, 140, 'FirstName38', 'LastName38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(141, 141, 'FirstName39', 'LastName39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(142, 142, 'FirstName40', 'LastName40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(143, 143, 'FirstName41', 'LastName41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(144, 144, 'FirstName42', 'LastName42', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(145, 145, 'FirstName43', 'LastName43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(146, 146, 'FirstName44', 'LastName44', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(147, 147, 'FirstName45', 'LastName45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(148, 148, 'FirstName46', 'LastName46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(149, 149, 'FirstName47', 'LastName47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(150, 150, 'FirstName48', 'LastName48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(151, 151, 'FirstName49', 'LastName49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(152, 152, '8Tu17mhwzK', '4WVqPlWddy', NULL, '8692297587', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(153, 153, 'GUyRyjcd3O', 'RH71Eh6UuO', NULL, '1712295123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(154, 1, 'Hassan', 'Alzahrani', NULL, '', '', '', '', '', '', '', '', '', '', ''),
(155, 154, 'ekn6BCBM90', '8MATnX6CBk', NULL, '6705095053', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(156, 155, 'eg6YWxRXO6', 'qrzG3yhXob', NULL, '9208235980', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(157, 156, 'PVc5q0iT5L', 'Z3sS2ZKpl1', NULL, '9249079900', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(158, 157, 'xAabaOk8Q5', 'UZutNrjfuP', NULL, '9202364103', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(159, 158, 'Ali', 'Basha', '65242c820b9ba.jpg', '0816862325', 'AuOlfRg4a6', 'InnEBt4CAL', 'y3xlvyl24y', 'rTcjpB2MHX', 'http://1Vku97ma.iC', 'B2RY6xhUWu', 's6wWbj6Tny', 'x2gYIyRvsf', 'LyTxYNVyg7', 't4stGrP3u5');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `description` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `description`) VALUES
(1, 'Administrator', 'Full access to manage the website.'),
(2, 'Moderator', 'Can moderate user content, but not full admin rights.'),
(3, 'Vendor', 'Can add and manage their own products or stores.'),
(4, 'Consumer', 'Regular user who can purchase and review products.'),
(5, 'Visitor', 'Site visitor with no special privileges.');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 5),
(3, 1),
(4, 5),
(10, 3),
(10, 4),
(10, 5),
(26, 5),
(73, 2),
(73, 5);

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `link` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email_verified` tinyint(1) DEFAULT 0,
  `verification_code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `email_verified`, `verification_code`, `created_at`) VALUES
(1, 'hsnwww@gmail.com', '$2y$10$I2rBVA5f2OHhdauygqmcOOdad8NSN82oc3On2rKr4WeGXpAwO/B/G', 1, '5200531ca1939a8c1', '2023-10-01 19:35:34'),
(3, 'user5373@example.com', '$2y$10$32rDht105qOfcJXyVUxfje4Y/iKVmGKaUuqeadZD9t4vTwcd7iy6G', 0, 'cdd6be267c8a2da4d0a6', '2023-10-01 21:18:03'),
(4, 'user5919@example.com', '$2y$10$i9kHfOwPTqKtW8PhMtrZie56K4p1lJtbN87Du.Y0fPtmCgJt/.uly', 1, 'b6e7db68e42d3251bb63', '2023-10-01 21:18:04'),
(5, 'user4579@example.com', '$2y$10$yQNfYSBR4DdH97mClaysQubsdnhGNrvGc6CFf0NkWKzsOvZ/FJmXS', 0, 'eeb7000b6fe116b3e1c4', '2023-10-01 21:18:04'),
(6, 'user6399@example.com', '$2y$10$4gVeWU3ChpfrNL.VD/IXke/z9T97gTtSaOabCxNlq094l1j3xZcne', 0, '0b00ae9a3370a1458a14', '2023-10-01 21:18:04'),
(7, 'user3315@example.com', '$2y$10$4IYHuaLoWk8l9.wDk7G26ueWQ8yvtKgBKqFMjbSYjzfVV3jlT1NYG', 0, 'a7c3087fed85fb6caa38', '2023-10-01 21:18:04'),
(8, 'user9678@example.com', '$2y$10$jZsz2Mw965NZxJ1rCpV/g.58Mz59Qw9v4xXgp1NmJmak5BqGNL1o6', 0, '12bc6e7714f6f87bf236', '2023-10-01 21:18:04'),
(9, 'user9899@example.com', '$2y$10$rupQ7LDJ36FcQmhE5vuQKOvWgowd8103i.MiaPM1nIsSBpilK5ai2', 0, '93dc340b2891c620e95c', '2023-10-01 21:18:04'),
(10, 'user7618@example.com', '$2y$10$zjfvWtLr.F8HXvB4.HNS6.1qHjV2Fo0tDJgPY8i69O8LB4UmBP5Di', 0, 'c21073abb977888a050f', '2023-10-01 21:18:05'),
(11, 'user9388@example.com', '$2y$10$s40lmPJdTYyxzIUKjqBHae8SMuDh0PKD4dqiJYSu8rwXnAptDWJ3O', 0, '3f3c8be11496dfdd4553', '2023-10-01 21:18:05'),
(12, 'user5500@example.com', '$2y$10$Ka5m7eXRQeMPd4IlkKx.Bef6tHsXRtpktLtr.rsfRulXqDeEerBve', 0, '757938fe625566053409', '2023-10-01 21:18:05'),
(13, 'user8685@example.com', '$2y$10$R6bWIi.yc6.ITVRPiFdp6OCrOt/umsO2GCpVH8hjnH2eaZytzrfUu', 0, 'b8214722e32c790cc4f5', '2023-10-01 21:18:05'),
(14, 'user9805@example.com', '$2y$10$b/yPfbiNMVPaKjAoqWZfme663HshPORKamO0iPte0aOlzfG9ZdQyG', 0, '26b763eaba7ad59088b3', '2023-10-01 21:18:05'),
(15, 'user5893@example.com', '$2y$10$p1vq/c9qebdaBYxVqCzko.Gy149RBHPhO8W9h3zNH9YwRVcqFvTmG', 0, 'ed71f6eb46c571b22b89', '2023-10-01 21:18:05'),
(16, 'user5083@example.com', '$2y$10$lRtarXtbyFgDRrJ4ivhRcuQJPq5bML2kVO2cR3kXgX5RiSD3ad/D2', 0, '6c4d1827e3c7a2c50877', '2023-10-01 21:18:06'),
(18, 'user2601@example.com', '$2y$10$bR8dLCCzyMS.rxbbT13tPOAkobf3cldRBx1TxhyxdCqvKPPEVw8Ca', 0, 'f47cdee576aed78334ed', '2023-10-01 21:18:06'),
(19, 'user6501@example.com', '$2y$10$rdcF0w8LuFpvgnbrb5j.Z.2zok16QYjIgjNw8ga0agujagCTS3MxS', 0, '5bcb1c90cadc140eac50', '2023-10-01 21:18:06'),
(20, 'user8775@example.com', '$2y$10$28.XGlbZoOUGabMgY48MMeQanaL9l7vSLMp0nMlxYGKOCBbYmczDy', 0, '209b836c77dffb501f70', '2023-10-01 21:18:07'),
(22, 'user2926@example.com', '$2y$10$TlHa.UHL3aC9S0ki7zRj9efhIMEtmA7umHXUUR2jbWCVjvx/XdAp.', 0, 'b31e7dc0e69dcaa4ae63', '2023-10-01 21:18:07'),
(23, 'user2927@example.com', '$2y$10$.wJFoB90Mpster4jDYfBr.BRgNuz1iWFcEMp6iu7tbuTV9wrshkxq', 0, '5d37f109c53ba4ad5153', '2023-10-01 21:18:07'),
(25, 'user7916@example.com', '$2y$10$R4J4KX8afqiabLCfRZD.VuX0NCTw8Y1ycIHsPpIlLzOyEWbyngAuy', 0, '7ab8440c15996e3c2b1c', '2023-10-01 21:18:08'),
(26, 'user9813@example.com', '$2y$10$Hn3/FOf3pd5v1fUVZefgfunONUnOVj9Ra1m77dQQHhLfqITnoaLTC', 1, '3f7cdb3d0af0796b3f04', '2023-10-01 21:18:08'),
(28, 'user3572@example.com', '$2y$10$PwVLKBf0scs/U1N5J5R.8.omafaag04K9gVznOtzf9Jc2mstBVR26', 0, 'b3acf2e76ec85621e8de', '2023-10-01 21:18:08'),
(29, 'user4467@example.com', '$2y$10$D6WhByzcLA31ib4tGtWKJOOkRgL7chEbixHzQRF.lCAVT5LzpXlHa', 0, '842982226a8ca67c29e6', '2023-10-01 21:18:08'),
(30, 'user2547@example.com', '$2y$10$gmMu7d8.FQIi9nNBd0z.tueVb9O0j/DgWUjLAUwkCgnNX9dMZDTMK', 0, '5bb02852454dbcd69849', '2023-10-01 21:18:09'),
(31, 'user4618@example.com', '$2y$10$R2N7hRgYSnu4MZ8ZMrolgOQLeLCuHHLzuw558uAKWnPWCzVH5zuCC', 0, '43f2620b54ef0e05dd8f', '2023-10-01 21:18:09'),
(33, 'user5646@example.com', '$2y$10$l6or5bBOeV.lrSH5b1KYt.ZPRgFLscMcfJS3WW7mqD758cqSbDjdq', 0, '31804ab0b4be3edb2ea2', '2023-10-01 21:18:09'),
(36, 'user9972@example.com', '$2y$10$ses/T/lhAVBrr0SLIgD1qeDXdOTmoeLmdUFdvwlhE1J5SU/D7ZSf6', 0, 'e64514eed4253dcac752', '2023-10-01 21:18:10'),
(37, 'user8828@example.com', '$2y$10$81c.muNIJs6BzSep05L7dewygdWQzyeTWPQ8wjwQGMxRJovWi9iXy', 0, 'acaed5b51e838e54aa4f', '2023-10-01 21:18:10'),
(38, 'user4586@example.com', '$2y$10$ISQ/RTKD/c.PwB6if/j.duT9SppZPz.4ZpK/P7vcNMbfU4//UdwAC', 0, 'a1499eefa34b87939a05', '2023-10-01 21:18:10'),
(40, 'user7332@example.com', '$2y$10$N3VO4kUVyXT5Nazy/sgBU.ABKUqWU12ME56v/CakPWd0BcB8.80um', 0, 'b30b27daf27168827555', '2023-10-01 21:18:11'),
(41, 'user5482@example.com', '$2y$10$ODpfgcVQFPrubjX9dB9JUOz2izbCrWniSIzy.xEDiqupIUkWZ3FC.', 0, '84024cd01063a3789da3', '2023-10-01 21:18:11'),
(42, 'user5868@example.com', '$2y$10$yYRd.6Wa3s6mISeFOA96ruQTFjxlGaaYvkoTNapRNrks2bWUb07x2', 0, 'ba7a2ef1cc1c1d34fbe6', '2023-10-01 21:18:11'),
(43, 'user3432@example.com', '$2y$10$eqr4BNkgp21Jokw400digub19Sz7QYgVBNMSO8aNn5gx9m1n78KFC', 0, '34772a2a8dce795bd998', '2023-10-01 21:18:11'),
(44, 'user1674@example.com', '$2y$10$JbpZve/B7NvFsnbCVxGEzO0lxIvVb2nlD6wUlz2wxpfpQ0dOKL4Fm', 0, '7f8a6475caf9f6f37409', '2023-10-01 21:18:11'),
(47, 'user5944@example.com', '$2y$10$NWY7jqJJi3OjzGaD037CMupujb1Gv.9cWFojd5uxRLnmWRWKpcqsy', 0, '68d454ac3f0edba4bb7f', '2023-10-01 21:18:12'),
(48, 'user1090@example.com', '$2y$10$mobhFAxJBazs4omnSPKLweGVdDciFhr0vpQXjeRU2EXn0tk52NBwC', 0, 'd27e9eb9a755cbd1ae57', '2023-10-01 21:18:12'),
(49, 'user2804@example.com', '$2y$10$t7bLi2BLCE2VvVP4S//jbea6eBc9.0OX228VYS8eltLDs1QBww5gq', 0, 'a623c4d91f80a2d0c021', '2023-10-01 21:18:12'),
(50, 'user7187@example.com', '$2y$10$EBTHIh90JhT8Twz9fVnYmuRVLZAQG1X0BFIn85OYs7PV.qSAOOS9y', 0, 'a3b52167a6f6e470e317', '2023-10-01 21:18:12'),
(51, 'user5018@example.com', '$2y$10$NYDn8q.N6EE5OnxUAo9y..hz6UDb3z6/DcVDa9j.hQ7gmGEtb3Hja', 0, '10a20b2ab2a5742a5e7d', '2023-10-01 21:18:13'),
(52, 'user8383@example.com', '$2y$10$pbS.FnL31ADgyn.1BK1J6OR93kK7nErv5Dnj1ZSlIMIyhGCXc05lK', 0, 'fc66172711aeaf744fbe', '2023-10-01 21:18:24'),
(53, 'user7994@example.com', '$2y$10$JURRWWMySvWe1.0MzmECHurct4GpCMPDa8LOF6UlkfwI0mIOZrAxK', 0, '56b1ba3b60d4726dfa4d', '2023-10-01 21:18:24'),
(54, 'user7512@example.com', '$2y$10$kg/HGezMEjMCuvNBr2Eazu1DmjiBjM652DLNwdfkTRNk1JXhJxMSW', 0, '3e537a4b6c2809ca8b8c', '2023-10-01 21:18:24'),
(55, 'user7876@example.com', '$2y$10$6YT4R3HEETvgnEAj2SvMHOjW9/UUzaZTYWoWj6ewRm0PWuNqs0ztS', 0, '192626a891803395fb49', '2023-10-01 21:18:24'),
(57, 'user2285@example.com', '$2y$10$wuO2w6Ok2bGjuVpXhe92qeykfEn.tzApkmdFocglWMB1z61ZJ6lU6', 0, '80e18eb3c7018fac7cd6', '2023-10-01 21:18:25'),
(58, 'user8001@example.com', '$2y$10$onXTXqKOpD3vLeKnb7TrJ.Wh2aqaGmhfoCbxzqkhQdWInC4ygADCm', 0, 'f00692b1e3c6a1e10515', '2023-10-01 21:18:25'),
(59, 'user8882@example.com', '$2y$10$e.x8Ji/6aPyWZ1I5DiuhBO276./KWRCK7FYhHFgIL/3X.GBPGkcsO', 0, '884719bb9bca866b6d9d', '2023-10-01 21:18:25'),
(60, 'user1075@example.com', '$2y$10$kYzLvQL6pCSNDJSU4uFyweY5KKrUKqNR4HNhAhv.VUP1KPIfQ3LXm', 0, 'e615efc7a3f7e2796a5c', '2023-10-01 21:18:25'),
(61, 'user2596@example.com', '$2y$10$K7T72nzA2VGVTFEzb5XXEuknOnMxu8yIX0lgJ.ykJ1G8eNum8LT1i', 0, 'c7ad974a36ac18921726', '2023-10-01 21:18:26'),
(62, 'user2363@example.com', '$2y$10$IjH5M0yPQVXp29iGpDHnAOYzFwI8RV.io3xMRhD5AxPSOYH3u8i.W', 0, '5e572a0080707de0a428', '2023-10-01 21:18:26'),
(63, 'user2324@example.com', '$2y$10$xEF2N1sRtQeEjBRJlx.NYeewLsFXfGmFJdYTNDZqe7HaVefhMNCjW', 0, '144d9b402d1a1e5a1708', '2023-10-01 21:18:26'),
(65, 'user4499@example.com', '$2y$10$F4f.5igks6ftaIfOvAYdEOCtoycXeBUURr/xVSepy5undVk74zJjO', 0, '3f04729bbdbea77aca1b', '2023-10-01 21:18:26'),
(66, 'user2928@example.com', '$2y$10$CoWijz3.TLqLKTk6VBtZUOhrhARJ3xdDQH/Yod9tcWYiHvA6jUS.q', 0, '432109f216cc46ed05a9', '2023-10-01 21:18:26'),
(67, 'user4485@example.com', '$2y$10$N1cdI1QTO7CDcfNKoVcH9.MgBAbksdfS9cjWR6GFpetBhTivgCx3a', 0, 'dffe971f411a11774fe2', '2023-10-01 21:18:27'),
(68, 'user6950@example.com', '$2y$10$dNmzykTF1UsVptHDyvacwORvtTOgZ8SkbIarkyDqflYxyMmGxn5xG', 0, '66bc473d3bf68b8b2d4e', '2023-10-01 21:18:27'),
(69, 'user9857@example.com', '$2y$10$4NElqLQWpZGQq0t83Bti4u5q.jwLBCCTODotHkuCJELbwVjB.ZCvu', 0, '9250f0c1353fc35dfd7d', '2023-10-01 21:18:27'),
(71, 'user3124@example.com', '$2y$10$fr6aNJ2T.W8KwCbTNleQBu2pk.R4pQY17tXGInf8YPQr3osKGyP3y', 0, '469990afe8bcfd490855', '2023-10-01 21:18:27'),
(72, 'user6608@example.com', '$2y$10$UPXTA21tFGhbS8JQKRAgpuEz2Cf.U2/eZOoPfUvLrbDUDqkU6.3fy', 0, 'a7dcfd58bc403376acfd', '2023-10-01 21:18:28'),
(73, 'user1240@example.com', '$2y$10$3WugmHl2riCvADtFhisIduvYOBsUt9vN7tql3vkgkwVpSjbGkJ9Zm', 0, '82b961cb561f18917a49', '2023-10-01 21:18:28'),
(74, 'user6184@example.com', '$2y$10$HofDydEsOthg.GEuR0DQKenFKFjFUGbjJ8VhRpH4OCN/Y1CmgtDlO', 0, '0daf80b26a557a499d65', '2023-10-01 21:18:28'),
(75, 'user8627@example.com', '$2y$10$gp2fMvAkhFGJ8njx4cXTguyUSuYJTZPRegI0uPKMTq65WyFzQCXS6', 0, 'db2acde3b7cd596b3f0e', '2023-10-01 21:18:28'),
(76, 'user2267@example.com', '$2y$10$jVvVXSu0Ffr8shEI.Q3Ab.Jkc4qvcpPQMQ/G51flzgtzhdKHiBkee', 0, '8911ef77dc885a3f4bb0', '2023-10-01 21:18:28'),
(78, 'user2959@example.com', '$2y$10$w8fvGqof95qwnuaepmdyj.V.cKPGW4N4lZsvgjXu0XdOvT24Z3hDi', 0, 'd7449718e2bbdff8ae45', '2023-10-01 21:18:29'),
(79, 'user7407@example.com', '$2y$10$n8rHJmwxsaf1KxEi5Xt6duG4l73301S/25zuGilVkP8XIobqMzW0y', 0, '3293a54911bd6ad2e9d7', '2023-10-01 21:18:29'),
(81, 'user2975@example.com', '$2y$10$M6KwhyivGNiJfXnixPxNIemj4BllT217ztLHWyuhzUkXk0Y/FFdmS', 0, '3f0b57cc9c827f8239ec', '2023-10-01 21:18:29'),
(82, 'user1414@example.com', '$2y$10$hKM8uFmNiqUyksbbG2Q9cel1132dRC0ALsNrQQu8bdLzHMYnVwWHi', 0, '9bcb8c554e39a1ff763e', '2023-10-01 21:18:29'),
(83, 'user5437@example.com', '$2y$10$SPl4cmrZSsgNoaqOFZ38GOAdXKQQok3mUM8NcJYXtf5bSzqI4bnv2', 0, 'edaeecfe0b2aeb8cba0d', '2023-10-01 21:18:30'),
(84, 'user2284@example.com', '$2y$10$h/00UvVDa8E9m/HaQVpSYeISEqnPjq.o6YUp1A2hSnfOgqMgw7R5C', 0, '96d3e32d5aad9a1bff88', '2023-10-01 21:18:30'),
(85, 'user5959@example.com', '$2y$10$g9jGFtPtNdSJVd8e2MVBKeQZeKgDDBRTltD0wUgFPfxmkAqZ/vcCi', 0, 'dc564f3a02c113bfb25d', '2023-10-01 21:18:30'),
(86, 'user5400@example.com', '$2y$10$ZaMed0ps14I4KhichcqaoOrSrSjlWjJD/mNOXYjsFwZONST836hEO', 0, 'd8def30c63f862d9c11c', '2023-10-01 21:18:30'),
(87, 'user8484@example.com', '$2y$10$yElXv8/QHQ34e.0O3HzzPuBDXPyZqeO7HkMgYgw/Y0fOJqWdC5aC6', 0, 'f727b1da80d23484aa4b', '2023-10-01 21:18:30'),
(88, 'user3726@example.com', '$2y$10$8//6NMVXBO5horFvg1frC.s7V9oRtM03qs.Y/Ft8gnPsaG2wTDFxK', 0, 'bb2d6dfda6d486da4258', '2023-10-01 21:18:31'),
(89, 'user5885@example.com', '$2y$10$9J5oiwa3J6cPjKzkIopHl.uobwVqJR8f9PRwakuBvqvhQNtV6fYNm', 0, '138a06415dba4e211702', '2023-10-01 21:18:31'),
(90, 'user8999@example.com', '$2y$10$QKPLldWu8DtgyRIw/zoeCes2FF0E9NYoacJaMOQW60ZYxENMla03e', 0, '0b4297a1bb764ec57035', '2023-10-01 21:18:31'),
(91, 'user4137@example.com', '$2y$10$QWAz0b9spNGf4tvFJAyUT.lLJbDod2NZy2IVPpwzHFUIkgnkurxFa', 0, 'c9b209ce47cf20f9af89', '2023-10-01 21:18:31'),
(92, 'user7397@example.com', '$2y$10$qScjrNKrfHy81PcvURhkZ.zBVwjDjVYprWhbRQ.X0sMtKnITxT.oy', 0, '562713196bc8290de2d9', '2023-10-01 21:18:31'),
(93, 'user5392@example.com', '$2y$10$qqkF.zKtSuerxQHWzPLIXeu8tup4L1Oqn2tYLfIyRVWzfJDFGHFum', 0, 'a8c33c148a2992f9f415', '2023-10-01 21:18:31'),
(95, 'user7133@example.com', '$2y$10$hxwWpw9YyYD0PMtzgI8V8uAufqJNf8EGBqJ4.WF2v.4PXcfmH.r2S', 0, '3d7057bc15dc0fbaa3c3', '2023-10-01 21:18:32'),
(96, 'user7771@example.com', '$2y$10$ro0IyH0aVzRVUZNkDCnyvu7g9B7Sq2Y1fBIoTDgKLvQybN/Kngnhu', 0, '2969bd8d7f0643310b7e', '2023-10-01 21:18:32'),
(97, 'user1978@example.com', '$2y$10$S1KSwdL19kolaEGzwgAsAe3SPhdu.xOzlrQITV/ZDzW3xlxDIRKMu', 0, '22de5c9bf40f5f1765f4', '2023-10-01 21:18:32'),
(98, 'user4272@example.com', '$2y$10$.JBUAV.72d8g41.M716Zd.krYAkACCnOoJ10TFKb6Z3i9FZuaDz5G', 0, 'f2ef391e4048c51501c6', '2023-10-01 21:18:32'),
(99, 'user4628@example.com', '$2y$10$3mOO3lb5yXtcoXjRSnKAb.z4Q2e/7OVzvLP9bUd8JH.aPqnz0pr7W', 0, 'd1676b0e10816e5aad09', '2023-10-01 21:18:33'),
(101, 'user5346@example.com', '$2y$10$wLsgPAujHurUL/oyRE93COUW2EgkdNQTa.RCb4F6Ka9IZ.ci0Ee5W', 0, 'bc1f8adf2f9f50bafa36', '2023-10-01 21:18:33'),
(102, 'user2466@example.com', '$2y$10$uSsJC0s9QQ0esD8ekZG8vuljj9D4gfaVrYMnFuMQZAQgj27ryRttC', 0, '3c44b7f2374d0a22621c', '2023-10-01 21:18:43'),
(103, 'user8159@example.com', '$2y$10$t6JSiDNzF.Qni1siLThRIOIPNEKr8KxCzqGZ3.fudOvUS1BuXwdn2', 0, '8c90667f24ff81399537', '2023-10-01 21:18:43'),
(104, 'user3431@example.com', '$2y$10$9/l2E0r1zE7t3outNQmmTunXvjDQYoBNJ.Xi6lHjVNFuR38m4Qs86', 1, '6357f486622de251ed37', '2023-10-01 21:18:43'),
(105, 'user3519@example.com', '$2y$10$PW9sBnFdJl2GPnoMyU9/j.NN0kiEwwb5Z1FyxHt/Bs2kh8sFBqmI.', 0, '464452d0295839a3aada', '2023-10-01 21:18:43'),
(106, 'user4352@example.com', '$2y$10$cIE0R.Zn647BSXkcNtO7h.y63KZ9dNEemsre8V6B5h1pdMWIunbxW', 0, '7bc37c2c0b8aab97feb3', '2023-10-01 21:18:43'),
(107, 'user1109@example.com', '$2y$10$3VPiRTB3kXYjkEeUgQab/u3R2kVmctt7W3S7Sd51sTUUO.VujCGv.', 0, '036a25eb951c7a343ca4', '2023-10-01 21:18:44'),
(109, 'user1494@example.com', '$2y$10$JqYV1Sai6leCgEhaaNd8r.7U.Qz9pLSioaRYSmydS.QRKQdUrZvMm', 0, '19aa4ceae3bd4f226c29', '2023-10-01 21:18:44'),
(110, 'user5206@example.com', '$2y$10$toOH88D2DlE5Fcz88rrid.NRUbJa8fCOiIHbo0alP7OCKH5aY0Q7.', 0, '98815c77662d2ac1066f', '2023-10-01 21:18:44'),
(111, 'user3715@example.com', '$2y$10$rvmAtziONKRa2JgxY5Cm8./O91HXAIaI9E6gGnNJXF7qhbaEu9JkK', 0, '17ea80a3c955ad4d727e', '2023-10-01 21:18:44'),
(112, 'user8840@example.com', '$2y$10$CypBU2toQhI4zciHk3ZwDuFlCUmwZaJRZUOEs.QmU0xyiD4A7kLlO', 0, '73db008f8ae38fddff5a', '2023-10-01 21:18:44'),
(113, 'user9776@example.com', '$2y$10$PMwiE7JvRkzp2xrv3aGJKOAEVBlQxpvLbVrl6aMp2BQWa.xx9GReC', 0, '8cdc440addf773e64506', '2023-10-01 21:18:45'),
(115, 'user2379@example.com', '$2y$10$oNBvwFAQ6B05zL6h6reOMOJ2Qx8f4w8Ke1PbyJdW70nTsar7o8tsu', 0, '5b202d00056ae8f4b206', '2023-10-01 21:18:45'),
(116, 'user7069@example.com', '$2y$10$kd9qO.Uyv9/Z9Q1KONKGo.8wdBSESlvnm2JQ/2y3E0x069Ej4k7i.', 0, '436993366290115569c5', '2023-10-01 21:18:45'),
(117, 'user2006@example.com', '$2y$10$kGTEahXoxLfSsMbmDEUUv.LmK.zBaqr7p8fnU45zbTH7W4yWufZD.', 0, '2ee5a1486513d50481f2', '2023-10-01 21:18:45'),
(118, 'user8496@example.com', '$2y$10$gbTwUdrXUmhq/h4alCqsS.mkgyiBcXIo5qUhvj5TbIIXHzzS7nryu', 0, '19d4b6233df0646cba74', '2023-10-01 21:18:46'),
(119, 'user8254@example.com', '$2y$10$cZWqbMCSYZeJfn6xE5HcSelUmsEMPW.0H3BBqrc3toOr6QQ/sHYSS', 0, '82f691f80e5588416816', '2023-10-01 21:18:46'),
(122, 'user8416@example.com', '$2y$10$Mpu2lAr3Ke08xGoqE1SWtuXWQcbSLW8BQ0mWBL42F89XX9SS7MvdG', 0, '6453941c48ee58842b49', '2023-10-01 21:18:47'),
(123, 'user5719@example.com', '$2y$10$9zssZVVgHaMCyW7RhJxiJeJyT7KkbQiFH2BWO03vBMHzhvopmiD1.', 0, '42994976efad5497877d', '2023-10-01 21:18:47'),
(124, 'user3516@example.com', '$2y$10$BuuhENbML6rnuCS4qxpI6OcUqsHFLtlibhcjEQ2ov.80xyflscnpi', 0, '3f77fde026532928ea07', '2023-10-01 21:18:48'),
(125, 'user9625@example.com', '$2y$10$m6AIQd3uoXmGO6zK3cjNFe895xqmSXFr1nvOEnzfggF9XhXllXc/W', 0, '7b22853805dbd397208f', '2023-10-01 21:18:48'),
(126, 'user2219@example.com', '$2y$10$N7DdyP9Y5p/fVX36kAnN2OaKbRCSPgfW/0B4GyMlMaXf1WnhoZj5O', 0, 'ec634bd08ca3a641924a', '2023-10-01 21:18:48'),
(127, 'user2860@example.com', '$2y$10$gK10sHsiL4EOkmkP2uqEw.CDblrjOv4iUDoAi46Jv.Z9BFm6xx3DW', 0, 'd071186fa869cde87d8e', '2023-10-01 21:18:48'),
(128, 'user2963@example.com', '$2y$10$lDdi7XxUkhqs7n3a0Qe9vu/KybNanr3/9rcBGSvn28SuwlyYFb52O', 0, 'fb6d936be0dd78d2674f', '2023-10-01 21:18:48'),
(129, 'user5610@example.com', '$2y$10$nigh5QV6FCfZQMcI7Ft4gOJufbHuRXHhWzt4UnIJxOgBClh1i5YMC', 0, '73a55c7c538a9d94d125', '2023-10-01 21:18:49'),
(130, 'user7392@example.com', '$2y$10$2/ykrrLTA2Z.W4KyuHOy9uAwKmwdOL8eIWv3dXzMCVv4peoJkzTqa', 0, '8f599361fb4e0136c8df', '2023-10-01 21:18:49'),
(132, 'user6895@example.com', '$2y$10$0EgTUPXhQYO2jLtpokfxluD.mk8xZfKCpxcjjvz6Y8Ug0AJCIcZTG', 0, '18e817cf1344870d39b1', '2023-10-01 21:18:50'),
(133, 'user8657@example.com', '$2y$10$k.8uRFESo4TOgEAc0ueueeJrYPiBDnGmQ3zm.Gj42heOpN.CvKogm', 0, '9d4f7ce19ca27dda1ac3', '2023-10-01 21:18:50'),
(134, 'user6565@example.com', '$2y$10$U76NMD28YuefZDfBDZAnFulQBKtahbRCarjMqJwoTU9QBVhqNefby', 0, '959beb3d7954a4bf9d6c', '2023-10-01 21:18:50'),
(135, 'user8226@example.com', '$2y$10$hsODb0L.kNhWOYYV455Nx.kesW/tQTPwgDTsA7jWZRJCXI0pzvbPy', 0, 'b05862af636db3e306d9', '2023-10-01 21:18:50'),
(136, 'user6181@example.com', '$2y$10$wtsWf144vq5naTJIv3OTOe9oz5NYZpnAZ3hFqDriGT.9O.aR6Eqxu', 0, '2a5d853a27f0c5ee3e2a', '2023-10-01 21:18:50'),
(137, 'user3944@example.com', '$2y$10$fKpB6CIsJe6Z4OfTvycDTOLPPsC5NGock4SZjIkMbal6GjbL3yWwC', 0, '8207beb09a62a16277f1', '2023-10-01 21:18:51'),
(138, 'user4168@example.com', '$2y$10$ddBmVxMkHtqgHvIOHfM6y.o3SXWDYkx71ffn4gwq09yRLUs7tFwRi', 0, '4718b000d42d33330c65', '2023-10-01 21:18:51'),
(139, 'user6978@example.com', '$2y$10$ynUuZg4yycfS4cpsDPQYF.QrLF5wRwg.cCuddhjhyJCm6MMqfwIWq', 0, '30c077fb9b72a296b5b1', '2023-10-01 21:18:51'),
(140, 'user2752@example.com', '$2y$10$FaMHA1ARp9KAHoApS2MQBu4OojEmRMVStH7lUE9dYi869oDXJU9SO', 0, '8ceae23ad2c7dd97f6b9', '2023-10-01 21:18:51'),
(141, 'user2670@example.com', '$2y$10$C0gzWYu9W03scoEaFtHI7.0ExCHdJ9laRkaSPpFPtGNX0WGcsSPbS', 0, 'a3d59447f7bcc4676911', '2023-10-01 21:18:51'),
(142, 'user2228@example.com', '$2y$10$BkiyPgS3J9k4fpynpwYbh.B.3nMmWdktGnFkyqJJvrzFE7RZ1cu6W', 0, '8c28a8661eff13b012d5', '2023-10-01 21:18:52'),
(143, 'user3878@example.com', '$2y$10$9d5HJpuXuF/S.FxfUBO6PeFpetM69s5vHusoGMjmhij2Yvbmm9S7e', 0, 'aff1235e141aaf8e5dda', '2023-10-01 21:18:52'),
(144, 'user9937@example.com', '$2y$10$SiNpVcjecvMzNyG4uCjD0usqo5Y0Tyh.LIio0kYANNZ.1UfWzcbsK', 0, '13ca25486203116f2b94', '2023-10-01 21:18:52'),
(145, 'user9917@example.com', '$2y$10$ouXz9BoNrABXh1P7JiLY8uVM4zh7RxuUUhJJ8teEWbXR5tZcmNgWS', 0, 'cfb959ddbf1b0a40c39a', '2023-10-01 21:18:52'),
(146, 'user2063@example.com', '$2y$10$9LIjszbehUP4qJ9MHffx4OFduUiJ5hK/i43hdnHwRoWBz97aidftm', 0, 'f35ce5d18a1a9a5a600e', '2023-10-01 21:18:52'),
(147, 'user1804@example.com', '$2y$10$5zFpxYAuyo886./mnpokbeGm7lgf.u.FBa3bfj.vmsyajdFdr6sUm', 0, '0f2de1588c69d20d08ba', '2023-10-01 21:18:53'),
(148, 'user4124@example.com', '$2y$10$FxuF9N6Qn4XcLVUGtewtyuUQpUSmNgXvShE1/XsxuAKqjP/KyxK3e', 0, 'a4341c63947b153225a3', '2023-10-01 21:18:53'),
(149, 'user9579@example.com', '$2y$10$.M022hgd95t2Y6KaE.2x7eRnjNTyYFxEdOM1VYPDI.HsfKTwCdL2i', 0, 'fb284eac194464eddd1e', '2023-10-01 21:18:53'),
(150, 'user9349@example.com', '$2y$10$Y5mZQwH7HPxq9ShlgWo00u6Czr8/bflyYL0rJ.FQkbQRAMVWTkyU.', 0, '0a7f09c79e181c1aef09', '2023-10-01 21:18:53'),
(151, 'user3979@example.com', '$2y$10$x2qUzmHWVicUTX5M4ziW1OFVcC1BJPYshBZNxMcXoWERZRRrOaN.C', 0, '29a545478887f8749879', '2023-10-01 21:18:53'),
(152, 'oxlr0@xqdm.com', '$2y$10$ewzbiqknd.daOQOy.dAm..5OLXMEZIFFQx.WWQLC0neOkuylDxaPC', 0, 'c46500de1f4fd1e147d6399e62a33e906c3eb7f9', '2023-10-07 08:07:14'),
(153, 'cvmmh@8iml.com', '$2y$10$/nxc7zix5K5MYKZlDISrc.XlNJtIsoTabs.1AsLPt7YuDq6TDK5ae', 0, 'c4664aa93363b32456adee94d34b25c90f8c957b', '2023-10-07 08:12:48'),
(154, '8q4w6@lg17.com', '$2y$10$/C854ffX0z.zY9mpxGHw9uEr41YLqWk7L4d.erHO.AcUyc9m4lZ32', 0, '48062d1ec1ecb28af627a90753eaf1a1bacfcf5d', '2023-10-09 13:45:25'),
(155, 'dg1vm@vwte.com', '$2y$10$aHbkgbjy4W.7FH5.iPzqCuPc7HQkjzSyS2n3cCv0kt8vzSEQYmDwW', 0, 'cd00b22e518acc55b3922bb978362858672d9b2c', '2023-10-09 13:55:26'),
(156, 'uxaww@kwi1.com', '$2y$10$iqxo939gQi9NZBA2Sx/j2Ooy3hMEW2n5LpMNBZ7a4On5ymz4N7x0W', 0, '0dca0fa3f8448e376ca63ab44c7efc665f278464', '2023-10-09 13:56:51'),
(157, 'ouv4u@22xi.com', '$2y$10$h01D1kSEEmD4wma34MlmtOcfDuaWzrM5iSdE2oUl8hOwTK7aVVy9e', 0, 'ca5550ab432127da034b8c8c8f5f7a5dd8f17c99', '2023-10-09 13:59:15'),
(158, 'jsi5f@iano.com', '$2y$10$QmtOHX5jN66uYw3gFGvm5uovmyp5ObBJNUiURFfMTowjSXNdg77jy', 1, 'a4e6a2f282492c5c5bf175ae189ca3ed3587d512', '2023-10-09 14:06:02');

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `user_id` int(11) NOT NULL,
  `notification_id` int(11) NOT NULL,
  `is_enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_notifications`
--

INSERT INTO `user_notifications` (`user_id`, `notification_id`, `is_enabled`) VALUES
(1, 1, 0),
(1, 2, 0),
(4, 1, 0),
(4, 2, 0),
(158, 2, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_id` (`message_id`);

--
-- Indexes for table `blocked_users`
--
ALTER TABLE `blocked_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blocker_id` (`blocker_id`),
  ADD KEY `blocked_id` (`blocked_id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversation_members`
--
ALTER TABLE `conversation_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation_id` (`conversation_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `conversation_id` (`conversation_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profiles_ibfk_1` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `notification_id` (`notification_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `blocked_users`
--
ALTER TABLE `blocked_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `conversation_members`
--
ALTER TABLE `conversation_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=248;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `attachments_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`);

--
-- Constraints for table `blocked_users`
--
ALTER TABLE `blocked_users`
  ADD CONSTRAINT `blocked_users_ibfk_1` FOREIGN KEY (`blocker_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `blocked_users_ibfk_2` FOREIGN KEY (`blocked_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `conversation_members`
--
ALTER TABLE `conversation_members`
  ADD CONSTRAINT `conversation_members_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`),
  ADD CONSTRAINT `conversation_members_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`);

--
-- Constraints for table `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`);

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `role_user_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `stores`
--
ALTER TABLE `stores`
  ADD CONSTRAINT `stores_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD CONSTRAINT `user_notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_notifications_ibfk_2` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
