<?

// Esquiroles (c) 2012 @soydelbierzo
// http://www.twitter.com/soydelbierzo
//
// This source code is released under GNU/GPL license
// http://www.gnu.org/licenses/gpl.html
//

	

	$anonaccess = true;
	
	require("includes/common.php");

	// Get passed category id and City, and clear any tags passed
	
	$id=strip_tags($_GET['id']);
	$city=strip_tags($_GET['city']);
	
	// Tablechar used to normalize special chars	
	$tablechar = get_html_translation_table(HTML_ENTITIES);

		if ($id=="" || $id=="0"){
			$id=2;
		}
	
		// Show items
		if ($city=="" || $city=="0"){
			$queryadd="";
		} else {
			$queryadd="and municipios.id=".$city." ";
		}
		$sql="select items.id as id ,items.title as name,items.description as description,items.address as address,municipios.municipio as city,items.phone as phone,items.mobile as mobile,items.fax as fax,items.web as web,items.photo as photo,items.variable1 as variable1,items.variable2 as variable2,items.variable3 as variable3,items.variable4 as variable4,items.variable5 as variable5,items.id_gallery as id_gallery,items.lat as lat,items.lng as lng,items.type as type,icons.id_icon as icon from items,icons,municipios where items.id_category=icons.id_icon and items.active=1 and items.city=municipios.id and items.id_repository=".$arka_session->data['repository']." and items.id_category=".$id." ".$queryadd."order by items.type DESC,items.title ASC";
		$queryresult = $db->fetch_all_array($sql);

		for ($i=0;$i<count($queryresult);$i++){
			$queryresult[$i]['location']=$queryresult[$i]['city'];
			$queryresult[$i]['city']=$queryresult[$i]['name'];
			$queryresult[$i]['name']=mystringencoder($queryresult[$i]['name']);
			$stringadd="";
			if (intval($queryresult[$i]['type']) > 1){
				$stringadd='<br /><a href="javascript:showinfopopup('.$queryresult[$i]['id'].',\''.mystringencoder($queryresult[$i]['city']).'\');"><b>Ver Ficha Completa</b></a>';				
			}
			$queryresult[$i]['infowindow']='<div class="Estilo3"><b>'.$queryresult[$i]['name'].'<br />'.$queryresult[$i]['location'].'</b><br /><i>Direcci&oacute;n: </i>'.$queryresult[$i]['address'].'<br /><i>Tel&eacute;fono: </i>'.$queryresult[$i]['phone'].$stringadd.'</div>';
		}

	

	$smarty->assign('items',$queryresult);

	$smarty->display('txt_info.tpl');

	$db->close();

?>
