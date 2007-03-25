<?php
# PROGRAM: MYSAR, FILE: WWW/INDEX.PHP
# COPYRIGHT 2004-2005, STOILIS GIANNIS <GIANNIS@STOILIS.GR>
#
# THIS FILE IS PART OF MYSAR.
#
# MYSAR IS FREE SOFTWARE; YOU CAN REDISTRIBUTE IT AND/OR MODIFY
# IT UNDER THE TERMS OF THE GNU GENERAL PUBLIC LICENSE AS PUBLISHED BY
# THE FREE SOFTWARE FOUNDATION; EITHER VERSION 2 OF THE LICENSE, OR
# (AT YOUR OPTION) ANY LATER VERSION.
#
# MYSAR IS DISTRIBUTED IN THE HOPE THAT IT WILL BE USEFUL,
# BUT WITHOUT ANY WARRANTY; WITHOUT EVEN THE IMPLIED WARRANTY OF
# MERCHANTABILITY OR FITNESS FOR A PARTICULAR PURPOSE.  SEE THE
# GNU GENERAL PUBLIC LICENSE FOR MORE DETAILS.
#
# YOU SHOULD HAVE RECEIVED A COPY OF THE GNU GENERAL PUBLIC LICENSE
# ALONG WITH FOOBAR; IF NOT, WRITE TO THE FREE SOFTWARE
# FOUNDATION, INC., 59 TEMPLE PLACE, SUITE 330, BOSTON, MA  02111-1307  USA

$DEBUG_MODE='web';
$DEBUG_LEVEL='20';

if(file_exists('install') && !file_exists('install/install.done')) {
	require('install/index.php');
	die();
}

// CALCULATE THE BASE PATH OF THE PROGRAM
$basePath=realpath(dirname(__FILE__).'/../');

// COMMON TASKS FOR BOTH WEB AND CMD
require($basePath.'/inc/common.inc.php');

$pageVars['programName']=PROGRAM_NAME_LONG;
$pageVars['programVersion']=PROGRAM_VERSION;

$smarty->register_modifier('bytesToHRF','bytesToHRF');
$smarty->assign('pageVars',$pageVars);

// GET LAST ACCESSED RECORD
$pageVars['lastTimestamp']=getConfigValue('lastTimestamp');
$pageVars['lastTimestampFormatted']=date('d-m-Y H:i:s',$pageVars['lastTimestamp']);

// GET LAST CLEAN-UP
$pageVars['lastCleanUp']=date_Ymd2dmY_seperator(getConfigValue('lastCleanUp'),'-');

// GET LAST IMPORTED RECORDS NUMBER
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

if(empty($_REQUEST['minDate'])) {
	$pageVars['minDate']=date('Y-m-d');
} else {
	$pageVars['minDate']=$_REQUEST['minDate'];
}

if(empty($_REQUEST['maxDate'])) {
	$pageVars['maxDate']=date('Y-m-d');
} else {
	$pageVars['maxDate']=$_REQUEST['maxDate'];
}


$pageVars['uri']=$_SERVER['REQUEST_URI'];
if ($_REQUEST['minDate'] == $_REQUEST['maxDate']) {
    $pageVars['thisDateFormatted']=date('l, d F Y',date_timestampFromDbDate($_REQUEST['minDate'],'-'));
} else {
    $pageVars['thisDateFormatted']=date('l, d F Y',date_timestampFromDbDate($_REQUEST['minDate'],'-')).
                             ' - '.date('l, d F Y',date_timestampFromDbDate($_REQUEST['maxDate'],'-'));
}
$dateArray=explode('-',$pageVars['date']);
$pageVars['today']=date('Y-m-d');
$pageVars['year']=$dateArray['0'];
$pageVars['month']=$dateArray['1'];
$pageVars['day']=$dateArray['2'];
$pageVars['previousDate']=date('Y-m-d',mktime(0,0,0,$pageVars['month'],$pageVars['day']-1,$pageVars['year']));
$pageVars['nextDate']=date('Y-m-d',mktime(0,0,0,$pageVars['month'],$pageVars['day']+1,$pageVars['year']));
$pageVars['previousWeek']=date('Y-m-d',mktime(0,0,0,$pageVars['month'],$pageVars['day']-7,$pageVars['year']));
$pageVars['nextWeek']=date('Y-m-d',mktime(0,0,0,$pageVars['month'],$pageVars['day']+7,$pageVars['year']));
if($_REQUEST['hostiplong']) {
	$pageVars['host']=getHostFromIP($_REQUEST['hostiplong'],$pageVars['date']);
	$pageVars['hostiplong']=$_REQUEST['hostiplong'];
}

