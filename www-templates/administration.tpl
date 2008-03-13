      <table><tr><th style="font-size: 20px";>{translate key="admin"}</th></tr></table>
      <p>
      <table>
        <form method="POST">
        <input type="hidden" name="hiddenSubmit" value="1">
        <input type="hidden" name="configName" value="language">
		<tr>
		  <td>{translate key="language"}</td>
		  <td><select name="thisValue">
			{foreach from=$pageVars.languages key=k item=foo}
				<option value={$k} {if $pageVars.language eq $k}selected{/if} >{$foo}</option>
			{/foreach}
		  </select></td>
		  <td><input type="submit" name="submit" value="{translate key="changevalue"}"></td>
		</tr>
		<tr>
		  <td colspan="3"><hr size="1"></td>
		</tr>
		</form>
        <form method="POST">
        <input type="hidden" name="hiddenSubmit" value="1">
        <input type="hidden" name="configName" value="keepHistoryDays">
        <tr>
          <td colspan="2">{translate key="autodelete"} <input type="text" name="thisValue" size="2" value="{$pageVars.keepHistoryDays}"> {translate key="days"}</td>
          <td><input type="submit" name="submit" value="{translate key="changevalue"}"></td>
        </tr>
      <tr><td colspan="2" style="text-align:justify;" width="200">
		   {translate key="autodeleteinfo"}
      </td></tr>
        </form>
      <tr><td colspan="3"><hr size="1"></td></tr>
        <form method="POST">
        <input type="hidden" name="hiddenSubmit" value="1">
        <input type="hidden" name="configName" value="squidLogPath">
        <tr>
          <td>{translate key="squidlogpath"}</td>
          <td><input type="text" name="thisValue" size="30" value="{$pageVars.squidLogPath}"></td>
          <td><input type="submit" name="submit" value="{translate key="changevalue"}"></td>
        </tr>
      <tr><td colspan="2" style="text-align:justify;" width="200">
		{translate key="squidlogpathdesc"}
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
          <td colspan="2">{translate key="clientdns"}
            <select name="thisValue">
              <option value="enabled" {$optionEnabled}>{translate key="enabled"}
              <option value="disabled" {$optionDisabled}>{translate key="disabled"}
            </select>
          </td>
          <td><input type="submit" name="submit" value="{translate key="changevalue"}"></td>
        </tr>
        </form>
      <tr><td colspan="2" style="text-align:justify;" width="200">
		{translate key="clientdnsdesc"}
      </td></tr>

      <tr><td colspan="3"><hr size="1"></td></tr>
        <form method="POST">
        <input type="hidden" name="hiddenSubmit" value="1">
        <input type="hidden" name="configName" value="squidlookImporter">
        {if $pageVars.squidlookImporter=="enabled"}
	{assign var="optionEnabled" value="selected"}
	{assign var="optionDisabled" value=""}
	{else}
	{assign var="optionEnabled" value=""}
	{assign var="optionDisabled" value="selected"}
	{/if}
        <tr>
          <td colspan="2">{translate key="squidlookstate"}
            <select name="thisValue">
              <option value="enabled" {$optionEnabled}>{translate key="enabled"}
              <option value="disabled" {$optionDisabled}>{translate key="disabled"}
            </select>
          </td>
          <td><input type="submit" name="submit" value="{translate key="changevalue"}"></td>
        </tr>
        </form>
      <tr><td colspan="2" style="text-align:justify;" width="200">
		{translate key="squidlookstatedesc"}
      </td></tr>


      <tr><td colspan="3"><hr size="1"></td></tr>
        <form method="POST">
        <input type="hidden" name="hiddenSubmit" value="1">
        <input type="hidden" name="configName" value="topGrouping">
	{if $pageVars.topGrouping=="yearly"}
		{assign var="optionYearly" value="selected"}
	{elseif $pageVars.topGrouping=="monthly"}
		{assign var="optionMonthly" value="selected"}
	{elseif $pageVars.topGrouping=="weekly"}
		{assign var="optionWeekly" value="selected"}
	{else}
		{assign var="optionDaily" value="selected"}
	{/if}
        <tr>
          <td colspan="2">{translate key="topgrouping"}
            <select name="thisValue">
              <option value="yearly" {$optionYearly}>{translate key="yearly"}
              <option value="monthly" {$optionMonthly}>{translate key="monthly"}
              <option value="weekly" {$optionWeekly}>{translate key="weekly"}
              <option value="daily" {$optionDaily}>{translate key="daily"}
            </select>
          </td>
          <td><input type="submit" name="submit" value="{translate key="changevalue"}"></td>
        </tr>
        </form>
      <tr><td colspan="2" style="text-align:justify;" width="200">
		{translate key="topgroupingdesc"}
      </td></tr>

      <tr><td colspan="3"><hr size="1"></td></tr>
      <tr><td colspan="2" style="text-align:justify;" width="200">
		{translate key="erasedesc"}
      </td>
        <td colspan="3" style="text-align:center;">
          <input type="submit" value="{translate key="erase"}" onClick="my_confirm('Are you sure you want to erase ALL statistics?','{$pageVars.uri}&action=eraseAllStats')">
        </td>
      </tr>
      
      </table>
      
