<?

// Esquiroles (c) 2012 @soydelbierzo
// http://www.twitter.com/soydelbierzo
//
// This source code is released under GNU/GPL license
// http://www.gnu.org/licenses/gpl.html
//

// Load common configs and objects

		require("includes/common.php");

// Force session to expire and go to homepage

		$tube_session->data['logged_in'] = false;
		$tube_session->save();
		$tube_session->expire();
		header('Location: /');
?>
