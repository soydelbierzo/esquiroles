<?

// Esquiroles (c) 2012 @soydelbierzo
// http://www.twitter.com/soydelbierzo
//
// This source code is released under GNU/GPL license
// http://www.gnu.org/licenses/gpl.html
//


	$anonaccess = true;

	require("includes/common.php");

  $sql = "select cities.city as city,items.id as id from cities,items where items.id_category=30 and items.city=cities.id";
  $togeocode=$db->fetch_all_array($sql);
  
  for ($i=0;$i<count($togeocode);$i++){
	$data=array('title'=>$togeocode[$i]['city'].' Farmacia');
	$db->query_update("items",$data,"id=".$togeocode[$i]['id']);
  }

	$db->close();
exit;

	for ($i=0;$i<count($togeocode);$i++){
		$togeocode[$i]['city']=str_replace('á','&aacute;',$togeocode[$i]['city']);
		$togeocode[$i]['city']=str_replace('é','&eacute;',$togeocode[$i]['city']);
		$togeocode[$i]['city']=str_replace('í','&iacute;',$togeocode[$i]['city']);
		$togeocode[$i]['city']=str_replace('ó','&oacute;',$togeocode[$i]['city']);
		$togeocode[$i]['city']=str_replace('ú','&uacute;',$togeocode[$i]['city']);
		$togeocode[$i]['city']=str_replace('Á','&Aacute;',$togeocode[$i]['city']);
		$togeocode[$i]['city']=str_replace('É','&Eacute;',$togeocode[$i]['city']);
		$togeocode[$i]['city']=str_replace('Í','&Iacute;',$togeocode[$i]['city']);
		$togeocode[$i]['city']=str_replace('Ó','&Oacute;',$togeocode[$i]['city']);
		$togeocode[$i]['city']=str_replace('Ú','&Uacute;',$togeocode[$i]['city']);
		$togeocode[$i]['city']=str_replace('Ñ','&Ntilde;',$togeocode[$i]['city']);
		$togeocode[$i]['city']=str_replace('ñ','&ntilde;',$togeocode[$i]['city']);
		$togeocode[$i]['address']=str_replace('á','&aacute;',$togeocode[$i]['address']);
		$togeocode[$i]['address']=str_replace('é','&eacute;',$togeocode[$i]['address']);
		$togeocode[$i]['address']=str_replace('í','&iacute;',$togeocode[$i]['address']);
		$togeocode[$i]['address']=str_replace('ó','&oacute;',$togeocode[$i]['address']);
		$togeocode[$i]['address']=str_replace('ú','&uacute;',$togeocode[$i]['address']);
		$togeocode[$i]['address']=str_replace('Á','&Aacute;',$togeocode[$i]['address']);
		$togeocode[$i]['address']=str_replace('É','&Eacute;',$togeocode[$i]['address']);
		$togeocode[$i]['address']=str_replace('Í','&Iacute;',$togeocode[$i]['address']);
		$togeocode[$i]['address']=str_replace('Ó','&Oacute;',$togeocode[$i]['address']);
		$togeocode[$i]['address']=str_replace('Ú','&Uacute;',$togeocode[$i]['address']);
		$togeocode[$i]['address']=str_replace('Ñ','&Ntilde;',$togeocode[$i]['address']);
		$togeocode[$i]['address']=str_replace('ñ','&ntilde;',$togeocode[$i]['address']);

		echo $togeocode[$i]['city']." ".$togeocode[$i]['address']."<br>";	

	 	$data = array('city'=>$togeocode[$i]['city'],'address'=>$togeocode[$i]['address']);
  	$db->query_update("cities",$data,"id=".$togeocode[$i]['id']);
	}
echo count($togeocode);

	$db->close();

?>
