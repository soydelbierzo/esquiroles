{foreach key=cid item=con from=$items}
{$con.lat}|{$con.lng}|{$con.city}|{$con.icon}|{$con.infowindow}|{$con.type}
{/foreach}