<?

// Esquiroles (c) 2012 @soydelbierzo
// http://www.twitter.com/soydelbierzo
//
// This source code is released under GNU/GPL license
// http://www.gnu.org/licenses/gpl.html
//


// Load common configs and objects

  require("includes/common.php");
  
// Get user submision and clear html, sql and php tags

	$username=strip_tags($_POST["username"]);
 	$password=strip_tags($_POST["password"]);
 	
 	$name = "";
 	$groups = "";
 	$ldap_id = "";
 	$company = "";

// Function to check if a given user is valid in ldap server.

  function checkldapuser($username,$password,$ldap_server,$ldap_dn){
  	global $name,$groups,$ldap_id,$company;
  	
    if($connect=@ldap_connect($ldap_server)){ 
      ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);
  
      if(($bind=@ldap_bind($connect)) == false){
        return false;
      }
  
      if (($res_id = ldap_search( $connect,$ldap_dn,"uid=$username")) == false) {
        return false;
      }
  
      if (ldap_count_entries($connect, $res_id) != 1) {
        return false;
      }
  
      if (( $entry_id = ldap_first_entry($connect, $res_id))== false) {
        return false;
      }
  
      if (( $user_dn = ldap_get_dn($connect, $entry_id)) == false) {
        return false;
      }
      if (($link_id = @ldap_bind($connect, $user_dn, $password)) == false) {
        return false;
      }
      $res_id = ldap_search( $connect,$ldap_dn,"uid=$username");
      $ldap_info = ldap_get_entries($connect,$res_id);
    	$name = $ldap_info[0]["cn"][0];
    	$ldap_id = $ldap_info[0]["employeeid"][0];
    	$company = $ldap_info[0]["companyname"][0];
      return true;
      @ldap_close($connect);
    } else {                                  
      return false;
    }
    @ldap_close($connect);
    return(false);
  }
 
// Function to check if user is stored in local database
 
function local_user($employeeid,$employeename,$employeecompany) {
	global $db;
	
	$sql = "select id_user from users where ldap_id=".$employeeid." limit 1";
	$result = $db->query($sql);
	$userid = 0;
	while ($dbuser = $db->fetch_array($result)) {
		$userid = $dbuser[id_user];
	}
	if ($userid == 0){
		$data = array('ldap_id'=>$employeeid,'user'=>$employeename,'company'=>$employeecompany);
		$returnid = $db->query_insert("users", $data);
	} else {
		$returnid = $userid;
	}
	return $returnid;
}
  
// If empty password return to login

  if ($password == ""){
  	$db->close();
  	header("Location: login.php?error=1");
  	exit;
  }

// Check user and start session if ok else return to login

  if (checkldapuser($username,$password,'ldap://10.1.0.227','o=HVM')) {
  	$tube_session->data['logged_in'] = true;
  	$tube_session->data['username'] = $name;
  	$tube_session->data['repository'] = $result['id_repository'];
  	$tube_session->data['repositorypath'] = $result['repository'];
  	$tube_session->data['user_id'] = local_user($ldap_id,$name,$company);
  	$tube_session->data['menu'] = $categories;
  	$tube_session->save();
  	$db->close();
    header("Location: /");
  } else {
  	$db->close();
    header("Location: login.php?error=1");
  }

?>
