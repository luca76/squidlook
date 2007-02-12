-- Copyright 2007, Trapanator <trap@trapanator.com>
--
-- This file is part of squidLook.
--
-- squidLook is free software; you can redistribute it and/or modify
-- it under the terms of the GNU General Public License version 2 as published by
-- the Free Software Foundation.
--
-- squidLook is distributed in the hope that it will be useful,
-- but WITHOUT ANY WARRANTY; without even the implied warranty of
-- MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
-- GNU General Public License for more details.
--
-- You should have received a copy of the GNU General Public License
-- along with Foobar; if not, write to the Free Software
-- Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

-- Database generation for squidLook
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `config`
-- 

DROP TABLE IF EXISTS `config`;
CREATE TABLE IF NOT EXISTS `config` (
  `name` varchar(255) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `config`
-- 

INSERT INTO `config` (`name`, `value`) VALUES 
('lastTimestamp', ''),
('lastCleanUp', ''),
('defaultindexOrderBy', 'date'),
('defaultindexOrderMethod', 'DESC'),
('lastImportedRecordsNumber', '11520'),
('defaultDateTimeOrderBy', 'time'),
('defaultindexByteUnit', 'M'),
('defaultIPSummaryOrderBy', 'cachePercent'),
('defaultIPSummaryOrderMethod', 'DESC'),
('defaultIPSummaryByteUnit', 'M'),
('defaultIPSitesSummaryOrderBy', 'bytes'),
('defaultIPSitesSummaryOrderMethod', 'DESC'),
('defaultIPSitesSummaryByteUnit', 'M'),
('defaultDateTimeOrderMethod', 'DESC'),
('defaultAllSitesOrderBy', 'cachePercent'),
('defaultAllSitesOrderMethod', 'DESC'),
('defaultAllSitesByteUnit', 'M'),
('defaultDateTimeByteUnit', 'K'),
('defaultSiteUsersOrderBy', 'bytes'),
('defaultSiteUsersOrderMethod', 'DESC'),
('defaultSiteUsersByteUnit', 'M'),
('keepHistoryDays', '180'),
('squidLogPath', '/var/log/squid/access.log'),
('schemaVersion', '3'),
('resolveClients', 'enabled'),
('mysarImporter', 'enabled'),
('topGrouping', 'monthly'),
('lastLogOffset', ''),
('firstLogTimestamp', ''),
('whitelistLimit', '100'),
('allsitesLimit', '100');


-- --------------------------------------------------------

-- 
-- Table structure for table `groups`
-- 

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `ID` int(11) NOT NULL auto_increment,
  `NAME` varchar(128) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `hostnames`
-- 

DROP TABLE IF EXISTS `hostnames`;
CREATE TABLE IF NOT EXISTS `hostnames` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `ip` int(10) unsigned NOT NULL default '0',
  `description` varchar(50) NOT NULL default '',
  `isResolved` tinyint(3) unsigned NOT NULL default '0',
  `hostname` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `isResolved` (`isResolved`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=144 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `sites`
-- 

DROP TABLE IF EXISTS `sites`;
CREATE TABLE IF NOT EXISTS `sites` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `site` varchar(255) NOT NULL default '',
  `whitelist` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `site` (`site`),
  KEY `whitelist` (`whitelist`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3313 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `traffic`
-- 

DROP TABLE IF EXISTS `traffic`;
CREATE TABLE IF NOT EXISTS `traffic` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `date` date NOT NULL default '0000-00-00',
  `time` time NOT NULL default '00:00:00',
  `elapsedTime` int(9) unsigned default '0',
  `ip` int(10) unsigned NOT NULL default '0',
  `resultCode` varchar(50) NOT NULL default '',
  `bytes` bigint(20) unsigned NOT NULL default '0',
  `url` varchar(255) NOT NULL default '',
  `authuser` varchar(30) NOT NULL default '',
  `sitesID` bigint(20) unsigned NOT NULL default '0',
  `usersID` bigint(20) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `date_ip_sitesID_usersID` (`date`,`ip`,`sitesID`,`usersID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=92326 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `trafficSummaries`
-- 

DROP TABLE IF EXISTS `trafficSummaries`;
CREATE TABLE IF NOT EXISTS `trafficSummaries` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `date` date NOT NULL default '0000-00-00',
  `ip` int(10) unsigned NOT NULL default '0',
  `usersID` bigint(20) unsigned NOT NULL default '0',
  `groupID` int(11) NOT NULL,
  `inCache` bigint(20) unsigned NOT NULL default '0',
  `outCache` bigint(20) unsigned NOT NULL default '0',
  `sitesID` bigint(20) unsigned NOT NULL default '0',
  `summaryTime` tinyint(3) unsigned NOT NULL default '0',
  `elapsedTime` int(9) unsigned default '0',
  `count` int(9) default '0',
  PRIMARY KEY  (`id`),
  KEY `usersID` (`usersID`),
  KEY `sitesID` (`sitesID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=11949 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `authuser` varchar(50) NOT NULL default '',
  `groupID` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `authuser` (`authuser`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=138 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `whitelist`
-- 

DROP TABLE IF EXISTS `whitelist`;
CREATE TABLE IF NOT EXISTS `whitelist` (
  `id` bigint(20) unsigned NOT NULL default '0',
  `site` varchar(255) NOT NULL default '',
  `whitelist` int(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`site`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
