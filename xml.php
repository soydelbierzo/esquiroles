<?

// Esquiroles (c) 2012 @soydelbierzo
// http://www.twitter.com/soydelbierzo
//
// This source code is released under GNU/GPL license
// http://www.gnu.org/licenses/gpl.html
//


	$anonaccess = true;
	
	require("includes/common.php");

	$sql="select cities.id as id ,cities.city as city,cities.altitud as altitud,cities.extension as extension,cities.population as population,cities.distance as distance,cities.web as web,cities.lat as lat,cities.lng as lng,icons.id_icon as icon from cities,icons where cities.type=icons.id_icon order by cities.city ASC";
	$queryresult = $db->fetch_all_array($sql);

	header('Content-Type: text/xml');  

	$smarty->assign('items',$queryresult);

	$smarty->display('xml.tpl');

	$db->close();

?>
