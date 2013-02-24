<?

// Esquiroles (c) 2012 @soydelbierzo
// http://www.twitter.com/soydelbierzo
//
// This source code is released under GNU/GPL license
// http://www.gnu.org/licenses/gpl.html
//


	$anonaccess=true;
// Load common configs and objects
	include("includes/common.php");

	$id = intval(strip_tags($_GET["itemid"]));
	
	
	if ($id > 0){
		$sql="select items.description as description,items.address as address,cities.city as city,items.phone as phone,items.mobile as mobile,items.fax as fax,items.web as web,items.photo as photo,items.variable1 as variable1,items.variable2 as variable2,items.variable3 as variable3,items.variable4 as variable4,items.variable5 as variable5,items.id_gallery as id_gallery,items.lat as lat,items.lng as lng,items.type as type,icons.id_icon as icon from items,icons,cities where items.id_category=icons.id_icon and items.active=1 and items.city=cities.id and items.id=".$id." limit 1";
		$queryresult = $db->fetch_all_array($sql);
		if (count($queryresult)>0){
			$smarty->assign('description',$queryresult[0]['description']);
			$smarty->assign('phone',$queryresult[0]['phone']);
			$smarty->assign('mobile',$queryresult[0]['mobile']);
			$smarty->assign('web',$queryresult[0]['web']);
			$smarty->assign('email',$queryresult[0]['email']);
		}
	}

	$smarty->display('items_view.tpl');
	
	$db->close();
?>
