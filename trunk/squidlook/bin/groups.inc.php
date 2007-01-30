<?php

# Organizzazione dei gruppi nei servizi

$names = array('Cultura', 'Sistema informativo', 'Polizia Municipale', 'Direzione generale', 'Piani, programmi e statistica');

$mgroups = array(
	'cultura' => 'Cultura',
	'serviziosistemainformativo' => 'Sistema informativo',
	'sistemainformativo' => 'Sistema informativo',
        'sistemainfterr' => 'Sistema informativo',
        'CED' => 'Sistema informativo',
        'serviziopolizia' => 'Polizia Municipale',
        'direzioneg' => 'Direzione generale',
        'comunicazi' => 'Direzione generale',
        'pianificazione-cdg' => 'Direzione generale',
        'pianistatistica' => 'Piani, programmi e statistica'
);

# print array_search ('Sistema informativo', $names);

function getGroupID ($username, $groups) {

   foreach (array_keys ($groups) as $uff) {
       $commandline = "echo \"$username $uff\" | /usr/sbin/wbinfo_group.pl";
       $res = system ($commandline);
       if ($res == 'OK') {
           break;
       }
   }
   return $uff;

}

?>
