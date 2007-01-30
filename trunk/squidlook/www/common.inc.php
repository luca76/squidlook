<?php
# Program: mysar, File: inc/common.inc.php
# Copyright 2004-2005, Stoilis Giannis <giannis@stoilis.gr>
#
# This file is part of mysar.
#
# mysar is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# mysar is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with Foobar; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

// Read the main configuration file
//if(file_exists($basePath.'/etc/config.ini')) {
if(file_exists('config.ini')) {
	$iniConfig=parse_ini_file('config.ini');
} else {
	$iniConfig=parse_ini_file($basePath.'/etc/config.ini.example');
}

if(isset($iniConfig['debugLevel']) && $iniConfig['debugLevel']!='') {
	$DEBUG_LEVEL=$iniConfig['debugLevel'];
}

// include common functions
// require($basePath.'/inc/functions.inc.php');
require('functions.inc.php');

// Disable PHP's execution time limit, if this is called from the command line
debug("Disabling PHP's execution time limit...",50,__FILE__,__LINE__);
if($DEBUG_MODE=='cmd') {
	debug('Yes',50);
	set_time_limit(0);
} else {
	debug('No',50);
}

// Initialize the database connection
debug('Initializing database connection...',40,__FILE__,__LINE__);
debug('dbHost='.$iniConfig['dbHost'].',dbUser='.$iniConfig['dbUser'].',dbPass='.$iniConfig['dbPass'],40,__FILE__,__LINE__);
$link=mysql_connect($iniConfig['dbHost'],$iniConfig['dbUser'],$iniConfig['dbPass']);
if (!$link) {
	debug('Error connecting to database!',20,__FILE__,__LINE__);
	db_error();
	debug('FATAL. Exiting...',20,__FILE__,__LINE__);
	die(1);
}
debug('Done.',40,__FILE__,__LINE__);
debug('Selecting database...',40,__FILE__,__LINE__);
debug('dbName='.$iniConfig['dbName'],40,__FILE__,__LINE__);
$result=mysql_select_db($iniConfig['dbName']);
if(!$result) {
	debug('Could not select database!',40,__FILE__,__LINE__);
	db_error();
	debug('FATAL. Exiting...',20,__FILE__,__LINE__);
	die(1);
}
debug('Done.',40,__FILE__,__LINE__);

// Identification
define('PROGRAM_NAME_SHORT','mysar');
define('PROGRAM_NAME_LONG','MySQL Squid Access Report');
define('PROGRAM_VERSION','2.0.11');

if($DEBUG_MODE=='web') {
// Initialize smarty template engine
	require($basePath.'/inc/smarty/Smarty.class.php');
	$smarty=new Smarty;
	$smarty->template_dir=$basePath.'/www-templates';
	$smarty->compile_dir=$basePath.'/smarty-tmp';
	$smarty->debugging = false;
}

$today=date('Y-m-d');

?>
