<?xml version="1.0" encoding="iso-8859-1"?>
<markers>
{foreach key=cid item=con from=$items}
 <marker lat="{$con.lat}" lng="{$con.lng}" label="{$con.city}" icontype="{$con.icon}">
   <infowindow>
   	<![CDATA[
{$con.city}<br>Altitud: {$con.altitud} metros<br>Población: {$con.population} Habitantes<br>Extensión: {$con.extension} Km2<br>Distancia a Madrid: {$con.distance} Km<br>Web: <a href={$con.web} target=_blank>{$con.web}</a>
   	]]>
   </infowindow>
 </marker>
{/foreach}
</markers> 