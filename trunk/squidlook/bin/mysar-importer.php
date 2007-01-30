#!/usr/bin/php
<?php
# Program: SquidLook
# Copyright 2007, Trapanator <trap@trapanator.com>
# Derived from the work of:
# Program: mysar, File: bin/mysar.php
# Copyright 2004-2006, Stoilis Giannis <giannis@stoilis.gr>
#
# This file is part of mysar.
#
# mysar is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License version 2 as published by
# the Free Software Foundation.
#
# mysar is distributed in the hope that it will be useful,
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
debug('Start timestamp is '.$startTime,40,__FILE__,__LINE__);
debug('Configuration:'.print_r($iniConfig,TRUE),40,__FILE__,__LINE__);

$mysarImporter=getConfigValue('mysarImporter');
if($mysarImporter!='enabled') {
	debug('Importer is disabled. Exiting...',30,__FILE__,__LINE__);
	debug('',30,__FILE__,__LINE__);
	exit(0);
}

$maxRunTime=55;

// http://www.squid-cache.org/Doc/FAQ/FAQ.html#toc6.7
$inCacheCodes[]='TCP_HIT';
$inCacheCodes[]='TCP_REFRESH_HIT';
$inCacheCodes[]='TCP_DENIED';
$inCacheCodes[]='TCP_REF_FAIL_HIT';
$inCacheCodes[]='TCP_NEGATIVE_HIT';
$inCacheCodes[]='TCP_MEM_HIT';
$inCacheCodes[]='TCP_OFFLINE_HIT';


debug('Getting last proccessed record timestamp...',40,__FILE__,__LINE__);
$query="SELECT value FROM config WHERE name='lastTimestamp'";
$recordSet=db_select_one_row($query);
$lastTimestamp=$recordSet['value'];
debug($lastTimestamp,40);

$squidLogFile=getConfigValue('squidLogPath');

debug('Opening log file'.$squidLogFile.'...',40,__FILE__,__LINE__);
if(!file_exists($squidLogFile)) {
	debug('ERROR: squid log file('.$squidLogFile.') does not exist!',20,__FILE__,__LINE__);
	debug('Exiting...',20,__FILE__,__LINE__);
	debug(' ',20,__FILE__,__LINE__);
	die(1);
}
$handle = fopen($squidLogFile,"r");
if(!$handle) {
	debug('ERROR: Failed opening log file '.$iniConfig['squidLog'],20,__FILE__,__LINE__);
	my_exit(1);
}
debug('OK',40,__FILE__,__LINE__);

debug('Reading the last log offset...',40,__FILE__,__LINE__);
$lastLogOffset=getConfigValue('lastLogOffset');
debug($lastLogOffset,40,__FILE__,__LINE__);

debug('Reading the first log file line...',40,__FILE__,__LINE__);
$buffer=fgets($handle, 4096);
$record=preg_split("/\s+/",$buffer);
debug(print_r($record,TRUE),40,__FILE__,__LINE__);


#$firstLogTimestamp=getConfigValue('firstLogTimestamp');
#if($record['0']==$firstLogTimestamp && $firstLogTimestamp!='') {
#	debug('This is a known log file. Skipping to offset '.$lastLogOffset.'...',40,__FILE__,__LINE__);
	fseek($handle,$lastLogOffset);
#	debug('OK',40);		
#} else {
#	debug('This is a new log file.',40,__FILE__,__LINE__);
#	fseek($handle,0);
#	updateConfig('lastLogOffset',0);
#	updateConfig('firstLogTimestamp',$record['0']);
#}

#sleep (10);

# Users caching
$cache_users = array();

$lastImportedRecordsNumber=0;

