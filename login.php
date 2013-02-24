<?

// Esquiroles (c) 2012 @soydelbierzo
// http://www.twitter.com/soydelbierzo
//
// This source code is released under GNU/GPL license
// http://www.gnu.org/licenses/gpl.html
//


// Load common configs and objects
	require("includes/common.php");

	$error_message = strip_tags($_GET[error]);

// Check for domain used to load proper templates

	$smarty->assign('template_body', 'form_login.tpl');
	if ($error_message == "1") {
		$smarty->assign('login_message', 'Incorrect Login: Check your username and password');
	} else {
		$smarty->assign('login_message', '');
	}
	$smarty->display('index.tpl');
	
	$db->close();

?>
