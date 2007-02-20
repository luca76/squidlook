<?php
# Program: SquidLook
# Copyright 2007, Trapanator <trap@trapanator.com>
# Derived from the work of:
# Program: mysar, File: www/install/index.php
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


// This is needed later on...
set_time_limit(0);
$basePath=realpath(dirname(__FILE__));

function generate_db() {
	global $basePath;

	$lines = file($basePath.'/www/install/squidlook.sql');
	
	$query = '';

	foreach ($lines as $linenum => $line) {
		if (substr ($line, 0, 2) == '--') {
			continue;
		}
		if (trim ($line) != '') {
			$query = $query.$line;
			if (strrpos($line, ";") !== false) {
				$result = mysql_query ($query) or die ("Mysql error at line $linenum, file $basePath/squidlook.sql " . mysql_error());
				db_check ($result);
				$query = '';
			}
		}
	}
	if ($query != '') {
		echo ("Executing '$query'<br>");
		$result = mysql_query ($query) or die ("Mysql error at line $linenum, file $basePath/squidlook.sql " . mysql_error());
		db_check ($result);
	}
	return 0;
}

function db_check($result,$step=1) {

	global $queries1;
	global $queries2;

	if($result==FALSE) {
		echo "Failed...";
		echo "<br>".mysql_error();
		echo '<p><a href="index.php?install=new'.$step.'">Click here to try again!</a>';
	
		switch($step) {
			case '3':
				echo "<p>Sorry, but I couldn't verify your database setup!";
				exit();

				break;
			default:
				echo "<p>Sorry, but I couldn't complete the database setup myself. Here are the commands, so that you can run them for youself. If you complete this step by yourself, <a href=\"./?install=new3\">click here</a> to test the connection and continue the installation.";
				echo "<br><pre>";
				reset($queries1);
				reset($queries2);
				while(list($key,$value)=each($queries1)) {
					echo "\n".$value;
				}//while(list($key,$value)=each($queries1)) {
				while(list($key,$value)=each($queries2)) {
					echo "\n".$value;
				}//while(list($key,$value)=each($queries2)) {
				exit();
		}//switch($step) {
	}//if($result==FALSE) {
}

$DEBUG_MODE='web';
$DEBUG_LEVEL='20';

// calculate the base path of the program
$basePath=realpath(dirname(__FILE__).'/../../');


$html_start='<html><head><link rel="stylesheet" href="dfl.css" type="text/css"><body><center><strong>SquidLook Installation wizard</strong></center><p>';
$html_end="</body></html>";

echo $html_start;

