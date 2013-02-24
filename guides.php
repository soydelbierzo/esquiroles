<?

// Esquiroles (c) 2012 @soydelbierzo
// http://www.twitter.com/soydelbierzo
//
// This source code is released under GNU/GPL license
// http://www.gnu.org/licenses/gpl.html
//

	$anonaccess=true;
	
// Load common configs and objects
	require("includes/common.php");

// Compose query

	$category = intval(strip_tags($_GET["activity"]));
	$location = intval(strip_tags($_GET["city"]));
	$pageIndex = intval(strip_tags($_GET["pagindex"]));
	if ($pageIndex>-1)
		$searchid=1;
	
	if (strip_tags($_GET["activity"]) == "" && strip_tags($_GET["city"]) == ""){
		$category = intval(strip_tags($_POST["activity"]));
		$location = intval(strip_tags($_POST["city"]));
		$searchid = intval(strip_tags($_POST["searchid"]));
	}

	if ($category < 1) {
		$category = 0;
		$categoryquery="";
	} else {
		$categoryquery=" and items.id_category=".$category;
	}

	if ($location < 1) {
		$location = 0;
		$locationquery="";
	} else {
		$locationquery=" and items.city=".$location;
	}

	$rowCount=10;
	$pagesToShow=2;

	function paginate($pagesCount,$pagesToShow,$pageIndex) { // Returns html code for pagination
		global $category,$location;
		$linkstring='<ul id="pages">';
		if ($pageIndex > 0) {
			$linknext=$pageIndex-1;
	        	$linkstring.='<li class="page"><a href="/directorio/pagina/'.$linknext.'/guia/'.$category.'/localidad/'.$location.'">Anterior</a></li>';
		}
		$start = $pageIndex - $pagesToShow;
		if ($start < 0)
        		$start = 0;

		$end = $pageIndex + $pagesToShow;
		if ($end >= $pagesCount)
        		$end = $pagesCount - 1;
		if ($start > 0) {
        		for ($i = 0; $i < 2 && $i < $start; ++$i) {
				$linknext=$i+1;
        			$linkstring.='<li class="page"><a href="/directorio/pagina/'.$i.'/guia/'.$category.'/localidad/'.$location.'">'.$linknext.'</a></li>';
		        }
			$linkstring.=" ··· ";
		}
		for ($i = $start; $i <= $end; ++$i) {
			$linknext=$i+1;
		        if ($pageIndex == $i) {
			        $linkstring.='<li class="page current">'.$linknext.'</li>';
		        } else {
        			$linkstring.='<li class="page"><a href="/directorio/pagina/'.$i.'/guia/'.$category.'/localidad/'.$location.'">'.$linknext.'</a></li>';
		        }
		}
		if ($end < $pagesCount - 1) {
			$linkstring.=" ··· ";
		        for ($i = max($pagesCount - 2, $end + 1); $i < $pagesCount; ++$i) {
				$linknext=$i+1;
			        $linkstring.='<li class="page"><a href="/directorio/pagina/'.$i.'/guia/'.$category.'/localidad/'.$location.'">'.$linknext.'</a></li>';
		        }
		}
		if ($pageIndex < ($pagesCount-1)) {
			$linknext=$pageIndex+1;
        		$linkstring.='<li class="page"><a href="/directorio/pagina/'.$linknext.'/guia/'.$category.'/localidad/'.$location.'">Siguiente</a></li>';
		}
		$linkstring.='</ul>';
		return $linkstring;
	}


	function paginatemobile($pagesCount,$pagesToShow,$pageIndex) { // Returns html code for mobile pagination
		global $category,$location;
		$pagesToShow=1;
		$linkstring='<br /><div id="pages">';
		if ($pageIndex > 0) {
			$linknext=$pageIndex-1;
	        	$linkstring.='<span class="page"><a class="Estilolink" href="/directorio/pagina/'.$linknext.'/guia/'.$category.'/localidad/'.$location.'">&lt;</a></span> ';
		}
		$start = $pageIndex - $pagesToShow;
		if ($start < 0)
        		$start = 0;

		$end = $pageIndex + $pagesToShow;
		if ($end >= $pagesCount)
        		$end = $pagesCount - 1;
		if ($start > 0) {
        		for ($i = 0; $i < 2 && $i < $start; ++$i) {
				$linknext=$i+1;
        			$linkstring.='<span class="page"><a class="Estilolink" href="/directorio/pagina/'.$i.'/guia/'.$category.'/localidad/'.$location.'">'.$linknext.'</a></span> ';
		        }
			$linkstring.=" ··· ";
		}
		for ($i = $start; $i <= $end; ++$i) {
			$linknext=$i+1;
		        if ($pageIndex == $i) {
			        $linkstring.='<span class="page current">'.$linknext.'</span> ';
		        } else {
        			$linkstring.='<span class="page"><a class="Estilolink" href="/directorio/pagina/'.$i.'/guia/'.$category.'/localidad/'.$location.'">'.$linknext.'</a></span> ';
		        }
		}
		if ($end < $pagesCount - 1) {
			$linkstring.=" ··· ";
		        for ($i = max($pagesCount - 2, $end + 1); $i < $pagesCount; ++$i) {
				$linknext=$i+1;
			        $linkstring.='<span class="page"><a class="Estilolink" href="/directorio/pagina/'.$i.'/guia/'.$category.'/localidad/'.$location.'">'.$linknext.'</a></span> ';
		        }
		}
		if ($pageIndex < ($pagesCount-1)) {
			$linknext=$pageIndex+1;
        		$linkstring.='<span class="page"><a class="Estilolink" href="/directorio/pagina/'.$linknext.'/guia/'.$category.'/localidad/'.$location.'">&gt;</a></span>';
		}
		$linkstring.='</div>';
		return $linkstring;
	}

	
	if ($category==0){
		$queryresult = $arka_session->data['menu'];
		for ($i=0;$i<count($queryresult);$i++){
			$queryresult[$i]['category']=$queryresult[$i]['category'];
		}
		if ($location==0) {
			$sql="select id,city from cities where view=1 and id_repository=".$repository." order by city ASC"; 
			$cityqueryresult = $db->fetch_all_array($sql);
			for ($i=0;$i<count($cityqueryresult);$i++){
				$cityqueryresult[$i]['city']=$cityqueryresult[$i]['city'];
			}
			$smarty->assign('cities', $cityqueryresult);
			$smarty->assign('template_body', 'info_guides.tpl');
		} else {
			$smarty->assign('location', $location);
			$smarty->assign('template_body', 'list_guides.tpl');
		}
	} elseif ($location==0 && $searchid==1){
			// Count results
			$sql="select count(*) as totalitems from items,cities,categories where items.id_repository=".$arka_session->data['repository']." and items.id_repository=categories.id_repository and items.id_category=categories.id_category and items.active=1 and items.city=cities.id".$categoryquery;
 			$countresult = $db->query_first($sql);
			$itemcount = $countresult['totalitems'];
			$pagesCount = (int)ceil($itemcount / $rowCount);
			if ($pageIndex >= $pagesCount)
        			$pageIndex = $pagesCount - 1;
			$offset = $pageIndex * $rowCount;
			if ($offset < 0)
				$offset=0;
			$sql="select items.id as id,items.title as title,items.description as description,items.address as address,cities.city as city,cities.postcode as postcode,categories.category as category,items.phone as phone,items.mobile as mobile,items.fax as fax,items.email as email,items.web as web,items.photo as photo,items.variable1 as variable1,items.variable2 as variable2,items.variable3 as variable3,items.variable4 as variable4,items.variable5 as variable5,items.id_gallery as gallery,items.type as type from items,cities,categories where items.id_repository=".$arka_session->data['repository']." and items.id_repository=categories.id_repository and items.id_category=categories.id_category and items.active=1 and items.city=cities.id".$categoryquery." order by items.type DESC, items.title ASC limit ".$offset.", ".$rowCount; 
			if ($arka_session->data['ismobile']==1) {
				$listfoot=paginatemobile($pagesCount,$pagesToShow,$pageIndex);
			} else {
				$listfoot=paginate($pagesCount,$pagesToShow,$pageIndex);
			}
			$smarty->assign('listfoot', $listfoot);
			$queryresult = $db->fetch_all_array($sql);
			for ($i=0;$i<count($queryresult);$i++){
				$queryresult[$i]['phone']=str_replace(" ","",$queryresult[$i]['phone']);
				$queryresult[$i]['mobile']=str_replace(" ","",$queryresult[$i]['mobile']);
				if ($queryresult[$i]['type']==1) {
					$queryresult[$i]['description']="";
					$queryresult[$i]['email']="";
					$queryresult[$i]['web']="";
					$queryresult[$i]['mobile']="";
					$queryresult[$i]['photo']="";
				}
			}
			if (count($queryresult)==0){
				$smarty->assign('template_body', 'not_found.tpl');
			} else {
				$smarty->assign('template_body', 'list_views.tpl');
				$smarty->assign('category', $queryresult[0]['category']);
			}
	} else {
  			if ($location==0){
  				$sql="select id,city from cities where view=1 and id_repository=".$repository." order by city ASC"; 
  				$queryresult = $db->fetch_all_array($sql);
  				for ($i=0;$i<count($queryresult);$i++){
  					$queryresult[$i]['city']=$queryresult[$i]['city'];
  				}
  				$smarty->assign('category', $category);
  				$smarty->assign('template_body', 'list_cities.tpl');
  			} else {
					// Count results
					$sql="select count(*) as totalitems from items,cities,categories where items.id_repository=".$arka_session->data['repository']." and items.id_repository=categories.id_repository and items.id_category=categories.id_category and items.active=1 and items.city=cities.id".$categoryquery.$locationquery;
 					$countresult = $db->query_first($sql);
					$itemcount = $countresult['totalitems'];
					$pagesCount = (int)ceil($itemcount / $rowCount);
					if ($pageIndex >= $pagesCount)
  	      				$pageIndex = $pagesCount - 1;
					$offset = $pageIndex * $rowCount;
								if ($offset < 0)
					$offset=0;
					$sql="select items.id as id,items.title as title,items.description as description,items.address as address,cities.city as city,cities.postcode as postcode,categories.category as category,items.phone as phone,items.mobile as mobile,items.fax as fax,items.email as email,items.web as web,items.photo as photo,items.variable1 as variable1,items.variable2 as variable2,items.variable3 as variable3,items.variable4 as variable4,items.variable5 as variable5,items.id_gallery as gallery,items.type as type from items,cities,categories where items.id_repository=".$arka_session->data['repository']." and items.id_repository=categories.id_repository and items.id_category=categories.id_category and items.active=1 and items.city=cities.id".$categoryquery.$locationquery." order by items.type DESC, items.title ASC limit ".$offset.", ".$rowCount; 
					if ($arka_session->data['ismobile']==1) {
						$listfoot=paginatemobile($pagesCount,$pagesToShow,$pageIndex);
					} else {
						$listfoot=paginate($pagesCount,$pagesToShow,$pageIndex);
					}
					$smarty->assign('listfoot', $listfoot);
  				$queryresult = $db->fetch_all_array($sql);
  				for ($i=0;$i<count($queryresult);$i++){
  					$queryresult[$i]['phone']=str_replace(" ","",$queryresult[$i]['phone']);
  					$queryresult[$i]['mobile']=str_replace(" ","",$queryresult[$i]['mobile']);
  					if ($queryresult[$i]['type']==1) {
  						$queryresult[$i]['description']="";
  						$queryresult[$i]['email']="";
  						$queryresult[$i]['web']="";
							$queryresult[$i]['mobile']="";
  						$queryresult[$i]['photo']="";
  					}
  				}
  				if (count($queryresult)==0){
  					$smarty->assign('template_body', 'not_found.tpl');
  				} else {
  					$smarty->assign('template_body', 'list_views.tpl');
  					$smarty->assign('category', $queryresult[0]['category']);
  					$smarty->assign('city', $queryresult[0]['city']);
  				}
  			}
			}

	$smarty->assign('result',$queryresult);
	$smarty->assign('returnurl',$_SERVER['HTTP_REFERER']);

	$smarty->display('index.tpl');
	
	$db->close();

?>
