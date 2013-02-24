<html>
<body>
{$description|nl2br}<br />
{if $phone != ""}
<b>Tel&eacute;fono: </b> {$phone}<br />
{/if}
{if $mobile != ""}
<b>M&oacute;vil: </b> {$mobile}<br />
{/if}
{if $web != ""}
<b>Web: </b> <a href="{$web}" target="_blank">{$web}</a><br />
{/if}
</body>
</html>