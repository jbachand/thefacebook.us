-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 22, 2013 at 10:16 AM
-- Server version: 5.5.33-31.1
-- PHP Version: 5.3.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `newportb_harvardconnection`
--

-- --------------------------------------------------------

--
-- Table structure for table `accountstatus`
--

CREATE TABLE IF NOT EXISTS `accountstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE IF NOT EXISTS `album` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE IF NOT EXISTS `class` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `schoolid` bigint(20) NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=256 ;

-- --------------------------------------------------------

--
-- Table structure for table `classlink`
--

CREATE TABLE IF NOT EXISTS `classlink` (
  `userid` bigint(20) NOT NULL,
  `classid` bigint(20) NOT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=486 ;

-- --------------------------------------------------------

--
-- Table structure for table `confirmationemail`
--

CREATE TABLE IF NOT EXISTS `confirmationemail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) NOT NULL,
  `confirmnumber` bigint(20) NOT NULL,
  `codenumber` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=69 ;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `creatorid` bigint(20) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `starttime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `endtime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pictureid` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `eventlink`
--

CREATE TABLE IF NOT EXISTS `eventlink` (
  `userid` bigint(20) NOT NULL,
  `eventid` bigint(20) NOT NULL,
  `statusid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `eventlinkstatus`
--

CREATE TABLE IF NOT EXISTS `eventlinkstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fridge`
--

CREATE TABLE IF NOT EXISTS `fridge` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET cp1251 COLLATE cp1251_general_cs NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=59 ;

-- --------------------------------------------------------

--
-- Table structure for table `fridgelink`
--

