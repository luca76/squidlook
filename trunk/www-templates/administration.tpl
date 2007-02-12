      <table><tr><th style="font-size: 20px";>Administration</th></tr></table>
      <p>
      <table>
        <form method="POST">
        <input type="hidden" name="hiddenSubmit" value="1">
        <input type="hidden" name="configName" value="keepHistoryDays">
        <tr>
          <td colspan="2">Automatically delete data older than <input type="text" name="thisValue" size="2" value="{$pageVars.keepHistoryDays}"> days</td>
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
          <td><input type="text" name="thisValue" size="30" value="{$pageVars.squidLogPath}"></td>
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
        {if $pageVars.resolveClients=="enabled"}
	{assign var="optionEnabled" value="selected"}
	{assign var="optionDisabled" value=""}
	{else}
	{assign var="optionEnabled" value=""}
	{assign var="optionDisabled" value="selected"}
	{/if}
        <tr>
          <td colspan="2">Client DNS resolving is
            <select name="thisValue">
              <option value="enabled" {$optionEnabled}>enabled
              <option value="disabled" {$optionDisabled}>disabled
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
        {if $pageVars.mysarImporter=="enabled"}
	{assign var="optionEnabled" value="selected"}
	{assign var="optionDisabled" value=""}
	{else}
	{assign var="optionEnabled" value=""}
	{assign var="optionDisabled" value="selected"}
	{/if}
        <tr>
          <td colspan="2">MySAR is
            <select name="thisValue">
              <option value="enabled" {$optionEnabled}>enabled
              <option value="disabled" {$optionDisabled}>disabled
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
	{if $pageVars.topGrouping=="annuale"}
		{assign var="optionYearly" value="selected"}
	{elseif $pageVars.topGrouping=="mensile"}
		{assign var="optionMonthly" value="selected"}
	{elseif $pageVars.topGrouping=="settimanale"}
		{assign var="optionWeekly" value="selected"}
	{else}
		{assign var="optionDaily" value="selected"}
	{/if}
        <tr>
          <td colspan="2">Top grouping is
            <select name="thisValue">
              <option value="annuale" {$optionYearly}>Annuale
              <option value="mensile" {$optionMonthly}>Mensile
              <option value="settimanale" {$optionWeekly}>Settimanale
              <option value="giornaliero" {$optionDaily}>Giornaliero
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
          <input type="submit" value="Erase all statistics" onClick="my_confirm('Are you sure you want to erase ALL statistics?','{$pageVars.uri}&action=eraseAllStats')">
        </td>
      </tr>
      
      </table>
      
