-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Час створення: Чрв 17 2026 р., 19:12
-- Версія сервера: 10.4.32-MariaDB
-- Версія PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `news_portal`
--

-- --------------------------------------------------------

--
-- Структура таблиці `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `news_id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  `topic` enum('general','advertising','cooperation','news_tip','bug','other') NOT NULL DEFAULT 'general',
  `message` text NOT NULL,
  `status` enum('new','read','replied') NOT NULL DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `contacts`
--

INSERT INTO `contacts` (`id`, `user_id`, `subject`, `topic`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Привіт', 'cooperation', 'вцукцуцуцу', 'read', '2026-06-09 14:57:28', '2026-06-09 14:58:37'),
(2, 1, 'Тававаів', 'bug', 'аіваіваівавіавіаіва', 'read', '2026-06-12 19:05:44', '2026-06-12 19:06:35'),
(3, 1, 'lklklk', 'general', 'lklklklklkl', 'read', '2026-06-13 04:13:34', '2026-06-17 05:32:14'),
(4, 1, '\\\\\'\\\'\\\'\\\'\\\'', 'news_tip', 'opipiopiopiopiopiop', 'read', '2026-06-13 04:41:23', '2026-06-17 05:32:13'),
(5, 1, '[p[', 'advertising', '[p[p[po[op[po[', 'read', '2026-06-13 04:41:42', '2026-06-17 05:32:12');

-- --------------------------------------------------------

--
-- Структура таблиці `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_31_191235_create_news_table', 2),
(5, '2026_05_31_194210_create_permission_tables', 3),
(6, '2026_06_01_170025_add_views_to_news_table', 4),
(7, '2026_06_02_080909_add_category_to_news_table', 5),
(8, '2026_06_02_092034_create_settings_table', 6),
(9, '2026_06_02_092946_create_news_views_table', 7),
(13, '2026_06_05_111653_create_contacts_table', 8),
(14, '2026_06_06_201853_create_saved_news_table', 8),
(15, '2026_06_06_201927_create_comments_table', 8),
(16, '2026_06_06_204108_create_news_views_table', 9);

-- --------------------------------------------------------

--
-- Структура таблиці `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3);

-- --------------------------------------------------------

