<?php /* Smarty version 2.6.10, created on 2006-07-24 14:35:07
         compiled from GroupSummary.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'bytesToHRF', 'GroupSummary.tpl', 73, false),)), $this); ?>

<table><tr><th style="font-size: 20px;">Host ed utenti</th></tr></table>
<p>
<p>
<table>
  <tr><td style="font-size: 20px;">
  <!-- a href="<?php echo $_SERVER['PHP_SELF']; ?>
?a=<?php echo $this->_tpl_vars['pageVars']['thisPage']; ?>
&date=<?php echo $this->_tpl_vars['pageVars']['previousWeek']; ?>
" title="Go back a week">&lt;&lt;</a>
  <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?a=<?php echo $this->_tpl_vars['pageVars']['thisPage']; ?>
&date=<?php echo $this->_tpl_vars['pageVars']['previousDate']; ?>
" title="Go back a day">&lt;</a -->
  <?php echo $this->_tpl_vars['pageVars']['thisDateFormatted']; ?>

  <!-- a href="<?php echo $_SERVER['PHP_SELF']; ?>
?a=<?php echo $this->_tpl_vars['pageVars']['thisPage']; ?>
&date=<?php echo $this->_tpl_vars['pageVars']['nextDate']; ?>
" title="Go forward a day">&gt;</a>
  <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?a=<?php echo $this->_tpl_vars['pageVars']['thisPage']; ?>
&date=<?php echo $this->_tpl_vars['pageVars']['nextWeek']; ?>
" title="Go forward a week">&gt;&gt;</a -->
  </td></tr>
  <tr><td style="text-align:center;">
  <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?a=<?php echo $this->_tpl_vars['pageVars']['thisPage']; ?>
&date=<?php echo $this->_tpl_vars['pageVars']['today']; ?>
" title="Go to today's report">[ Vai alla data odierna ]</a>
  </td></tr>
  </table>
<p>
[ <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?a=allsites&minDate=<?php echo $this->_tpl_vars['pageVars']['minDate']; ?>
&maxDate=<?php echo $this->_tpl_vars['pageVars']['maxDate']; ?>
" title="List of all the different sites that were visited">Riassunto siti visitati in questo periodo</a> ]

<center>
  <table>
    <tr>
      <th></th>
      <th>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['hostipASC']; ?>
"><img border="<?php echo $this->_tpl_vars['pageVars']['hostipASCImageBorder']; ?>
" src="images/up-arrow.gif"></a>
          <?php echo $this->_tpl_vars['pageVars']['hostipLabelStart']; ?>
HOST<?php echo $this->_tpl_vars['pageVars']['hostipLabelEnd']; ?>

        <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['hostipDESC']; ?>
"><img border="<?php echo $this->_tpl_vars['pageVars']['hostipDESCImageBorder']; ?>
" src="images/down-arrow.gif"></a>
      </th>
      <th>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['usernameASC']; ?>
"><img border="<?php echo $this->_tpl_vars['pageVars']['usernameASCImageBorder']; ?>
" src="images/up-arrow.gif"></a>
          <?php echo $this->_tpl_vars['pageVars']['usernameLabelStart']; ?>
Servizio<?php echo $this->_tpl_vars['pageVars']['usernameLabelEnd']; ?>

        <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['usernameDESC']; ?>
"><img border="<?php echo $this->_tpl_vars['pageVars']['usernameDESCImageBorder']; ?>
" src="images/down-arrow.gif"></a>
      </th>
      <th>
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['sitesASC']; ?>
"><img border="<?php echo $this->_tpl_vars['pageVars']['sitesASCImageBorder']; ?>
" src="images/up-arrow.gif"></a>
          <?php echo $this->_tpl_vars['pageVars']['sitesLabelStart']; ?>
Siti<?php echo $this->_tpl_vars['pageVars']['sitesLabelEnd']; ?>

        <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['sitesDESC']; ?>
"><img border="<?php echo $this->_tpl_vars['pageVars']['sitesDESCImageBorder']; ?>
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
    <?php $this->assign('bytesTotal', '0'); ?>
    <?php $_from = $this->_tpl_vars['pageVars']['groupIPRecords']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['record']):
?>
      <?php if ($this->_tpl_vars['record']['hostdescription'] != ""): ?>
        <?php $this->assign('thisRecord', $this->_tpl_vars['record']['hostdescription']); ?>
      <?php elseif ($this->_tpl_vars['record']['hostip'] != $this->_tpl_vars['record']['hostname']): ?>
        <?php $this->assign('thisRecord', $this->_tpl_vars['record']['hostname']); ?>
      <?php else: ?>
        <?php $this->assign('thisRecord', $this->_tpl_vars['record']['hostip']); ?>
      <?php endif; ?>

    <tr onMouseOver="this.bgColor='#C5D3E7';" onMouseOut="this.bgColor='#DAE3F0';">
      <td></td>
      <td><a href='<?php echo $_SERVER['PHP_SELF']; ?>
?a=IPSitesSummary&minDate=<?php echo $this->_tpl_vars['pageVars']['minDate']; ?>
&maxDate=<?php echo $this->_tpl_vars['pageVars']['maxDate']; ?>
&hostiplong=<?php echo $this->_tpl_vars['record']['hostiplong']; ?>
&usersID=<?php echo $this->_tpl_vars['record']['usersID']; ?>
'><?php echo $this->_tpl_vars['thisRecord']; ?>
</td>
      <td><a href='<?php echo $_SERVER['PHP_SELF']; ?>
?a=IPSummary&minDate=<?php echo $this->_tpl_vars['pageVars']['minDate']; ?>
&maxDate=<?php echo $this->_tpl_vars['pageVars']['maxDate']; ?>
&hostiplong=<?php echo $this->_tpl_vars['record']['hostiplong']; ?>
&Servizio=<?php echo $this->_tpl_vars['record']['servizio']; ?>
&elapsedTime=0'><?php echo $this->_tpl_vars['record']['servizio']; ?>
</td>
      <td><a href='<?php echo $_SERVER['PHP_SELF']; ?>
?a=allsites&minDate=<?php echo $this->_tpl_vars['pageVars']['minDate']; ?>
&maxDate=<?php echo $this->_tpl_vars['pageVars']['maxDate']; ?>
&Servizio=<?php echo $this->_tpl_vars['record']['servizio']; ?>
'><?php echo $this->_tpl_vars['record']['sites']; ?>
</td>
      <td><?php echo ((is_array($_tmp=$this->_tpl_vars['record']['bytes'])) ? $this->_run_mod_handler('bytesToHRF', true, $_tmp, $this->_tpl_vars['pageVars']['ByteUnit']) : bytesToHRF($_tmp, $this->_tpl_vars['pageVars']['ByteUnit'])); ?>
</td>
      <td><?php echo $this->_tpl_vars['record']['cachePercent']; ?>
%</td>
    </tr>
    <?php $this->assign('bytesTotal', $this->_tpl_vars['bytesTotal']+$this->_tpl_vars['record']['bytes']); ?>
    <?php endforeach; endif; unset($_from); ?>
<!--    <tr><td></td></tr>
    <tr><td></td></tr>
    <tr>
      <th>TOTALS</th>
      <th style="text-align: right;"><?php echo $this->_tpl_vars['pageVars']['distinctValues']['ips']; ?>
</th>
      <th style="text-align: right;"><?php echo $this->_tpl_vars['pageVars']['distinctValues']['users']; ?>
</th>
      <th style="text-align: right;"><?php echo $this->_tpl_vars['pageVars']['distinctValues']['sites']; ?>
</th>
      <th style="text-align: right;"><?php echo ((is_array($_tmp=$this->_tpl_vars['bytesTotal'])) ? $this->_run_mod_handler('bytesToHRF', true, $_tmp, $this->_tpl_vars['pageVars']['ByteUnit']) : bytesToHRF($_tmp, $this->_tpl_vars['pageVars']['ByteUnit'])); ?>
</th>
      <th></th>
    </tr> --> 
  </table>
  <p>
</center>