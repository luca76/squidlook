
<table><tr><th style="font-size: 20px";>Sites Summary for a Specific Host, User and Date</th></tr></table>
<p>
<table>
  <tr><td style="font-size: 20px;">
    <!-- a href="{$smarty.server.PHP_SELF}?a={$pageVars.thisPage}&hostiplong={$pageVars.hostiplong}&date={$pageVars.previousWeek}&usersID={$pageVars.usersID}">&lt;&lt;</a>
    <a href="{$smarty.server.PHP_SELF}?a={$pageVars.thisPage}&hostiplong={$pageVars.hostiplong}&date={$pageVars.previousDate}&usersID={$pageVars.usersID}">&lt;</a> -->
    {$pageVars.thisDateFormatted}
    <!-- <a href="{$smarty.server.PHP_SELF}?a={$pageVars.thisPage}&hostiplong={$pageVars.hostiplong}&date={$pageVars.nextDate}&usersID={$pageVars.usersID}">&gt;</a>
    <a href="{$smarty.server.PHP_SELF}?a={$pageVars.thisPage}&hostiplong={$pageVars.hostiplong}&date={$pageVars.nextWeek}&usersID={$pageVars.usersID}">&gt;&gt;</a> -->
  </td></tr>
  <tr><td style="text-align:center;">
  </td></tr>
</table>
<p>
<table>
  <tr><th colspan="2">Information box</th></tr>
  <form method="POST">
  <input type="hidden" name="hiddenSubmit" value="1">
  <input type="hidden" name="action" value="hostDescriptionUpdate">
{*
  <input type="hidden" name="a" value="{$pageVars.thisPage}">
  <input type="hidden" name="date" value="{$pageVars.date}">
  <input type="hidden" name="hostiplong" value="{$pageVars.hostiplong}">
  <input type="hidden" name="usersID" value="{$pageVars.usersID}">
*}
  <tr><td>Host Name</td><td style="text-align:left;">{$pageVars.host.hostname}</td></tr>
  <tr><td>Host IP</td><td style="text-align:left;">{$pageVars.host.ip}</td></tr>
  <tr><td>Host Description</td><td style="text-align:left;"><input type="text" name="thisValue" value="{$pageVars.host.description}"</td></tr>
  <tr><td>User Name</td><td style="text-align:left;">{$pageVars.user.authuser}</tr>
  </form>
