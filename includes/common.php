<?

// Esquiroles (c) 2012 @soydelbierzo
// http://www.twitter.com/soydelbierzo
//
// This source code is released under GNU/GPL license
// http://www.gnu.org/licenses/gpl.html
//
	
	
	// Load php configs
	require("config.inc.php");

// Load classes and init objects
	require_once($basepath."classes/session/class_session.php");
	require($basepath."classes/db/database.class.php");
	require('smarty/libs/Smarty.class.php');
	
	$smarty = new Smarty();
  if (!$arka_session = new session()) {
	  echo "There is a problem with session manager, contact web administrator.";
    echo $arka_session->log;
    exit();
  }
  
// Check if user is logged or running the allowed scripts if not logged.

	if ($anonaccess!=true){
		if (($_SERVER['PHP_SELF'] != "/index.php" && $_SERVER['PHP_SELF'] != "/search.php" && $_SERVER['PHP_SELF'] != "/login.php" && $_SERVER['PHP_SELF'] != "/verify.php" && $_SERVER['PHP_SELF'] != "/getinfo.php" && $_SERVER['PHP_SELF'] != "/view.php" && $arka_session->data['logged_in'] == false) {
			header('Location: /');
			exit();
		}
	}
	
// Smarty object action properties

	$smarty->compile_check = true;
	$smarty->debugging = false;

// Check for domain used to load proper templates

	$domain = $_SERVER['SERVER_NAME'];
	$db = new Database($config_mysql['server'], $config_mysql['user'], $config_mysql['pass'], $config_mysql['database'], $config_mysql['tablePrefix']);

	$db->connect();

// Gather info from session data or load from database

	if ($arka_session->data['repository'] < 1){	
		$sql = "select id_repository,repository,domain,domainshort,name,email,mapkey from repositories where domain = '".$domain."'";
		$result = $db->query_first($sql);
		$ismobile = "";
		$repository = $result['id_repository'];
		$repository_path = $result['repository'];
		$arka_session->data['repository']=$repository;
		$arka_session->data['repositorypath']=$repository_path;
		$arka_session->data['domain']=$result['domain'];
		$arka_session->data['domainshort']=$result['domainshort'];
		$arka_session->data['domainname']=$result['name'];
		$arka_session->data['domainemail']=$result['email'];
		$arka_session->data['mapkey']=$result['mapkey'];
		$arka_session->save();
	} else {
		$repository = $arka_session->data['repository'];
		$repository_path = $arka_session->data['repositorypath'];
		if ($arka_session->data['ismobile']==1){
			$ismobile = ".mobile";
			header("Content-Type: application/xhtml+xml"); 
			$mobile_width=$arka_session->data['mobwidth'];
			$mobile_height=$arka_session->data['mobheight'];

		} else {
			$ismobile = "";
		}
	}
	
	
	if ($result['id_repository'] > 0 || $arka_session->data['repository'] > 0) {
		
		// Define Template dirs

		$smarty->template_dir = 'smarty/'.$repository_path.$ismobile.'/templates';
		$smarty->compile_dir = 'smarty/'.$repository_path.$ismobile.'/templates_c';
		$smarty->cache_dir = 'smarty/'.$repository_path.$ismobile.'/cache';
		$smarty->config_dir = 'smarty/'.$repository_path.$ismobile.'/configs';

		// Check if user is logged in

		if ($arka_session->data['logged_in'] == true) {
			$smarty->assign('name', $arka_session->data['username']);
		} else {
			$smarty->assign('name', 'Not logged');
		}

		// Load Category menu items
		if ($arka_session->data['menu'] == null) {	// Gather info from session data or load from database
			$sql = "select id_category,category from categories where id_category<>1 and id_repository=".$repository." order by category ASC";
			$categories = $db->fetch_all_array($sql);
			$arka_session->data['menu']=$categories;
		} else {
			$categories = $arka_session->data['menu'];
		}

		$tablechar = get_html_translation_table(HTML_ENTITIES);
	
	
		$smarty->assign('menu',$categories);

		// Load Cities menu items
		if ($arka_session->data['cities'] == null) {	// Gather info from session data or load from database
			$sql = "select id,municipio as city from municipios order by municipio ASC";
			$cities = $db->fetch_all_array($sql);
//			for ($x=0;$x<count($cities); $x++) {
//				$cities[$x]['city']=htmlentities($cities[$x]['city'], ENT_NOQUOTES, 'UTF-8');;
//			}
			$arka_session->data['cities']=$cities;
		} else {
			$cities = $arka_session->data['cities'];
		}

	
		$smarty->assign('cities',$cities);
		//$arka_session->save();
		$smarty->assign('randomnumber',rand(1,100000000));
		$smarty->assign('mapscript',"common");
		if ($arka_session->data['ismobile']==1){
			$smarty->assign('mobwidth',$mobile_width);
			$smarty->assign('mobheight',$mobile_height);
			if ($mobile_width > 100){
				$mobile_logo="100";
			}
			if ($mobile_width > 150){
				$mobile_logo="150";
			}
			if ($mobile_width > 200){
				$mobile_logo="200";
			}
			$smarty->assign('moblogo',$mobile_logo);
		}
	}
	
	// Common Functions
	
	function geocodeitem($address,$city){
		global $arka_session,$db;
		
	  // Your Google Maps API key
  	$key = $arka_session->data['mapkey'];
  
  	$sql = "select municipio as city from municipios where id=".$city." limit 1";
  	$togeocode=$db->fetch_all_array($sql);
	
		$myaddress=urlencode($address.",".$togeocode[0]['postcode']." ".$togeocode[0]['city'].",Spain");
		
  	// Desired address
 		$address = "http://maps.google.com/maps/geo?q=$myaddress&output=csv&key=$key";
	
		// Retrieve the URL contents
  	$page = file_get_contents($address);
  	
		
  	// Parse the returned csv file
  	list($status,$accuracy,$latitude,$longitude)=explode(",",$page);
  	
  	if (intval($accuracy)<6) {
  		usleep(500);
  		$myaddress=urlencode($togeocode[0]['postcode']." ".$togeocode[0]['city'].",Spain");
  		$address = "http://maps.google.com/maps/geo?q=$myaddress&output=csv&key=$key";
  		$page = file_get_contents($address);
  		list($status,$accuracy,$latitude,$longitude)=explode(",",$page);
  	}
  	
  	return $status."/".$accuracy."/".$latitude."/".$longitude;
	}

	function mystringencoder($string){
  	$string = htmlentities($string, ENT_NOQUOTES, 'UTF-8'); // Convert special chars to entities
    $string = htmlspecialchars_decode($string, ENT_NOQUOTES); // Leave <, & and > as original
    return $string;
  }

        function mystringdecoder($string){
                $string = str_replace("&aacute;","á",$string);
                $string = str_replace("&eacute;","é",$string);
                $string = str_replace("&iacute;","í",$string);
                $string = str_replace("&oacute;","ó",$string);
                $string = str_replace("&uacute;","ú",$string);
                $string = str_replace("&Aacute;","Á",$string);
                $string = str_replace("&Eacute;","É",$string);
                $string = str_replace("&Iacute;","Í",$string);
                $string = str_replace("&Oacute;","Ó",$string);
                $string = str_replace("&Uacute;","Ú",$string);
                $string = str_replace("&nacute;","ñ",$string);
                $string = str_replace("&Nacute;","Ñ",$string);
      		return $string;
  	}
?>
