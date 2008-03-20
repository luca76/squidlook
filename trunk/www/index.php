<?php 
# Program: squidLook, File: www/index.php
# Copyright 2007-2008, Luca Manganelli <luca76@gmail.com> - Servizio Sistema Informativo, Comune di Trento
# Derived from: mysar,
# copyright 2004-2005, Stoilis Giannis <giannis@stoilis.gr>
#
# This file is part of squidLook.
#
# squidLook is free software; you can redistribute it and/or modify
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


$DEBUG_MODE='web';
$DEBUG_LEVEL='20';

// calculate the base path of the program
$basePath=realpath(dirname(__FILE__).'/../');

if (!file_exists($basePath."/etc/config.ini")) {
        header("location: install/?install=");
        die();
}

$iniFile = parse_ini_file ($basePath."/etc/config.ini");

#if(file_exists('install') && !file_exists('install/install.done')) {
if ($iniFile['installed'] != 1) {
	// require('install/index.php');
	header("location: install/");
	die();
}

error_reporting(E_ALL);

// Common tasks for both web and cmd
require($basePath.'/inc/common.inc.php');

$pageVars['programName']=PROGRAM_NAME_LONG;
$pageVars['programVersion']=PROGRAM_VERSION;

$smarty->register_modifier('bytesToHRF','bytesToHRF');
$smarty->assign('pageVars',$pageVars);

// get last accessed record
$pageVars['lastTimestamp']=getConfigValue('lastTimestamp');
if ($pageVars['lastTimestamp'] == 0) {
	$pageVars['lastTimestamp'] = mktime();
}
$pageVars['lastTimestampFormatted']=date('d-m-Y H:i:s',$pageVars['lastTimestamp']);

// get last clean-up
if (getConfigValue('lastCleanUp')=='') {
	$pageVars['lastCleanUp'] = "Never";
} else {
	$pageVars['lastCleanUp']=date_Ymd2dmY_seperator(getConfigValue('lastCleanUp'),'-');
}

require ($basePath.'/inc/translation.inc.php');
#$pageVars['lang'] = getConfigValue('language');
loadtranslations (getConfigValue('language'));
$smarty->register_function('translate', 'translate');

// get last imported records number
$pageVars['lastImportedRecordsNumber']=getConfigValue('lastImportedRecordsNumber');

$pageVars['currentDateTime']=date('d-m-Y H:i:s');

if(empty($_REQUEST['a'])) {
	$pageVars['thisPage']='index';
} else {
	$pageVars['thisPage']=$_REQUEST['a'];
}

if(empty($_REQUEST['date'])) {
	$pageVars['date']=date('Y-m-d');
} else {
	$pageVars['date']=$_REQUEST['date'];
}

$pageVars['uri']=$_SERVER['REQUEST_URI'];
$pageVars['thisDateFormatted']=date('l, d F Y',date_timestampFromDbDate($pageVars['date'],'-'));
$dateArray=explode('-',$pageVars['date']);
$pageVars['today']=date('Y-m-d');
$pageVars['year']=$dateArray['0'];
$pageVars['month']=$dateArray['1'];
$pageVars['day']=$dateArray['2'];
$pageVars['previousDate']=date('Y-m-d',mktime(0,0,0,$pageVars['month'],$pageVars['day']-1,$pageVars['year']));
$pageVars['nextDate']=date('Y-m-d',mktime(0,0,0,$pageVars['month'],$pageVars['day']+1,$pageVars['year']));
$pageVars['previousWeek']=date('Y-m-d',mktime(0,0,0,$pageVars['month'],$pageVars['day']-7,$pageVars['year']));
$pageVars['nextWeek']=date('Y-m-d',mktime(0,0,0,$pageVars['month'],$pageVars['day']+7,$pageVars['year']));
if(!empty($_REQUEST['hostiplong'])) {
	$pageVars['host']=getHostFromIP($_REQUEST['hostiplong'],$pageVars['date']);
	$pageVars['hostiplong']=$_REQUEST['hostiplong'];
}

if(!empty($_REQUEST['sitesID'])) {
	$pageVars['sitesID']=$_REQUEST['sitesID'];
	$pageVars['site']=getSiteFromSiteID($pageVars['sitesID'],$pageVars['date']);
}

