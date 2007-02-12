<?php

$language = array();
$langPath=realpath(dirname(__FILE__).'/../lang');
print $langPath;

function loadtranslations ($lang) {
	global $langPath, $language;
	$lines = file ($langPath.'/'.$lang.'.lang');

	foreach ($lines as $line) {
		$parts = explode ('=', $line);
		$language [trim($parts[0])] = trim ($parts[1]);	
	}
	return 0;
}

// Input:   key  =  words to obtain for a given language
// Output:  string : the translated
function translate ($params, &$smarty) {
	global $langPath, $language;
	if(empty($params['key'])) {
		return 'NOKEYPARAMETER';
	}
	return $language[$params['key']];
}

?>

