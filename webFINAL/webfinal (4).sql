-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2021-06-06 06:56:34
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
  `animal` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `forum`
--

INSERT INTO `forum` (`fid`, `forum`, `animal`) VALUES
(1, '小橘', 'cat'),
(2, '花花', 'dog'),
(3, '胖虎', 'cat'),
(4, '獵奇動物', 'others');

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
  `longtitude` double NOT NULL COMMENT '經度',
  `latitude` double NOT NULL COMMENT '緯度',
  `health` varchar(11) NOT NULL COMMENT '健康狀態',
  `feed` varchar(11) NOT NULL COMMENT '有無餵食',
  `ip` varchar(64) NOT NULL COMMENT '發文者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `message1`
--

INSERT INTO `message1` (`mid`, `uid`, `title`, `content`, `time`, `longtitude`, `latitude`, `health`, `feed`, `ip`) VALUES
(1, 2, '小橘', '小橘', '2021-06-05 14:24:26', 121.57648206320519, 24.987197754293412, 'healthy', 'nofeed', '::1');

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
  `longtitude` double NOT NULL COMMENT '經度',
  `latitude` double NOT NULL COMMENT '緯度',
  `health` varchar(11) NOT NULL COMMENT '健康狀態',
  `feed` varchar(11) NOT NULL COMMENT '有無餵食',
  `ip` varchar(64) NOT NULL COMMENT '發文者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `message2`
--

INSERT INTO `message2` (`mid`, `uid`, `title`, `content`, `time`, `longtitude`, `latitude`, `health`, `feed`, `ip`) VALUES
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
  `longtitude` double NOT NULL COMMENT '經度',
  `latitude` double NOT NULL COMMENT '緯度',
  `health` varchar(11) NOT NULL COMMENT '健康狀態',
  `feed` varchar(11) NOT NULL COMMENT '有無餵食',
  `ip` varchar(64) NOT NULL COMMENT '發文者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `message3`
--

INSERT INTO `message3` (`mid`, `uid`, `title`, `content`, `time`, `longtitude`, `latitude`, `health`, `feed`, `ip`) VALUES
(1, 2, '胖虎', '胖虎', '2021-06-05 14:25:22', 0, 0, 'healthy', 'nofeed', '::1');

-- --------------------------------------------------------

--
-- 資料表結構 `message4`
--

CREATE TABLE `message4` (
  `mid` int(11) NOT NULL COMMENT '文章id',
  `uid` int(11) NOT NULL COMMENT '貼文者id',
  `title` varchar(256) NOT NULL COMMENT '標題',
  `content` varchar(1024) NOT NULL COMMENT '內容',
  `time` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '發表時間',
  `longtitude` double NOT NULL COMMENT '經度',
  `latitude` double NOT NULL COMMENT '緯度',
  `health` varchar(11) NOT NULL COMMENT '健康狀態',
  `feed` varchar(11) NOT NULL COMMENT '有無餵食',
  `ip` varchar(64) NOT NULL COMMENT '發文者IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `message4`
--

INSERT INTO `message4` (`mid`, `uid`, `title`, `content`, `time`, `longtitude`, `latitude`, `health`, `feed`, `ip`) VALUES
(1, 2, '草尼馬', '草尼馬', '2021-06-05 14:25:49', 121.56845405319315, 24.981592343617542, 'healthy', 'nofeed', '::1');

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
-- 資料表結構 `respon4`
--

CREATE TABLE `respon4` (
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
-- 資料表索引 `message4`
--
ALTER TABLE `message4`
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
-- 資料表索引 `respon4`
--
ALTER TABLE `respon4`
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
  MODIFY `fid` int(5) NOT NULL AUTO_INCREMENT COMMENT '討論區id', AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `member`
--
ALTER TABLE `member`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT '會員ID', AUTO_INCREMENT=6;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `message1`
--
ALTER TABLE `message1`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章id', AUTO_INCREMENT=2;

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
-- 使用資料表自動遞增(AUTO_INCREMENT) `message4`
--
ALTER TABLE `message4`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章id', AUTO_INCREMENT=2;

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
-- 使用資料表自動遞增(AUTO_INCREMENT) `respon4`
--
ALTER TABLE `respon4`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT COMMENT '回覆文章id';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
