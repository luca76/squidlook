<?php

$language = array();
$langPath=realpath(dirname(__FILE__).'/../lang');

function loadtranslations ($lang) {
	global $langPath, $language;
	$lines = file ($langPath.'/'.$lang);
	foreach ($lines as $line) {
		if (strpos ($line, "#") === 0) {
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

