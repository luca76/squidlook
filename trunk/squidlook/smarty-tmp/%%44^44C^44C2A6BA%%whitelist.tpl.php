<?php /* Smarty version 2.6.10, created on 2006-06-27 11:41:43
         compiled from whitelist.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'whitelist.tpl', 43, false),)), $this); ?>

<table><tr><th style="font-size: 20px";>Whitelist</th></tr></table>
<p>
<table>
  <form method="POST" name="WH">
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
  <table>
    <tr>
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
      	Nella whitelist?
      </th>
    </tr>
  <?php $_from = $this->_tpl_vars['pageVars']['whitelistSites']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['record']):
?>
  <tr onMouseOver="this.bgColor='#C5D3E7';" onMouseOut="this.bgColor='#DAE3F0';">
    <td><?php echo $this->_tpl_vars['record']['site']; ?>
</td>
    <td><?php echo $this->_tpl_vars['record']['count']; ?>
</td>
    <?php if ($this->_tpl_vars['record']['whitelist'] == 1): ?>
    <?php $this->assign('chk', 'checked'); ?>
    <?php else: ?>
    <?php $this->assign('chk', ""); ?>
    <?php endif; ?>
    <td style="text-align: center;"><input type="checkbox" name="<?php echo smarty_function_counter(array(), $this);?>
" value="<?php echo $this->_tpl_vars['record']['sitesID']; ?>
" <?php echo $this->_tpl_vars['chk']; ?>
></td>
  </tr>
  <?php endforeach; endif; unset($_from); ?>
  </table>
  <center><input type="submit" value="OK" name="OK"></center>
  </form>