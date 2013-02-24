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

	$id = intval(strip_tags($_GET["helpmeid"]));
	
	
	if ($id > 0){
		$smarty->display('help_item'.$id.'.tpl');
	}

	$db->close();
?>