CREATE TABLE IF NOT EXISTS `fridgelink` (
  `userid` bigint(20) NOT NULL,
  `fridgeid` bigint(20) NOT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`,`fridgeid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=124 ;

-- --------------------------------------------------------

--
-- Table structure for table `highschool`
--

CREATE TABLE IF NOT EXISTS `highschool` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=465 ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `HitsPerDay`
--
CREATE TABLE IF NOT EXISTS `HitsPerDay` (
`hits` bigint(21)
,`date` varchar(10)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `HitsPerMonth`
--
CREATE TABLE IF NOT EXISTS `HitsPerMonth` (
`hits` bigint(21)
,`date` varchar(7)
);
-- --------------------------------------------------------

--
-- Table structure for table `Hits_Per_Day`
--

CREATE TABLE IF NOT EXISTS `Hits_Per_Day` (
  `hits` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Hits_Per_Month`
--

CREATE TABLE IF NOT EXISTS `Hits_Per_Month` (
  `hits` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `interestedin`
--

CREATE TABLE IF NOT EXISTS `interestedin` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `interestedinlink`
--

CREATE TABLE IF NOT EXISTS `interestedinlink` (
  `userid` bigint(20) NOT NULL,
  `interestedinid` bigint(20) NOT NULL,
  KEY `userid` (`userid`,`interestedinid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `interests`
--

CREATE TABLE IF NOT EXISTS `interests` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET cp1251 COLLATE cp1251_general_cs NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=128 ;

-- --------------------------------------------------------

--
-- Table structure for table `interestslink`
--

CREATE TABLE IF NOT EXISTS `interestslink` (
  `userid` bigint(20) NOT NULL,
  `interestsid` bigint(20) NOT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`,`interestsid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1254 ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `lastactivity`
--
CREATE TABLE IF NOT EXISTS `lastactivity` (
`last` timestamp
,`userid` bigint(20)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `lastupdate`
--
CREATE TABLE IF NOT EXISTS `lastupdate` (
`last` timestamp
,`userid` bigint(20)
);
-- --------------------------------------------------------

--
-- Table structure for table `last_activity`
--

CREATE TABLE IF NOT EXISTS `last_activity` (
  `last` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `last_update`
--

CREATE TABLE IF NOT EXISTS `last_update` (
  `last` datetime NOT NULL,
  `user_id` bigint(20) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `page` text NOT NULL,
  `ip` varchar(16) NOT NULL,
  `userid` bigint(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `get` text NOT NULL,
  `post` text NOT NULL,
  `ref` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `idx_refs` (`timestamp`,`ref`(20),`id`),
  KEY `idx_times` (`timestamp`),
  KEY `idx_times_ip` (`timestamp`,`ip`),
  KEY `idx_ip` (`ip`),
  KEY `idx_times_userid` (`timestamp`,`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1157969 ;

--
-- Triggers `log`
--
DROP TRIGGER IF EXISTS `log_trigger`;
DELIMITER //
CREATE TRIGGER `log_trigger` AFTER INSERT ON `log`
 FOR EACH ROW BEGIN
REPLACE INTO `last_activity` (`last`, `user_id`) VALUES (NOW(), NEW.userid);
IF (Select count(1) from `Hits_Per_Day` WHERE `date`=CURDATE())=0 THEN
	INSERT INTO `Hits_Per_Day` (`date`,`hits`) VALUES (CURDATE(),'1');
ELSE
	UPDATE `Hits_Per_Day` SET `hits`=`hits`+1 WHERE `date`=CURDATE();
END IF;
IF (Select count(1) from `Hits_Per_Month` WHERE `date`=concat(YEAR(curdate()),"-",month(curdate()),"-0"))=0 THEN
	INSERT INTO `Hits_Per_Month` (`date`,`hits`) VALUES (concat(YEAR(curdate()),"-",month(curdate()),"-0"),'1');
ELSE
	UPDATE `Hits_Per_Month` SET `hits`=`hits`+1 WHERE `date`=concat(YEAR(curdate()),"-",month(curdate()),"-0");
END IF;
IF NEW.userid>0 AND (Select count(1) from `log` WHERE `userid`=NEW.userid AND `timestamp`>CURDATE())=1 THEN
	IF (Select count(1) from `Users_Per_Day` WHERE `date`=CURDATE())=0 THEN
		INSERT INTO `Users_Per_Day` (`date`,`hits`) VALUES (CURDATE(),'1');
	ELSE
		UPDATE `Users_Per_Day` SET `hits`=`hits`+1 WHERE `date`=CURDATE();
	END IF;
END IF;
IF (Select count(1) from `log` WHERE `ip`=NEW.ip AND `timestamp`>CURDATE())=1 THEN
	IF (Select count(1) from `Uniques_Per_Day` WHERE `date`=CURDATE())=0 THEN
		INSERT INTO `Uniques_Per_Day` (`date`,`hits`) VALUES (CURDATE(),'1');
	ELSE
		UPDATE `Uniques_Per_Day` SET `hits`=`hits`+1 WHERE `date`=CURDATE();
	END IF;
END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `lookingfor`
--

CREATE TABLE IF NOT EXISTS `lookingfor` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `lookingforlink`
--

CREATE TABLE IF NOT EXISTS `lookingforlink` (
  `userid` bigint(20) NOT NULL,
  `lookingforid` bigint(20) NOT NULL,
  KEY `userid` (`userid`,`lookingforid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `senderid` bigint(20) NOT NULL,
  `receiverid` bigint(20) NOT NULL,
  `messagestatusid` int(11) NOT NULL,
  `subject` text NOT NULL,
  `text` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `senderid` (`senderid`,`receiverid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=561 ;

-- --------------------------------------------------------

--
-- Table structure for table `messagestatus`
--

CREATE TABLE IF NOT EXISTS `messagestatus` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `music`
--

CREATE TABLE IF NOT EXISTS `music` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET cp1251 COLLATE cp1251_general_cs NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=128 ;

-- --------------------------------------------------------

--
-- Table structure for table `musiclink`
--

CREATE TABLE IF NOT EXISTS `musiclink` (
  `userid` bigint(20) NOT NULL,
  `musicid` bigint(20) NOT NULL,
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`,`musicid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1208 ;

-- --------------------------------------------------------

--
-- Table structure for table `online`
--

CREATE TABLE IF NOT EXISTS `online` (
  `userid` bigint(20) NOT NULL,
  `lastactive` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `phoneprovider`
--

CREATE TABLE IF NOT EXISTS `phoneprovider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `textext` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `picture`
--

CREATE TABLE IF NOT EXISTS `picture` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) NOT NULL,
  `albumid` bigint(20) NOT NULL,
  `link` text NOT NULL,
  `thumb` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23082 ;

-- --------------------------------------------------------

--
-- Table structure for table `political`
--

CREATE TABLE IF NOT EXISTS `political` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `PossibleHacks`
--
CREATE TABLE IF NOT EXISTS `PossibleHacks` (
`id` bigint(20)
,`page` text
,`ip` varchar(16)
,`userid` bigint(20)
,`timestamp` timestamp
,`get` text
,`post` text
);
-- --------------------------------------------------------

--
-- Table structure for table `profileupdates`
--

CREATE TABLE IF NOT EXISTS `profileupdates` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26939 ;

--
-- Triggers `profileupdates`
--
DROP TRIGGER IF EXISTS `lu_trigger`;
DELIMITER //
CREATE TRIGGER `lu_trigger` AFTER INSERT ON `profileupdates`
 FOR EACH ROW BEGIN
REPLACE INTO `last_update` (`last`, `user_id`) VALUES (DATE_ADD(NOW(), INTERVAL 1 HOUR), NEW.userid);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `relationship`
--

CREATE TABLE IF NOT EXISTS `relationship` (
  `senderid` bigint(20) NOT NULL,
  `receiverid` bigint(20) NOT NULL,
  `realtionshiptypeid` int(11) NOT NULL,
  `confirmed` int(11) NOT NULL,
  KEY `senderid` (`senderid`,`receiverid`),
  KEY `send_rec_idx` (`senderid`,`receiverid`,`confirmed`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `relationshiptype`
--

CREATE TABLE IF NOT EXISTS `relationshiptype` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `residence`
--

CREATE TABLE IF NOT EXISTS `residence` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=285 ;

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE IF NOT EXISTS `school` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `emailextension` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17126641 ;

-- --------------------------------------------------------

--
-- Table structure for table `schoolstatus`
--

CREATE TABLE IF NOT EXISTS `schoolstatus` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `schoolsuggestions`
--

CREATE TABLE IF NOT EXISTS `schoolsuggestions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` text NOT NULL,
  `school` text NOT NULL,
  `dtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9167 ;

-- --------------------------------------------------------

--
-- Table structure for table `screenname`
--

CREATE TABLE IF NOT EXISTS `screenname` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=267 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `site_on` tinyint(4) NOT NULL,
  `email_alerts` tinyint(4) NOT NULL,
  `launch_date` text NOT NULL,
  `registration_on` tinyint(4) NOT NULL,
  `login_on` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `sex`
--

CREATE TABLE IF NOT EXISTS `sex` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `Uniques_Per_Day`
--

CREATE TABLE IF NOT EXISTS `Uniques_Per_Day` (
  `hits` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `accountstatusid` tinyint(4) NOT NULL,
  `registerdate` date NOT NULL,
  `name` varchar(50) NOT NULL,
  `schoolid` bigint(20) NOT NULL,
  `phone` text NOT NULL,
  `phoneproviderid` int(11) NOT NULL,
  `graduationyear` varchar(4) NOT NULL,
  `schoolstatusid` tinyint(4) NOT NULL,
  `sexid` tinyint(4) NOT NULL,
  `residenceid` bigint(20) NOT NULL,
  `birthday` date NOT NULL,
  `hometown` text NOT NULL,
  `highschoolid` bigint(20) NOT NULL,
  `screennameid` bigint(20) NOT NULL,
  `websites` text NOT NULL,
  `politicalid` bigint(20) NOT NULL,
  `newsletters` int(11) NOT NULL,
  `posttofb` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_reg_date` (`id`,`accountstatusid`,`registerdate`),
  KEY `idx_name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100006224670685 ;

-- --------------------------------------------------------

--
-- Table structure for table `userstatus`
--

CREATE TABLE IF NOT EXISTS `userstatus` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` bigint(20) NOT NULL,
  `text` text NOT NULL,
  `dtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Users_Per_Day`
--

CREATE TABLE IF NOT EXISTS `Users_Per_Day` (
  `hits` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `whatcamefirstodayratings`
--

CREATE TABLE IF NOT EXISTS `whatcamefirstodayratings` (
  `id` text NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `whatcamefirsttoday`
--

CREATE TABLE IF NOT EXISTS `whatcamefirsttoday` (
  `id` text NOT NULL,
  `image1` text NOT NULL,
  `image2` text NOT NULL,
  `title` text NOT NULL,
  `author` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure for view `HitsPerDay`
--
DROP TABLE IF EXISTS `HitsPerDay`;

CREATE ALGORITHM=UNDEFINED DEFINER=`newportb`@`localhost` SQL SECURITY DEFINER VIEW `HitsPerDay` AS select count(0) AS `hits`,date_format(`log`.`timestamp`,_utf8'%Y-%m-%d') AS `date` from `log` group by date_format(`log`.`timestamp`,_utf8'%Y-%m-%d') order by date_format(`log`.`timestamp`,_utf8'%Y-%m-%d') desc limit 365;

-- --------------------------------------------------------

--
-- Structure for view `HitsPerMonth`
--
DROP TABLE IF EXISTS `HitsPerMonth`;

CREATE ALGORITHM=UNDEFINED DEFINER=`newportb`@`localhost` SQL SECURITY DEFINER VIEW `HitsPerMonth` AS select count(0) AS `hits`,date_format(`log`.`timestamp`,_utf8'%Y-%m') AS `date` from `log` group by date_format(`log`.`timestamp`,_utf8'%Y-%m') order by date_format(`log`.`timestamp`,_utf8'%Y-%m') desc limit 365;

-- --------------------------------------------------------

--
-- Structure for view `lastactivity`
--
DROP TABLE IF EXISTS `lastactivity`;

CREATE ALGORITHM=UNDEFINED DEFINER=`newportb`@`localhost` SQL SECURITY DEFINER VIEW `lastactivity` AS select distinct max(`p`.`timestamp`) AS `last`,`p`.`userid` AS `userid` from `log` `p` group by `p`.`userid`;

-- --------------------------------------------------------

--
-- Structure for view `lastupdate`
--
DROP TABLE IF EXISTS `lastupdate`;

CREATE ALGORITHM=UNDEFINED DEFINER=`newportb`@`localhost` SQL SECURITY DEFINER VIEW `lastupdate` AS select distinct max(`p`.`timestamp`) AS `last`,`p`.`userid` AS `userid` from `profileupdates` `p` group by `p`.`userid`;

-- --------------------------------------------------------

--
-- Structure for view `PossibleHacks`
--
DROP TABLE IF EXISTS `PossibleHacks`;

CREATE ALGORITHM=UNDEFINED DEFINER=`newportb`@`localhost` SQL SECURITY DEFINER VIEW `PossibleHacks` AS select `log`.`id` AS `id`,`log`.`page` AS `page`,`log`.`ip` AS `ip`,`log`.`userid` AS `userid`,`log`.`timestamp` AS `timestamp`,`log`.`get` AS `get`,`log`.`post` AS `post` from `log` where ((`log`.`get` like _utf8'%select%') or _utf8'%union%' or _utf8'%\\%%' or (`log`.`post` like _utf8'%select%') or _utf8'%union%' or _utf8'%\\%%' or (`log`.`page` like _utf8'%select%') or _utf8'%union%' or _utf8'%\\%%');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


--
-- Database: `newportb_harvardconnection`
--

--
-- Dumping data for table `accountstatus`
--

INSERT INTO `accountstatus` (`id`, `name`) VALUES
(1, 'Registered'),
(2, 'Confirmed'),
(3, 'School Admin'),
(9, 'Super Admin'),
(-1, 'Deactivated');



--
-- Dumping data for table `lookingfor`
--

INSERT INTO `lookingfor` (`id`, `name`) VALUES
(1, 'Friendship'),
(2, 'Relationship'),
(3, 'Dating'),
(4, 'Hooking-up'),
(5, 'Moral Support'),
(6, 'Parties');

--
-- Dumping data for table `messagestatus`
--

INSERT INTO `messagestatus` (`id`, `name`) VALUES
(1, 'Sent'),
(2, 'Read'),
(3, 'Replied');

--
-- Dumping data for table `political`
--

INSERT INTO `political` (`id`, `name`) VALUES
(1, 'Very Liberal'),
(2, 'Liberal'),
(3, 'Middle of the road'),
(4, 'Conservative'),
(5, 'Very Conservative');

--
-- Dumping data for table `relationshiptype`
--

INSERT INTO `relationshiptype` (`id`, `name`) VALUES
(1, 'Friends'),
(2, 'Casually dating'),
(3, 'In a serious relationship'),
(4, 'Friends with benefits'),
(5, 'Best Friends'),
(6, 'Rivals'),
(7, 'Enemies'),
(8, 'Engaged'),
(9, 'Married');

--
-- Dumping data for table `schoolstatus`
--

INSERT INTO `schoolstatus` (`id`, `name`) VALUES
(1, 'Student'),
(2, 'Alumnus/Alumna'),
(3, 'Faculty'),
(4, 'Staff');

--
-- Dumping data for table `sex`
--

INSERT INTO `sex` (`id`, `name`) VALUES
(1, 'Female'),
(2, 'Male');

INSERT INTO `settings` (`site_on`, `email_alerts`, `launch_date`, `registration_on`, `login_on`) VALUES
(1, 0, '2011-04-06', 1, 1);

