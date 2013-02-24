<?

// Esquiroles (c) 2012 @soydelbierzo
// http://www.twitter.com/soydelbierzo
//
// This source code is released under GNU/GPL license
// http://www.gnu.org/licenses/gpl.html
//


	$anonaccess = true;
	
	require("includes/common.php");

  // Your Google Maps API key
  $key = $arka_session->data['mapkey'];
  
  $sql = "select id,city,address,postcode from cities where (lat=0 or lat='') and view=1";
  $togeocode=$db->fetch_all_array($sql);
	
	for ($i=0;$i<count($togeocode);$i++){
		
		$myaddress=urlencode($togeocode[$i]['city'].",Spain");
		
	  // Desired address
  	$address = "http://maps.google.com/maps/geo?q=$myaddress&output=csv&key=$key";
	
	  // Retrieve the URL contents
  	$page = file_get_contents($address);
  	
		
  	// Parse the returned csv file
  	list($status,$accuracy,$latitude,$longitude)=explode(",",$page);
	  

  	// Retrieve the desired XML node
  	echo $myaddress."<br>";
  	echo "Longitude: $longitude, Latitude: $latitude";
  	echo "<br>Status: $status";
  	echo "<br>Exactitud: $accuracy<br><br>";
  	if (intval($accuracy)>7) {
	  	$data = array('lat'=>$latitude,'lng'=>$longitude,'active'=>1);
  		$db->query_update("items",$data,"id=".$togeocode[$i]['id']);
  	} else {
  		echo "<a href='geoviewayto.php?id=".$togeocode[$i]['id']."' target='_blank'>No guardado, no da un resultado bueno.</a><br>";
  	}
  	usleep(500);
	}


	$db->close();

?>
