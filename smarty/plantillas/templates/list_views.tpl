<div class="Estilo5">DIRECTORIO DE GU&Iacute;AS - {$city} - {$category}</div><br />
{foreach key=cid item=con from=$result}
<div class="Estilotipo{$con.type}" xmlns:v="http://rdf.data-vocabulary.org/#" typeof="v:Organization">
<div class="Estilo13"><span property="v:name">{$con.title}</span</div><br />
{$con.description|nl2br}<br />
<div rel="v:address">
<span property="v:street-address">{$con.address}</span><br />
<span property="v:postal-code">{$con.postcode}</span> <span property="v:locality">{$con.city}</span></div><br />
{if $con.phone != ""}
<b>Tel&eacute;fono: </b> <span property="v:tel">{$con.phone}</span><br />
{/if}
{if $con.mobile != ""}
<b>M&oacute;vil: </b> {$con.mobile}<br />
{/if}
{if $con.web != ""}
<b>Web: </b> <a href="{$con.web}" target="_blank"><span property="v:url">{$con.web}</span></a><br />
{/if}
<hr>
</div>
{/foreach}
{$listfoot}