--
-- Структура таблиці `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `views` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `category` varchar(255) NOT NULL DEFAULT 'Новини'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `image`, `created_at`, `updated_at`, `views`, `category`) VALUES
(10, 'The government presented a new economic development strategy', 'The government has unveiled a new economic development strategy aimed at attracting investment, supporting businesses and creating new jobs. Officials said the reforms should accelerate economic growth and increase the country\'s international competitiveness.', 'news/mSxMsaiOlPWLrHymlpUUVBFMSu3UoBMNDAKA5una.png', '2026-06-02 06:26:21', '2026-06-13 05:30:43', 67, 'Politics'),
(11, 'EU approves 17th package of sanctions against Russia', 'The European Union has approved its 17th package of sanctions against Russia, increasing economic and political pressure in response to the ongoing aggression against Ukraine. The new restrictions target companies, financial institutions, and individuals that support Russia’s military activities or help circumvent previous sanctions. Particular attention is being given to limiting access to technologies, equipment, and resources that could be used for warfare. EU officials emphasize that the sanctions policy is intended to weaken Russia’s ability to finance military operations and encourage compliance with international law. The package also demonstrates the unity of European countries in supporting Ukraine and protecting regional security. The new measures are expected to further enhance the effectiveness of previous restrictions in the future.', 'news/FBR9aEzfS88EEwfoqK2Wz6A6GUh48oCiYYAMS0J1.webp', '2026-06-03 09:30:05', '2026-06-13 04:09:23', 18, 'Politics'),
(12, 'Shakhtar advanced to the Champions League next season', 'Donetsk Shakhtar Donetsk secured its place in the next UEFA Champions League, which was an important achievement for the team and its fans. Thanks to its consistent performances throughout the season, the club has earned the right to represent Ukraine in the most prestigious European club tournament. Participation in the Champions League opens up new sporting and financial opportunities for the team, as well as a chance to compete with the strongest clubs in Europe. The coaching staff and players are already starting preparations for the upcoming international matches. The fans hope that the team will be able to perform well on the European stage and achieve high results in the new season.', 'news/3Ahp75GWhHsPoW3rliKwf5E8AMIH1zL5ubbecd2Y.jpg', '2026-06-03 09:30:58', '2026-06-13 04:07:40', 9, 'Sports'),
(13, 'Global markets rise on US news', 'Global financial markets are showing positive momentum amid important economic news from the United States. Investors responded favorably to data on the economy, labor market, and inflation, which came in better than analysts had expected. Major stock indices are rising not only in the United States but also across European and Asian markets.\r\nExperts believe that market optimism is linked to the possibility of monetary policy easing and the continued stability of economic growth. At the same time, investors remain closely focused on decisions by the Federal Reserve and on global economic risks. The current market gains indicate an improvement in sentiment across international financial markets.', 'news/lZ8wVc3NhP4tDNfgXnlVU9sGpMmJKBieFMci0i4Q.avif', '2026-06-03 09:32:12', '2026-06-13 04:06:24', 1, 'World'),
(14, 'The government announced a new community support program', 'The government has introduced a new program to support local communities aimed at developing infrastructure and improving the quality of life of the population. The initiative provides for financing road repairs, modernization of schools, hospitals and municipal facilities. According to officials, special attention will be paid to small towns and rural areas that need additional resources for development. The program is expected to help create new jobs and attract investment to the regions. Representatives of local authorities positively assessed the innovation and expressed hope for the rapid implementation of the planned projects. The first stages of financing will begin in the coming months across the country.', 'news/JhF8ptIgQeA0TDAbFin2XImUPBcUKf8DvVJxmbAf.jpg', '2026-06-03 09:37:32', '2026-06-14 08:01:21', 4, 'Politics'),
(15, 'Parliament approved a package of economic reforms', 'The Parliament supported a package of economic reforms that should stimulate business development and improve the investment climate. The legislative changes provide for the simplification of administrative procedures, reduction of bureaucratic barriers and improvement of the tax system. Experts believe that such steps can positively affect economic growth and attract international partners. Representatives of the business community welcomed the adoption of the reforms, emphasizing the importance of their rapid implementation. At the same time, opposition politicians called for close monitoring of the implementation of the new norms. The government stated that the implementation of the reforms would take place in stages, taking into account the needs of entrepreneurs and the economic situation in the country.', 'news/ikbfbhFnXqKYY7etdgqCJe7p58nXtA3pq7KkaNL0.jpg', '2026-06-03 09:38:12', '2026-06-13 03:59:39', 1, 'Politics'),
(16, 'Ministers discussed the development of digital services', 'At the government meeting, ministers discussed the further development of digital services for citizens and businesses. The main topic was the modernization of government services and the introduction of new online tools for receiving administrative services. According to the meeting participants, digitalization will reduce the time for processing documents and make government procedures more transparent. It is also planned to expand the capabilities of electronic identification and introduce new services in mobile applications. Experts note that such solutions will help increase the efficiency of government institutions. The first updates should become available to users in the near future.', 'news/rq9T9AafdCBQYu41RRT0Iz46uOFyJ4sXmSUHRbww.jpg', '2026-06-03 09:38:58', '2026-06-13 03:58:03', 1, 'Politics'),
(17, 'An international delegation visited the capital', 'An international delegation arrived in the capital to hold negotiations on cooperation in the economic and humanitarian spheres. During the meetings, the parties discussed the possibilities of implementing joint projects, supporting investments and developing trade relations. Particular attention was paid to issues of education, energy and technology. Representatives of the delegation noted the positive dynamics of cooperation and readiness for further expansion of partnership. As a result of the negotiations, preliminary agreements were reached on new interaction programs. It is expected that the results of the meetings will contribute to strengthening international ties and open up additional opportunities for economic development.', 'news/8QnvPUFBfqCx5FRXASIIxiqak3AY41eU2807ozkP.jpg', '2026-06-03 09:39:30', '2026-06-13 03:56:27', 6, 'Politics'),
(18, 'Regions will receive additional funding', 'The government has approved a decision to allocate additional funding for regional development programs. The funds are planned to be used to modernize transport infrastructure, support social projects, and upgrade utility networks. According to government officials, this will allow for the acceleration of the implementation of important initiatives on the ground and increase the level of comfort for residents. Funding will be distributed taking into account the needs of each region and the priority of projects. Local administrations are already preparing proposals for the use of the resources received. It is expected that the implementation of the program will have a positive impact on the socio-economic development of communities in the coming years.', 'news/4LojoPdhHjuqI8XqRgxy03CobfejpsCSjhCqhYTS.jpg', '2026-06-03 09:40:24', '2026-06-13 03:55:53', 6, 'Politics'),
(19, 'The team won an important victory', 'The national team demonstrated a confident game and won an important victory in the next match of the international tournament. The team actively started the match and already in the first half of the game created several dangerous moments. Thanks to the coordinated actions of the players and competent tactics of the coaching staff, a positive result was achieved. The fans actively supported the athletes throughout the match, creating a wonderful atmosphere in the stands. After the match, the coach thanked the team for their dedication and discipline. This victory allowed the team to improve its tournament position and get closer to fulfilling the set sporting goals.', 'news/TGtyaljkTDMmzXPe2BzyyT86DVtB5F3OxjxPSDNq.jpg', '2026-06-03 09:41:04', '2026-06-13 03:54:55', 2, 'Sports'),
(20, 'A new record was set at the championship', 'During the national championship, a new sports record was set, which became one of the main events of the competition. The athlete demonstrated excellent training and surpassed the previous achievement, which had been held for several years. The audience warmly welcomed the record holder, and experts highly appreciated his result. According to the coach, the success was the result of hard training and careful preparation for the season. The organizers noted the high level of the tournament participants and the significant interest of the fans in the competition. It is expected that the new record will become an additional motivation for young athletes and will contribute to the popularization of the sport.', 'news/Fs3nkquvIFO0DGC1EB5nFezECapYSXLUao6VwZ8A.jpg', '2026-06-03 09:41:42', '2026-06-13 03:40:03', 1, 'Sports'),
(21, 'The football club presented its newcomers', 'The management of the football club officially introduced the new players who joined the team before the start of the season. The newcomers have already completed their first training sessions and have become familiar with the requirements of the coaching staff. The club representatives are confident that strengthening the squad will help achieve the goals set in national and international tournaments. During the presentation, the players thanked for the trust and promised to make every effort for successful performances. The fans positively received the personnel changes and expressed their support for the new team members. The first matches of the season will show how effective the new transfers will be.', 'news/vScaRLvlLndzeqdusW1Sv1LGEZCiKHjZH84np4Rh.jpg', '2026-06-03 09:43:23', '2026-06-13 03:39:30', 3, 'Sports'),
(22, 'A modern sports complex has opened in the city', 'The grand opening of the new sports complex took place with the participation of local authorities, athletes and city residents. The facility is equipped with modern training halls, a swimming pool and playgrounds for various sports. According to the organizers, the complex will become an important center for the development of physical culture and holding sports events. Special attention was paid to creating comfortable conditions for children and youth. It is expected that the new infrastructure will help attract more people to an active lifestyle. In the near future, they plan to hold training sessions, tournaments and other sports events here.', 'news/I0knnmfz67skwg0LAxopDbYvDKo8QClRLLSW5MZH.jpg', '2026-06-03 09:44:05', '2026-06-13 03:39:00', 2, 'Sports'),
(23, 'The tournament attracted a record number of participants', 'This year\'s annual sports tournament set a record for the number of participants and guests. Athletes from different regions took part in the competition, demonstrating a high level of skill and training. The organizers prepared a rich program that included performances by professionals and amateurs. Spectators had the opportunity to watch the intense competition and support their favorites. At the end of the tournament, the winners received awards and commemorative medals. Representatives of the sports community noted the importance of such events for promoting a healthy lifestyle and developing young talents.', 'news/c9v958xk01j3rqqpGgaynC2NXX19X9XHc28bBJJF.jpg', '2026-06-03 09:48:54', '2026-06-13 03:38:26', 2, 'Sports'),
(24, 'Scientists announced a new discovery', 'An international group of researchers has announced an important scientific discovery that could impact the further development of technologies. According to scientists, the results of many years of research open up new opportunities for the practical application of innovative solutions in various industries. The scientific community is already actively discussing potential prospects and directions for further research. Experts emphasize that the discovery requires additional study, but its significance is already highly appreciated. The results of the work were presented at an international conference and aroused considerable interest among the participants. Further tests are planned to be carried out in the near future.', 'news/WVDiC79UYTXdxkXZujcr2kqBqgtXqC17DPJrBRkw.jpg', '2026-06-03 09:49:30', '2026-06-13 03:36:45', 4, 'World'),
(25, 'The airline opened a new route', 'One of the largest airlines has announced the launch of a new international route that will connect several popular tourist destinations. Representatives of the carrier noted that the new flight will help improve transport connections and meet the growing demand among passengers. The first flight took place on schedule and was successful. Local authorities positively assessed the launch of the route, emphasizing its importance for the development of tourism and business. The new air connection is expected to contribute to an increase in tourist flows and create additional opportunities for international cooperation between regions.', 'news/xol32n9WRVeKhLZusTwhcZZyJqsmpfMbq1NVVTEp.jpg', '2026-06-03 09:50:12', '2026-06-13 03:34:30', 2, 'World'),
(26, 'Space mission successfully achieved its goal', 'The international space mission has successfully completed a key stage of the program after a long period of preparation. The spacecraft transmitted the first data, which are already being analyzed by specialists. Project representatives noted that the results exceeded initial expectations and open up new opportunities for scientific research. Specialists from several countries participated in the implementation of the mission, which became an example of effective international cooperation. Experts emphasize the importance of the data obtained for further study of space. The next stages of the mission involve collecting additional information and conducting new experiments.', 'news/TxbuT3Y8Rye3PMC3VBM9Z59KTb1WhQnho97ipm7k.jpg', '2026-06-03 09:50:55', '2026-06-13 03:33:54', 1, 'World'),
(27, 'International forum launched in the capital', 'A large-scale international forum has begun in the capital, bringing together representatives of business, science and the public sector. Participants are discussing issues of innovation, economic development and global challenges of our time. The organizers have prepared a number of panel discussions, presentations and thematic meetings. Special attention is paid to finding new ways of international cooperation and introducing modern technologies. Experts believe that the results of the forum can become the basis for future partnership projects. The event will last several days and will end with the signing of joint declarations and recommendations.', 'news/qseXXuTQAkKcCn6DUIDDtsWDMA9xFHwF9AuYNmip.jpg', '2026-06-03 09:51:22', '2026-06-13 03:33:02', 2, 'World'),
(28, 'Environmental initiative unites countries', 'Several countries have announced the launch of a large-scale environmental initiative aimed at protecting the environment and reducing harmful emissions. The program involves the implementation of joint projects in the field of renewable energy and energy efficiency. Representatives of the countries emphasized the importance of international cooperation to achieve environmental goals. Experts note that such steps can have a positive impact on the environment and contribute to sustainable development. The initiative plans to conduct research, exchange experience and implement new technological solutions. The first results are expected in the coming years.', 'news/5V0OKm2fs5gJV1TWbBqDbe9Ptnz9ZaFphFZSYlRP.jpg', '2026-06-03 09:51:52', '2026-06-11 13:08:11', 2, 'World'),
(29, 'A new exhibition opened at the museum', 'The city museum opened a new exhibition dedicated to contemporary art and creative experiments by young artists. The exhibition features paintings, installations, and multimedia works that reflect current topics. The organizers note that the project is designed to support talented artists and interest a wide audience in cultural events. The first visitors positively assessed the exhibition and noted its originality. Thematic meetings, excursions, and master classes are planned for the coming weeks. The exhibition will be open to the public for several months.', 'news/0eV5cyI0KEVxwLEq46CoKJ8eEe02meM3nvPiCKjb.webp', '2026-06-03 09:52:19', '2026-06-10 18:32:01', 1, 'Culture'),
(30, 'The arts festival attracted thousands of guests', 'The annual arts festival has opened in the city center and attracted thousands of visitors. The event program includes musical performances, theater productions, art exhibitions and creative workshops. Organizers emphasize that the festival contributes to the development of cultural life and the support of young talents. Guests have the opportunity to get acquainted with the works of artists from different regions and take part in thematic events. The festive atmosphere has attracted the attention of both local residents and tourists. The event will last several days and will end with a large gala concert with the participation of famous performers.', 'news/kVVzzRkiWBvjYaudxNeKkIq1j4Go5uiYZdt0vbyx.jpg', '2026-06-03 09:52:48', '2026-06-17 05:25:53', 5, 'Culture'),
(31, 'The theater presented the season premiere', 'The City Theater presented the long-awaited premiere of the new season, which aroused considerable interest among the audience. The production combines a modern approach to directing and classical theatrical traditions. The actors demonstrated a high level of skill, and the scenography created a special atmosphere for the development of the plot. After the performance, the audience applauded the creative team for a long time. Critics positively assessed the premiere and noted its artistic value. The theater plans to include the performance in the main repertoire and present it at several art festivals.', 'news/n9gZcxcDuWDScH5nOas8Bka2UmOhqUnVjt1QVOTL.jpg', '2026-06-03 09:53:19', '2026-06-17 05:11:25', 10, 'Culture'),
(32, 'The library launched an educational project', 'The Central Library has announced the launch of a new educational project for children and adults. The initiative includes lectures, literary meetings, master classes, and interactive classes. The organizers aim to promote reading and make cultural events more accessible to a wide audience. Participants will be able to talk to writers, teachers, and experts from various fields. The first events have aroused considerable interest among city residents. Library representatives are convinced that the project will contribute to the development of education, creativity, and cultural exchange between different generations.', 'news/47wrUVAy3LDxZRTNlBYREehXfGHIee1LtLjsCpIb.jpg', '2026-06-03 09:53:49', '2026-06-17 05:11:24', 47, 'Culture'),
(33, 'The famous band announced a new album', 'The popular music band announced the completion of work on a new studio album, the release of which will take place in the near future. The musicians said that during the recording they experimented with the sound and worked on creating original material. Fans are actively discussing the upcoming release on social networks and are waiting for the presentation of new compositions. Representatives of the band also announced a series of concerts in support of the album. Music industry experts predict high interest in the new work of the performers. Additional details about the release are promised to be announced in the coming weeks.', 'news/kjoO9PnWlJJeebx5J4SaTO8pksbP3xZpfazSqY60.jpg', '2026-06-03 09:54:21', '2026-06-17 05:21:23', 58, 'Culture');

-- --------------------------------------------------------

--
-- Структура таблиці `news_views`
--

CREATE TABLE `news_views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `news_id` bigint(20) UNSIGNED NOT NULL,
  `viewed_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `news_views`
--

INSERT INTO `news_views` (`id`, `user_id`, `news_id`, `viewed_at`, `created_at`, `updated_at`) VALUES
(1, 1, 11, '2026-06-13 04:07:48', NULL, NULL),
(2, 1, 10, '2026-06-13 05:30:43', NULL, NULL),
(3, 1, 12, '2026-06-13 04:07:16', NULL, NULL),
(4, 1, 17, '2026-06-13 03:55:59', NULL, NULL),
(5, 1, 25, '2026-06-13 03:33:58', NULL, NULL),
(6, 1, 19, '2026-06-13 03:54:23', NULL, NULL),
(7, 1, 14, '2026-06-13 03:59:44', NULL, NULL),
(8, 1, 21, '2026-06-13 03:39:06', NULL, NULL),
(9, 1, 23, '2026-06-13 03:37:56', NULL, NULL),
(12, 1, 32, '2026-06-17 05:11:24', NULL, NULL),
(13, 2, 32, '2026-06-14 08:24:48', NULL, NULL),
(14, 2, 33, '2026-06-14 08:25:07', NULL, NULL),
(15, 2, 31, '2026-06-10 18:30:09', NULL, NULL),
(16, 2, 30, '2026-06-10 18:30:52', NULL, NULL),
(17, 2, 29, '2026-06-10 18:31:27', NULL, NULL),
(18, 2, 28, '2026-06-11 13:08:11', NULL, NULL),
(19, 2, 27, '2026-06-10 18:32:47', NULL, NULL),
(20, 1, 33, '2026-06-17 05:21:23', NULL, NULL),
(22, 1, 27, '2026-06-13 03:33:02', NULL, NULL),
(23, 1, 26, '2026-06-13 03:33:26', NULL, NULL),
(24, 1, 24, '2026-06-13 03:36:07', NULL, NULL),
(25, 1, 22, '2026-06-13 03:38:35', NULL, NULL),
(26, 1, 20, '2026-06-13 03:39:36', NULL, NULL),
(27, 1, 18, '2026-06-13 03:55:09', NULL, NULL),
(28, 1, 16, '2026-06-13 03:57:32', NULL, NULL),
(29, 1, 15, '2026-06-13 03:58:08', NULL, NULL),
(30, 1, 13, '2026-06-13 04:01:16', NULL, NULL),
(31, 1, 31, '2026-06-17 05:11:25', NULL, NULL),
(32, 1, 30, '2026-06-17 05:25:53', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблиці `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2026-05-31 17:46:54', '2026-05-31 17:46:54'),
(2, 'helper', 'web', '2026-05-31 17:46:54', '2026-05-31 17:46:54'),
(3, 'reader', 'web', '2026-05-31 17:46:54', '2026-05-31 17:46:54');

