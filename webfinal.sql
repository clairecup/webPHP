-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2021 年 06 月 21 日 16:11
-- 伺服器版本： 10.4.19-MariaDB
-- PHP 版本： 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫: `webFINAL`
--

-- --------------------------------------------------------

--
-- 資料表結構 `admin`
--

CREATE TABLE `admin` (
  `aid` int(11) NOT NULL COMMENT '管理流水號',
  `uid` int(11) NOT NULL COMMENT '會員id',
  `fid` int(5) NOT NULL COMMENT '管理看板'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `admin`
--

INSERT INTO `admin` (`aid`, `uid`, `fid`) VALUES
(1, 1, 0),
(7, 2, 2),
(23, 4, 18),
(24, 5, 1),
(25, 13, 22),
(26, 14, 23),
(27, 18, 24),
(28, 22, 25),
(29, 25, 26);

-- --------------------------------------------------------

--
-- 資料表結構 `forum`
--

CREATE TABLE `forum` (
  `fid` int(5) NOT NULL COMMENT '討論區id',
  `forum` varchar(15) NOT NULL COMMENT '討論區名稱',
  `animal` varchar(11) NOT NULL,
  `introduce` varchar(256) DEFAULT NULL,
  `nickname` varchar(32) DEFAULT NULL,
  `features` varchar(64) DEFAULT NULL,
  `characters` varchar(64) DEFAULT NULL,
  `places` varchar(64) DEFAULT NULL,
  `socialmedia` varchar(256) DEFAULT NULL,
  `imageurl` varchar(128) DEFAULT 'images/defalt.png',
  `iconurl` varchar(128) DEFAULT 'images/defalt.png',
  `mapIcon` varchar(64) NOT NULL DEFAULT 'images/defalt.png' COMMENT '地圖ICON'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `forum`
--

INSERT INTO `forum` (`fid`, `forum`, `animal`, `introduce`, `nickname`, `features`, `characters`, `places`, `socialmedia`, `imageurl`, `iconurl`, `mapIcon`) VALUES
(1, '小橘', 'cat', '嗨，我是小橘，住在政大莊九女宿外，今年四歲，經常在女宿外面賣萌睡覺，喜歡的東西是肉泥、枯樹枝、名車與太陽。', '火星、虎皮', '貓如其名、金瞳孔', '慵懶愜意、善於放電而不自知', '莊敬九舍、教育系館、憩賢樓', 'https://www.instagram.com/littleorange_nccu/', 'images/orange.jpg', 'images/icon_orange.png', 'images/AnimalIcon1.png'),
(2, '花花', 'dog', '大家好，我是政大花花！今年不知道幾歲！興趣是閉眼聽課，專長是搭電梯，綜院跟國際大樓都會。', '斑斑、大花、胖花', '深色玳瑁花紋、有戴項圈', '溫和沉穩，十分好學，政大校園最友善的狗狗', '山上山下都可以看到花花的足跡！', 'https://www.instagram.com/huahualufyou/', 'images/huahua.jpg', 'images/icon_huahua.png', 'images/AnimalIcon2.png'),
(3, '胖虎', 'cat', '愛被拍屁股、沒節操、 超級聰明的肥大叔。', '阿肥、老大', '深色虎斑貓、綠瞳孔', '任性、桀傲不遜、自由奔放', '莊外、莊內', 'https://www.instagram.com/fluffycat_fatty/', 'images/tiger.jpg', 'images/icon_tiger.png', 'images/AnimalIcon3.png'),
(18, '草尼馬', 'others', '羊駝（學名：Vicugna pacos；西班牙語：Alpaca、英語：Alpaca），又名駝羊，俗稱草泥馬，屬偶蹄目駱駝科，外形有點像綿羊，一般在高原生活，世界現有羊駝約300萬隻左右，約90%以上生活在南美洲的祕魯及智利的高原上。\n政大有一隻很神奇ㄝ', '馬馬', '毛茸茸', '兇兇', '河堤、星巴克、私房面', '', './images/1623405833.jpg', 'images/defalt.png', 'images/defalt.png'),
(19, '賓士', 'cat', '小公寓貓貓', '', '', '', '', '', 'images/defalt.png', 'images/defalt.png', 'images/defalt.png'),
(20, '穿山甲', 'others', '', '', '', '', '', '', './images/1623413802.png', 'images/defalt.png', 'images/defalt.png'),
(22, '鯊魚', 'others', '我是小鯊魚', '沙沙', '', '', '', '', 'images/defalt.png', 'images/defalt.png', 'images/defalt.png'),
(23, '艾莉鯊鯊', 'others', '我是鯊魚喔！！！', '', '', '', '', '', 'images/defalt.png', 'images/defalt.png', 'images/defalt.png'),
(24, '酷冰鯊', 'others', '有夠酷', '', '', '', '', '', 'images/defalt.png', 'images/defalt.png', 'images/defalt.png'),
(25, '養樂多', 'others', '我好好喝', '', '', '', '', '', 'images/defalt.png', 'images/defalt.png', 'images/defalt.png'),
(26, '哀鳳11', 'others', '我很貴', '', '', '', '', '', 'images/defalt.png', 'images/defalt.png', 'images/defalt.png');

-- --------------------------------------------------------

--
-- 資料表結構 `member`
--

CREATE TABLE `member` (
  `uid` int(11) NOT NULL COMMENT '會員ID',
  `preference` varchar(11) NOT NULL COMMENT '貓派、犬派、全部',
  `username` varchar(256) NOT NULL COMMENT '會員帳號',
  `password` varchar(256) NOT NULL COMMENT '會員密碼',
  `nickname` varchar(256) NOT NULL COMMENT '會員暱稱'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `member`
--

INSERT INTO `member` (`uid`, `preference`, `username`, `password`, `nickname`) VALUES
(1, 'all', 'admin', '900150983cd24fb0d6963f7d28e17f72', 'admin'),
(2, 'dog', 'b', '92eb5ffee6ae2fec3ad71c777531578f', 'b'),
(3, 'cat', 'c', '4a8a08f09d37b73795649038408b5f33', 'c'),
(4, 'all', 'd', '8277e0910d750195b448797616e091ad', 'd'),
(5, 'dog', 'e', 'e1671797c52e15f763380b45e841ec32', 'e'),
(7, 'all', 'trytrysee', '6e1a75b113f246a57086d11959c76b29', 'trytrysee'),
(8, 'all', 'try', '080f651e3fcca17df3a47c2cecfcb880', 'try'),
(9, 'dog', 'cool', 'b1f4f9a523e36fd969f4573e25af4540', 'cool'),
(10, 'all', 'teatteat', 'b13202dd0865e9910b9f906abf68c1d9', 'teatteat'),
(11, 'all', 'trytrytry', 'fbe8ca2f069f63a4d8e3d58d7638c8d0', 'trytrytry'),
(12, 'dog', 'lol', '9cdfb439c7876e703e307864c9167a15', 'lol'),
(13, 'dog', 'wow', 'bcedc450f8481e89b1445069acdc3dd9', 'wow'),
(14, 'dog', 'qaq', '563ba72ccf2593689f6d215b93eb48b3', 'qaq'),
(15, 'all', '1', 'c4ca4238a0b923820dcc509a6f75849b', '1'),
(16, 'all', 'hihi', 'e9f5713dec55d727bb35392cec6190ce', '我都不喜歡怎麼辦'),
(17, 'all', '123', '202cb962ac59075b964b07152d234b70', '123'),
(18, 'dog', 'www', '4eae35f1b35977a00ebd8086c259d4c9', 'www'),
(19, 'all', 'helloo', 'b373870b9139bbade83396a49b1afc9a', 'helloo!!!'),
(20, 'all', 'catlover', 'ee077a4cdd6dc2cd26cded6db444831f', 'catlover'),
(21, 'cat', 'iloveorange', '8bda9f570dfd585213061d3a4bbde3e5', 'oranger'),
(22, 'all', 'coool', '5c550692bb6fdf12a0184cc7ecab4737', 'imcool'),
(23, 'all', 'roy', 'd4c285227493531d0577140a1ed03964', 'Royal'),
(24, 'cat', 'sponge', 'f55c106c03a96f51f0b1f2b9e9454fc0', 'spongebob'),
(25, 'cat', 'cool123', '3794e979a93e7ac532b748c877316322', 'cooler'),
(26, 'all', '107', 'c39287d312d814d143e0a4d1051ffc91', '刺客'),
(27, 'all', 'TA', '81dc9bdb52d04dc20036dbd8313ed055', 'TA'),
(28, 'all', 'cc125487', 'dac5c2e573c43768bece513607c17745', '龜'),
(29, 'all', 'test123', 'cc03e747a6afbbcbf8be7668acfebee5', '123'),
(30, 'cat', 'slmt', '098f6bcd4621d373cade4e832627b4f6', 'SLMT'),
(31, 'all', 'aloha', '202cb962ac59075b964b07152d234b70', 'aloha123'),
(32, 'all', '1231', '202cb962ac59075b964b07152d234b70', 'hihi'),
(33, 'all', '321', 'caf1a3dfb505ffed0d024130f58c5cfa', '&lt;script&gt;alert(\\\'OAO\\\');&lt;/script&gt;'),
(34, 'all', '12345', '827ccb0eea8a706c4c34a16891f84e7b', '123'),
(35, 'all', '111', '698d51a19d8a121ce581499d7b701668', '111'),
(36, 'cat', 'f', '8fa14cdd754f91cc6554c9e71929cce7', 'f');

-- --------------------------------------------------------

--
-- 資料表結構 `message1`
--

CREATE TABLE `message1` (
  `mid` int(11) NOT NULL COMMENT '文章id',
  `uid` int(11) NOT NULL COMMENT '貼文者id',
  `title` varchar(256) NOT NULL COMMENT '標題',
  `content` varchar(1024) NOT NULL COMMENT '內容',
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
  `longitude` double NOT NULL COMMENT '經度',
  `latitude` double NOT NULL COMMENT '緯度',
  `health` varchar(11) NOT NULL COMMENT '健康狀態',
  `feed` varchar(11) NOT NULL COMMENT '有無餵食',
  `imageurl` varchar(128) DEFAULT NULL,
  `ip` varchar(64) NOT NULL COMMENT '發文者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `message1`
--

INSERT INTO `message1` (`mid`, `uid`, `title`, `content`, `time`, `longitude`, `latitude`, `health`, `feed`, `imageurl`, `ip`) VALUES
(1, 2, '小橘', '小橘', '2021-06-05 14:24:26', 121.57648206320519, 24.987197754293412, 'healthy', 'nofeed', NULL, '::1'),
(2, 1, '測試', '測試測試', '2021-06-06 18:07:16', 121.58142205323983, 24.984221979014727, 'healthy', 'nofeed', NULL, '::1'),
(7, 1, 'test2', 'test2', '2021-06-11 09:07:43', 121.57252472457712, 24.98785266293052, 'healthy', 'nofeed', NULL, '::1'),
(10, 2, 'test3', 'test3', '2021-06-11 11:58:03', 121.57407617565697, 24.984713782513452, 'healthy', 'nofeed', './images/1623412443.png', '::1'),
(11, 1, '橘', '橘橘', '2021-06-13 15:35:17', 121.57718044934187, 24.989574434450226, 'healthy', 'nofeed', NULL, '180.218.130.153'),
(12, 1, '小橘', '小橘小橘小橘小橘', '2021-06-13 15:39:26', 0, 0, 'healthy', 'nofeed', NULL, '180.218.130.153'),
(13, 11, '剛剛發現了小橘', '好大的小橘', '2021-06-14 09:09:45', 121.57501417067255, 24.9874869404814, 'healthy', 'nofeed', './images/1623661758.jpg', '27.242.32.172'),
(14, 12, '我剛剛看到好多小橘', '小橘小橘', '2021-06-14 09:20:45', 121.57507386351278, 24.986008729018007, 'healthy', 'nofeed', './images/1623662429.jpg', '27.242.32.172'),
(24, 27, '&lt;script&gt;alert(\\&quot;OAO\\&quot;);&lt;/script&gt;', '&lt;script&gt;alert(\\&quot;OAO\\&quot;);&lt;/script&gt;', '2021-06-15 03:47:15', 121.57668132234586, 24.9876139682342, 'unhealthy', 'nofeed', NULL, '106.105.103.145'),
(25, 30, 'Meme', 'It\\\'s Fine', '2021-06-15 07:09:22', 0, 0, 'healthy', 'nofeed', './images/1623740960.jpg', '114.37.136.239'),
(26, 30, 'GPS Test', 'Nothing to worry.', '2021-06-15 07:10:26', 121.54026958198106, 24.992048309335942, 'healthy', 'nofeed', NULL, '114.37.136.239');

-- --------------------------------------------------------

--
-- 資料表結構 `message2`
--

CREATE TABLE `message2` (
  `mid` int(11) NOT NULL COMMENT '文章id',
  `uid` int(11) NOT NULL COMMENT '貼文者id',
  `title` varchar(256) NOT NULL COMMENT '標題',
  `content` varchar(1024) NOT NULL COMMENT '內容',
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
  `longitude` double NOT NULL COMMENT '經度',
  `latitude` double NOT NULL COMMENT '緯度',
  `health` varchar(11) NOT NULL COMMENT '健康狀態',
  `feed` varchar(11) NOT NULL COMMENT '有無餵食',
  `imageurl` varchar(128) DEFAULT NULL,
  `ip` varchar(64) NOT NULL COMMENT '發文者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `message2`
--

INSERT INTO `message2` (`mid`, `uid`, `title`, `content`, `time`, `longitude`, `latitude`, `health`, `feed`, `imageurl`, `ip`) VALUES
(2, 1, '花花比穿山甲可愛', '花花比穿山甲可愛', '2021-06-11 13:23:42', 0, 0, 'healthy', 'nofeed', './images/1623417801.png', '::1'),
(3, 4, '急徵罐罐', '花花肚子餓\n急徵罐罐', '2021-06-13 13:45:57', 121.5746064219959, 24.985391996988444, 'healthy', 'nofeed', './images/1623591913.png', '180.218.130.153');

-- --------------------------------------------------------

--
-- 資料表結構 `message3`
--

CREATE TABLE `message3` (
  `mid` int(11) NOT NULL COMMENT '文章id',
  `uid` int(11) NOT NULL COMMENT '貼文者id',
  `title` varchar(256) NOT NULL COMMENT '標題',
  `content` varchar(1024) NOT NULL COMMENT '內容',
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
  `longitude` double NOT NULL COMMENT '經度',
  `latitude` double NOT NULL COMMENT '緯度',
  `health` varchar(11) NOT NULL COMMENT '健康狀態',
  `feed` varchar(11) NOT NULL COMMENT '有無餵食',
  `imageurl` varchar(128) DEFAULT NULL,
  `ip` varchar(64) NOT NULL COMMENT '發文者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `message3`
--

INSERT INTO `message3` (`mid`, `uid`, `title`, `content`, `time`, `longitude`, `latitude`, `health`, `feed`, `imageurl`, `ip`) VALUES
(1, 2, '胖虎', '胖虎', '2021-06-05 14:25:22', 0, 0, 'healthy', 'nofeed', NULL, '::1'),
(2, 1, 'test1', 'test1', '2021-06-11 12:09:04', 121.57712531083236, 24.987820129713405, 'healthy', 'nofeed', './images/1623413316.png', '::1'),
(3, 1, '哈哈', '哈哈', '2021-06-11 13:22:56', 121.57502313106113, 24.985003855825596, 'healthy', 'nofeed', NULL, '::1'),
(4, 3, '喵', '喵喵', '2021-06-13 14:39:57', 121.5724251268143, 24.983769285919617, 'healthy', 'nofeed', './images/1623595159.png', '180.218.130.153'),
(5, 28, 'お令和ジャイアン', '我是胖虎我是孩子王', '2021-06-15 03:09:19', 0, 0, 'healthy', 'nofeed', './images/1623726428.jpg', '203.77.34.72'),
(6, 33, '321', '321', '2021-06-15 13:40:13', 0, 0, 'healthy', 'nofeed', NULL, '220.136.80.66');

-- --------------------------------------------------------

--
-- 資料表結構 `message18`
--

CREATE TABLE `message18` (
  `mid` int(11) NOT NULL COMMENT '文章id',
  `uid` int(11) NOT NULL COMMENT '貼文者id',
  `title` varchar(256) NOT NULL COMMENT '標題',
  `content` varchar(1024) NOT NULL COMMENT '內容',
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
  `longitude` double NOT NULL COMMENT '經度',
  `latitude` double NOT NULL COMMENT '緯度',
  `health` varchar(11) NOT NULL COMMENT '健康狀態',
  `feed` varchar(11) NOT NULL COMMENT '有無餵食',
  `imageurl` varchar(128) DEFAULT NULL,
  `ip` varchar(64) NOT NULL COMMENT '發文者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `message18`
--

INSERT INTO `message18` (`mid`, `uid`, `title`, `content`, `time`, `longitude`, `latitude`, `health`, `feed`, `imageurl`, `ip`) VALUES
(1, 1, '挖', '挖', '2021-06-11 13:22:25', 121.57804932223598, 24.98149314789999, 'healthy', 'nofeed', NULL, '::1');

-- --------------------------------------------------------

--
-- 資料表結構 `message19`
--

CREATE TABLE `message19` (
  `mid` int(11) NOT NULL COMMENT '文章id',
  `uid` int(11) NOT NULL COMMENT '貼文者id',
  `title` varchar(256) NOT NULL COMMENT '標題',
  `content` varchar(1024) NOT NULL COMMENT '內容',
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
  `longitude` double NOT NULL COMMENT '經度',
  `latitude` double NOT NULL COMMENT '緯度',
  `health` varchar(11) NOT NULL COMMENT '健康狀態',
  `feed` varchar(11) NOT NULL COMMENT '有無餵食',
  `imageurl` varchar(128) DEFAULT NULL,
  `ip` varchar(64) NOT NULL COMMENT '發文者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `message19`
--

INSERT INTO `message19` (`mid`, `uid`, `title`, `content`, `time`, `longitude`, `latitude`, `health`, `feed`, `imageurl`, `ip`) VALUES
(1, 3, 'ㄚㄚㄚㄚㄚ', '有人在看你!!!', '2021-06-11 17:14:47', 121.57548631244737, 24.98763943463682, 'healthy', 'nofeed', './images/1623431640.png', '::1'),
(2, 7, '好酷', '是一輛賓士', '2021-06-13 13:54:20', 121.57638848318673, 24.985918957410227, 'unhealthy', 'feed', NULL, '27.247.164.182'),
(3, 7, '賓士', '賓士賓士', '2021-06-13 13:55:55', 121.58266735056453, 24.982502608456542, 'healthy', 'nofeed', './images/1623592549.jpg', '27.247.164.182');

-- --------------------------------------------------------

--
-- 資料表結構 `message20`
--

CREATE TABLE `message20` (
  `mid` int(11) NOT NULL COMMENT '文章id',
  `uid` int(11) NOT NULL COMMENT '貼文者id',
  `title` varchar(256) NOT NULL COMMENT '標題',
  `content` varchar(1024) NOT NULL COMMENT '內容',
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
  `longitude` double NOT NULL COMMENT '經度',
  `latitude` double NOT NULL COMMENT '緯度',
  `health` varchar(11) NOT NULL COMMENT '健康狀態',
  `feed` varchar(11) NOT NULL COMMENT '有無餵食',
  `imageurl` varchar(128) DEFAULT NULL,
  `ip` varchar(64) NOT NULL COMMENT '發文者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `message20`
--

INSERT INTO `message20` (`mid`, `uid`, `title`, `content`, `time`, `longitude`, `latitude`, `health`, `feed`, `imageurl`, `ip`) VALUES
(1, 4, '穿山甲', '穿山甲\n穿山甲\n穿山甲\n穿山甲', '2021-06-13 13:35:03', 121.57536792728935, 24.98378557443342, 'healthy', 'nofeed', './images/1623590914.png', '180.218.130.153'),
(2, 28, '昔日頭號要犯「穿山甲」詹龍欄出獄', '〔記者江志雄、王涵平／綜合報導〕昔日頭號槍擊要犯，綽號「穿山甲」的詹龍欄，申請三十四次假釋後獲准，牢獄日子逾二十載，九月二十三日假釋出獄，他步出宜蘭監獄，獨自搭計程車低調離開，返台南東山老家，詹龍欄返家後多未出門，但訪友不斷，他低調表示，暫休息一下，多陪老父，不希望太多外界打擾。\n\n六十八歲的詹龍欄出身台南，曾是綁架集團首腦，因擅長在山區潛逃得名，後來犯下殺人及擄人勒贖罪，被判處無期徒刑定讞，二○○三年入監服刑，二○○七年底移至宜蘭監獄執行。', '2021-06-15 03:10:29', 0, 0, 'healthy', 'nofeed', NULL, '203.77.34.72'),
(3, 33, '&lt;script&gt;alert(\\\'OAO\\\');&lt;/script&gt;', '&lt;script&gt;alert(\\\'OAO\\\');&lt;/script&gt;', '2021-06-15 13:40:56', 121.55641884309485, 24.988703119464162, 'healthy', 'feed', NULL, '220.136.80.66');

-- --------------------------------------------------------

--
-- 資料表結構 `message22`
--

CREATE TABLE `message22` (
  `mid` int(11) NOT NULL COMMENT '文章id',
  `uid` int(11) NOT NULL COMMENT '貼文者id',
  `title` varchar(256) NOT NULL COMMENT '標題',
  `content` varchar(1024) NOT NULL COMMENT '內容',
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
  `longitude` double NOT NULL COMMENT '經度',
  `latitude` double NOT NULL COMMENT '緯度',
  `health` varchar(11) NOT NULL COMMENT '健康狀態',
  `feed` varchar(11) NOT NULL COMMENT '有無餵食',
  `imageurl` varchar(128) DEFAULT NULL,
  `ip` varchar(64) NOT NULL COMMENT '發文者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `message23`
--

CREATE TABLE `message23` (
  `mid` int(11) NOT NULL COMMENT '文章id',
  `uid` int(11) NOT NULL COMMENT '貼文者id',
  `title` varchar(256) NOT NULL COMMENT '標題',
  `content` varchar(1024) NOT NULL COMMENT '內容',
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
  `longitude` double NOT NULL COMMENT '經度',
  `latitude` double NOT NULL COMMENT '緯度',
  `health` varchar(11) NOT NULL COMMENT '健康狀態',
  `feed` varchar(11) NOT NULL COMMENT '有無餵食',
  `imageurl` varchar(128) DEFAULT NULL,
  `ip` varchar(64) NOT NULL COMMENT '發文者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `message24`
--

CREATE TABLE `message24` (
  `mid` int(11) NOT NULL COMMENT '文章id',
  `uid` int(11) NOT NULL COMMENT '貼文者id',
  `title` varchar(256) NOT NULL COMMENT '標題',
  `content` varchar(1024) NOT NULL COMMENT '內容',
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
  `longitude` double NOT NULL COMMENT '經度',
  `latitude` double NOT NULL COMMENT '緯度',
  `health` varchar(11) NOT NULL COMMENT '健康狀態',
  `feed` varchar(11) NOT NULL COMMENT '有無餵食',
  `imageurl` varchar(128) DEFAULT NULL,
  `ip` varchar(64) NOT NULL COMMENT '發文者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `message25`
--

CREATE TABLE `message25` (
  `mid` int(11) NOT NULL COMMENT '文章id',
  `uid` int(11) NOT NULL COMMENT '貼文者id',
  `title` varchar(256) NOT NULL COMMENT '標題',
  `content` varchar(1024) NOT NULL COMMENT '內容',
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
  `longitude` double NOT NULL COMMENT '經度',
  `latitude` double NOT NULL COMMENT '緯度',
  `health` varchar(11) NOT NULL COMMENT '健康狀態',
  `feed` varchar(11) NOT NULL COMMENT '有無餵食',
  `imageurl` varchar(128) DEFAULT NULL,
  `ip` varchar(64) NOT NULL COMMENT '發文者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `message26`
--

CREATE TABLE `message26` (
  `mid` int(11) NOT NULL COMMENT '文章id',
  `uid` int(11) NOT NULL COMMENT '貼文者id',
  `title` varchar(256) NOT NULL COMMENT '標題',
  `content` varchar(1024) NOT NULL COMMENT '內容',
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
  `longitude` double NOT NULL COMMENT '經度',
  `latitude` double NOT NULL COMMENT '緯度',
  `health` varchar(11) NOT NULL COMMENT '健康狀態',
  `feed` varchar(11) NOT NULL COMMENT '有無餵食',
  `imageurl` varchar(128) DEFAULT NULL,
  `ip` varchar(64) NOT NULL COMMENT '發文者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `message26`
--

INSERT INTO `message26` (`mid`, `uid`, `title`, `content`, `time`, `longitude`, `latitude`, `health`, `feed`, `imageurl`, `ip`) VALUES
(2, 26, '來看看其他組的網頁', '不知道看到豬腳算不算動物', '2021-06-14 13:40:31', 121.57131893906293, 24.97991183775846, 'healthy', 'nofeed', NULL, '61.230.202.237'),
(3, 26, '為什麼圖片沒有傳成功', '再一次', '2021-06-14 13:41:28', 121.57865433473498, 24.986252515627797, 'healthy', 'nofeed', './images/1623678081.png', '61.230.202.237');

-- --------------------------------------------------------

--
-- 資料表結構 `respon1`
--

CREATE TABLE `respon1` (
  `rid` int(11) NOT NULL COMMENT '回覆文章id',
  `mid` int(11) NOT NULL COMMENT '文章id ',
  `uid` int(11) NOT NULL COMMENT '回覆者id ',
  `content` varchar(1024) NOT NULL COMMENT '回覆內容',
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
  `ip` varchar(64) NOT NULL COMMENT '回覆者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `respon1`
--

INSERT INTO `respon1` (`rid`, `mid`, `uid`, `content`, `time`, `ip`) VALUES
(1, 1, 2, '哇', '2021-06-05 11:00:40', '::1'),
(2, 13, 11, '好大喔', '2021-06-14 09:10:10', '27.242.32.172'),
(8, 14, 27, '&lt;script&gt;alert(\'OAO);&lt;/script&gt;', '2021-06-15 02:50:51', '106.105.103.145'),
(9, 14, 27, '點座標好像會跳到頁面最上面', '2021-06-15 02:51:28', '106.105.103.145'),
(10, 24, 30, '壞壞', '2021-06-15 07:07:36', '114.37.136.239'),
(11, 26, 27, 'test', '2021-06-15 10:07:35', '106.105.103.145');

-- --------------------------------------------------------

--
-- 資料表結構 `respon2`
--

CREATE TABLE `respon2` (
  `rid` int(11) NOT NULL COMMENT '回覆文章id',
  `mid` int(11) NOT NULL COMMENT '文章id ',
  `uid` int(11) NOT NULL COMMENT '回覆者id ',
  `content` varchar(1024) NOT NULL COMMENT '回覆內容',
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
  `ip` varchar(64) NOT NULL COMMENT '回覆者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `respon2`
--

INSERT INTO `respon2` (`rid`, `mid`, `uid`, `content`, `time`, `ip`) VALUES
(1, 3, 29, '&lt;script&gt;alert(\'OAO\');&lt;/script&gt;', '2021-06-15 07:10:47', '114.24.88.101');

-- --------------------------------------------------------

--
-- 資料表結構 `respon3`
--

CREATE TABLE `respon3` (
  `rid` int(11) NOT NULL COMMENT '回覆文章id',
  `mid` int(11) NOT NULL COMMENT '文章id ',
  `uid` int(11) NOT NULL COMMENT '回覆者id ',
  `content` varchar(1024) NOT NULL COMMENT '回覆內容',
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
  `ip` varchar(64) NOT NULL COMMENT '回覆者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `respon18`
--

CREATE TABLE `respon18` (
  `rid` int(11) NOT NULL COMMENT '回覆文章id',
  `mid` int(11) NOT NULL COMMENT '文章id ',
  `uid` int(11) NOT NULL COMMENT '回覆者id ',
  `content` varchar(1024) NOT NULL COMMENT '回覆內容',
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
  `ip` varchar(64) NOT NULL COMMENT '回覆者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `respon18`
--

INSERT INTO `respon18` (`rid`, `mid`, `uid`, `content`, `time`, `ip`) VALUES
(1, 1, 34, '哇', '2021-06-16 03:38:29', '123.110.215.91'),
(2, 1, 36, '嗨', '2021-06-20 16:57:13', '140.119.96.195');

-- --------------------------------------------------------

--
-- 資料表結構 `respon19`
--

CREATE TABLE `respon19` (
  `rid` int(11) NOT NULL COMMENT '回覆文章id',
  `mid` int(11) NOT NULL COMMENT '文章id ',
  `uid` int(11) NOT NULL COMMENT '回覆者id ',
  `content` varchar(1024) NOT NULL COMMENT '回覆內容',
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
  `ip` varchar(64) NOT NULL COMMENT '回覆者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `respon19`
--

INSERT INTO `respon19` (`rid`, `mid`, `uid`, `content`, `time`, `ip`) VALUES
(1, 3, 7, 'wow', '2021-06-13 13:56:10', '27.247.164.182');

-- --------------------------------------------------------

--
-- 資料表結構 `respon20`
--

CREATE TABLE `respon20` (
  `rid` int(11) NOT NULL COMMENT '回覆文章id',
  `mid` int(11) NOT NULL COMMENT '文章id ',
  `uid` int(11) NOT NULL COMMENT '回覆者id ',
  `content` varchar(1024) NOT NULL COMMENT '回覆內容',
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
  `ip` varchar(64) NOT NULL COMMENT '回覆者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `respon22`
--

CREATE TABLE `respon22` (
  `rid` int(11) NOT NULL COMMENT '回覆文章id',
  `mid` int(11) NOT NULL COMMENT '文章id ',
  `uid` int(11) NOT NULL COMMENT '回覆者id ',
  `content` varchar(1024) NOT NULL COMMENT '回覆內容',
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
  `ip` varchar(64) NOT NULL COMMENT '回覆者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `respon23`
--

CREATE TABLE `respon23` (
  `rid` int(11) NOT NULL COMMENT '回覆文章id',
  `mid` int(11) NOT NULL COMMENT '文章id ',
  `uid` int(11) NOT NULL COMMENT '回覆者id ',
  `content` varchar(1024) NOT NULL COMMENT '回覆內容',
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
  `ip` varchar(64) NOT NULL COMMENT '回覆者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `respon24`
--

CREATE TABLE `respon24` (
  `rid` int(11) NOT NULL COMMENT '回覆文章id',
  `mid` int(11) NOT NULL COMMENT '文章id ',
  `uid` int(11) NOT NULL COMMENT '回覆者id ',
  `content` varchar(1024) NOT NULL COMMENT '回覆內容',
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
  `ip` varchar(64) NOT NULL COMMENT '回覆者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `respon25`
--

CREATE TABLE `respon25` (
  `rid` int(11) NOT NULL COMMENT '回覆文章id',
  `mid` int(11) NOT NULL COMMENT '文章id ',
  `uid` int(11) NOT NULL COMMENT '回覆者id ',
  `content` varchar(1024) NOT NULL COMMENT '回覆內容',
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
  `ip` varchar(64) NOT NULL COMMENT '回覆者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `respon26`
--

CREATE TABLE `respon26` (
  `rid` int(11) NOT NULL COMMENT '回覆文章id',
  `mid` int(11) NOT NULL COMMENT '文章id ',
  `uid` int(11) NOT NULL COMMENT '回覆者id ',
  `content` varchar(1024) NOT NULL COMMENT '回覆內容',
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
  `ip` varchar(64) NOT NULL COMMENT '回覆者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`aid`);

--
-- 資料表索引 `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`fid`);

--
-- 資料表索引 `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `member_uniq` (`username`);

--
-- 資料表索引 `message1`
--
ALTER TABLE `message1`
  ADD PRIMARY KEY (`mid`);

--
-- 資料表索引 `message2`
--
ALTER TABLE `message2`
  ADD PRIMARY KEY (`mid`);

--
-- 資料表索引 `message3`
--
ALTER TABLE `message3`
  ADD PRIMARY KEY (`mid`);

--
-- 資料表索引 `message18`
--
ALTER TABLE `message18`
  ADD PRIMARY KEY (`mid`);

--
-- 資料表索引 `message19`
--
ALTER TABLE `message19`
  ADD PRIMARY KEY (`mid`);

--
-- 資料表索引 `message20`
--
ALTER TABLE `message20`
  ADD PRIMARY KEY (`mid`);

--
-- 資料表索引 `message22`
--
ALTER TABLE `message22`
  ADD PRIMARY KEY (`mid`);

--
-- 資料表索引 `message23`
--
ALTER TABLE `message23`
  ADD PRIMARY KEY (`mid`);

--
-- 資料表索引 `message24`
--
ALTER TABLE `message24`
  ADD PRIMARY KEY (`mid`);

--
-- 資料表索引 `message25`
--
ALTER TABLE `message25`
  ADD PRIMARY KEY (`mid`);

--
-- 資料表索引 `message26`
--
ALTER TABLE `message26`
  ADD PRIMARY KEY (`mid`);

--
-- 資料表索引 `respon1`
--
ALTER TABLE `respon1`
  ADD PRIMARY KEY (`rid`);

--
-- 資料表索引 `respon2`
--
ALTER TABLE `respon2`
  ADD PRIMARY KEY (`rid`);

--
-- 資料表索引 `respon3`
--
ALTER TABLE `respon3`
  ADD PRIMARY KEY (`rid`);

--
-- 資料表索引 `respon18`
--
ALTER TABLE `respon18`
  ADD PRIMARY KEY (`rid`);

--
-- 資料表索引 `respon19`
--
ALTER TABLE `respon19`
  ADD PRIMARY KEY (`rid`);

--
-- 資料表索引 `respon20`
--
ALTER TABLE `respon20`
  ADD PRIMARY KEY (`rid`);

--
-- 資料表索引 `respon22`
--
ALTER TABLE `respon22`
  ADD PRIMARY KEY (`rid`);

--
-- 資料表索引 `respon23`
--
ALTER TABLE `respon23`
  ADD PRIMARY KEY (`rid`);

--
-- 資料表索引 `respon24`
--
ALTER TABLE `respon24`
  ADD PRIMARY KEY (`rid`);

--
-- 資料表索引 `respon25`
--
ALTER TABLE `respon25`
  ADD PRIMARY KEY (`rid`);

--
-- 資料表索引 `respon26`
--
ALTER TABLE `respon26`
  ADD PRIMARY KEY (`rid`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `admin`
--
ALTER TABLE `admin`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理流水號', AUTO_INCREMENT=30;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `forum`
--
ALTER TABLE `forum`
  MODIFY `fid` int(5) NOT NULL AUTO_INCREMENT COMMENT '討論區id', AUTO_INCREMENT=27;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `member`
--
ALTER TABLE `member`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT '會員ID', AUTO_INCREMENT=37;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `message1`
--
ALTER TABLE `message1`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章id', AUTO_INCREMENT=27;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `message2`
--
ALTER TABLE `message2`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章id', AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `message3`
--
ALTER TABLE `message3`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章id', AUTO_INCREMENT=7;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `message18`
--
ALTER TABLE `message18`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章id', AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `message19`
--
ALTER TABLE `message19`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章id', AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `message20`
--
ALTER TABLE `message20`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章id', AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `message22`
--
ALTER TABLE `message22`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章id', AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `message23`
--
ALTER TABLE `message23`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章id', AUTO_INCREMENT=3;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `message24`
--
ALTER TABLE `message24`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章id', AUTO_INCREMENT=3;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `message25`
--
ALTER TABLE `message25`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章id', AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `message26`
--
ALTER TABLE `message26`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章id', AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `respon1`
--
ALTER TABLE `respon1`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT COMMENT '回覆文章id', AUTO_INCREMENT=12;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `respon2`
--
ALTER TABLE `respon2`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT COMMENT '回覆文章id', AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `respon3`
--
ALTER TABLE `respon3`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT COMMENT '回覆文章id';

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `respon18`
--
ALTER TABLE `respon18`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT COMMENT '回覆文章id', AUTO_INCREMENT=3;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `respon19`
--
ALTER TABLE `respon19`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT COMMENT '回覆文章id', AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `respon20`
--
ALTER TABLE `respon20`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT COMMENT '回覆文章id';

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `respon22`
--
ALTER TABLE `respon22`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT COMMENT '回覆文章id', AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `respon23`
--
ALTER TABLE `respon23`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT COMMENT '回覆文章id';

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `respon24`
--
ALTER TABLE `respon24`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT COMMENT '回覆文章id';

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `respon25`
--
ALTER TABLE `respon25`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT COMMENT '回覆文章id', AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `respon26`
--
ALTER TABLE `respon26`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT COMMENT '回覆文章id';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