while (!feof($handle)) {
	debug('Current file offset: '.ftell($handle),40,__FILE__,__LINE__);
	
	$timestampNow=mktime();
	debug('Now timestamp is: '.$timestampNow.'. Script start was at: '.$startTime,40,__FILE__,__LINE__);
	debug('Checking if run time exceeded '.$maxRunTime.' seconds...',40,__FILE__,__LINE__);
	if(($timestampNow-$startTime ) > $maxRunTime) {
		debug('YES',40);
		debug('Exceeded run time',30,__FILE__,__LINE__);
		my_exit(0);
	}
	debug('NO',40);

	debug('Reading one line from log file...',40,__FILE__,__LINE__);
	$buffer=fgets($handle, 4096);
	if($buffer==FALSE) {
		debug('Cannot read record. Skipping...',40,__FILE__,__LINE__);

		debug('Updating last known offset to '.ftell($handle).'... ',40,__FILE__,__LINE__);
		updateConfig('lastLogOffset',ftell($handle));
		debug('Done.',40);

		continue;
	}
	debug('OK',40);
	
	$record=preg_split("/\s+/",$buffer);
	debug('Record received: ',40,__FILE__,__LINE__);
	debug(print_r($record,TRUE),40,__FILE__,__LINE__);
	
	debug('Checking if it already processed...',40,__FILE__,__LINE__);
	if($record[0]<=$lastTimestamp) {
		debug('YES',40);
		// print a dot for every bad records
		// debug('.',30);

		debug('Updating last known offset to '.ftell($handle).'... ',40,__FILE__,__LINE__);
		updateConfig('lastLogOffset',ftell($handle));
		debug('Done.',40);
		
		continue;
	}
	// print a _ for every good record
	debug('NO',40);
	//debug('_',30);
	$lastImportedRecordsNumber++;
	
	debug('Parsing record...',40,__FILE__,__LINE__);
	$dbRecord['date']=date('Y-m-d',$record[0]);
	$dbRecord['time']=date('H:i:s',$record[0]);
	$dbRecord['elapsedTime']=$record[1];
	$dbRecord['summaryTime']=date('H',$record[0]);
	$dbRecord['elapsedTime']=$record[1];
	$dbRecord['ip']=$dbIP=$record[2];
	$dbRecord['resultCode']=$record[3];
	$dbRecord['bytes']=$record[4];

	$u = addslashes($record[6]);
	
	$dbRecord['url']= (substr ($u, -1) != '?') ? $u : substr ($u, 0, -1) ;

	$dbRecord['authuser']=mysql_real_escape_string(substr($record[7],0,50));

	// #### FILTRO - ELIMINAZIONE UTENTE '-'

	if ($dbRecord['authuser'] == '-') {
		continue;
	}

	// #### FILTRO - ESTENSIONI IGNORATE: CSS, JS

	$ext = array (".css", ".js", ".jpg", ".jpeg", ".png", ".gif", ".swf", ".ico", ".rss", ".xml", ".cgi", ".do", ".flv", ".rdf");

	foreach ($ext as $item) {
        	if (preg_match("/\\".$item.'$/i', $dbRecord['url'])) {
			continue 2;
		}
	}
					
	$resultCodeArray=explode('/',$dbRecord['resultCode']);
	
	// #### FILTRO - ELIMINAZIONE STATO TCP/DENIED 407
	
	if ($resultCodeArray[0] == 'TCP_DENIED') {
		continue;
	}
	
	if(in_array($resultCodeArray[0],$inCacheCodes)) {
		$dbRecord['field']='inCache';
	} else {
		$dbRecord['field']='outCache';
	}




	debug(print_r($dbRecord,TRUE),40,__FILE__,__LINE__);
	
	debug('Checking if this is a zero-bytes record...',40,__FILE__,__LINE__);	
	if($dbRecord['bytes']==0) {
		debug('YES',40);

		debug('Updating last known offset to '.ftell($handle).'... ',40,__FILE__,__LINE__);
		updateConfig('lastLogOffset',ftell($handle));
		debug('Done.',40);
		
		continue;
	}
	debug('NO',40);
	
	debug('Parsing url...',40,__FILE__,__LINE__);
	$dbUrlArray=parse_url($dbRecord['url']);
	debug(print_r($dbUrlArray,TRUE),40);
	
	if(isset($dbUrlArray['scheme']) && $dbUrlArray['scheme']=='error') {
		debug('X',30);

		debug('Updating last known offset to '.ftell($handle).'... ',40,__FILE__,__LINE__);
		updateConfig('lastLogOffset',ftell($handle));
		debug('Done.',40);

		continue;
	}

	if($dbUrlArray['host']=='cache_object') {
		debug('This a squid-specific poll. Ignoring this record...',40,__FILE__,__LINE__);
		
		debug('Updating last known offset to '.ftell($handle).'... ',40,__FILE__,__LINE__);
		updateConfig('lastLogOffset',ftell($handle));
		debug('Done.',40);

		continue;
	}
	
	debug('Inserting raw record into the database...',40,__FILE__,__LINE__);
	$query='INSERT INTO traffic(date,time,elapsedTime,ip,resultCode,bytes,url,authuser) VALUES (';
		$query.="'".$dbRecord['date']."'";
		$query.=',';
		$query.="'".$dbRecord['time']."'";
		$query.=',';
		$query.="'".$dbRecord['elapsedTime']."'";
		$query.=',';
		$query.="INET_ATON('".$dbRecord['ip']."')";
		$query.=',';
		$query.="'".$dbRecord['resultCode']."'";
		$query.=',';
		$query.="'".$dbRecord['bytes']."'";
		$query.=',';
		$query.="'".$dbRecord['url']."'";
		$query.=',';
		$query.="'".$dbRecord['authuser']."'";
		$query.=')';
	$dbRecord['id']=db_insert($query);

	debug('Searching ip '.$dbRecord['ip'].'...',40,__FILE__,__LINE__);
	$query="SELECT id FROM hostnames WHERE ip=INET_ATON('".$dbRecord['ip']."')";
	$recordSet=db_select_one_row($query);
	if($recordSet['id']=='') {
		debug('Not found. Inserting to database...',40,__FILE__,__LINE__);
		$query='INSERT INTO ';
		$query.='hostnames';
		$query.='(';
		$query.='ip';
		$query.=',';
		$query.='hostname';
		$query.=') VALUES (';
		$query.="INET_ATON('".$dbRecord['ip']."')";
		$query.=',';
		$query.="'".$dbRecord['ip']."'";
		$query.=')';
		$hostnamesID=db_insert($query);
	} else {
		debug('Found.',40,__FILE__,__LINE__);
		$hostnamesID=$recordSet['id'];
	}
	debug('Hostname ID is: '.$hostnamesID,40,__FILE__,__LINE__);

	if(empty($dbUrlArray['scheme'])) {
		$dbUrl='http';
	} else {
		$dbUrl=$dbUrlArray['scheme'];
	}
	$dbUrl.='://'.$dbUrlArray['host'];
	if(!(empty($dbUrlArray['port']) || $dbUrlArray['port']=='80')) {
		$dbUrl.=':'.$dbUrlArray['port'];
	}
	$dbUrl=substr($dbUrl,0,254);
	
	debug('Full host url is '.$dbUrl,40,__FILE__,__LINE__);
	
	debug('Searching id of host '.$dbUrl.'...',40,__FILE__,__LINE__);
	$query="SELECT id FROM sites WHERE site='".$dbUrl."'";
	$recordSet=db_select_one_row($query);
	if($recordSet['id']=='') {
		debug('Not found. Inserting to database...',40,__FILE__,__LINE__);
		$query="INSERT INTO sites(site) VALUES ('$dbUrl')";
		$sitesID=db_insert($query);
	} else {
		debug('Found.',40,__FILE__,__LINE__);
		$sitesID=$recordSet['id'];
	}
	debug('Site ID is: '.$sitesID,40,__FILE__,__LINE__);

	$query="INSERT INTO whitelist(id,site) VALUES ('$sitesID','$dbUrl')";
	db_insert_noexit($query);

        $user = $dbRecord['authuser']; 
	debug('Searching id of user '.$user.'...',40,__FILE__,__LINE__);
        if (array_key_exists($user, $cache_users)) { 
                $usersID = $cache_users[$user];
		debug('User $user cached. The ID is '.$usersID);
	} else {
		$query="SELECT id FROM users WHERE authuser='".$user."'";
		$recordSet=db_select_one_row($query);
		if($recordSet['id']=='') {
			debug('Not found. Inserting to database...',40,__FILE__,__LINE__);
        	        $group = $mgroups [getGroupID ($user, $mgroups)]; 
	                debug('Found group "'. $group .'" for user '. $user,40,__FILE__,__LINE__);
			$query="INSERT INTO users(authuser,servizio) VALUES ('".$user."','".$group."')";
			$usersID=db_insert($query);

			$query="INSERT INTO groups(username,servizio) VALUES ('".$user."','".$group."')";
			db_insert($query);
		} else {
			debug('Found.',40,__FILE__,__LINE__);
			$usersID=$recordSet['id'];
		}
	}
	debug('User ID is: '.$usersID,40,__FILE__,__LINE__);
	
	debug('Updating trafficSummaries...',40,__FILE__,__LINE__);
	$query='UPDATE ';
	$query.='trafficSummaries SET ';
	$query.=$dbRecord['field'].'='.$dbRecord['field'].'+'.$dbRecord['bytes'];
	$query.=' WHERE ';
	$query.="date='".$dbRecord['date']."'";
	$query.=" AND ";
	$query.="ip=INET_ATON('".$dbRecord['ip']."')";
	$query.=" AND ";
	$query.="sitesID='$sitesID'";
	$query.=" AND ";
	$query.="usersID='$usersID'";
        $query.=" AND ";
	$query.="groupID='$group'";
	$query.=" AND ";
	$query.="summaryTime='".$dbRecord['summaryTime']."'";
	$affectedRows=db_update($query);
	if($affectedRows==0) {
		debug('Did not update. Trying insert...',40,__FILE__,__LINE__);
		$query='INSERT INTO trafficSummaries(date,ip,'.$dbRecord['field'].',sitesID,usersID,summaryTime) VALUES (';
			$query.="'".$dbRecord['date']."'";
			$query.=',';
			$query.="INET_ATON('".$dbRecord['ip']."')";
			$query.=',';
			$query.="'".$dbRecord['bytes']."'";
			$query.=',';
			$query.="'$sitesID'";
			$query.=',';
			$query.="'$usersID'";
			$query.=',';
			$query.="'".$dbRecord['summaryTime']."'";
			$query.=')';
		$insertID=db_insert($query);
		debug('Insert ID is '.$insertID,40,__FILE__,__LINE__);
	}

        debug('Updating trafficSummaries...',40,__FILE__,__LINE__);
        $query='UPDATE ';
        $query.='trafficSummaries SET ';
        $query.='elapsedTime=elapsedTime+'.$dbRecord['elapsedTime'];
        $query.=' WHERE ';
        $query.="date='".$dbRecord['date']."'";
        $query.=" AND ";
        $query.="ip=INET_ATON('".$dbRecord['ip']."')";
        $query.=" AND ";
        $query.="sitesID='$sitesID'";
        $query.=" AND ";
        $query.="usersID='$usersID'";
        $query.=" AND ";
        $query.="summaryTime='".$dbRecord['summaryTime']."'";
        $affectedRows=db_update($query);


	$query='UPDATE ';
        $query.='trafficSummaries SET ';
        $query.='count=count+1';
        $query.=' WHERE ';
        $query.="date='".$dbRecord['date']."'";
        $query.=" AND ";
        $query.="ip=INET_ATON('".$dbRecord['ip']."')";
        $query.=" AND ";
        $query.="sitesID='$sitesID'";
        $query.=" AND ";
        $query.="usersID='$usersID'";
        $query.=" AND ";
        $query.="summaryTime='".$dbRecord['summaryTime']."'";
        $affectedRows=db_update($query);
							
	debug('Updating original record id '.$dbRecord['id'].' to contain sitesID and usersID...',40,__FILE__,__LINE__);
	$query='UPDATE ';
	$query.='traffic ';
	$query.='SET ';
	$query.="sitesID='".$sitesID."'";
	$query.=',';
	$query.="usersID='".$usersID."'";
	$query.=' WHERE ';
	$query.="id='".$dbRecord['id']."'";
	db_update($query,1);

	debug('Updating last processed record to '.$record[0].'... ',40,__FILE__,__LINE__);
	updateConfig('lastTimeStamp',$record[0]);
	debug('Done.',40);

	debug('Updating last known offset to '.ftell($handle).'... ',40,__FILE__,__LINE__);
	updateConfig('lastLogOffset',ftell($handle));
	debug('Done.',40);
}
my_exit(0);
?>