-- --------------------------------------------------------

--
-- Структура таблиці `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `saved_news`
--

CREATE TABLE `saved_news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `news_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `saved_news`
--

INSERT INTO `saved_news` (`id`, `user_id`, `news_id`, `created_at`, `updated_at`) VALUES
(18, 1, 30, '2026-06-17 05:25:56', '2026-06-17 05:25:56');

-- --------------------------------------------------------

--
-- Структура таблиці `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_name` varchar(255) NOT NULL DEFAULT 'News',
  `theme_color` varchar(255) NOT NULL DEFAULT '#8b5cf6',
  `sidebar_width` int(11) NOT NULL DEFAULT 260,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `settings`
--

INSERT INTO `settings` (`id`, `site_name`, `theme_color`, `sidebar_width`, `created_at`, `updated_at`) VALUES
(1, 'ADMIN PANEL', '#1c1717', 900, '2026-06-02 07:38:50', '2026-06-13 04:10:16');

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@admin.com', NULL, '$2y$12$5br5Bp.9mgcxTWiJOSLq/uQkiXyDTdrwIB4UCEDVp6krRmn135X5O', '4VE2d0OTtwrBdb3ipPdAd3hqhG8GOK7gzJvCJwTCK8Pu2S73UWz6UgjtXMWd', '2026-05-31 17:08:24', '2026-06-17 05:25:32'),
(2, 'Helper', 'helper@helper.com', NULL, '$2y$12$UA2.0MmU8J27UcwMX8z9mOM3cxBpkJxaAlHjnyMERuQW9TOV10yPG', NULL, '2026-06-01 14:07:07', '2026-06-09 16:57:39'),
(4, 'Reader', 'reader@reader.com', NULL, '$2y$12$.1.0iYIAk/pxqSmmYFpLMe9RSBLAmknEKjYkPmZ.DCKyojrK9vc4a', NULL, '2026-06-14 09:42:03', '2026-06-14 09:42:03');

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Індекси таблиці `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Індекси таблиці `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_foreign` (`user_id`),
  ADD KEY `comments_news_id_foreign` (`news_id`);

