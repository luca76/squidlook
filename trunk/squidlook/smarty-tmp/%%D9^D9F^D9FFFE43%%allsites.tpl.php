<?php /* Smarty version 2.6.10, created on 2006-07-21 10:45:16
         compiled from allsites.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'string_trim', 'allsites.tpl', 75, false),array('modifier', 'bytesToHRF', 'allsites.tpl', 79, false),)), $this); ?>
<nobr>[
<a href="<?php echo $_SERVER['PHP_SELF']; ?>
?a=IPSummary&date=<?php echo $this->_tpl_vars['pageVars']['today']; ?>
">&lt;&lt;&lt; torna indietro</a>
|
<a href="<?php echo $this->_tpl_vars['pageVars']['uri']; ?>
">Aggiorna questa pagina</a>
]</nobr>

<table><tr><th style="font-size: 20px";>Riassunto dei siti in un giorno specificato</th></tr></table>
<p>
<table>
  <tr><td style="font-size: 20px;">
  <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?a=<?php echo $this->_tpl_vars['pageVars']['thisPage']; ?>
&date=<?php echo $this->_tpl_vars['pageVars']['previousWeek']; ?>
">&lt;&lt;</a>
  <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?a=<?php echo $this->_tpl_vars['pageVars']['thisPage']; ?>
&date=<?php echo $this->_tpl_vars['pageVars']['previousDate']; ?>
">&lt;</a>
  <?php echo $this->_tpl_vars['pageVars']['thisDateFormatted']; ?>

  <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?a=<?php echo $this->_tpl_vars['pageVars']['thisPage']; ?>
&date=<?php echo $this->_tpl_vars['pageVars']['nextDate']; ?>
">&gt;</a>
  <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?a=<?php echo $this->_tpl_vars['pageVars']['thisPage']; ?>
&date=<?php echo $this->_tpl_vars['pageVars']['nextWeek']; ?>
">&gt;&gt;</a>
  </td></tr>
  <tr><td style="text-align:center;">
  <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?a=<?php echo $this->_tpl_vars['pageVars']['thisPage']; ?>
&date=<?php echo $this->_tpl_vars['pageVars']['today']; ?>
">[ Vai alla data odierna ]</a>
  </td></tr>
  </table>
  <p>
      [
        <a href="<?php echo $this->_tpl_vars['pageVars']['uri']; ?>
&action=setDefaultView">
          Imposta questa pagina come predefenita
        </a>
      ]<br>
            <font color="red">Attenzione: Gli accessi ad alcuni siti non sono correntemente visualizzati, cliccare <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?a=whitelist&minDate=<?php echo $this->_tpl_vars['pageVars']['minDate']; ?>
&maxDate=<?php echo $this->_tpl_vars['pageVars']['maxDate']; ?>
">qui</a> per vedere la lista di tali siti</font>

  <table>
    <tr>
      <th></th>
      <th>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['siteASC']; ?>
"><img border="<?php echo $this->_tpl_vars['pageVars']['siteASCImageBorder']; ?>
" src="images/up-arrow.gif"></a>
          <?php echo $this->_tpl_vars['pageVars']['siteLabelStart']; ?>
Indirizzo<?php echo $this->_tpl_vars['pageVars']['siteLabelEnd']; ?>

        <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['siteDESC']; ?>
"><img border="<?php echo $this->_tpl_vars['pageVars']['siteDESCImageBorder']; ?>
" src="images/down-arrow.gif"></a>
      </th>
      <th>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['usersASC']; ?>
"><img border="<?php echo $this->_tpl_vars['pageVars']['usersASCImageBorder']; ?>
" src="images/up-arrow.gif"></a>
          <?php echo $this->_tpl_vars['pageVars']['usersLabelStart']; ?>
Utenti<?php echo $this->_tpl_vars['pageVars']['usersLabelEnd']; ?>

        <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['usersDESC']; ?>
"><img border="<?php echo $this->_tpl_vars['pageVars']['usersDESCImageBorder']; ?>
" src="images/down-arrow.gif"></a>
      </th>
      <th>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['countASC']; ?>
"><img border="<?php echo $this->_tpl_vars['pageVars']['countASCImageBorder']; ?>
" src="images/up-arrow.gif"></a>
          <?php echo $this->_tpl_vars['pageVars']['countLabelStart']; ?>
Numero Accessi<?php echo $this->_tpl_vars['pageVars']['countLabelEnd']; ?>

        <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['countDESC']; ?>
"><img border="<?php echo $this->_tpl_vars['pageVars']['countDESCImageBorder']; ?>
" src="images/down-arrow.gif"></a>
      </th>
      <th>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['hostsASC']; ?>
"><img border="<?php echo $this->_tpl_vars['pageVars']['hostsASCImageBorder']; ?>
" src="images/up-arrow.gif"></a>
          <?php echo $this->_tpl_vars['pageVars']['hostsLabelStart']; ?>
HOSTS<?php echo $this->_tpl_vars['pageVars']['hostsLabelEnd']; ?>

        <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['hostsDESC']; ?>
"><img border="<?php echo $this->_tpl_vars['pageVars']['hostsDESCImageBorder']; ?>
" src="images/down-arrow.gif"></a>
      </th>
      <th>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['bytesASC']; ?>
"><img border="<?php echo $this->_tpl_vars['pageVars']['bytesASCImageBorder']; ?>
" src="images/up-arrow.gif"></a>
          <?php echo $this->_tpl_vars['pageVars']['bytesLabelStart']; ?>
BYTES<?php echo $this->_tpl_vars['pageVars']['bytesLabelEnd']; ?>

        <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['bytesDESC']; ?>
"><img border="<?php echo $this->_tpl_vars['pageVars']['bytesDESCImageBorder']; ?>
" src="images/down-arrow.gif"></a>
        <br>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['B']; ?>
"><?php echo $this->_tpl_vars['pageVars']['BLabelStart']; ?>
B<?php echo $this->_tpl_vars['pageVars']['BLabelEnd']; ?>
</a>
        |
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['K']; ?>
"><?php echo $this->_tpl_vars['pageVars']['KLabelStart']; ?>
K<?php echo $this->_tpl_vars['pageVars']['KLabelEnd']; ?>
</a>
        |
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['M']; ?>
"><?php echo $this->_tpl_vars['pageVars']['MLabelStart']; ?>
M<?php echo $this->_tpl_vars['pageVars']['MLabelEnd']; ?>
</a>
        |
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['G']; ?>
"><?php echo $this->_tpl_vars['pageVars']['GLabelStart']; ?>
G<?php echo $this->_tpl_vars['pageVars']['GLabelEnd']; ?>
</a>

      </th>
      <th>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['cachePercentASC']; ?>
"><img border="<?php echo $this->_tpl_vars['pageVars']['cachePercentASCImageBorder']; ?>
" src="images/up-arrow.gif"></a>
          <?php echo $this->_tpl_vars['pageVars']['cachePercentLabelStart']; ?>
CACHE PERCENT<?php echo $this->_tpl_vars['pageVars']['cachePercentLabelEnd']; ?>

        <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['cachePercentDESC']; ?>
"><img border="<?php echo $this->_tpl_vars['pageVars']['cachePercentDESCImageBorder']; ?>
" src="images/down-arrow.gif"></a>
      </th>
    </tr>
  <?php $_from = $this->_tpl_vars['pageVars']['allSites']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['record']):
?>
  <tr onMouseOver="this.bgColor='#C5D3E7';" onMouseOut="this.bgColor='#DAE3F0';">
    <td><a href="<?php echo $_SERVER['PHP_SELF']; ?>
?a=siteusers&sitesID=<?php echo $this->_tpl_vars['record']['sitesID']; ?>
&date=<?php echo $this->_tpl_vars['pageVars']['date']; ?>
"><b>Dettagli</b></a></td>
    <td style="text-align: left"><a href="<?php echo $this->_tpl_vars['record']['site']; ?>
" target="_blank"><?php echo ((is_array($_tmp=$this->_tpl_vars['record']['site'])) ? $this->_run_mod_handler('string_trim', true, $_tmp, 80, "...") : string_trim($_tmp, 80, "...")); ?>
</a></td>
    <td><?php echo $this->_tpl_vars['record']['users']; ?>
</td>
    <td><?php echo $this->_tpl_vars['record']['count']; ?>
</td>
    <td><?php echo $this->_tpl_vars['record']['hosts']; ?>
</td>
    <td><?php echo ((is_array($_tmp=$this->_tpl_vars['record']['bytes'])) ? $this->_run_mod_handler('bytesToHRF', true, $_tmp, $this->_tpl_vars['pageVars']['byteUnit']) : bytesToHRF($_tmp, $this->_tpl_vars['pageVars']['byteUnit'])); ?>
</td>
    <td><?php echo $this->_tpl_vars['record']['cachePercent']; ?>
%</td>
  </tr>
  <?php endforeach; endif; unset($_from); ?>
  </table>