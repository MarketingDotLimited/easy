        {if $dt.filters.date == true}

<center>
<table >
<tr>
<td style="padding:20px;">
<span> From: </span> <input type="text" id="FromDate_{$dt.id}"  readonly="readonly" style="background:white;"  value="{$date.firstDay}">
</td>
<td style="padding:20px;">
<span> To: </span> <input type="text" id="ToDate_{$dt.id}"  readonly="readonly" style="background:white;"  value="{$date.lastDay}" >
</td>
</tr>
</table>
</center>
        {/if}