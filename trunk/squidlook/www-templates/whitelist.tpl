
<table><tr><th style="font-size: 20px";>Whitelist</th></tr></table>
<p>
<table>
  <form method="POST" name="WH">
  <tr><td style="font-size: 20px;">
  <a href="{$smarty.server.PHP_SELF}?a={$pageVars.thisPage}&date={$pageVars.previousWeek}">&lt;&lt;</a>
  <a href="{$smarty.server.PHP_SELF}?a={$pageVars.thisPage}&date={$pageVars.previousDate}">&lt;</a>
  {$pageVars.thisDateFormatted}
  <a href="{$smarty.server.PHP_SELF}?a={$pageVars.thisPage}&date={$pageVars.nextDate}">&gt;</a>
  <a href="{$smarty.server.PHP_SELF}?a={$pageVars.thisPage}&date={$pageVars.nextWeek}">&gt;&gt;</a>
  </td></tr>
  <tr><td style="text-align:center;">
  <a href="{$smarty.server.PHP_SELF}?a={$pageVars.thisPage}&date={$pageVars.today}">[ Vai alla data odierna ]</a>
  </td></tr>
  </table>
  <p>
  <table>
    <tr>
      <th>
        <a href="{$smarty.server.PHP_SELF}?{$pageVars.url.siteASC}"><img border="{$pageVars.siteASCImageBorder}" src="images/up-arrow.gif"></a>
          {$pageVars.siteLabelStart}Indirizzo{$pageVars.siteLabelEnd}
        <a href="{$smarty.server.PHP_SELF}?{$pageVars.url.siteDESC}"><img border="{$pageVars.siteDESCImageBorder}" src="images/down-arrow.gif"></a>
      </th>
      <th>
        <a href="{$smarty.server.PHP_SELF}?{$pageVars.url.countASC}"><img border="{$pageVars.countASCImageBorder}" src="images/up-arrow.gif"></a>
          {$pageVars.countLabelStart}Numero Accessi{$pageVars.countLabelEnd}
        <a href="{$smarty.server.PHP_SELF}?{$pageVars.url.countDESC}"><img border="{$pageVars.countDESCImageBorder}" src="images/down-arrow.gif"></a>
      </th>
      <th>
      	Nella whitelist?
      </th>
    </tr>
  {foreach from=$pageVars.whitelistSites item=record}
  <tr onMouseOver="this.bgColor='#C5D3E7';" onMouseOut="this.bgColor='#DAE3F0';">
    <td>{$record.site}</td>
    <td>{$record.count}</td>
    {if $record.whitelist == 1}
    {assign var="chk" value="checked"}
    {else}
    {assign var="chk" value=""}
    {/if}
    <td style="text-align: center;"><input type="checkbox" name="{counter}" value="{$record.sitesID}" {$chk}></td>
  </tr>
  {/foreach}
  </table>
  <center><input type="submit" value="OK" name="OK"></center>
  </form>
