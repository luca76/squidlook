#!/usr/bin/php5
<?php
# Program: SquidLook
# Copyright 2007, Trapanator <trap@trapanator.com>
# Derived from the work of:
# Program: mysar, File: bin/mysar-maintenance.php
# Copyright 2004-2006, Stoilis Giannis <giannis@stoilis.gr>
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

$tmpPath=getConfigValue('tmpPath');

error_reporting(E_ALL);

debug('Starting '.$argv[0].'...',30,__FILE__,__LINE__);
debug('Start timestamp is '.$startTime,40,__FILE__,__LINE__);
debug('Configuration:'.print_r($iniConfig,TRUE),40,__FILE__,__LINE__);

$maxRunTime=55;

$cleanUntil=date('Y-m-d',mktime(0,0,0,substr($today,5,2),substr($today,8,2)-getConfigValue('keepHistoryDays'),substr($today,0,4)));
debug('Cleaning up until '.$cleanUntil,40,__FILE__,__LINE__);
	
// array containing tables to be cleaned
$cleanTable=array('traffic','trafficSummaries');
reset($cleanTable);

while(list($key,$tableName)=each($cleanTable)) {
	debug('Cleaning-up '.$tableName.'...',40,__FILE__,__LINE__);
	$query='DELETE FROM '.$tableName." WHERE date<'".$cleanUntil."'";
	db_delete($query);
}

$query='SHOW TABLES';
$tables=db_select_all($query);
reset($tables);
while(list($key,$tableName)=each($tables)) {
	$timestampNow=mktime();
	debug('Now timestamp is: '.$timestampNow.'. Script start was at: '.$startTime,40,__FILE__,__LINE__);
	debug('Checking if run time exceeded '.$maxRunTime.' seconds...',40,__FILE__,__LINE__);
	if(($timestampNow-$startTime ) > $maxRunTime) {
		debug('YES',40);
		debug('Exceeded run time',30,__FILE__,__LINE__);
		my_exit(0);
	}
	debug('NO',40);

	$query="OPTIMIZE TABLE $tableName[0]";
	debug('Optimizing '.$tableName[0].'...',30,__FILE__,__LINE__);
	db_query($query);
	debug('Optimization finished.',30,__FILE__,__LINE__);
}

	
debug('Updating last clean-up date to today date...',40,__FILE__,__LINE__);
$query="UPDATE config SET value='".date('Y-m-d')."' WHERE name='lastCleanUp'";
db_update($query);
debug('Finisched '.$argv[0],30,__FILE__,__LINE__);

echo "\n";
?>
