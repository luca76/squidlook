<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso8859-1">
    <title>{$pageVars.programName} {$pageVars.programVersion}</title>
    <link rel="stylesheet" href="dfl.css" type="text/css">
    {literal}
    <SCRIPT language="JavaScript"><!--
      function my_confirm(msg,go) {
        var where_to= confirm(msg);
        if (where_to== true) {
          window.location=go;
        }
      }
    //--></SCRIPT>
   {/literal}
  </head>
    <body><center>
    <h1>{$pageVars.programName} {$pageVars.programVersion}</h1>
    <p>[ <a href=".">{translate key="main"}</a> | <a href="{$smarty.server.PHP_SELF}?a=administration">{translate key="admin"}</a> ]</p>
