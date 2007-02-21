<?php
# Program: mysar, File: www/functions.inc.php
# Copyright 2004-2995, Stoilis Giannis <giannis@stoilis.gr>
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

function bytesToHRF($bytes,$unit='') {
	// convert bytes to a human readable format
		
	$units['T']=1099511627776;
	$units['G']=1073741824;
	$units['M']=1048576;
	$units['K']=1023;
		
	reset($units);
	while(list($key,$value)=each($units)) {
		if($key==$unit) {
			$bytes=sprintf('%01.2f',$bytes/$value);
			return $bytes.$key;
		}
		if($bytes>$value && empty($unit)) {
			$bytes=sprintf('%01.2f',$bytes/$value);
			return $bytes.$key;
		}
	}
	return $bytes;
}


function date_Ymd2dmY_seperator($date,$seperator) {
	$dateArray=explode('-',$date);
	
	return $dateArray['2'].$seperator.$dateArray['1'].$seperator.$dateArray['0'];
}


function date_timestampFromDbDate($date,$seperator) {
	// returns the timestamp of a db date
		
	$dateArray=explode('-',$date);
	return mktime(0,0,0,$dateArray['1'],$dateArray['2'],$dateArray['0']);
}


function db_delete($query) {

	debug('('.$query.') ',50);
	$recordSet=mysql_query($query);
	if(!$recordSet) {
		db_error($query);
	}
		
	$affectedRows=mysql_affected_rows();	
	debug('Affected rows: '.$affectedRows,50,__FILE__,__LINE__);
		
	return($affectedRows);
	}


function db_select_all($query) {
// select all rows
	debug('('.$query.') ',40);

	$result=mysql_query($query);

	if(!$result) {
		debug('SQL Error',20,__FILE__,__LINE__);
		db_error($query);
		debug('Exiting...',20,__FILE__,__LINE__);
		die(1);
	}

	$allRecords=array();
	while($row=mysql_fetch_array($result)) {
		$allRecords[]=$row;
	}

	return $allRecords;
}


function db_error($query='') {
	// handles the database errors

	debug('ERROR on SQL query',20,__FILE__,__LINE__);
	if($query!='') {
		debug('SQL query: '.$query,20,__FILE__,__LINE__);
	}
	debug('Database error number: '.mysql_errno(),20,__FILE__,__LINE__);
	debug('Database error message: '.mysql_error(),20,__FILE__,__LINE__);
}


function db_update($query,$minimumAffectedRows=0) {

	debug('('.$query.')',40,__FILE__,__LINE__);
	$result=mysql_query($query);
	if(!$result) {
		debug('SQL Update Error',20,__FILE__,__LINE__);
		db_error($query);
		debug('Exiting...',20,__FILE__,__LINE__);
		die(1);
	}
		
	$affectedRows=mysql_affected_rows();
	if($affectedRows<$minimumAffectedRows) {
		debug('SQL Update Error: Less affected rows than expected',20,__FILE__,__LINE__);
		db_error($query);
	}
	
	debug('Affected rows: '.$affectedRows,40,__FILE__,__LINE__);
	
	return($affectedRows);
}


function db_query($query) {
	debug('('.$query.')',40,__FILE__,__LINE__);
	return mysql_query($query);
}

function debug($message,$debugLevel='',$file='',$line='') {
// Prints the debugging messages, depending on the debug level

	global $DEBUG_LEVEL;
	global $DEBUG_MODE;
	
	$newLine='';

	if($DEBUG_LEVEL>=$debugLevel) {
		if($line!='') {
			if($DEBUG_MODE=='cmd') {
				$newLine="\n";
			} else {
				$newLine="</center><br>";
			}
			if($debugLevel>=50) {
				$newLine.=$file.'('.$line.') -> ';
			}
		}
		echo $newLine.$message;
	}
}

function getConfigValue($name) {
	
	$query="SELECT value FROM config WHERE name='$name'";
	$result=db_select_one_row($query);

	return $result['value'];
}

function db_select_one_row($query) {

	debug('('.$query.')',40,__FILE__,__LINE__);
	$result=mysql_query($query);

	return $row;
}


function db_select($query) {
	$result=mysql_query($query);

	if(!$result) {
		db_error($query);
		debug('Exiting...',20,__FILE__,__LINE__);
		die(1);
	}

	return $result;
}

function db_fetch_array($result) {
	if($row=mysql_fetch_array($result)) {
		return $row;
	} else {
echo mysql_error();
		return FALSE;
	}
}


function setDefaultView() {
// Sets the default view(order method,order by, byte unit) for the current page viewed

	// define the values to change
	$viewParameters=array('OrderBy','OrderMethod','ByteUnit');
	
	reset($viewParameters);
	while(list($key,$value)=each($viewParameters)) {
		$dbName='default'.$_REQUEST['a'].$value;
		$dbValue=$_REQUEST["$value"];

		if($dbValue!='') {
			updateConfig($dbName,$dbValue);
		}

	}
}	


function errorHandler($line,$error) {
	echo "\nError at line: $line\n";
	echo "$error\n";
	exit(1);
}

function getIpFromIpID($ipID,$date) {
	global $s;
	
	$query="SELECT INET_NTOA(ip) AS ip FROM resolvedIPs WHERE id='$ipID' AND date='$date'";
	$recordSet=db_select_one_row($query);
	
	return $recordSet['ip'];
}

function getHostnameFromIp($ip) {
	
	$query="SELECT hostname FROM hostnames WHERE ip='$ip'";
	$recordSet=db_select_one_row($query);
	
	return $recordSet['hostname'];
}

