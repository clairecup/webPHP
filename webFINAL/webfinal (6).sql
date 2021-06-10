-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2021-06-08 16:49:50
-- 伺服器版本： 10.4.18-MariaDB
-- PHP 版本： 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `webfinal`
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
(8, 4, 2),
(9, 3, 4);

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
  `iconurl` varchar(128) DEFAULT 'images/defalt.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `forum`
--

INSERT INTO `forum` (`fid`, `forum`, `animal`, `introduce`, `nickname`, `features`, `characters`, `places`, `socialmedia`, `imageurl`, `iconurl`) VALUES
(1, '小橘', 'cat', '嗨，我是小橘，住在政大莊九女宿外，今年四歲，經常在女宿外面賣萌睡覺，喜歡的東西是肉泥、枯樹枝、名車與太陽。', '火星、虎皮', '貓如其名、金瞳孔', '慵懶愜意、善於放電而不自知', '莊敬九舍、教育系館、憩賢樓', 'https://www.instagram.com/littleorange_nccu/', 'images/orange.jpg', 'images/icon_orange.png'),
(2, '花花', 'dog', '大家好，我是政大花花！今年不知道幾歲！興趣是閉眼聽課，專長是搭電梯，綜院跟國際大樓都會。', '斑斑、大花、胖花', '深色玳瑁花紋、有戴項圈', '溫和沉穩，十分好學，政大校園最友善的狗狗', '山上山下都可以看到花花的足跡！', 'https://www.instagram.com/huahualufyou/', 'images/huahua.jpg', 'images/icon_huahua.png'),
(3, '胖虎', 'cat', '愛被拍屁股、沒節操、 超級聰明的肥大叔。', '阿肥、老大', '深色虎斑貓、綠瞳孔', '任性、桀傲不遜、自由奔放', '莊外、莊內', 'https://www.instagram.com/fluffycat_fatty/', 'images/tiger.jpg', 'images/icon_tiger.png'),
(9, '草尼馬', 'others', '外形有點像綿羊，一般在高原生活，世界現有羊駝約300萬隻左右，約90%以上生活在南美洲的祕魯及智利的高原上，其餘分布於澳洲的維多利亞州和新南威爾斯州，以及紐西蘭\n\n不覺得他出現在政大很神奇嗎（＾∀＾●）ﾉｼ', '草草', '', '', '', '', './uploadFile/1623140896.jpg', 'images/defalt.png'),
(15, 'cc', 'cat', '', '', '', '', '', '', 'undefined', 'images/defalt.png');

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
(1, 'all', 'admin', '0cc175b9c0f1b6a831c399e269772661', 'admin'),
(2, 'dog', 'b', '92eb5ffee6ae2fec3ad71c777531578f', 'b'),
(3, 'cat', 'c', '4a8a08f09d37b73795649038408b5f33', 'c'),
(4, 'all', 'd', '8277e0910d750195b448797616e091ad', 'd'),
(5, 'dog', 'e', 'e1671797c52e15f763380b45e841ec32', 'e');

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
  `ip` varchar(64) NOT NULL COMMENT '發文者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `message1`
--

INSERT INTO `message1` (`mid`, `uid`, `title`, `content`, `time`, `longitude`, `latitude`, `health`, `feed`, `ip`) VALUES
(1, 2, '小橘', '小橘', '2021-06-05 14:24:26', 121.57648206320519, 24.987197754293412, 'healthy', 'nofeed', '::1'),
(2, 1, '測試', '測試測試', '2021-06-06 18:07:16', 121.58142205323983, 24.984221979014727, 'healthy', 'nofeed', '::1');

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
  `ip` varchar(64) NOT NULL COMMENT '發文者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `message2`
--

INSERT INTO `message2` (`mid`, `uid`, `title`, `content`, `time`, `longitude`, `latitude`, `health`, `feed`, `ip`) VALUES
(1, 2, '花花', '花花', '2021-06-05 14:24:51', 121.57316471258011, 24.982014411622984, 'unhealthy', 'feed', '::1');

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
  `ip` varchar(64) NOT NULL COMMENT '發文者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `message3`
