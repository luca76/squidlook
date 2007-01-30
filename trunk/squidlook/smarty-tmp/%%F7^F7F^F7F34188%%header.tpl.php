<?php /* Smarty version 2.6.10, created on 2006-06-19 14:06:41
         compiled from header.tpl */ ?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso8859-1">
    <title><?php echo $this->_tpl_vars['pageVars']['programName']; ?>
 <?php echo $this->_tpl_vars['pageVars']['programVersion']; ?>
</title>
    <link rel="stylesheet" href="dfl.css" type="text/css">
    <?php echo '
    <SCRIPT language="JavaScript"><!--
      function my_confirm(msg,go) {
        var where_to= confirm(msg);
        if (where_to== true) {
          window.location=go;
        }
      }
    //--></SCRIPT>
   '; ?>

  </head>
    <body><center>
    <h1><?php echo $this->_tpl_vars['pageVars']['programName']; ?>
 <?php echo $this->_tpl_vars['pageVars']['programVersion']; ?>
</h1>
    <p>[ <a href=".">Pagina principale</a> | <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?a=administration">Amministrazione</a> ]</p>