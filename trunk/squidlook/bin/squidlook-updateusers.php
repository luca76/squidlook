#!/usr/bin/php5
<?php
# Program: SquidLook
# Copyright 2007, Trapanator <trap@trapanator.com>
#
# This file is part of squidLook.
#
# squidLook is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License version 2 as published by
# the Free Software Foundation.
#
# squidLook is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with Foobar; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA


# record start time, to stop execution if time is exceeded...
$startTime=mktime();
$yesterdayTimestamp=$startTime-86400;

// calculate the base path of the program
$basePath=realpath(dirname(__FILE__).'/../');

$DEBUG_MODE='cmd';
$DEBUG_LEVEL='30';

// Common tasks for both web and cmd
require($basePath.'/inc/common.inc.php');

// Group manangement
require('groups.inc.php');

error_reporting(E_ALL);
debug('Starting '.$ARGV[0].'...', 30,__FILE__,__LINE__);
debug('Start timestamp is '.$startTime,30,__FILE__,__LINE__);
debug('Configuration:'.print_r($iniConfig,TRUE),40,__FILE__,__LINE__);
 
$maxRunTime=14400; // 4 ore

$query = "SELECT * FROM groups";
$res = db_select_all ($query);
$groups = array();
foreach ($res as $record) {
	if ($record['NAME'] != '') {
		$groups [$record['NAME']] = $record['ID'];
	}
}

$query = "SELECT * FROM users";
$vec = db_select_all ($query);

foreach ($vec as $record) {
	print "\n";
	$oldg = $record['groupID'];
	print "Nome:".$record['authuser']." - Gruppo: ".$record['groupID']."\n";
	$group = $mgroups [getGroupID ($record['authuser'], $mgroups)];
	if (!array_key_exists ($group, $groups)) {
		// Non essite nella tabella groups, lo inserisco!
		$query = "INSERT INTO `groups` ( `ID` , `NAME` ) VALUES (NULL, '".$group."');";
		$idx = db_insert($query);
		$groups [$group] = $idx;
	}
	print "Gruppo dell'utente trovato: ".$group." - ID ".$groups[$group]." \n";
	$newg = $groups[$group];

	if ($oldg != $newg) {
		print "**** GRUPPI DIVERSI\n\n\n";
	}

	print "\n";
}

my_exit(0);
?>
