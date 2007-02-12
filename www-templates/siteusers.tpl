<nobr>[
<a href="{$smarty.server.PHP_SELF}?a=allsites&date={$pageVars.today}">&lt;&lt;&lt; torna indietro"</a>
|
<a href="{$pageVars.uri}">Refresh this page</a>
]</nobr>

  <table><tr><th style="font-size: 20px";>Riassunto hosts ed utenti per un sito e giorno specificati</th></tr></table>
<p>
<table>
  <tr><td style="font-size: 20px;">
    {$pageVars.thisDateFormatted}
  </td></tr>
</table>

<p>
<table>
  <tr><th colspan="2">Information box</th></tr>
  <form method="POST">
  <tr><td>Site</td><td style="text-align:left;"><a href="{$pageVars.site}" target="_blank">{$pageVars.site}</a></td></tr>
  </form>
</table>

  <p>
      [
        <a href="{$smarty.server.PHP_SELF}?a={$pageVars.thisPage}&action=setDefaultView&OrderMethod={$pageVars.orderMethod}&OrderBy={$pageVars.orderBy}&ByteUnit={$pageVars.byteUnit}&date={$pageVars.date}&siteID={$pageVars.siteID}">
          Set this view as the default
        </a>
      ]
  <table>
    <tr>
      <th>
        <a href="{$smarty.server.PHP_SELF}?{$pageVars.url.hostipASC}"><img border="{$pageVars.hostipASCImageBorder}" src="images/up-arrow.gif"></a>
          {$pageVars.hostipLabelStart}HOST{$pageVars.hostipLabelEnd}
        <a href="{$smarty.server.PHP_SELF}?{$pageVars.url.hostipDESC}"><img border="{$pageVars.hostipDESCImageBorder}" src="images/down-arrow.gif"></a>
      </th>
      <th>
        <a href="{$smarty.server.PHP_SELF}?{$pageVars.url.usernameASC}"><img border="{$pageVars.usernameASCImageBorder}" src="images/up-arrow.gif"></a>
          {$pageVars.usernameLabelStart}USERNAME{$pageVars.usernameLabelEnd}
        <a href="{$smarty.server.PHP_SELF}?{$pageVars.url.usernameDESC}"><img border="{$pageVars.usernameDESCImageBorder}" src="images/down-arrow.gif"></a>
      </th>
      <th>
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
        <a href="{$smarty.server.PHP_SELF}?{$pageVars.url.cachePercentASC}"><img border="{$pageVars.cachePercentASCImageBorder}" src="images/up-arrow.gif"></a>
          {$pageVars.cachePercentLabelStart}CACHE PERCENT{$pageVars.cachePercentLabelEnd}
        <a href="{$smarty.server.PHP_SELF}?{$pageVars.url.cachePercentDESC}"><img border="{$pageVars.cachePercentDESCImageBorder}" src="images/down-arrow.gif"></a>
      </th>
    </tr>
    {assign var=bytesTotal value="0"}
    {foreach from=$pageVars.siteusers item=record}
      {if $record.hostdescription!=""}
        {assign var="thisRecord" value=$record.hostdescription"}
      {elseif $record.hostip!=$record.hostname}
        {assign var="thisRecord" value=$record.hostname}
      {else}
        {assign var="thisRecord" value=$record.hostip}
      {/if}
    <tr onMouseOver="this.bgColor='#C5D3E7';" onMouseOut="this.bgColor='#DAE3F0';">
      <td><a href='{$smarty.server.PHP_SELF}?a=details&date={$pageVars.date}&hostiplong={$record.hostiplong}&usersID={$record.usersID}&sitesID={$pageVars.sitesID}'>{$thisRecord}</td>
      <td><a href='{$smarty.server.PHP_SELF}?a=details&date={$pageVars.date}&hostiplong={$record.hostiplong}&usersID={$record.usersID}&sitesID={$pageVars.sitesID}'>{$record.username}</td>
      <td>{$record.bytes|bytesToHRF:$pageVars.byteUnit}</td>
      <td>{$record.cachePercent}%</td>
    </tr>
    {assign var=bytesTotal value=$bytesTotal+$record.bytes}
    {/foreach}
    <tr><td></td></tr>
    <tr><td></td></tr>
    <tr>
      <th>TOTALI</th>
      <th style="text-align: right;">{$pageVars.distinctValues.users}</th>
      <th style="text-align: right;">{$bytesTotal|bytesToHRF:$pageVars.byteUnit}</th>
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
    {foreach from=$pageVars.latestSiteActivity item=record}
    <tr onMouseOver="this.bgColor='#C5D3E7';" onMouseOut="this.bgColor='#DAE3F0';">
      <td><a href='{$smarty.server.PHP_SELF}?a=IPSitesSummary&date={$pageVars.date}&hostiplong={$record.hostiplong}&usersID={$record.usersID}'>{$record.hostip}</a></td>
      <td><a href='{$smarty.server.PHP_SELF}?a=IPSitesSummary&date={$pageVars.date}&hostiplong={$record.hostiplong}&usersID={$record.usersID}'>{$record.username}</a></td>
      <td>{$record.time}</td>
      <td>{$record.bytes}</td>
      <td style="text-align: left"><a href="{$record.url}" target="_blank">{$record.url|string_trim:80:"..."}</a></td>
      <td style="text-align: left">{$record.resultCode}</td>
    </tr>
    {/foreach}
  </table>

