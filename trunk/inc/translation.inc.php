<?php
# Program: squidLook, File: inc/common.inc.php
# Copyright 2007-2008, Luca Manganelli <luca76@gmail.com> - Servizio Sistema Informativo - Comune di Trento, Comune di Trento
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

$language = array();
$langPath=realpath(dirname(__FILE__).'/../lang');

function loadtranslations ($lang) {
	global $langPath, $language;
	$lines = file ($langPath.'/'.$lang);
	foreach ($lines as $line) {
		if (strpos ($line, "#") === 0 ||
			trim($line) == ""
				) {
			continue;
		}
		$parts = explode ('=', $line);
		$language [trim($parts[0])] = trim ($parts[1]);	
	}
	return 0;
}

// Input:   key  =  words to obtain for a given language
// Output:  string : the translated
function translate ($params, &$smarty) {
	global $langPath, $language;
	#if(empty($params['lang'])) {
	#	return 'lang parameter missing';
	#}
	#loadtranslations ($params['lang']);
	if(empty($params['key'])) {
		return 'key parameter missing';
	}
	return $language[$params['key']];
}

?>