</table>
<p>
      [
        <a href="{$smarty.server.PHP_SELF}?a={$pageVars.thisPage}&action=setDefaultView&OrderMethod={$pageVars.orderMethod}&OrderBy={$pageVars.orderBy}&ByteUnit={$pageVars.byteUnit}&minDate={$date.minDate}&maxDate={$date.maxDate}&hostiplong={$pageVars.hostiplong}">
          Imposta questa vista come predefenita 
        </a>
      ]<br>
      
      <font color="red">Attenzione: Gli accessi ad alcuni siti non sono correntemente visualizzati, cliccare <a href="{$smarty.server.PHP_SELF}?a=whitelist&minDate={$pageVars.minDate}&maxDate={$pageVars.maxDate}">qui</a> per vedere la lista di tali siti</font>
      
  <table>
    <tr>
      <th></th>
      <th>
        <a href="{$smarty.server.PHP_SELF}?{$pageVars.url.siteASC}"><img border="{$pageVars.siteASCImageBorder}" src="images/up-arrow.gif"></a>
          {$pageVars.siteLabelStart}Indirizzo{$pageVars.siteLabelEnd}
        <a href="{$smarty.server.PHP_SELF}?{$pageVars.url.siteDESC}"><img border="{$pageVars.siteDESCImageBorder}" src="images/down-arrow.gif"></a>
      </th>
      <th>
	<a href="{$smarty.server.PHP_SELF}?{$pageVars.url.countASC}"><img border="{$pageVars.countASCImageBorder}" src="images/up-arrow.gif"></a>
      	{$pageVars.countLabelStart}Count{$pageVars.countLabelEnd}
	<a href="{$smarty.server.PHP_SELF}?{$pageVars.url.countDESC}"><img border="{$pageVars.countDESCImageBorder}" src="images/down-arrow.gif"></a>
      </th>
      <th width="110">
        <a href="{$smarty.server.PHP_SELF}?{$pageVars.url.bytesASC}"><img border="{$pageVars.bytesASCImageBorder}" src="images/up-arrow.gif"></a>
          {$pageVars.bytesLabelStart}BYTES{$pageVars.bytesLabelEnd}
        <a href="{$smarty.server.PHP_SELF}?{$pageVars.url.bytesDESC}"><img border="{$pageVars.bytesDESCImageBorder}" src="images/down-arrow.gif"></a>
        <br>
        <a href="{$smarty.server.PHP_SELF}?{$pageVars.url.B}">{$pageVars.BLabelStart}B{$pageVars.BLabelEnd}</a>
        |
        <a href="{$smarty.server.PHP_SELF}?{$pageVars.url.K}">{$pageVars.KLabelStart}K{$pageVars.KLabelEnd}</a>
        |
        <a href="{$smarty.server.PHP_SELF}?{$pageVars.url.M}">{$pageVars.MLabelStart}M{$pageVars.MLabelEnd}</a>
        |
        <a href="{$smarty.server.PHP_SELF}?{$pageVars.url.G}">{$pageVars.GLabelStart}G{$pageVars.GLabelEnd}</a>
      </th>
      <th>
        <a href="{$smarty.server.PHP_SELF}?{$pageVars.url.elapsedTimeASC}"><img border="{$pageVars.elapsedTimeASCImageBorder}" src="images/up-arrow.gif"></a>{$pageVars.elapsedTimeLabelStart}Elapsed Time{$pageVars.elapsedTimeLabelEnd}
	 <a href="{$smarty.server.PHP_SELF}?{$pageVars.url.elapsedTimeDESC}"><img border="{$pageVars.elapsedTimeDESCImageBorder}" src="images/down-arrow.gif"></a>
      </th>
      <th>
        <a href="{$smarty.server.PHP_SELF}?{$pageVars.url.cachePercentASC}"><img border="{$pageVars.cachePercentASCImageBorder}" src="images/up-arrow.gif"></a>
          {$pageVars.cachePercentLabelStart}CACHE PERCENT{$pageVars.cachePercentLabelEnd}
        <a href="{$smarty.server.PHP_SELF}?{$pageVars.url.cachePercentDESC}"><img border="{$pageVars.cachePercentDESCImageBorder}" src="images/down-arrow.gif"></a>
      </th>
    </tr>
  {assign var=recordCount value="0"}
  {assign var=bytesTotal value="0"}
  {assign var=countTotal value="0"}
  {foreach from=$pageVars.summaryIPSites item=record}
  <tr onMouseOver="this.bgColor='#C5D3E7';" onMouseOut="this.bgColor='#DAE3F0';">
    <td style="text-align: center;"><a href="{$smarty.server.PHP_SELF}?a=details&minDate={$pageVars.minDate}&maxDate={$pageVars.maxDate}&hostiplong={$pageVars.hostiplong}&sitesID={$record.sitesID}&usersID={$pageVars.usersID}&elap=0"><b>Details</b></td>
    <td style="text-align: left;"><a href="{$record.site}" target="_blank">{$record.site}</a></td>
    <td>{$record.count}</td>
    <td>{$record.bytes|bytesToHRF:$pageVars.byteUnit}</td>
    <td>{$record.elapsedTime}</td>
    <td>{$record.cachePercent}%</td>
  </tr>
  {assign var=recordCount value=$recordCount+1}
  {assign var=bytesTotal value=$bytesTotal+$record.bytes}
  {assign var=countTotal value=$countTotal+$record.count}
  {/foreach}
    <tr>
      <th>TOTALS</th>
      <th style="text-align: right;">{$recordCount}</th>
      <th style="text-align: right;">{$countTotal}</th>
      <th style="text-align: right;">{$bytesTotal|bytesToHRF:$pageVars.byteUnit}</th>
      <th></th>
      <th></th>
    </tr>
  </table>
  <p>
    <table>
    <tr><th colspan="7">Ultima attività utente</th></td>
    <tr>
      <th>Ora</th>
      <th>BYTES</th>
      <th>Indirizzo</th>
      <th>Stato</th>
    </tr>
    {foreach from=$pageVars.latestUserActivity item=record}
    <tr onMouseOver="this.bgColor='#C5D3E7';" onMouseOut="this.bgColor='#DAE3F0';">
      <td>{$record.time}</td>
      <td>{$record.bytes}</td>
      <td style="text-align: left"><a href="{$record.url}">{$record.url|string_trim:80:"..."}</a></td>
      <td style="text-align: left">{$record.resultCode}</td>
    </tr>
    {/foreach}
  </table>