if($_REQUEST['sitesID']) {
	$pageVars['sitesID']=$_REQUEST['sitesID'];
	$pageVars['site']=getSiteFromSiteID($pageVars['sitesID'],$pageVars['date']);
}

$pageVars['activeUsers']=getActiveUsers();

$pageVars['user']=getUserFromUsersID($_REQUEST['usersID'],$pageVars['date']);
$pageVars['usersID']=$_REQUEST['usersID'];

if($_REQUEST['action']=='setDefaultView') {
	setDefaultView();
}

// Obtain all groups and put them into one array
$query = "SELECT * FROM groups";
$result = db_select_all ($query);
$groups_array = Array();

foreach ($result as $record) {
    $groups_array[$record['ID']] = $record['NAME'];
}
$pageVars['groups'] = $groups_array;

$commandline = "echo \"".$_SERVER['REMOTE_USER']."  statisticheproxy\" | /usr/sbin/wbinfo_group.pl";
$res = exec ($commandline);
if ($res != 'OK') {

	print "Accesso non autorizzato.\n";
	exit (0);

}


switch($_REQUEST['a']) {
	case 'IPSummary':
		// CREATE THE URLS FOR THE USERS,DATE, BYTES AND CACHEPERCENT
		$validSortedFields[]='hostip';
		$validSortedFields[]='groupID';
		$validSortedFields[]='username';
		$validSortedFields[]='sites';
		$validSortedFields[]='bytes';
		$validSortedFields[]='cachePercent';
		$pageVars['url']=url_createSortParameters($_SERVER['QUERY_STRING'],$validSortedFields);
		
		// CREATE THE URLS FOR THE BYTE UNIT
		$pageVars['url']['B']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','B');
		$pageVars['url']['K']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','K');
		$pageVars['url']['M']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','M');
		$pageVars['url']['G']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','G');

		// DETERMING THE SORT METHOD, OR GET THE DEFAULTS
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
		
		// GET BYTE UNIT USED
		if(empty($_REQUEST['ByteUnit'])) {
			$pageVars['ByteUnit']=getConfigValue('defaultIPSummaryByteUnit');
		} else {
			$pageVars['ByteUnit']=$_REQUEST['ByteUnit'];
		}
		
		$pageVars['Servizio'] = $_REQUEST['Servizio'];
		
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
		$query.='users.groupID as groupID';
		#$query.=',';
		#$query.='groups.name as servizio';
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
		#$query.=' LEFT JOIN groups';
		#$query.=' ON';
		#$query.=' users.groupID LIKE groups.ID';
		$query.=' WHERE ';
		$query.='  (';
		$query.=" trafficSummaries.date>='".$_REQUEST['minDate']."'";
		$query.=' AND ';
		$query.=" trafficSummaries.date<='".$_REQUEST['maxDate']."')"; 

		if(!empty($_REQUEST['Servizio'])) {
			$query.=' AND ';
			$query.=' users.groupID LIKE "'.$_REQUEST['Servizio'].'"'; 		  
		}

		$query.= ' GROUP BY  trafficSummaries.ip,  users.authuser';	
		$query.=' ORDER BY '.$pageVars['OrderBy'].' '.$pageVars['OrderMethod'];

		$pageVars['summaryIPRecords']=db_select_all($query);
    		
		$template='IPSummary';
		break;

	case 'GroupSummary':
		// CREATE THE URLS FOR THE USERS,DATE, BYTES AND CACHEPERCENT
		$validSortedFields[]='name';
		$validSortedFields[]='sites';
		$validSortedFields[]='bytes';
		$validSortedFields[]='cachePercent';
		$pageVars['url']=url_createSortParameters($_SERVER['QUERY_STRING'],$validSortedFields);
		
		// CREATE THE URLS FOR THE BYTE UNIT
		$pageVars['url']['B']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','B');
		$pageVars['url']['K']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','K');
		$pageVars['url']['M']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','M');
		$pageVars['url']['G']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','G');

		// DETERMING THE SORT METHOD, OR GET THE DEFAULTS
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
		
		// GET BYTE UNIT USED
		if(empty($_REQUEST['ByteUnit'])) {
			$pageVars['ByteUnit']=getConfigValue('defaultIPSummaryByteUnit');
		} else {
			$pageVars['ByteUnit']=$_REQUEST['ByteUnit'];
		}
		
		$pageVars[$pageVars['OrderBy'].'LabelStart']='<u>';
		$pageVars[$pageVars['OrderBy'].'LabelEnd']='</u>';
		$pageVars[$pageVars['OrderBy'].$pageVars['OrderMethod'].'ImageBorder']='1';
		$pageVars[$pageVars['ByteUnit'].'LabelStart']='<u>';
		$pageVars[$pageVars['ByteUnit'].'LabelEnd']='</u>';
		
		$query='SELECT ';
		$query.='groups.id as groupid';
		$query.=',';
		$query.='name';
		$query.=',';
		$query.='SUM(trafficSummaries.inCache+trafficSummaries.outCache) as bytes';
		$query.=',';
		$query.='TRUNCATE((SUM(trafficSummaries.inCache)/SUM(trafficSummaries.inCache+trafficSummaries.outCache))*100,0) AS cachePercent';
		$query.=',';
		$query.='COUNT(DISTINCTROW(trafficSummaries.sitesID)) AS sites';
		$query.=' FROM trafficSummaries, groups';
		$query.=' WHERE (';
		$query.=" trafficSummaries.date>='".$_REQUEST['minDate']."'";
		$query.=' AND ';
		$query.=" trafficSummaries.date<='".$_REQUEST['maxDate']."')";
		$query.=' AND ';
    		$query.=' groups.ID = groupID'; 
		$query.= ' GROUP BY name';
		$query.=' ORDER BY '.$pageVars['OrderBy'].' '.$pageVars['OrderMethod'];
		
		$pageVars['groupIPRecords']=db_select_all($query);

		$template='GroupSummary';
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
		$validSortedFields[]='site';
		$validSortedFields[]='bytes';
		$validSortedFields[]='cachePercent';
		$validSortedFields[]='elapsedTime';
		$validSortedFields[]='count';
		$pageVars['url']=url_createSortParameters($_SERVER['QUERY_STRING'],$validSortedFields);
		
		// CREATE THE URLS FOR THE BYTE UNIT
		$pageVars['url']['B']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','B');
		$pageVars['url']['K']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','K');
		$pageVars['url']['M']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','M');
		$pageVars['url']['G']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','G');

		// DETERMING THE SORT METHOD, OR GET THE DEFAULTS
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
		
		// GET BYTE UNIT USED
		if(empty($_REQUEST['ByteUnit'])) {
			$pageVars['ByteUnit']=getConfigValue('defaultIPSitesSummaryByteUnit');
		} else {
			$pageVars['ByteUnit']=$_REQUEST['ByteUnit'];
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
		$query.='TRUNCATE(SUM(trafficSummaries.elapsedTime)/1000,0) AS elapsedTime';
		$query.=',';
		$query.='SUM(trafficSummaries.inCache+trafficSummaries.outCache) AS bytes';
		$query.=',';
		$query.='TRUNCATE((SUM(trafficSummaries.inCache)/SUM(trafficSummaries.inCache+trafficSummaries.outCache))*100,0) AS cachePercent';
		$query.=',';
		$query.='SUM(trafficSummaries.count) as count';
		#$query.=' FROM trafficSummaries,whitelist';
		$query.=' FROM trafficSummaries,whitelist,sites ';
		#$query.=' JOIN sites ON ';
		$query.=' WHERE ';
		$query.='trafficSummaries.sitesID=sites.id';
		#$query.=' WHERE ';
		$query.=' AND ';
		$query.="trafficSummaries.ip='".$pageVars['hostiplong']."'";
		
		$query.=' AND ';
		$query.=" trafficSummaries.date>='".$_REQUEST['minDate']."'";
		$query.=' AND ';
		$query.=" trafficSummaries.date<='".$_REQUEST['maxDate']."'";


		$query.=' AND ';
		$query.="trafficSummaries.usersID='".$pageVars['usersID']."'";
		$query.=' AND (sites.site = whitelist.site AND whitelist.whitelist = "0")';
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

		$query.=" traffic.date>='".$_REQUEST['minDate']."'";
		$query.=' AND ';
		$query.=" traffic.date<='".$_REQUEST['maxDate']."'";


		$query.=' AND ';
		$query.="traffic.usersID='".$pageVars['usersID']."'";
		$query.=' AND ';
		$query.="traffic.ip='".$pageVars['hostiplong']."'";
		$query.=' ORDER BY traffic.date DESC, traffic.time DESC';
		$query.=' LIMIT 10';
		$pageVars['latestUserActivity']=db_select_all($query);
		
		$template='IPSitesSummary';
		break;

	case 'details':
		$validSortedFields[]='time';
		$validSortedFields[]='bytes';
		$validSortedFields[]='url';
		$validSortedFields[]='status';
		$validSortedFields[]='elapsedTime';
		$validSortedFields[]='count';
		$pageVars['url']=url_createSortParameters($_SERVER['QUERY_STRING'],$validSortedFields);

		// CREATE THE URLS FOR THE BYTE UNIT
		$pageVars['url']['B']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','B');
		$pageVars['url']['K']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','K');
		$pageVars['url']['M']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','M');
		$pageVars['url']['G']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','G');

		// DETERMING THE SORT METHOD, OR GET THE DEFAULTS
		if(empty($_REQUEST['OrderBy'])) {
			$pageVars['OrderBy']='bytes';
		} else {
			$pageVars['OrderBy']=$_REQUEST['OrderBy'];
		}
		if(empty($_REQUEST['OrderMethod'])) {
			$pageVars['OrderMethod']='DESC';
		} else {
			$pageVars['OrderMethod']=$_REQUEST['OrderMethod'];
		}
		// GET BYTE UNIT USED
		if(empty($_REQUEST['ByteUnit'])) {
			$pageVars['ByteUnit']=getConfigValue('defaultDateTimeByteUnit');
		} else {
			$pageVars['ByteUnit']=$_REQUEST['ByteUnit'];
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
		$query.="SUM(bytes) as bytes,url,COUNT(url) AS count,resultCode,TRUNCATE(SUM(elapsedTime)/1000,0) AS elapsedTime";
		$query.=" FROM traffic";
		$query.=" WHERE ";

		$query.=" (date>='".$_REQUEST['minDate']."'";
		$query.=' AND ';
		$query.=" date<='".$_REQUEST['maxDate']."')";

		$query.=" AND ";
		$query.="sitesID='".$pageVars['sitesID']."'";
		$query.=" AND ";
		$query.="usersID='".$pageVars['usersID']."'";
		$query.=" AND ";
		$query.="ip='".$pageVars['hostiplong']."'";
		$query.=" GROUP BY url";
		$query.=' ORDER BY '.$pageVars['OrderBy'].' '.$pageVars['OrderMethod'];
		$pageVars['siteDetails']=db_select_all($query);

		$template='details';
		break;
	
	case 'allsites':
                if ($_POST['Aggiorna'] == 'Aggiorna') {
                        updateConfig ('allsitesLimit', $_REQUEST['allsitesLimit']);
                }

		$validSortedFields[]='site';
		$validSortedFields[]='hosts';
		$validSortedFields[]='users';
		$validSortedFields[]='count';
		$validSortedFields[]='bytes';
		$validSortedFields[]='cachePercent';
		$pageVars['url']=url_createSortParameters($_SERVER['QUERY_STRING'],$validSortedFields);
		
		// CREATE THE URLS FOR THE BYTE UNIT
		$pageVars['url']['B']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','B');
		$pageVars['url']['K']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','K');
		$pageVars['url']['M']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','M');
		$pageVars['url']['G']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','G');

		// DETERMING THE SORT METHOD, OR GET THE DEFAULTS
		if(empty($_REQUEST['OrderBy'])) {
			$pageVars['OrderBy']='count';
		} else {
			$pageVars['OrderBy']=$_REQUEST['OrderBy'];
		}
		if(empty($_REQUEST['OrderMethod'])) {
			$pageVars['OrderMethod']='DESC';
		} else {
			$pageVars['OrderMethod']=$_REQUEST['OrderMethod'];
		}
		
		// GET BYTE UNIT USED
		if(empty($_REQUEST['OyteUnit'])) {
			$pageVars['ByteUnit']=getConfigValue('defaultAllSitesByteUnit');
		} else {
			$pageVars['ByteUnit']=$_REQUEST['ByteUnit'];
		}
		
		$pageVars[$pageVars['OrderBy'].'LabelStart']='<u>';
		$pageVars[$pageVars['OrderBy'].'LabelEnd']='</u>';
		$pageVars[$pageVars['OrderBy'].$pageVars['OrderMethod'].'ImageBorder']='1';
		$pageVars[$pageVars['ByteUnit'].'LabelStart']='<u>';
		$pageVars[$pageVars['ByteUnit'].'LabelEnd']='</u>';

		$limit = getConfigValue ('allsitesLimit');
		if ($limit == '') {
			$limit = 100;
		}

		$query='SELECT ';
		$query.='sites.id AS sitesID';
		$query.=',';
		$query.='sites.site AS site';
		$query.=',';
		$query.='COUNT(DISTINCTROW(usersID)) AS users';
		$query.=',';
		$query.='SUM(count) AS count';
		$query.=',';
		$query.='SUM(trafficSummaries.inCache+trafficSummaries.outCache) AS bytes';
		$query.=',';
		$query.='TRUNCATE((SUM(trafficSummaries.inCache)/SUM(trafficSummaries.inCache+trafficSummaries.outCache))*100,0) AS cachePercent';
		$query.=' FROM ';
		#$query.='trafficSummaries,whitelist,sites,users';
		$query.='trafficSummaries,whitelist,sites';
		$query.=' WHERE ';
		$query.='trafficSummaries.sitesID=sites.id';
		#$query.=" AND ";
		#$query.='users.id = trafficSummaries.usersID';
		if (array_key_exists ('Servizio', $_REQUEST)) {
		
  			$query.=" AND ";
  			#$query.=" users.groupID LIKE '".$_REQUEST['Servizio']."'";
  			$query.=" groupID LIKE '".$_REQUEST['Servizio']."'";
		
    		}
		
		$query.=" AND ";
                $query.='  (';
                $query.=" trafficSummaries.date>='".$_REQUEST['minDate']."'";
                $query.=' AND ';
                $query.=" trafficSummaries.date<='".$_REQUEST['maxDate']."')";

		$query.=" AND ";
		$query.=" sites.site = whitelist.site AND whitelist.whitelist = 0 ";
		
		$query.=' GROUP BY sites.id';
		$query.=' ORDER BY '.$pageVars['OrderBy'].' '.$pageVars['OrderMethod'];

		$query.=' LIMIT 0,'.$limit;

		$pageVars['allsitesLimit'] = $limit;
		$pageVars['allSites']=db_select_all($query);	
		
		$template='allsites';
		break;
		
	case 'siteusers':
		$validSortedFields[]='ip';
		$validSortedFields[]='hostname';
		$validSortedFields[]='bytes';
		$validSortedFields[]='cachePercent';
		$pageVars['url']=url_createSortParameters($_SERVER['QUERY_STRING'],$validSortedFields);
		
		// CREATE THE URLS FOR THE BYTE UNIT
		$pageVars['url']['B']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','B');
		$pageVars['url']['K']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','K');
		$pageVars['url']['M']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','M');
		$pageVars['url']['G']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','G');

		// DETERMING THE SORT METHOD, OR GET THE DEFAULTS
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
		
		// GET BYTE UNIT USED
		if(empty($_REQUEST['ByteUnit'])) {
			$pageVars['ByteUnit']=getConfigValue('defaultSiteUsersByteUnit');
		} else {
			$pageVars['ByteUnit']=$_REQUEST['ByteUnit'];
		}
		
		// USE THIS TO REALLY SORT BY IP NUMBER, NOT BY IP CHAR...
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
		//$query.='trafficSummaries.date=users.date';
		//$query.=' AND ';
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
		$commandline = "echo \"".$_SERVER['REMOTE_USER']." statisticheproxycomplete\" | /usr/sbin/wbinfo_group.pl";
		$res = exec ($commandline);
		if ($res != 'OK') {
        		print "Accesso non autorizzato.\n";
			exit (0);
		}

		$template='administration';
		
		if($_REQUEST['hiddenSubmit']=='1') {

			updateConfig($_REQUEST['configName'],$_REQUEST['thisValue']);

		} elseif($_REQUEST['action']=='eraseAllStats') {
			$tables=array('hostnames','sites','traffic','trafficSummaries','users','whitelist');
			reset($tables);
			while(list($key,$value)=each($tables)) {
				$query='TRUNCATE TABLE '.$value;
				db_query($query);
			}
			updateConfig('lastTimestamp','0');
			updateConfig('lastLogOffset','0');
		}

		$configVariables[]='keepHistoryDays';
		$configVariables[]='resolveClients';
		$configVariables[]='squidLogPath';
		$configVariables[]='mysarImporter';
		$configVariables[]='topGrouping';
		
		reset($configVariables);
		while(list($key,$value)=each($configVariables)) {
			$pageVars[$value]=getConfigValue($value);
		}

		break;

        case 'whitelist':

		if ($_POST['Aggiorna'] == 'Aggiorna') {
			updateConfig ('whitelistLimit', $_REQUEST['whitelistLimit']);
		}

                if ($_POST['OK'] == 'OK') {
                        db_query ('update whitelist set whitelist="0"');
                        foreach ($_POST as $key => $value) {
                                $query = "UPDATE whitelist SET whitelist='1'";
                                $query .= " WHERE id='$value'";
                                db_query($query);
                        }
                }
		
                $validSortedFields[]='site';
                $validSortedFields[]='hosts';
                $validSortedFields[]='users';
                $validSortedFields[]='count';
                $validSortedFields[]='bytes';
                $validSortedFields[]='cachePercent';
                $pageVars['url']=url_createSortParameters($_SERVER['QUERY_STRING'],$validSortedFields);


                // DETERMING THE SORT METHOD, OR GET THE DEFAULTS
                if(empty($_REQUEST['OrderBy'])) {
                        $pageVars['OrderBy']='count';
                } else {
                        $pageVars['OrderBy']=$_REQUEST['OrderBy'];
                }
                if(empty($_REQUEST['OrderMethod'])) {
                        $pageVars['OrderMethod']='DESC';
                } else {
                        $pageVars['OrderMethod']=$_REQUEST['OrderMethod'];
                }

		$limit = getConfigValue ('whitelistLimit');
		if ($limit == '') {
			$limit = 100;
		}

                $query="SELECT ";
                $query.='whitelist.id AS sitesID';
                $query.=',';
                $query.='sites.site AS site';
                $query.=',';
                $query.='whitelist.whitelist AS whitelist';
                $query.=',';
                $query.='TRUNCATE(SUM(trafficSummaries.elapsedTime)/1000,0) AS elapsedTime';
                $query.=',';
                $query.='SUM(trafficSummaries.inCache+trafficSummaries.outCache) AS bytes';
                $query.=',';
                $query.='TRUNCATE((SUM(trafficSummaries.inCache)/SUM(trafficSummaries.inCache+trafficSummaries.outCache))*100,0) AS cachePercent';
                $query.=',';
                $query.='SUM(trafficSummaries.count) as count';
                $query.=' FROM trafficSummaries,whitelist,sites';
                $query.=' WHERE ';
                $query.='trafficSummaries.sitesID=sites.id';
                $query.=' AND';
                $query.=' sites.site = whitelist.site';
                $query.=" GROUP BY sitesID";
                $query.=' ORDER BY '.$pageVars['OrderBy'].' '.$pageVars['OrderMethod'];
		$query.=' LIMIT 0,'.$limit;
                $pageVars['whitelistSites']=db_select_all($query);
		$pageVars['whitelistLimit']=$limit;

                $template='whitelist';

		break;

	default:
		// CREATE THE URLS FOR THE USERS,DATE, BYTES AND CACHEPERCENT
		$validSortedFields[]='bytes';
		$validSortedFields[]='cachePercent';
		$validSortedFields[]='date';
		$validSortedFields[]='hosts';
		$validSortedFields[]='sites';
		$validSortedFields[]='users';
		$pageVars['url']=url_createSortParameters($_SERVER['QUERY_STRING'],$validSortedFields);
		
		// CREATE THE URLS FOR THE BYTE UNIT
		$pageVars['url']['B']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','B');
		$pageVars['url']['K']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','K');
		$pageVars['url']['M']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','M');
		$pageVars['url']['G']=url_addParameter($_SERVER['QUERY_STRING'],'ByteUnit','G');

		// DETERMING THE SORT METHOD, OR GET THE DEFAULTS
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
		
		// GET BYTE UNIT USED
		if(empty($_REQUEST['ByteUnit'])) {
			$pageVars['ByteUnit']=getConfigValue('defaultIndexByteUnit');
		} else {
			$pageVars['ByteUnit']=$_REQUEST['ByteUnit'];
		}
		
		$pageVars[$pageVars['OrderBy'].'LabelStart']='<u>';
		$pageVars[$pageVars['OrderBy'].'LabelEnd']='</u>';
		$pageVars[$pageVars['OrderBy'].$pageVars['OrderMethod'].'ImageBorder']='1';
		$pageVars[$pageVars['ByteUnit'].'LabelStart']='<u>';
		$pageVars[$pageVars['ByteUnit'].'LabelEnd']='</u>';

		// DATE GROUPING CALCULATION
		//// AVAILABLE GROUPINGS
		$dateGroupings['giornaliero']='0';
		$dateGroupings['settimanale']='1';
		$dateGroupings['mensile']='2';
		$dateGroupings['annuale']='3';
		////GET USER-SELECTED GROUPING
		$topGrouping=getConfigValue('topGrouping');
		////GET VALID GROUPINGS THAT CAN BE GENERATED FROM THE AVAILABLE DATA
		$query='SELECT ';
		$query.='DATEDIFF(MAX(date),MIN(date))';
		$query.=' FROM ';
		$query.='trafficSummaries';
		if(!empty($_REQUEST['minDate']) && $_REQUEST['minDate']!='') {
			$whereQuery=' WHERE ';
			$whereQuery.=" date>='".$_REQUEST['minDate']."'";
			$whereQuery.=' AND ';
			$whereQuery.=" date<='".$_REQUEST['maxDate']."'";
		}
		$query.=$whereQuery;
		$dbDays=db_select_one_row($query);

		
		if($dbDays>365) {
			$validGrouping='annuale';
		} elseif($dbDays>31) {
			$validGrouping='mensile';
		} elseif($dbDays>7) {
			$validGrouping='settimanale';
		} else {
			$validGrouping='giornaliero';
		}

		//CHOOSE THE GROUPING CLOSEST TO THE USER SELECTED
		if($dateGroupings[$validGrouping]<$dateGroupings[$topGrouping]) {
			$topGrouping=$validGrouping;
		}

		$pageVars['topGrouping']=$topGrouping;

		switch($topGrouping) {
			case 'annuale':
			$groupingQuery1="DATE_FORMAT(date, '%x') AS dateFormatted";
			$groupingQuery2=" GROUP BY dateFormatted";
			
			break;

			case 'mensile':
			$groupingQuery1="DATE_FORMAT(date, '%M %x') AS dateFormatted";
			$groupingQuery2=" GROUP BY dateFormatted";
			break;

			case 'settimanale':
			$groupingQuery1='CONCAT(';
			$groupingQuery1.="DATE_FORMAT(MIN(date), '%d/%m/%x')";
			$groupingQuery1.=',';
			$groupingQuery1.="' - '";
			$groupingQuery1.=',';
			$groupingQuery1.="DATE_FORMAT(MAX(date), '%d/%m/%x')";
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
