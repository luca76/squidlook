<?php /* Smarty version 2.6.10, created on 2006-06-19 15:11:58
         compiled from siteusers.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'bytesToHRF', 'siteusers.tpl', 72, false),array('modifier', 'string_trim', 'siteusers.tpl', 104, false),)), $this); ?>
<nobr>[
<a href="<?php echo $_SERVER['PHP_SELF']; ?>
?a=allsites&date=<?php echo $this->_tpl_vars['pageVars']['today']; ?>
">&lt;&lt;&lt; torna indietro"</a>
|
<a href="<?php echo $this->_tpl_vars['pageVars']['uri']; ?>
">Refresh this page</a>
]</nobr>

  <table><tr><th style="font-size: 20px";>Riassunto hosts ed utenti per un sito e giorno specificati</th></tr></table>
<p>
<table>
  <tr><td style="font-size: 20px;">
    <?php echo $this->_tpl_vars['pageVars']['thisDateFormatted']; ?>

  </td></tr>
</table>

<p>
<table>
  <tr><th colspan="2">Information box</th></tr>
  <form method="POST">
  <tr><td>Site</td><td style="text-align:left;"><a href="<?php echo $this->_tpl_vars['pageVars']['site']; ?>
" target="_blank"><?php echo $this->_tpl_vars['pageVars']['site']; ?>
</a></td></tr>
  </form>
</table>

  <p>
      [
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?a=<?php echo $this->_tpl_vars['pageVars']['thisPage']; ?>
&action=setDefaultView&OrderMethod=<?php echo $this->_tpl_vars['pageVars']['orderMethod']; ?>
&OrderBy=<?php echo $this->_tpl_vars['pageVars']['orderBy']; ?>
&ByteUnit=<?php echo $this->_tpl_vars['pageVars']['byteUnit']; ?>
&date=<?php echo $this->_tpl_vars['pageVars']['date']; ?>
&siteID=<?php echo $this->_tpl_vars['pageVars']['siteID']; ?>
">
          Set this view as the default
        </a>
      ]
  <table>
    <tr>
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
USERNAME<?php echo $this->_tpl_vars['pageVars']['usernameLabelEnd']; ?>

        <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['usernameDESC']; ?>
"><img border="<?php echo $this->_tpl_vars['pageVars']['usernameDESCImageBorder']; ?>
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
    <?php $_from = $this->_tpl_vars['pageVars']['siteusers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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
      <td><a href='<?php echo $_SERVER['PHP_SELF']; ?>
?a=details&date=<?php echo $this->_tpl_vars['pageVars']['date']; ?>
&hostiplong=<?php echo $this->_tpl_vars['record']['hostiplong']; ?>
&usersID=<?php echo $this->_tpl_vars['record']['usersID']; ?>
&sitesID=<?php echo $this->_tpl_vars['pageVars']['sitesID']; ?>
'><?php echo $this->_tpl_vars['thisRecord']; ?>
</td>
      <td><a href='<?php echo $_SERVER['PHP_SELF']; ?>
?a=details&date=<?php echo $this->_tpl_vars['pageVars']['date']; ?>
&hostiplong=<?php echo $this->_tpl_vars['record']['hostiplong']; ?>
&usersID=<?php echo $this->_tpl_vars['record']['usersID']; ?>
&sitesID=<?php echo $this->_tpl_vars['pageVars']['sitesID']; ?>
'><?php echo $this->_tpl_vars['record']['username']; ?>
</td>
      <td><?php echo ((is_array($_tmp=$this->_tpl_vars['record']['bytes'])) ? $this->_run_mod_handler('bytesToHRF', true, $_tmp, $this->_tpl_vars['pageVars']['byteUnit']) : bytesToHRF($_tmp, $this->_tpl_vars['pageVars']['byteUnit'])); ?>
</td>
      <td><?php echo $this->_tpl_vars['record']['cachePercent']; ?>
%</td>
    </tr>
    <?php $this->assign('bytesTotal', $this->_tpl_vars['bytesTotal']+$this->_tpl_vars['record']['bytes']); ?>
    <?php endforeach; endif; unset($_from); ?>
    <tr><td></td></tr>
    <tr><td></td></tr>
    <tr>
      <th>TOTALI</th>
      <th style="text-align: right;"><?php echo $this->_tpl_vars['pageVars']['distinctValues']['users']; ?>
</th>
      <th style="text-align: right;"><?php echo ((is_array($_tmp=$this->_tpl_vars['bytesTotal'])) ? $this->_run_mod_handler('bytesToHRF', true, $_tmp, $this->_tpl_vars['pageVars']['byteUnit']) : bytesToHRF($_tmp, $this->_tpl_vars['pageVars']['byteUnit'])); ?>
</th>
      <th></th>
      <th></th>
    </tr>
  </table>
  <p>
  <table>
    <tr><th colspan="7">Latest site activity</th></td>
    <tr>
      <th>HOST IP</th>
      <th>USERNAME</th>
      <th>TIME</th>
      <th>BYTES</th>
      <th>URL</th>
      <th>STATUS</th>
    </tr>
    <?php $_from = $this->_tpl_vars['pageVars']['latestSiteActivity']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['record']):
?>
    <tr onMouseOver="this.bgColor='#C5D3E7';" onMouseOut="this.bgColor='#DAE3F0';">
      <td><a href='<?php echo $_SERVER['PHP_SELF']; ?>
?a=IPSitesSummary&date=<?php echo $this->_tpl_vars['pageVars']['date']; ?>
&hostiplong=<?php echo $this->_tpl_vars['record']['hostiplong']; ?>
&usersID=<?php echo $this->_tpl_vars['record']['usersID']; ?>
'><?php echo $this->_tpl_vars['record']['hostip']; ?>
</a></td>
      <td><a href='<?php echo $_SERVER['PHP_SELF']; ?>
?a=IPSitesSummary&date=<?php echo $this->_tpl_vars['pageVars']['date']; ?>
&hostiplong=<?php echo $this->_tpl_vars['record']['hostiplong']; ?>
&usersID=<?php echo $this->_tpl_vars['record']['usersID']; ?>
'><?php echo $this->_tpl_vars['record']['username']; ?>
</a></td>
      <td><?php echo $this->_tpl_vars['record']['time']; ?>
</td>
      <td><?php echo $this->_tpl_vars['record']['bytes']; ?>
</td>
      <td style="text-align: left"><a href="<?php echo $this->_tpl_vars['record']['url']; ?>
" target="_blank"><?php echo ((is_array($_tmp=$this->_tpl_vars['record']['url'])) ? $this->_run_mod_handler('string_trim', true, $_tmp, 80, "...") : string_trim($_tmp, 80, "...")); ?>
</a></td>
      <td style="text-align: left"><?php echo $this->_tpl_vars['record']['resultCode']; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
  </table>
