<?php
# Program: SquidLook
# Copyright 2007-2008, Luca Manganelli <luca76@gmail.com> - Servizio Sistema Informativo
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