--

INSERT INTO `message3` (`mid`, `uid`, `title`, `content`, `time`, `longitude`, `latitude`, `health`, `feed`, `ip`) VALUES
(1, 2, '胖虎', '胖虎', '2021-06-05 14:25:22', 0, 0, 'healthy', 'nofeed', '::1');

-- --------------------------------------------------------

--
-- 資料表結構 `message9`
--

CREATE TABLE `message9` (
  `mid` int(11) NOT NULL COMMENT '文章id',
  `uid` int(11) NOT NULL COMMENT '貼文者id',
  `title` varchar(256) NOT NULL COMMENT '標題',
  `content` varchar(1024) NOT NULL COMMENT '內容',
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
  `longitude` double NOT NULL COMMENT '經度',
  `latitude` double NOT NULL COMMENT '緯度',
  `health` varchar(11) NOT NULL COMMENT '健康狀態',
  `feed` varchar(11) NOT NULL COMMENT '有無餵食',
  `ip` varchar(64) NOT NULL COMMENT '發文者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `message15`
--

CREATE TABLE `message15` (
  `mid` int(11) NOT NULL COMMENT '文章id',
  `uid` int(11) NOT NULL COMMENT '貼文者id',
  `title` varchar(256) NOT NULL COMMENT '標題',
  `content` varchar(1024) NOT NULL COMMENT '內容',
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
  `longitude` double NOT NULL COMMENT '經度',
  `latitude` double NOT NULL COMMENT '緯度',
  `health` varchar(11) NOT NULL COMMENT '健康狀態',
  `feed` varchar(11) NOT NULL COMMENT '有無餵食',
  `ip` varchar(64) NOT NULL COMMENT '發文者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(1, 1, 2, '哇', '2021-06-05 11:00:40', '::1');

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
-- 資料表結構 `respon9`
--

CREATE TABLE `respon9` (
  `rid` int(11) NOT NULL COMMENT '回覆文章id',
  `mid` int(11) NOT NULL COMMENT '文章id ',
  `uid` int(11) NOT NULL COMMENT '回覆者id ',
  `content` varchar(1024) NOT NULL COMMENT '回覆內容',
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
  `ip` varchar(64) NOT NULL COMMENT '回覆者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `respon15`
--

CREATE TABLE `respon15` (
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
-- 資料表索引 `message9`
--
ALTER TABLE `message9`
  ADD PRIMARY KEY (`mid`);

--
-- 資料表索引 `message15`
--
ALTER TABLE `message15`
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
-- 資料表索引 `respon9`
--
ALTER TABLE `respon9`
  ADD PRIMARY KEY (`rid`);

--
-- 資料表索引 `respon15`
--
ALTER TABLE `respon15`
  ADD PRIMARY KEY (`rid`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `admin`
--
ALTER TABLE `admin`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理流水號', AUTO_INCREMENT=10;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `forum`
--
ALTER TABLE `forum`
  MODIFY `fid` int(5) NOT NULL AUTO_INCREMENT COMMENT '討論區id', AUTO_INCREMENT=16;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `member`
--
ALTER TABLE `member`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT '會員ID', AUTO_INCREMENT=7;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `message1`
--
ALTER TABLE `message1`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章id', AUTO_INCREMENT=3;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `message2`
--
ALTER TABLE `message2`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章id', AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `message3`
--
ALTER TABLE `message3`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章id', AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `message9`
--
ALTER TABLE `message9`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章id';

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `message15`
--
ALTER TABLE `message15`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章id';

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `respon1`
--
ALTER TABLE `respon1`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT COMMENT '回覆文章id', AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `respon2`
--
ALTER TABLE `respon2`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT COMMENT '回覆文章id';

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `respon3`
--
ALTER TABLE `respon3`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT COMMENT '回覆文章id';

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `respon9`
--
ALTER TABLE `respon9`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT COMMENT '回覆文章id';

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `respon15`
--
ALTER TABLE `respon15`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT COMMENT '回覆文章id';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
