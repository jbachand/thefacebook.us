-- phpMyAdmin SQL Dump
-- version 2.11.9.4
-- http://www.phpmyadmin.net
--
-- Host: 10.6.166.123
-- Generation Time: Feb 13, 2011 at 03:01 PM
-- Server version: 5.0.91
-- PHP Version: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `havardconn123`
--

-- --------------------------------------------------------

--
-- Table structure for table `accountstatus`
--

CREATE TABLE `accountstatus` (
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `accountstatus`
--

INSERT INTO `accountstatus` VALUES(1, 'Registered');
INSERT INTO `accountstatus` VALUES(2, 'Confirmed');
INSERT INTO `accountstatus` VALUES(3, 'School Admin');
INSERT INTO `accountstatus` VALUES(9, 'Super Admin');
INSERT INTO `accountstatus` VALUES(-1, 'Deactivated');

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `id` bigint(20) NOT NULL auto_increment,
  `userid` bigint(20) NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `album`
--


-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` bigint(20) NOT NULL auto_increment,
  `schoolid` bigint(20) NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `class`
--


-- --------------------------------------------------------

--
-- Table structure for table `classlink`
--

CREATE TABLE `classlink` (
  `userid` bigint(20) NOT NULL,
  `classid` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `classlink`
--


-- --------------------------------------------------------

--
-- Table structure for table `confirmationemail`
--

CREATE TABLE `confirmationemail` (
  `id` bigint(20) NOT NULL auto_increment,
  `userid` bigint(20) NOT NULL,
  `confirmnumber` bigint(20) NOT NULL,
  `codenumber` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `confirmationemail`
--


-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` bigint(20) NOT NULL auto_increment,
  `creatorid` bigint(20) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `starttime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `endtime` timestamp NOT NULL default '0000-00-00 00:00:00',
  `pictureid` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `event`
--


-- --------------------------------------------------------

--
-- Table structure for table `eventlink`
--

CREATE TABLE `eventlink` (
  `userid` bigint(20) NOT NULL,
  `eventid` bigint(20) NOT NULL,
  `statusid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `eventlink`
--


-- --------------------------------------------------------

--
-- Table structure for table `eventlinkstatus`
--

CREATE TABLE `eventlinkstatus` (
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `eventlinkstatus`
--


-- --------------------------------------------------------

--
-- Table structure for table `highschool`
--

CREATE TABLE `highschool` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `highschool`
--


-- --------------------------------------------------------

--
-- Table structure for table `interestedin`
--

CREATE TABLE `interestedin` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `interestedin`
--

INSERT INTO `interestedin` VALUES(1, 'Women');
INSERT INTO `interestedin` VALUES(2, 'Men');

-- --------------------------------------------------------

--
-- Table structure for table `interestedinlink`
--

CREATE TABLE `interestedinlink` (
  `userid` bigint(20) NOT NULL,
  `interestedinid` bigint(20) NOT NULL,
  KEY `userid` (`userid`,`interestedinid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `interestedinlink`
--


-- --------------------------------------------------------

--
-- Table structure for table `lookingfor`
--

CREATE TABLE `lookingfor` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `lookingfor`
--

INSERT INTO `lookingfor` VALUES(1, 'Friendship');
INSERT INTO `lookingfor` VALUES(2, 'Relationship');
INSERT INTO `lookingfor` VALUES(3, 'Dating');
INSERT INTO `lookingfor` VALUES(4, 'Hooking-up');
INSERT INTO `lookingfor` VALUES(5, 'Moral Support');
INSERT INTO `lookingfor` VALUES(6, 'Parties');

-- --------------------------------------------------------

--
-- Table structure for table `lookingforlink`
--

CREATE TABLE `lookingforlink` (
  `userid` bigint(20) NOT NULL,
  `lookingforid` bigint(20) NOT NULL,
  KEY `userid` (`userid`,`lookingforid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lookingforlink`
--


-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` bigint(20) NOT NULL auto_increment,
  `senderid` bigint(20) NOT NULL,
  `receiverid` bigint(20) NOT NULL,
  `messagestatusid` int(11) NOT NULL,
  `subject` text NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `senderid` (`senderid`,`receiverid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `message`
--


-- --------------------------------------------------------

--
-- Table structure for table `messagestatus`
--

CREATE TABLE `messagestatus` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `messagestatus`
--

INSERT INTO `messagestatus` VALUES(1, 'Sent');
INSERT INTO `messagestatus` VALUES(2, 'Read');
INSERT INTO `messagestatus` VALUES(3, 'Replied');

-- --------------------------------------------------------

--
-- Table structure for table `online`
--

CREATE TABLE `online` (
  `userid` bigint(20) NOT NULL,
  `lastactive` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `online`
--


-- --------------------------------------------------------

--
-- Table structure for table `phoneprovider`
--

CREATE TABLE `phoneprovider` (
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `textext` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `phoneprovider`
--


-- --------------------------------------------------------

--
-- Table structure for table `picture`
--

CREATE TABLE `picture` (
  `id` bigint(20) NOT NULL auto_increment,
  `userid` bigint(20) NOT NULL,
  `albumid` bigint(20) NOT NULL,
  `link` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `picture`
--


-- --------------------------------------------------------

--
-- Table structure for table `political`
--

CREATE TABLE `political` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `political`
--

INSERT INTO `political` VALUES(1, 'Very Liberal');
INSERT INTO `political` VALUES(2, 'Liberal');
INSERT INTO `political` VALUES(3, 'Middle of the road');
INSERT INTO `political` VALUES(4, 'Conservative');
INSERT INTO `political` VALUES(5, 'Very Conservative');

-- --------------------------------------------------------

--
-- Table structure for table `profileupdates`
--

CREATE TABLE `profileupdates` (
  `id` bigint(20) NOT NULL auto_increment,
  `userid` bigint(20) NOT NULL,
  `dtime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `profileupdates`
--


-- --------------------------------------------------------

--
-- Table structure for table `relationship`
--

CREATE TABLE `relationship` (
  `senderid` bigint(20) NOT NULL,
  `receiverid` bigint(20) NOT NULL,
  `realtionshiptypeid` int(11) NOT NULL,
  `confirmed` int(11) NOT NULL,
  KEY `senderid` (`senderid`,`receiverid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `relationship`
--


-- --------------------------------------------------------

--
-- Table structure for table `relationshiptype`
--

CREATE TABLE `relationshiptype` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `relationshiptype`
--

INSERT INTO `relationshiptype` VALUES(1, 'Friend');
INSERT INTO `relationshiptype` VALUES(2, 'Dating');
INSERT INTO `relationshiptype` VALUES(3, 'Couple');

-- --------------------------------------------------------

--
-- Table structure for table `residence`
--

CREATE TABLE `residence` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `residence`
--


-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE `school` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` text NOT NULL,
  `emailextension` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `school`
--

INSERT INTO `school` VALUES(1, 'Harvard University', '@harvard.edu');

-- --------------------------------------------------------

--
-- Table structure for table `schoolstatus`
--

CREATE TABLE `schoolstatus` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `schoolstatus`
--

INSERT INTO `schoolstatus` VALUES(1, 'Student');
INSERT INTO `schoolstatus` VALUES(2, 'Alumni');
INSERT INTO `schoolstatus` VALUES(3, 'Faculty');
INSERT INTO `schoolstatus` VALUES(4, 'Staff');

-- --------------------------------------------------------

--
-- Table structure for table `schoolsuggestions`
--

CREATE TABLE `schoolsuggestions` (
  `id` bigint(20) NOT NULL auto_increment,
  `email` text NOT NULL,
  `school` text NOT NULL,
  `dtime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `schoolsuggestions`
--

INSERT INTO `schoolsuggestions` VALUES(1, 'jeff@n2op.com', 'UMass', '2011-02-13 14:25:35');

-- --------------------------------------------------------

--
-- Table structure for table `screenname`
--

CREATE TABLE `screenname` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `screenname`
--


-- --------------------------------------------------------

--
-- Table structure for table `sex`
--

CREATE TABLE `sex` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sex`
--

INSERT INTO `sex` VALUES(1, 'Female');
INSERT INTO `sex` VALUES(2, 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` bigint(20) NOT NULL auto_increment,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `accountstatusid` tinyint(4) NOT NULL,
  `registerdate` date NOT NULL,
  `name` text NOT NULL,
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
  `interestsid` bigint(20) NOT NULL,
  `musicid` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` VALUES(1, 'testjeff', 'testjeff', 9, '0000-00-00', '', 0, '', 0, '', 0, 0, 0, '0000-00-00', '', 0, 0, '', 0, 0, 0);
INSERT INTO `user` VALUES(2, 'testjim', 'testjim', 9, '0000-00-00', '', 0, '', 0, '', 0, 0, 0, '0000-00-00', '', 0, 0, '', 0, 0, 0);
INSERT INTO `user` VALUES(3, 'jeff@harvardconnection.co', 'bachand0', 9, '2011-02-13', 'Jeffrey Bachand', 1, '', 0, '', 0, 0, 0, '0000-00-00', '', 0, 0, '', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `userstatus`
--

CREATE TABLE `userstatus` (
  `id` bigint(20) NOT NULL auto_increment,
  `userid` bigint(20) NOT NULL,
  `text` text NOT NULL,
  `dtime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `userstatus`
--

