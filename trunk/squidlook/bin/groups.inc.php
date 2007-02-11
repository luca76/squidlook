<?php

# Searches group for a username

# please configure your arrays
$groups = Array('Group1', 'Group2', 'Group3');
$users[0] = Array('manganelll','fioronig','vicentinim');
$users[1] = Array('veronesm', 'avit', 'lorenzag');
$users[2] = Array('zanollim');

function searchAD ($username) {

   global $groups;
   foreach ($groups as $group) {
       $commandline = "echo \"$username $group\" | /usr/sbin/wbinfo_group.pl";
       $res = exec ($commandline);
       if ($res == 'OK') {
           break;
       }
   }
   if ($res != 'OK') {
       return FALSE;
   }

   return array_search ($group, $groups);

}

function searchArray ($username) {

   global $groups;
   global $users;
   foreach (array_keys($users) as $group_id) {
      $res = array_search ($username, $users[$group_id]);
      if ($res !== FALSE) {
         return $group_id;
      }
   }
   return FALSE;
}

function getGroupID ($username) {

   # return searchAD ($username);  // Uncomment this if you are using Active Directory
   # return searchLDAP ($username); // Uncomment this if you are using LDAP
   # return 0; // Uncomment this if you want to disable group searching
   return searchArray ($username); // Uncomment this if you are using Array lists

}
?>