--
-- Індекси таблиці `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_user_id_foreign` (`user_id`),
  ADD KEY `contacts_topic_index` (`topic`),
  ADD KEY `contacts_status_index` (`status`),
  ADD KEY `contacts_created_at_index` (`created_at`);

--
-- Індекси таблиці `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Індекси таблиці `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Індекси таблиці `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Індекси таблиці `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Індекси таблиці `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `news_views`
--
ALTER TABLE `news_views`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_views_user_id_news_id_unique` (`user_id`,`news_id`),
  ADD KEY `news_views_news_id_foreign` (`news_id`);

--
-- Індекси таблиці `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Індекси таблиці `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Індекси таблиці `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Індекси таблиці `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Індекси таблиці `saved_news`
--
ALTER TABLE `saved_news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `saved_news_user_id_news_id_unique` (`user_id`,`news_id`),
  ADD KEY `saved_news_news_id_foreign` (`news_id`);

--
-- Індекси таблиці `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Індекси таблиці `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблиці `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблиці `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблиці `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT для таблиці `news_views`
--
ALTER TABLE `news_views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT для таблиці `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблиці `saved_news`
--
ALTER TABLE `saved_news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблиці `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблиці `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_news_id_foreign` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `news_views`
--
ALTER TABLE `news_views`
  ADD CONSTRAINT `news_views_news_id_foreign` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `news_views_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `saved_news`
--
ALTER TABLE `saved_news`
  ADD CONSTRAINT `saved_news_news_id_foreign` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `saved_news_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
