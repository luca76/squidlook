<?php /* Smarty version 2.6.10, created on 2006-06-28 11:36:56
         compiled from administration.tpl */ ?>
      <table><tr><th style="font-size: 20px";>Administration</th></tr></table>
      <p>
      <table>
        <form method="POST">
        <input type="hidden" name="hiddenSubmit" value="1">
        <input type="hidden" name="configName" value="keepHistoryDays">
        <tr>
          <td colspan="2">Automatically delete data older than <input type="text" name="thisValue" size="2" value="<?php echo $this->_tpl_vars['pageVars']['keepHistoryDays']; ?>
"> days</td>
          <td><input type="submit" name="submit" value="Change value"></td>
        </tr>
      <tr><td colspan="2" style="text-align:justify;" width="200">
      To prevent the database from getting too big, mysar will delete old data periodically. Use this value to specify how often you want this maintenance to take place. Don't set this too high, as it will increase the load of the server. Default value: 32.
      </td></tr>
        </form>
      <tr><td colspan="3"><hr size="1"></td></tr>
        <form method="POST">
        <input type="hidden" name="hiddenSubmit" value="1">
        <input type="hidden" name="configName" value="squidLogPath">
        <tr>
          <td>Squid's access.log file path</td>
          <td><input type="text" name="thisValue" size="30" value="<?php echo $this->_tpl_vars['pageVars']['squidLogPath']; ?>
"></td>
          <td><input type="submit" name="submit" value="Change value"></td>
        </tr>
      <tr><td colspan="2" style="text-align:justify;" width="200">
      This is where to find squid's log file. mysar needs this value to collect data from the log. Make sure this file is readable by the user running mysar's cron job. Default value: /var/log/squid/access.log.
      </td></tr>
        </form>
      <tr><td colspan="3"><hr size="1"></td></tr>
        <form method="POST">
        <input type="hidden" name="hiddenSubmit" value="1">
        <input type="hidden" name="configName" value="resolveClients">
        <?php if ($this->_tpl_vars['pageVars']['resolveClients'] == 'enabled'): ?>
	<?php $this->assign('optionEnabled', 'selected'); ?>
	<?php $this->assign('optionDisabled', ""); ?>
	<?php else: ?>
	<?php $this->assign('optionEnabled', ""); ?>
	<?php $this->assign('optionDisabled', 'selected'); ?>
	<?php endif; ?>
        <tr>
          <td colspan="2">Client DNS resolving is
            <select name="thisValue">
              <option value="enabled" <?php echo $this->_tpl_vars['optionEnabled']; ?>
>enabled
              <option value="disabled" <?php echo $this->_tpl_vars['optionDisabled']; ?>
>disabled
            </select>
          </td>
          <td><input type="submit" name="submit" value="Change value"></td>
        </tr>
        </form>
      <tr><td colspan="2" style="text-align:justify;" width="200">
      If you have a network where all of your clients connecting to the squid server have DNS resolvable address, enable this and mysar will use this information when displaying statistics. Otherwize, keep this disabled, as it is a waste of resources. Default value: Disabled.
      </td></tr>

      <tr><td colspan="3"><hr size="1"></td></tr>
        <form method="POST">
        <input type="hidden" name="hiddenSubmit" value="1">
        <input type="hidden" name="configName" value="mysarImporter">
        <?php if ($this->_tpl_vars['pageVars']['mysarImporter'] == 'enabled'): ?>
	<?php $this->assign('optionEnabled', 'selected'); ?>
	<?php $this->assign('optionDisabled', ""); ?>
	<?php else: ?>
	<?php $this->assign('optionEnabled', ""); ?>
	<?php $this->assign('optionDisabled', 'selected'); ?>
	<?php endif; ?>
        <tr>
          <td colspan="2">MySAR is
            <select name="thisValue">
              <option value="enabled" <?php echo $this->_tpl_vars['optionEnabled']; ?>
>enabled
              <option value="disabled" <?php echo $this->_tpl_vars['optionDisabled']; ?>
>disabled
            </select>
          </td>
          <td><input type="submit" name="submit" value="Change value"></td>
        </tr>
        </form>
      <tr><td colspan="2" style="text-align:justify;" width="200">
      If, for some reason, you want mysar to stop importing the log file into the database, use this option. Default value: Enabled.
      </td></tr>


      <tr><td colspan="3"><hr size="1"></td></tr>
        <form method="POST">
        <input type="hidden" name="hiddenSubmit" value="1">
        <input type="hidden" name="configName" value="topGrouping">
	<?php if ($this->_tpl_vars['pageVars']['topGrouping'] == 'annuale'): ?>
		<?php $this->assign('optionYearly', 'selected'); ?>
	<?php elseif ($this->_tpl_vars['pageVars']['topGrouping'] == 'mensile'): ?>
		<?php $this->assign('optionMonthly', 'selected'); ?>
	<?php elseif ($this->_tpl_vars['pageVars']['topGrouping'] == 'settimanale'): ?>
		<?php $this->assign('optionWeekly', 'selected'); ?>
	<?php else: ?>
		<?php $this->assign('optionDaily', 'selected'); ?>
	<?php endif; ?>
        <tr>
          <td colspan="2">Top grouping is
            <select name="thisValue">
              <option value="annuale" <?php echo $this->_tpl_vars['optionYearly']; ?>
>Annuale
              <option value="mensile" <?php echo $this->_tpl_vars['optionMonthly']; ?>
>Mensile
              <option value="settimanale" <?php echo $this->_tpl_vars['optionWeekly']; ?>
>Settimanale
              <option value="giornaliero" <?php echo $this->_tpl_vars['optionDaily']; ?>
>Giornaliero
            </select>
          </td>
          <td><input type="submit" name="submit" value="Change value"></td>
        </tr>
        </form>
      <tr><td colspan="2" style="text-align:justify;" width="200">
      If, for some reason, you want mysar to stop importing the log file into the database, use this option. Default value: Enabled.
      </td></tr>

      <tr><td colspan="3"><hr size="1"></td></tr>
      <tr><td colspan="2" style="text-align:justify;" width="200">
      Press this button to erase ALL data collected by mysar. This action is not reversible. Use this solve any weird problems, like reports not updating correctly etc.
      </td>
        <td colspan="3" style="text-align:center;">
          <input type="submit" value="Erase all statistics" onClick="my_confirm('Are you sure you want to erase ALL statistics?','<?php echo $this->_tpl_vars['pageVars']['uri']; ?>
&action=eraseAllStats')">
        </td>
      </tr>
      
      </table>
      