function getSiteFromSiteID($sitesID,$date) {
	
	$query="SELECT id,site FROM sites WHERE id='$sitesID' AND date='$date'";
	$recordSet=db_select_one_row($query);
	return $recordSet['site'];
}


function getHostFromIP($ip,$date) {
	
	$query="SELECT id,ip as hostiplong,hostname,description,INET_NTOA(ip) AS ip FROM hostnames WHERE ip='$ip'";
	$recordSet=db_select_one_row($query);
	
	return $recordSet;
}


function getUserFromUsersID($usersID,$date) {
	$query="SELECT id,authuser FROM users WHERE id='$usersID' AND date='$date'";
	$recordSet=db_select_one_row($query);
	
	return $recordSet;
}
	
function getActiveUsers() {
	global $pageVars,$s;
	
	$time=date('H:i:s',$pageVars['lastTimestamp']-600);
	
	$query="SELECT ";
		$query.='COUNT(DISTINCTROW ip) AS users';
		$query.=' FROM traffic WHERE ';
		$query.="date='".$pageVars['date']."'";
		$query.=" AND ";
		$query.="time>'$time'";
	
	$recordSet=db_select_one_row($query);
	
	return $recordSet['users'];
}

function addParameter($url,$newParameter,$newValue) {
	// forms the url query string, adding or changing the selected parameters
	
	if($url=='') {
		return $newParameter.'='.$newValue;
	}
	$parameters=explode('&',$url);
	reset($parameters);
	while(list($key,$value)=each($parameters)) {
		if(!empty($newQueryString)) {
			$newQueryString=$newQueryString.'&';
		}
		$thisParameter=explode('=',$value);
		if($newParameter==$thisParameter['0']) {
			$newQueryString.=$newParameter.'='.$newValue;
			$foundParameter=TRUE;
		} else {
			$newQueryString.=$thisParameter['0'].'='.$thisParameter['1'];
		}
	}
	if($foundParameter!=TRUE) {
		$newQueryString.='&'.$newParameter.'='.$newValue;
	} else {
	}
	
	return $newQueryString;
}
	

function db_insert($query) {

	debug('('.$query.') ',50);
	$result=mysql_query($query);
	if(!$result) {
		db_error($query);
		debug('Exiting...',20,__FILE__,__LINE__);
		die(1);
	}
		
	$insertID=mysql_insert_id();
	debug('Insert ID: '.$insertID,40,__FILE__,__LINE__);
		
	return $insertID;
}


function db_insert_noexit ($query) {
        debug('('.$query.') ',50);
        $result=mysql_query($query);
}

function updateLastTimestamp($timestamp) {
	
	$query="UPDATE config SET value='$timestamp' WHERE name='lastTimestamp'";
	debug('Updating lastTimestamp...',40,__FILE__,__LINE__);
	db_update($query);
}

function updateConfig($name,$value) {
	
	debug("Updating config value $name to $value...",40,__FILE__,__LINE__);

	$query='SELECT ';
	$query.='name';
	$query.=' FROM ';
	$query.='config';
	$query.=' WHERE ';
	$query.="name='".$name."'";
	$result=mysql_query($query);
	if($result) {
		$numrows=mysql_num_rows($result);
	}
	if($numrows>0) {
		$query="UPDATE config SET value='".$value."' WHERE name='".$name."'";
		db_update($query);
	} else {
		$query='INSERT INTO ';
		$query.='config';
		$query.=' (';
		$query.='name';
		$query.=',';
		$query.='value';
		$query.=') VALUES (';
		$query.="'".$name."'";
		$query.=',';
		$query.="'".$value."'";
		$query.=')';
		db_insert($query);
	}
}


function url_addParameter($url,$newParameter,$newValue) {
// forms the url query string, adding or changing the selected parameters
		
	if($url=='') {
		return $newParameter.'='.$newValue;
	}
	$parameters=explode('&',$url);
	reset($parameters);
	while(list($key,$value)=each($parameters)) {
		if(!empty($newQueryString)) {
			$newQueryString=$newQueryString.'&';
		}
		$thisParameter=explode('=',$value);
		if($newParameter==$thisParameter['0']) {
			$newQueryString.=$newParameter.'='.$newValue;
			$foundParameter=TRUE;
		} else {
			$newQueryString.=$thisParameter['0'].'='.$thisParameter['1'];
		}
	}
	if($foundParameter!=TRUE) {
		$newQueryString.='&'.$newParameter.'='.$newValue;
	}
		
	return $newQueryString;
}


function url_createSortParameters($url,$validParameters) {
// modifies the given url, to include ASC and DESC parameters for the parameters given
		
	reset($validParameters);
	while(list($key,$value)=each($validParameters)) {
		$tmpUrl=url_addParameter($url,'OrderBy',$value);
		$newUrl[$value.'ASC']=url_addParameter($tmpUrl,'OrderMethod','ASC');
		$newUrl[$value.'DESC']=url_addParameter($tmpUrl,'OrderMethod','DESC');
	}
	
	return $newUrl;
}



function my_exit($errorCode) {
	global $lastImportedRecordsNumber,$record,$s;
	
	debug($lastImportedRecordsNumber.' records processed',30,__FILE__,__LINE__);
	updateConfig('lastTimeStamp',$record[0]);
	updateConfig('lastImportedRecordsNumber',$lastImportedRecordsNumber);
	debug("\n",30,__FILE__,__LINE__);

	exit($errorCode);
}

function string_trim($string,$maxLength,$substitute='') {
// if $string exceeds length $maxLength, and append $substitute, if it is set
		
	if(strlen($string)>$maxLength) {
		$newString=substr($string,0,$maxLength);
			
		return $newString.$substitute;
	}
		
	return $string;
}



?>
