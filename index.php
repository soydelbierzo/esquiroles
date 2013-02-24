<?

// Esquiroles (c) 2012 @soydelbierzo
// http://www.twitter.com/soydelbierzo
//
// This source code is released under GNU/GPL license
// http://www.gnu.org/licenses/gpl.html
//

// Load common configs and objects
	include("includes/common.php");

	$smarty->assign('template_body', 'info_index.tpl');
	$smarty->display('index.tpl');
	
	$db->close();

?>