switch($_REQUEST['install']) {
	case 'upgrade3':
		echo "Reading config.ini file...";
		$iniConfig=parse_ini_file($basePath.'/etc/config.ini');
		if($iniConfig==FALSE) {
			echo "Failed!";
			echo '<p>You need to copy the file "etc/config.ini" from you previous mysar installation and put it in "'.$basePath.'/etc/config.ini", making sure it is readable by the web server process.';
			echo '<br>If you lost it, you can always recreate it with the following contents, using the appropriate values:';
			echo '<br>dbUser = &lt;database name&gt;';
			echo '<br>dbPass = &lt;database password&gt;';
			echo '<br>dbHost = &lt;database hostname&gt;';
			echo '<br>dbName = &lt;database name&gt;';
			echo '<p><a href="index.php?install=upgrade3">Click here</a> to try again.';
			die();
		}
		echo "Found!";
		echo "<br>".print_r($iniConfig,TRUE);

		echo "<p>Testing database connection...";
		$iniConfig=parse_ini_file($basePath.'/etc/config.ini');
		$link=mysql_connect($iniConfig['dbHost'],$iniConfig['dbUser'],$iniConfig['dbPass']);
		db_check($link,3);

		$result=mysql_select_db($iniConfig['dbName']);
		db_check($result,3);

		$query="SELECT value FROM config WHERE name='schemaVersion'";
		$result=mysql_query($query);
		db_check($result,3);
		echo "Done!";

		$schemaVersion=mysql_fetch_array($result);
		$schemaVersion=$schemaVersion['value'];
		
		switch($schemaVersion) {
			case '3':
			
			echo "No upgrade necessery!";
			echo '<p><a href="index.php?install=end">Click here</a> to continue.';
			die();
			
			break;
			
			
			case '2':
			$tables[]='users';
			$tables[]='traffic';
			
			reset($tables);
			while(list($key,$value)=each($tables)) {
				echo 'Expanding authuser fiest at '.$value.'...';
				$query='ALTER TABLE '.$value.' CHANGE authuser authuser VARCHAR(50) NOT NULL';

				$result=mysql_query($query);
				if($result==FALSE) {
					echo "ERROR! ".mysql_error();
					exit();
				}				
				echo "Done!<br>";				
			}

			echo 'Updating schema version to 3...';
			$query="UPDATE config SET value='3' WHERE name='schemaVersion'";
			$result=mysql_query($query);
			if($result==FALSE) {
				echo "ERROR! ".mysql_error();
				exit();
			}
			echo "Done!<br>";

			case '8':
				break;

			default:
				echo '<p>Oops! I don\'t recognise this schema version! Something is VERY wrong! Please <a href="http://giannis.stoilis.gr/software/mysar/">report a bug!</a>';
				exit();
		}
		echo '<p>Upgrade is finished!';
		echo '<p><a href="index.php?install=end">Click here</a> to continue.';

		break;

	case 'upgrade2':
		echo "Reading config.ini file...";
		$iniConfig=parse_ini_file($basePath.'/etc/config.ini');
		if($iniConfig==FALSE) {
			echo "Failed!";
			echo '<p>You need to copy the file "etc/config.ini" from you previous mysar installation and put it in "'.$basePath.'/etc/config.ini", making sure it is readable by the web server process.';
			echo '<br>If you lost it, you can always recreate it with the following contents, using the appropriate values:';
			echo '<br>dbUser = &lt;database name&gt;';
			echo '<br>dbPass = &lt;database password&gt;';
			echo '<br>dbHost = &lt;database hostname&gt;';
			echo '<br>dbName = &lt;database name&gt;';
			echo '<p><a href="index.php?install=upgrade2">Click here</a> to try again.';
			die();
		}
		echo "Found!";
		echo "<br>".print_r($iniConfig,TRUE);

		echo "<p>Testing database connection...";
		$iniConfig=parse_ini_file($basePath.'/etc/config.ini');
		$link=mysql_connect($iniConfig['dbHost'],$iniConfig['dbUser'],$iniConfig['dbPass']);
		db_check($link,3);

		$result=mysql_select_db($iniConfig['dbName']);
		db_check($result,3);

		$query="SELECT value FROM config WHERE name='upgradeStage'";
		$result=mysql_query($query);
		db_check($result,3);
		echo "Done!";

		if($row=mysql_fetch_array($result)) {
			$upgradeStage=$row['value'];
		} else {
			$upgradeStage='0';
		}

		switch($upgradeStage) {
			case '0': // config
				echo "<p>Doing upgrade stage...".$upgradeStage.'<br>';
				$totalSteps=2;
				$currentStep=0;

				echo ++$currentStep.'/'.$totalSteps.'... ';
				$result=mysql_query($queries6['0']);
				if($result==FALSE) {
					echo "ERROR! ".mysql_error();
					exit();
				}

				echo ++$currentStep.'/'.$totalSteps.'... ';
				$queries=count($queries3);
				reset($queries3);
				$numeric_key=1;
				while(list($key,$value)=each($queries3)) {
					$result=mysql_query($value);
					if($result==FALSE) {
						echo "ERROR! ".mysql_error();
						exit();
					}
					echo '('.$numeric_key++.'/'.$queries.')... ';
				}

				echo ++$currentStep.'/'.$totalSteps.'... ';
				$upgradeStage++;
				$query="INSERT INTO config VALUES('upgradeStage','$upgradeStage')";
				$result=mysql_query($query);
				if($result==FALSE) {
					echo "ERROR! ".mysql_error();
					exit();
				}

				echo "Done!<br>";

			case '1': //hostnames
				echo "<p>Doing upgrade stage...".$upgradeStage.'<br>';
				$totalSteps=2;
				$currentStep=0;

				echo ++$currentStep.'/'.$totalSteps.'... ';
				$query=$queries2['1'];
				$result=mysql_query($query);
				if($result==FALSE) {
					echo "ERROR! ".mysql_error();
					exit();
				}

				echo ++$currentStep.'/'.$totalSteps.'... ';
				$upgradeStage++;
				$query="UPDATE config SET value='$upgradeStage' WHERE name='upgradeStage'";
				$result=mysql_query($query);
				if($result==FALSE) {
					echo "ERROR! ".mysql_error();
					exit();
				}

				echo 'Done!<br>';

			case '2': //hostnames
				echo "<p>Doing upgrade stage...".$upgradeStage.'<br>';
				$totalSteps=4;
				$currentStep=0;

				echo ++$currentStep.'/'.$totalSteps.'... ';
				$query='SELECT id,date,ip,hostname FROM resolvedIPs ORDER BY id ASC';
				$result=mysql_query($query);
				if($result==FALSE) {
					echo "ERROR! ".mysql_error();
					exit();
				}

				echo ++$currentStep.'/'.$totalSteps.'... ';
				$numrows=mysql_num_rows($result);

				echo ++$currentStep.'/'.$totalSteps.'... ';
				$currentSubStep=0;
				while($row=mysql_fetch_array($result)) {
					echo '('.++$currentSubStep.'/'.$numrows.')... ';
					$query='INSERT IGNORE INTO hostnames VALUES (';
					$query.="'".$row['id']."',";
					$query.="'".$row['ip']."',";
					$query.="'',";
					$query.="'1',";
					$query.="'".$row['hostname']."')";
					$result2=mysql_query($query);
					if($result2==FALSE) {
						echo "ERROR! ".mysql_error();
						exit();
					}
				}

				echo ++$currentStep.'/'.$totalSteps.'... ';
				$upgradeStage++;
				$query="UPDATE config SET value='$upgradeStage' WHERE name='upgradeStage'";
				$result=mysql_query($query);
				if($result==FALSE) {
					echo "ERROR! ".mysql_error();
					exit();
				}

				echo 'Done!<br>';

			case '3': // trafficSummaries
				echo "<p>Doing upgrade stage...".$upgradeStage.'<br>';
				$totalSteps=5;
				$currentStep=0;

				echo ++$currentStep.'/'.$totalSteps.'... ';
				$query=$queries2['2'];
				$result=mysql_query($query);
				if($result==FALSE) {
					echo "ERROR! ".mysql_error();
					exit();
				}

				echo ++$currentStep.'/'.$totalSteps.'... ';
				$query='SELECT ';
				$query.='ipToSitesSums.date AS date';
				$query.=',';
				$query.='resolvedIPs.ip AS ip';
				$query.=',';
				$query.='ipToSitesSums.inCache AS inCache';
				$query.=',';
				$query.='ipToSitesSums.outCache AS outCache';
				$query.=',';
				$query.='ipToSitesSums.siteID AS siteID';
				$query.=',';
				$query.='ipToSitesSums.summaryTime AS summaryTime';
				$query.=' FROM ipToSitesSums ';
				$query.=' JOIN resolvedIPs ON ';
				$query.='ipToSitesSums.ipID=resolvedIPs.id';
				$result=mysql_query($query);
				if($result==FALSE) {
					echo "ERROR! ".mysql_error();
					exit();
				}
				
				echo ++$currentStep.'/'.$totalSteps.'... ';
				$numrows=mysql_num_rows($result);
				
				echo ++$currentStep.'/'.$totalSteps.'... ';
				$currentSubStep=0;
				while($row=mysql_fetch_array($result)) {
					echo '('.++$currentSubStep.'/'.$numrows.')... ';
					$query='INSERT IGNORE INTO trafficSummaries VALUES (';
					$query.="''";
					$query.=',';
					$query.="'".$row['date']."'";
					$query.=',';
					$query.="'".$row['ip']."'";
					$query.=',';
					$query.="'0'";
					$query.=',';
					$query.="'".$row['inCache']."'";
					$query.=',';
					$query.="'".$row['outCache']."'";
					$query.=',';
					$query.="'".$row['siteID']."'";
					$query.=',';
					$query.="'".$row['summaryTime']."'";
					$query.=')';
					$result2=mysql_query($query);
					if($result2==FALSE) {
						echo "ERROR! ".mysql_error();
						exit();
					}
				}

				echo ++$currentStep.'/'.$totalSteps.'... ';
				$upgradeStage++;
				$query="UPDATE config SET value='$upgradeStage' WHERE name='upgradeStage'";
				$result=mysql_query($query);
				if($result==FALSE) {
					echo "ERROR! ".mysql_error();
					exit();
				}

				echo 'Done!<br>';

			case '4': // traffic
				echo "<p>Doing upgrade stage...".$upgradeStage.'<br>';
				$totalSteps=2;
				$currentStep=0;

				echo ++$currentStep.'/'.$totalSteps.'... ';
				$query='ALTER TABLE traffic RENAME oldTraffic';
				$result=mysql_query($query);
				if($result==FALSE) {
					echo "ERROR! ".mysql_error();
					exit();
				}

				echo ++$currentStep.'/'.$totalSteps.'... ';
				$upgradeStage++;
				$query="UPDATE config SET value='$upgradeStage' WHERE name='upgradeStage'";
				$result=mysql_query($query);
				if($result==FALSE) {
					echo "ERROR! ".mysql_error();
					exit();
				}

				echo 'Done!<br>';

			case '5':
				echo "<p>Doing upgrade stage...".$upgradeStage.'<br>';
				$totalSteps=5;
				$currentStep=0;

				echo ++$currentStep.'/'.$totalSteps.'... ';
				$query=$queries2['3'];
				$result=mysql_query($query);
				if($result==FALSE) {
					echo "ERROR! ".mysql_error();
					exit();
				}

				echo ++$currentStep.'/'.$totalSteps.'... ';
				$query='SELECT ';
				$query.='date';
				$query.=',';
				$query.='time';
				$query.=',';
				$query.='ip';
				$query.=',';
				$query.='resultCode';
				$query.=',';
				$query.='bytes';
				$query.=',';
				$query.='url';
				$query.=',';
				$query.='hostID';
				$query.=' FROM ';
				$query.='oldTraffic';
				$result=mysql_query($query);
				if($result==FALSE) {
					echo "ERROR! ".mysql_error();
					exit();
				}

				echo ++$currentStep.'/'.$totalSteps.'... ';
				$numrows=mysql_num_rows($result);

				echo ++$currentStep.'/'.$totalSteps.'... ';
				$currentSubStep=0;
				while($row=mysql_fetch_array($result)) {
					echo '('.++$currentSubStep.'/'.$numrows.') ';
					$query='INSERT IGNORE INTO traffic VALUES (';
					$query.="''";
					$query.=',';
					$query.="'".$row['date']."'";
					$query.=',';
					$query.="'".$row['time']."'";
					$query.=',';
					$query.="INET_ATON('".$row['ip']."')";
					$query.=',';
					$query.="'".$row['resultCode']."'";
					$query.=',';
					$query.="'".$row['bytes']."'";
					$query.=',';
					$query.="'".$row['url']."'";
					$query.=',';
					$query.="'-'";
					$query.=',';
					$query.="''";
					$query.=',';
					$query.="'0'";
					$query.=')';
					$result2=mysql_query($query);
					if($result2==FALSE) {
						echo "ERROR! ".mysql_error();
						exit();
					}
				}

				echo ++$currentStep.'/'.$totalSteps.'... ';
				$upgradeStage++;
				$query="UPDATE config SET value='$upgradeStage' WHERE name='upgradeStage'";
				$result=mysql_query($query);
				if($result==FALSE) {
					echo "ERROR! ".mysql_error();
					exit();
				}

				echo 'Done!<br>';

			case '6': // users
				echo "<p>Doing upgrade stage...".$upgradeStage.'<br>';
				$totalSteps=5;
				$currentStep=0;

				echo ++$currentStep.'/'.$totalSteps.'... ';
				$query=$queries2['4'];
				$result=mysql_query($query);
				if($result==FALSE) {
					echo "ERROR! ".mysql_error();
					exit();
				}

				echo ++$currentStep.'/'.$totalSteps.'... ';
				$query='SELECT DISTINCTROW(date) AS date FROM traffic';
				$result=mysql_query($query);
				if($result==FALSE) {
					echo "ERROR! ".mysql_error();
					exit();
				}

				echo ++$currentStep.'/'.$totalSteps.'... ';
				$numrows=mysql_num_rows($result);

				echo ++$currentStep.'/'.$totalSteps.'... ';
				while($row=mysql_fetch_array($result)) {
					echo '('.++$currentSubStep.'/'.$numrows.') ';
					$query='INSERT IGNORE INTO users VALUES (';
					$query.="''";
					$query.=',';
					$query.="'-'";
					$query.=',';
					$query.="'".$row['date']."'";
					$query.=')';
					$result2=mysql_query($query);
					if($result2==FALSE) {
						echo "ERROR! ".mysql_error();
						exit();
					}

					$insert_id=mysql_insert_id();
					$query="UPDATE traffic SET usersID='".$insert_id."' WHERE date='".$row['date']."'";
					$result2=mysql_query($query);
					if($result2==FALSE) {
						echo "ERROR! ".mysql_error();
						exit();
					}
				}

				echo ++$currentStep.'/'.$totalSteps.'... ';
				$upgradeStage++;
				$query="UPDATE config SET value='$upgradeStage' WHERE name='upgradeStage'";
				$result=mysql_query($query);
				if($result==FALSE) {
					echo "ERROR! ".mysql_error();
					exit();
				}

				echo 'Done!<br>';

			case '7':
				echo "<p>Doing upgrade stage...".$upgradeStage.'<br>';
				$totalSteps=2;
				$currentStep=0;

				echo ++$currentStep.'/'.$totalSteps.'... ';
				$tables=array('ipToSitesSums','oldTraffic','resolvedIPs');
				reset($tables);
				while(list($key,$value)=each($tables)) {
					$query='DROP TABLE IF EXISTS '.$value;
					$result=mysql_query($query);
					if($result==FALSE) {
						echo "ERROR! ".mysql_error();
						exit();
					}
				}

				echo ++$currentStep.'/'.$totalSteps.'... ';
				$upgradeStage++;
				$query="UPDATE config SET value='$upgradeStage' WHERE name='upgradeStage'";
				$result=mysql_query($query);
				if($result==FALSE) {
					echo "ERROR! ".mysql_error();
					exit();
				}

				echo 'Done!<br>';

			case '8':
				break;

			default:
				echo '<p>Oops! I don\'t know what to do in this upgrade stage! Something is VERY wrong! Please <a href="http://giannis.stoilis.gr/software/mysar/">report a bug!</a>';
				exit();
		}
		echo '<p>Upgrade is finished!';
		echo '<p><a href="index.php?install=end">Click here</a> to continue.';

		break;

	case 'upgrade1':
		echo 'It is advisable you keep a backup of the database before proceeding, since many things can go wrong.';
		echo '<br><b>Your previous data may be lost!</b>';
		echo '<p>If for whatever reason the upgrade gets interrupted, this wizard tries to be smart enough to continue from where it left of the next time you run it.';
		echo '<p>If you have lots of data, this can take some time...';
		echo '<p><a href="index.php?install=upgrade2">Click here</a> to continue.';	

		break;

	case 'end':
		echo "Installation is finished!";
		echo "<p>Please refer to <a href=\"http://code.google.com/p/squidlook/\">SquidLook site</a> if you have any problem.<p> You can even drop me a note, telling me what you think about this software. Any opinion is taken under consideration, either positive or negative.
<p>Good luck with SquidLook, I hope it serves you well.
<p><center><a href=\"index.php\">Start using SquidLook!</a>";

		break;
	case 'new4':
		echo 'Checking where adodb template cache directory is writeable...';
		$result1=touch($basePath.'/www-templates/mysar.install.test');
		$result2=unlink($basePath.'/www-templates/mysar.install.test');
		if($result1==FALSE || $result2==FALSE) {
			echo "Failed!";
			echo "<p>You need to set the directory $basePath/www-templates to be writable by the web server process. This can be done by executing the following as root:";
			$whoami=exec('whoami');
			if(isset($whoami) && $whoami!='') {
				echo "<br>chown $whoami $basePath/www-templates";
				echo "<br>chmod o+rwx $basePath/www-templates";
			} else {//if(isset($whoami) && $whoami!='') {
				echo "<br>chmod 777 $basePath/www-templates";
			}
			echo '<p><a href="./?install=new4">Click here</a> to try again';
			exit();
		}//if($result1==FALSE || $result2==FALSE) {

		echo "OK!";
		echo '<p><a href="./?install=end">Click here</a> to continue';
		break;
	case 'new3':
		echo "Creating config.ini file...";
		$handle = fopen ($basePath.'/etc/config.ini', "w") or die ("Unable do edit $basePath/etc/config.ini");
		fwrite ($handle, 'dbUser = '.$_REQUEST['dbuser']."\n");
		fwrite ($handle, 'dbPass = '.$_REQUEST['dbpass']."\n");
		fwrite ($handle, 'dbHost = '.$_REQUEST['dbhost']."\n");
		fwrite ($handle, 'dbName = '.$_REQUEST['dbname']."\n");
		fwrite ($handle, 'installed = 1');
		fclose ($handle);
		echo "...done!";
		echo "<p>Testing config file and the database connection...";
		$iniConfig=parse_ini_file($basePath.'/etc/config.ini');
		$link=mysql_connect($iniConfig['dbHost'],$iniConfig['dbUser'],$iniConfig['dbPass']);
		db_check($link,3);
		$result=mysql_select_db($iniConfig['dbName']);
		db_check($result,3);
		$query="SELECT value FROM config WHERE name='schemaVersion'";
		$result=mysql_query($query);
		db_check($result,3);
		echo "Done!";
		echo '<p><a href="index.php?install=new4">Click here</a> to continue.';
		break;

	case 'new2':
		echo "Creating database...<p>";
		$result=mysql_connect($_REQUEST['dbhost'],$_REQUEST['admuser'],$_REQUEST['admpass']);
		db_check($result);

		$result=mysql_query ('DROP DATABASE IF EXISTS '.$_REQUEST['dbname']);
		db_check($result);

		$result=mysql_query ('CREATE DATABASE '.$_REQUEST['dbname']);
		db_check($result);

		$result=mysql_select_db ($_REQUEST['dbname']);
		db_check($result);

		generate_db();		

		echo "Creating user...<p>";
		$query = 'GRANT SELECT,INSERT,UPDATE,DELETE,CREATE,DROP ON '.$_REQUEST['dbname'].'.*';
		$query .= ' TO \''.$_REQUEST['dbuser'].'\'@\'localhost\'';
		$query .= ' IDENTIFIED BY \''.$_REQUEST['dbpass'].'\'';
		$result=mysql_query ($query);
		echo "Done!";

		echo "<p><a href=\"index.php?install=new3";
		echo '&dbuser='.$_REQUEST['dbuser'];
		echo '&dbpass='.$_REQUEST['dbpass'];
		echo '&dbhost='.$_REQUEST['dbhost'];
		echo '&dbname='.$_REQUEST['dbname'];
		echo "\">Click here</a> to test the database connection.";
		break;
	case 'new1':
		?>
		I need the administrative username and password for mysql. It will not be stored. It will be used to create the database, import the schema, and create a simple user for this database.
 		<p>Please, keep in ming that if there is already a database using the same name, it will be deleted.<br><br>
		<table align="center"><tr><td>
		<form method="get">
		MySQL Administrative Username <input type="text" name="admuser" value="root">
		<p>MySQL Administrative Password <input type="text" name="admpass">
		<p>MySQL Database Host <input type="text" name="dbhost" value="localhost">
		<p>MySQL Database Name for squidLook <input type="text" name="dbname" value="squidlook">
		<p>Mysql Database Username to create, for squidLook <input type="text" name="dbuser" value="squidlook">
		<p>Mysql Database Password for the new user defined above <input type="text" name="dbpass" value="squidlook">
		<p>SquidLook host from which Mysql database is connected <input type="text" name="dbconnect" value="localhost">
		<input type="hidden" name="install" value="new2">
		<p><center><input type="submit" value="OK"></center>
		</td></tr></table>
		<?
		break;
	case '1':
		?>
		Are you installing for the first time, or are you upgrading from a previous mysar version?
		<p><p>
		<ul>
		<li>
		<a href="./?install=new1">New install</a><p>
		</li>
		<li>
		<a href="./?install=upgrade3">Upgrade from mysar 2.0.11 or 2.0.12</a>
		</li>
		</ul>
		<?
		break;
	default:
		?>		
                <center><img src="images/glasses.jpg"><br>
		</center>

		Hello,
		<br>I am the installation wizard and I will help you install this program.
		<p><a href="./?install=1">Click here to continue &gt;&gt;&gt;</a>
		<p>
		<?
}
echo $html_end;
exit();

?>