$pageVars['activeUsers']=getActiveUsers();

if (!empty($_REQUEST['usersID'])) {
	$pageVars['user']=getUserFromUsersID($_REQUEST['usersID'],$pageVars['date']);
	$pageVars['usersID']=$_REQUEST['usersID'];
}

if (!empty($_REQUEST['action'])) {
	if($_REQUEST['action']=='setDefaultView') {
		setDefaultView();
	}
}

$request = empty($_REQUEST['a']) ? '' : $_REQUEST['a'];

switch($request) {
	case 'IPSummary':
		// create the urls for the users,date, bytes and cachePercent
		$validSortedFields[]='bytes';
		$validSortedFields[]='hostip';
		$validSortedFields[]='username';
		$validSortedFields[]='sites';
		$validSortedFields[]='cachePercent';
		$pageVars['url']=url_createSortParameters($_SERVER['QUERY_STRING'],$validSortedFields);
		
		// create the urls for the byte unit
		$pageVars['url']['B']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','B');
		$pageVars['url']['K']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','K');
		$pageVars['url']['M']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','M');
		$pageVars['url']['G']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','G');

		// determing the sort method, or get the defaults
		if(empty($_REQUEST['OrderBy'])) {
			$pageVars['OrderBy']=getConfigValue('defaultIPSummaryOrderBy');
		} else {
			$pageVars['OrderBy']=$_REQUEST['OrderBy'];
		}
		if(empty($_REQUEST['OrderMethod'])) {
			$pageVars['OrderMethod']=getConfigValue('defaultIPSummaryOrderMethod');
		} else {
			$pageVars['OrderMethod']=$_REQUEST['OrderMethod'];
		}
		
		// get byte unit used
		if(empty($_REQUEST['ByteUnit'])) {
			$pageVars['ByteUnit']=getConfigValue('defaultIPSummaryByteUnit');
		} else {
			$pageVars['ByteUnit']=$_REQUEST['ByteUnit'];
		}

		// Fall back to reasonable defaults in case the database is missing these values
		if(empty($pageVars['OrderBy'])) {
			$pageVars['OrderBy']=$validSortedFields['0'];
		}
		
		$pageVars[$pageVars['OrderBy'].'LabelStart']='<u>';
		$pageVars[$pageVars['OrderBy'].'LabelEnd']='</u>';
		$pageVars[$pageVars['OrderBy'].$pageVars['OrderMethod'].'ImageBorder']='1';
		$pageVars[$pageVars['ByteUnit'].'LabelStart']='<u>';
		$pageVars[$pageVars['ByteUnit'].'LabelEnd']='</u>';
		
		$query='SELECT ';
		$query.='INET_NTOA(trafficSummaries.ip) AS hostip';
		$query.=',';
		$query.='trafficSummaries.ip AS hostiplong';
		$query.=',';
		$query.='hostnames.hostname AS hostname';
		$query.=',';
		$query.='hostnames.description AS hostdescription';
		$query.=',';
		$query.='users.id AS usersID';
		$query.=',';
		$query.='users.authuser AS username';
		$query.=',';
		$query.='SUM(trafficSummaries.inCache+trafficSummaries.outCache) as bytes';
		$query.=',';
		$query.='TRUNCATE((SUM(trafficSummaries.inCache)/SUM(trafficSummaries.inCache+trafficSummaries.outCache))*100,0) AS cachePercent';
		$query.=',';
		$query.='COUNT(DISTINCTROW(trafficSummaries.sitesID)) AS sites';
		$query.=' FROM trafficSummaries';
		$query.=' LEFT JOIN hostnames';
		$query.=' ON ';
		$query.='trafficSummaries.ip=hostnames.ip';
		$query.=' LEFT JOIN users';
		$query.=' ON ';
		$query.='trafficSummaries.usersID=users.id';
		$query.=' AND ';
		$query.='trafficSummaries.date=users.date';
		$query.=' WHERE ';
		$query.="trafficSummaries.date='".$pageVars['date']."'";
		$query.=' GROUP BY trafficSummaries.ip,trafficSummaries.usersID';
		$query.=' ORDER BY '.$pageVars['OrderBy'].' '.$pageVars['OrderMethod'];
		$pageVars['summaryIPRecords']=db_select_all($query);
		
		$query='SELECT ';
		$query.='COUNT(DISTINCTROW(ip)) AS ips';
		$query.=',';
		$query.='COUNT(DISTINCTROW(usersID)) AS users';
		$query.=',';
		$query.='COUNT(DISTINCTROW(sitesID)) AS sites';
		$query.=' FROM ';
		$query.='trafficSummaries';
		$query.=' WHERE ';
		$query.="trafficSummaries.date='".$pageVars['date']."'";
		$pageVars['distinctValues']=db_select_one_row($query);
		
		$query='SELECT ';
		$query.='INET_NTOA(traffic.ip) AS hostip';
		$query.=',';
		$query.='traffic.ip AS hostiplong';
		$query.=',';
		$query.='hostnames.hostname AS hostname';
		$query.=',';
		$query.='hostnames.description AS hostdescription';
		$query.=',';
		$query.='traffic.usersID AS usersID';
		$query.=',';
		$query.='traffic.authuser AS username';
		$query.=',';
		$query.='traffic.time AS time';
		$query.=',';
		$query.='traffic.bytes AS bytes';
		$query.=',';
		$query.='traffic.url AS url';
		$query.=',';
		$query.='traffic.resultCode AS resultCode';
		$query.=' FROM traffic';
		$query.=' LEFT JOIN hostnames';
		$query.=' ON ';
		$query.='traffic.ip=hostnames.ip';
		$query.=' WHERE ';
		$query.="traffic.date='".$pageVars['date']."'";
		$query.=' ORDER BY traffic.time DESC ';
		$query.=' LIMIT 10';
		$pageVars['latestUserActivity']=db_select_all($query);
				
		$template='IPSummary';
		break;

	case 'IPSitesSummary':
		if($_REQUEST['action']=='hostDescriptionUpdate') {
			$query='UPDATE ';
			$query.='hostnames';
			$query.=' SET ';
			$query.="description='".$_REQUEST['thisValue']."'";
			$query.=' WHERE ';
			$query.="ip='".$_REQUEST['hostiplong']."'";
			db_update($query);
			$pageVars['host']=getHostFromIP($_REQUEST['hostiplong'],$pageVars['date']);
		}
		$validSortedFields[]='bytes';
		$validSortedFields[]='site';
		$validSortedFields[]='cachePercent';
		$pageVars['url']=url_createSortParameters($_SERVER['QUERY_STRING'],$validSortedFields);
		
		// create the urls for the byte unit
		$pageVars['url']['B']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','B');
		$pageVars['url']['K']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','K');
		$pageVars['url']['M']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','M');
		$pageVars['url']['G']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','G');

		// determing the sort method, or get the defaults
		if(empty($_REQUEST['OrderBy'])) {
			$pageVars['OrderBy']=getConfigValue('defaultIPSitesSummaryOrderBy');
		} else {
			$pageVars['OrderBy']=$_REQUEST['OrderBy'];
		}
		if(empty($_REQUEST['OrderMethod'])) {
			$pageVars['OrderMethod']=getConfigValue('defaultIPSitesSummaryOrderMethod');
		} else {
			$pageVars['OrderMethod']=$_REQUEST['OrderMethod'];
		}
		
		// get byte unit used
		if(empty($_REQUEST['ByteUnit'])) {
			$pageVars['ByteUnit']=getConfigValue('defaultIPSitesSummaryByteUnit');
		} else {
			$pageVars['ByteUnit']=$_REQUEST['ByteUnit'];
		}

		// Fall back to reasonable defaults in case the database is missing these values
		if(empty($pageVars['OrderBy'])) {
			$pageVars['OrderBy']=$validSortedFields['0'];
		}
		
		$pageVars[$pageVars['OrderBy'].'LabelStart']='<u>';
		$pageVars[$pageVars['OrderBy'].'LabelEnd']='</u>';
		$pageVars[$pageVars['OrderBy'].$pageVars['OrderMethod'].'ImageBorder']='1';
		$pageVars[$pageVars['ByteUnit'].'LabelStart']='<u>';
		$pageVars[$pageVars['ByteUnit'].'LabelEnd']='</u>';
		
		$query="SELECT ";
		$query.='trafficSummaries.sitesID AS sitesID';
		$query.=',';
		$query.='sites.site AS site';
		$query.=',';
		$query.='SUM(trafficSummaries.inCache+trafficSummaries.outCache) AS bytes';
		$query.=',';
		$query.='TRUNCATE((SUM(trafficSummaries.inCache)/SUM(trafficSummaries.inCache+trafficSummaries.outCache))*100,0) AS cachePercent';
		$query.=' FROM trafficSummaries';
		$query.=' JOIN sites ON ';
		$query.='trafficSummaries.sitesID=sites.id';
		$query.=' AND ';
		$query.='trafficSummaries.date=sites.date';
		$query.=' WHERE ';
		$query.="trafficSummaries.ip='".$pageVars['hostiplong']."'";
		$query.=' AND ';
		$query.="trafficSummaries.date='".$pageVars['date']."'";
		$query.=' AND ';
		$query.="trafficSummaries.usersID='".$pageVars['usersID']."'";
		$query.=" GROUP BY trafficSummaries.sitesID";
		$query.=' ORDER BY '.$pageVars['OrderBy'].' '.$pageVars['OrderMethod'];
		$pageVars['summaryIPSites']=db_select_all($query);
		
		$query='SELECT ';
		$query.='INET_NTOA(traffic.ip) AS hostip';
		$query.=',';
		$query.='traffic.ip AS hostiplong';
		$query.=',';
		$query.='traffic.usersID AS usersID';
		$query.=',';
		$query.='traffic.authuser AS username';
		$query.=',';
		$query.='traffic.time AS time';
		$query.=',';
		$query.='traffic.bytes AS bytes';
		$query.=',';
		$query.='traffic.url AS url';
		$query.=',';
		$query.='traffic.resultCode AS resultCode';
		$query.=' FROM traffic';
		$query.=' WHERE ';
		$query.="traffic.date='".$pageVars['date']."'";
		$query.=' AND ';
		$query.="traffic.usersID='".$pageVars['usersID']."'";
		$query.=' AND ';
		$query.="traffic.ip='".$pageVars['hostiplong']."'";
		$query.=' ORDER BY traffic.time DESC ';
		$query.=' LIMIT 10';
		$pageVars['latestUserActivity']=db_select_all($query);
		
		$template='IPSitesSummary';
		break;

	case 'details':
		$validSortedFields[]='time';
		$validSortedFields[]='bytes';
		$validSortedFields[]='url';
		$validSortedFields[]='status';
		$pageVars['url']=url_createSortParameters($_SERVER['QUERY_STRING'],$validSortedFields);

		// create the urls for the byte unit
		$pageVars['url']['B']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','B');
		$pageVars['url']['K']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','K');
		$pageVars['url']['M']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','M');
		$pageVars['url']['G']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','G');
		
		// determing the sort method, or get the defaults
		if(empty($_REQUEST['OrderBy'])) {
			$pageVars['OrderBy']=getConfigValue('defaultDateTimeOrderBy');
		} else {
			$pageVars['OrderBy']=$_REQUEST['OrderBy'];
		}
		if(empty($_REQUEST['OrderMethod'])) {
			$pageVars['OrderMethod']=getConfigValue('defaultDateTimeOrderMethod');
		} else {
			$pageVars['OrderMethod']=$_REQUEST['OrderMethod'];
		}
		// get byte unit used
		if(empty($_REQUEST['ByteUnit'])) {
			$pageVars['ByteUnit']=getConfigValue('defaultDateTimeByteUnit');
		} else {
			$pageVars['ByteUnit']=$_REQUEST['ByteUnit'];
		}
		
		// Fall back to reasonable defaults in case the database is missing these values
		if(empty($pageVars['OrderBy'])) {
			$pageVars['OrderBy']=$validSortedFields['0'];
		}

		$pageVars[$pageVars['OrderBy'].'LabelStart']='<u>';
		$pageVars[$pageVars['OrderBy'].'LabelEnd']='</u>';
		$pageVars[$pageVars['OrderBy'].$pageVars['OrderMethod'].'ImageBorder']='1';
		$pageVars[$pageVars['ByteUnit'].'LabelStart']='<u>';
		$pageVars[$pageVars['ByteUnit'].'LabelEnd']='</u>';

		if($pageVars['OrderBy']=='status') {
			$pageVars['OrderBy']='resultCode';
		}
		$query="SELECT ";
		$query.="time,bytes,url,resultCode";
		$query.=" FROM traffic";
		$query.=" WHERE ";
		$query.="date='".$pageVars['date']."'";
		$query.=" AND ";
		$query.="sitesID='".$pageVars['sitesID']."'";
		$query.=" AND ";
		$query.="usersID='".$pageVars['usersID']."'";
		$query.=" AND ";
		$query.="ip='".$pageVars['hostiplong']."'";
		$query.=' ORDER BY '.$pageVars['OrderBy'].' '.$pageVars['OrderMethod'];
		$pageVars['siteDetails']=db_select_all($query);

		$template='details';
		break;
	
	case 'allsites':
		$validSortedFields[]='bytes';
		$validSortedFields[]='site';
		$validSortedFields[]='hosts';
		$validSortedFields[]='users';
		$validSortedFields[]='cachePercent';
		$pageVars['url']=url_createSortParameters($_SERVER['QUERY_STRING'],$validSortedFields);
		
		// create the urls for the byte unit
		$pageVars['url']['B']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','B');
		$pageVars['url']['K']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','K');
		$pageVars['url']['M']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','M');
		$pageVars['url']['G']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','G');

		// determing the sort method, or get the defaults
		if(empty($_REQUEST['OrderBy'])) {
			$pageVars['OrderBy']=getConfigValue('defaultAllSitesOrderBy');
		} else {
			$pageVars['OrderBy']=$_REQUEST['OrderBy'];
		}
		if(empty($_REQUEST['OrderMethod'])) {
			$pageVars['OrderMethod']=getConfigValue('defaultAllSitesOrderMethod');
		} else {
			$pageVars['OrderMethod']=$_REQUEST['OrderMethod'];
		}
		
		// get byte unit used
		if(empty($_REQUEST['ByteUnit'])) {
			$pageVars['ByteUnit']=getConfigValue('defaultAllSitesByteUnit');
		} else {
			$pageVars['ByteUnit']=$_REQUEST['ByteUnit'];
		}

		// Fall back to reasonable defaults in case the database is missing these values
		if(empty($pageVars['OrderBy'])) {
			$pageVars['OrderBy']=$validSortedFields['0'];
		}
		
		$pageVars[$pageVars['OrderBy'].'LabelStart']='<u>';
		$pageVars[$pageVars['OrderBy'].'LabelEnd']='</u>';
		$pageVars[$pageVars['OrderBy'].$pageVars['OrderMethod'].'ImageBorder']='1';
		$pageVars[$pageVars['ByteUnit'].'LabelStart']='<u>';
		$pageVars[$pageVars['ByteUnit'].'LabelEnd']='</u>';

		$query='SELECT ';
		$query.='sites.id AS sitesID';
		$query.=',';
		$query.='sites.site AS site';
		$query.=',';
		$query.='COUNT(DISTINCTROW(usersID)) AS users';
		$query.=',';
		$query.='COUNT(DISTINCTROW(ip)) AS hosts';
		$query.=',';
		$query.='SUM(trafficSummaries.inCache+trafficSummaries.outCache) AS bytes';
		$query.=',';
		$query.='TRUNCATE((SUM(trafficSummaries.inCache)/SUM(trafficSummaries.inCache+trafficSummaries.outCache))*100,0) AS cachePercent';
		$query.=' FROM ';
		$query.='trafficSummaries';
		$query.=' JOIN sites ON ';
		$query.='trafficSummaries.date=sites.date';
		$query.=' AND ';
		$query.='trafficSummaries.sitesID=sites.id';
		$query.=' WHERE ';
		$query.="trafficSummaries.date='".$pageVars['date']."'";
		$query.=' GROUP BY trafficSummaries.sitesID';
		$query.=' ORDER BY '.$pageVars['OrderBy'].' '.$pageVars['OrderMethod'];
		$pageVars['allSites']=db_select_all($query);	
		
		$template='allsites';
		break;
		
	case 'siteusers':
		$validSortedFields[]='bytes';
		$validSortedFields[]='ip';
		$validSortedFields[]='hostname';
		$validSortedFields[]='cachePercent';
		$pageVars['url']=url_createSortParameters($_SERVER['QUERY_STRING'],$validSortedFields);
		
		// create the urls for the byte unit
		$pageVars['url']['B']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','B');
		$pageVars['url']['K']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','K');
		$pageVars['url']['M']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','M');
		$pageVars['url']['G']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','G');

		// determing the sort method, or get the defaults
		if(empty($_REQUEST['OrderBy'])) {
			$pageVars['OrderBy']=getConfigValue('defaultSiteUsersOrderBy');
		} else {
			$pageVars['OrderBy']=$_REQUEST['OrderBy'];
		}
		if(empty($_REQUEST['OrderMethod'])) {
			$pageVars['OrderMethod']=getConfigValue('defaultSiteUsersOrderMethod');
		} else {
			$pageVars['OrderMethod']=$_REQUEST['OrderMethod'];
		}
		
		// get byte unit used
		if(empty($_REQUEST['ByteUnit'])) {
			$pageVars['ByteUnit']=getConfigValue('defaultSiteUsersByteUnit');
		} else {
			$pageVars['ByteUnit']=$_REQUEST['ByteUnit'];
		}
		
		// Fall back to reasonable defaults in case the database is missing these values
		if(empty($pageVars['OrderBy'])) {
			$pageVars['OrderBy']=$validSortedFields['0'];
		}

		// use this to REALLY sort by ip number, not by ip char...
		if($pageVars['OrderBy']=='ip') {
			$pageVars['OrderBy']='ipNTOA';
		}

		$pageVars[$pageVars['OrderBy'].'LabelStart']='<u>';
		$pageVars[$pageVars['OrderBy'].'LabelEnd']='</u>';
		$pageVars[$pageVars['OrderBy'].$pageVars['OrderMethod'].'ImageBorder']='1';
		$pageVars[$pageVars['ByteUnit'].'LabelStart']='<u>';
		$pageVars[$pageVars['ByteUnit'].'LabelEnd']='</u>';

		$query='SELECT ';
		$query.='trafficSummaries.ip AS hostiplong';
		$query.=',';
		$query.='INET_NTOA(hostnames.ip) AS hostip';
		$query.=',';
		$query.='hostnames.hostname AS hostname';
		$query.=',';
		$query.='hostnames.description AS hostdescription';
		$query.=',';
		$query.='users.id AS usersID';
		$query.=',';
		$query.='users.authuser AS username';
		$query.=',';
		$query.='SUM(trafficSummaries.inCache+trafficSummaries.outCache) AS bytes';
		$query.=',';
		$query.='TRUNCATE((SUM(trafficSummaries.inCache)/SUM(trafficSummaries.inCache+trafficSummaries.outCache))*100,0) AS cachePercent';
		$query.=' FROM ';
		$query.='trafficSummaries';
		$query.=' JOIN hostnames ON ';
		$query.='trafficSummaries.ip=hostnames.ip';
		$query.=' JOIN users ON ';
		$query.='trafficSummaries.date=users.date';
		$query.=' AND ';
		$query.='trafficSummaries.usersID=users.id';
		$query.=' WHERE ';
		$query.="trafficSummaries.date='".$pageVars['date']."'";
		$query.=' AND ';
		$query.="trafficSummaries.sitesID='".$pageVars['sitesID']."'";
		$query.=' GROUP BY trafficSummaries.ip,trafficSummaries.usersID';
		$query.=' ORDER BY '.$pageVars['OrderBy'].' '.$pageVars['OrderMethod'];
		$pageVars['siteusers']=db_select_all($query);
		
		$query='SELECT ';
		$query.='COUNT(DISTINCTROW(usersID)) AS users';
		$query.=' FROM ';
		$query.='trafficSummaries';
		$query.=' WHERE ';
		$query.="trafficSummaries.date='".$pageVars['date']."'";
		$query.=' AND ';
		$query.="trafficSummaries.sitesID='".$pageVars['sitesID']."'";
		$pageVars['distinctValues']=db_select_one_row($query);
		
		$query='SELECT ';
		$query.='INET_NTOA(traffic.ip) AS hostip';
		$query.=',';
		$query.='traffic.ip AS hostiplong';
		$query.=',';
		$query.='traffic.usersID AS usersID';
		$query.=',';
		$query.='traffic.authuser AS username';
		$query.=',';
		$query.='traffic.time AS time';
		$query.=',';
		$query.='traffic.bytes AS bytes';
		$query.=',';
		$query.='traffic.url AS url';
		$query.=',';
		$query.='traffic.resultCode AS resultCode';
		$query.=' FROM traffic';
		$query.=' WHERE ';
		$query.="traffic.date='".$pageVars['date']."'";
		$query.=' AND ';
		$query.="traffic.sitesID='".$pageVars['sitesID']."'";
		$query.=' ORDER BY traffic.time DESC ';
		$query.=' LIMIT 10';
		$pageVars['latestSiteActivity']=db_select_all($query);
		
		$template='siteusers';
		break;
		
	case 'administration':
		$template='administration';
		
		if (!empty ($_REQUEST['hiddenSubmit'])) {
			if($_REQUEST['hiddenSubmit']=='1') {

				updateConfig($_REQUEST['configName'],$_REQUEST['thisValue']);

			} elseif($_REQUEST['action']=='eraseAllStats') {
				$tables=array('hostnames','sites','traffic','trafficSummaries','users');
				reset($tables);
				while(list($key,$value)=each($tables)) {
					$query='TRUNCATE TABLE '.$value;
					db_query($query);
				}
				updateConfig('lastTimestamp','0');
			}
		}

		$configVariables[]='keepHistoryDays';
		$configVariables[]='resolveClients';
		$configVariables[]='squidLogPath';
		$configVariables[]='squidlookImporter';
		$configVariables[]='topGrouping';
		$configVariables[]='language';
		
		reset($configVariables);
		while(list($key,$value)=each($configVariables)) {
			$pageVars[$value]=getConfigValue($value);
		}

		$lang = array();
		# Search the available languages
		foreach (glob("../lang/*.lang") as $filename) {
			$h = fopen ($filename, 'r');
			$l = fgets ($h, 255);
			fclose ($h);
			$lang[substr ($filename, strrpos ($filename, "/") + 1, 255)] = trim (substr ($l, stripos ($l, ": ") + 2, 255));
		}
		$pageVars["languages"] = $lang;
		break;

	default:
		// create the urls for the users,date, bytes and cachePercent
		$validSortedFields[]='date';
		$validSortedFields[]='bytes';
		$validSortedFields[]='cachePercent';
		$validSortedFields[]='hosts';
		$validSortedFields[]='sites';
		$validSortedFields[]='users';
		$pageVars['url']=url_createSortParameters($_SERVER['QUERY_STRING'],$validSortedFields);
		
		// create the urls for the byte unit
		$pageVars['url']['B']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','B');
		$pageVars['url']['K']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','K');
		$pageVars['url']['M']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','M');
		$pageVars['url']['G']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','G');

		// determing the sort method, or get the defaults
			if(empty($_REQUEST['OrderBy'])) {
			$pageVars['OrderBy']=getConfigValue('defaultIndexOrderBy');
		} else {
			$pageVars['OrderBy']=$_REQUEST['OrderBy'];
		}
		if(empty($_REQUEST['OrderMethod'])) {
			$pageVars['OrderMethod']=getConfigValue('defaultIndexOrderMethod');
		} else {
			$pageVars['OrderMethod']=$_REQUEST['OrderMethod'];
		}
		
		// get byte unit used
		if(empty($_REQUEST['ByteUnit'])) {
			$pageVars['ByteUnit']=getConfigValue('defaultIndexByteUnit');
		} else {
			$pageVars['ByteUnit']=$_REQUEST['ByteUnit'];
		}
		
		// Fall back to reasonable defaults in case the database is missing these values
		if(empty($pageVars['OrderBy'])) {
			$pageVars['OrderBy']=$validSortedFields['0'];
		}

		$pageVars[$pageVars['OrderBy'].'LabelStart']='<u>';
		$pageVars[$pageVars['OrderBy'].'LabelEnd']='</u>';
		$pageVars[$pageVars['OrderBy'].$pageVars['OrderMethod'].'ImageBorder']='1';
		$pageVars[$pageVars['ByteUnit'].'LabelStart']='<u>';
		$pageVars[$pageVars['ByteUnit'].'LabelEnd']='</u>';

		// date grouping calculation
		//// Available groupings
		$dateGroupings['daily']='0';
		$dateGroupings['weekly']='1';
		$dateGroupings['monthly']='2';
		$dateGroupings['yearly']='3';
		////get user-selected grouping
		$topGrouping=getConfigValue('topGrouping');
		////get valid groupings that can be generated from the available data
		$query='SELECT ';
		$query.='DATEDIFF(MAX(date),MIN(date))';
		$query.=' FROM ';
		$query.='trafficSummaries';
		$whereQuery = '';
		if(!empty($_REQUEST['minDate']) && $_REQUEST['minDate']!='') {
			$whereQuery=' WHERE ';
			$whereQuery.=" date>='".$_REQUEST['minDate']."'";
			$whereQuery.=' AND ';
			$whereQuery.=" date<='".$_REQUEST['maxDate']."'";
		}
		$query.=$whereQuery;
		$dbDays=db_select_one_row($query);
		$dbDays=$dbDays['0'];
		if($dbDays>365) {
			$validGrouping='yearly';
		} elseif($dbDays>31) {
			$validGrouping='monthly';
		} elseif($dbDays>7) {
			$validGrouping='weekly';
		} else {
			$validGrouping='daily';
		}

		//Choose the grouping closest to the user selected
		if($dateGroupings[$validGrouping]<$dateGroupings[$topGrouping]) {
			$topGrouping=$validGrouping;
		}

		$pageVars['topGrouping']=$topGrouping;
	
		$groupingQuery1='';
		switch($topGrouping) {
			case 'yearly':
			$groupingQuery1="DATE_FORMAT(date, '%x') AS dateFormatted";
			$groupingQuery2=" GROUP BY dateFormatted";
			
			break;

			case 'monthly':
			$groupingQuery1="DATE_FORMAT(date, '%M %x') AS dateFormatted";
			$groupingQuery2=" GROUP BY dateFormatted";
			break;

			case 'weekly':
			$groupingQuery1='CONCAT(';
			$groupingQuery1.="DATE_FORMAT(MIN(date), '%W, %d %M %x')";
			$groupingQuery1.=',';
			$groupingQuery1.="' - '";
			$groupingQuery1.=',';
			$groupingQuery1.="DATE_FORMAT(MAX(date), '%W, %d %M %x')";
			$groupingQuery1.=') AS dateFormatted';
			$groupingQuery1.=',';
			$groupingQuery1.="DATE_FORMAT(date, '%v%x') AS dateFormatted2";
			$groupingQuery2=" GROUP BY dateFormatted2";

			break;

			default:
			$groupingQuery1.="DATE_FORMAT(date, '%W, %d %M %x') AS dateFormatted";
			$groupingQuery2=" GROUP BY dateFormatted";
			break;
		}
		
		
		$query="SELECT ";
		$query.=$groupingQuery1;
		$query.=',';
		$query.='date';
		$query.=',';
		$query.='MIN(date) AS minDate';
		$query.=',';
		$query.='MAX(date) AS maxDate';
		$query.=',';
		$query.='COUNT(DISTINCTROW ip) AS hosts';
		$query.=',';
		$query.='COUNT(DISTINCTROW usersID) AS users';
		$query.=',';
		$query.='COUNT(DISTINCTROW sitesID) AS sites';
		$query.=',';
		$query.='SUM(inCache+outCache) AS bytes';
		$query.=',';
		$query.='TRUNCATE(SUM(inCache)/SUM(inCache+outCache)*100,0) AS cachePercent';
		$query.=' FROM trafficSummaries';
		$query.=$whereQuery;
		$query.=$groupingQuery2;
		$query.=' ORDER BY '.$pageVars['OrderBy'].' '.$pageVars['OrderMethod'];
		$pageVars['availableDates']=db_select_all($query);

		$template='index';
}
$smarty->assign('pageVars',$pageVars);
$smarty->display('header.tpl');
$smarty->display("$template.tpl");
$smarty->display('footer.tpl');


?>
