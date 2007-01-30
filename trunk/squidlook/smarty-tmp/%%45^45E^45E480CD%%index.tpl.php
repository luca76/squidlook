<?php /* Smarty version 2.6.10, created on 2006-07-24 08:38:56
         compiled from index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'bytesToHRF', 'index.tpl', 61, false),)), $this); ?>

      <table><tr><th style="font-size: 20px";>Riassunto <?php echo $this->_tpl_vars['pageVars']['topGrouping']; ?>
</th></tr></table>
      <p>
      <table cellpadding=1 cellspacing=1>
        <tr>
          <th rowspan="2">
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['dateASC']; ?>
"><img border="<?php echo $this->_tpl_vars['pageVars']['dateASCImageBorder']; ?>
" src="images/up-arrow.gif"></a>
              <?php echo $this->_tpl_vars['pageVars']['dateLabelStart']; ?>
Data<?php echo $this->_tpl_vars['pageVars']['dateLabelEnd']; ?>

            <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['dateDESC']; ?>
"><img border="<?php echo $this->_tpl_vars['pageVars']['dateDESCImageBorder']; ?>
" src="images/down-arrow.gif"></a>
          </th>
          <th rowspan="2">
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
          <th rowspan="2">
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['hostsASC']; ?>
"><img border="<?php echo $this->_tpl_vars['pageVars']['hostsASCImageBorder']; ?>
" src="images/up-arrow.gif"></a>
              <?php echo $this->_tpl_vars['pageVars']['hostsLabelStart']; ?>
Host<?php echo $this->_tpl_vars['pageVars']['hostsLabelEnd']; ?>

            <a href="<?php echo $_SERVER['PHP_SELF']; ?>
?<?php echo $this->_tpl_vars['pageVars']['url']['hostsDESC']; ?>
"><img border="<?php echo $this->_tpl_vars['pageVars']['hostsDESCImageBorder']; ?>
" src="images/down-arrow.gif"></a>
          </th>
          <th rowspan="2">
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
          <th colspan="2">Traffico</th>
        </tr>
        <tr>
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
        <?php $_from = $this->_tpl_vars['pageVars']['availableDates']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['date']):
?>
        <tr onMouseOver="this.bgColor='#C5D3E7';" onMouseOut="this.bgColor='#DAE3F0';">
          <td style="text-align: left;">
          <!-- <a href='<?php echo $_SERVER['PHP_SELF']; ?>
?a=IPSummary&minDate=<?php echo $this->_tpl_vars['date']['minDate']; ?>
&maxDate=<?php echo $this->_tpl_vars['date']['maxDate']; ?>
'><?php echo $this->_tpl_vars['date']['dateFormatted']; ?>
</a> -->
          
          <a href='<?php echo $_SERVER['PHP_SELF']; ?>
?a=GroupSummary&minDate=<?php echo $this->_tpl_vars['date']['minDate']; ?>
&maxDate=<?php echo $this->_tpl_vars['date']['maxDate']; ?>
'><?php echo $this->_tpl_vars['date']['dateFormatted']; ?>
</a>

          </td>
          <td style="text-align: center;"><?php echo $this->_tpl_vars['date']['users']; ?>
</td>
          <td style="text-align: center;"><?php echo $this->_tpl_vars['date']['hosts']; ?>
</td>
          <td style="text-align: center;">
          <?php echo $this->_tpl_vars['date']['sites']; ?>

          </td>
          <td style="text-align: right;"><?php echo ((is_array($_tmp=$this->_tpl_vars['date']['bytes'])) ? $this->_run_mod_handler('bytesToHRF', true, $_tmp, $this->_tpl_vars['pageVars']['ByteUnit']) : bytesToHRF($_tmp, $this->_tpl_vars['pageVars']['ByteUnit'])); ?>
</td>
          <td style="text-align: center;"><?php echo $this->_tpl_vars['date']['cachePercent']; ?>
%</td>
        </tr>
      <?php endforeach; endif; unset($_from); ?>
      </table>