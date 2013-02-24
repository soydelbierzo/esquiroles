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

	// Get id to display
	
	$id=intval(strip_tags($_GET['id']));
	
	function loadservicetemplate($templateid){
		global $db;
		$sql="select template from services where id=".$templateid;
		$queryresult = $db->query_first($sql);
		if ($queryresult['template'] != ""){
			$servicetemplate="services_".$queryresult['template'].".tpl";
		} else {
			$db->close();
			header("Location: /");
		}
		return $servicetemplate;
	}
	if ($id > 0) {
		$mytemplate=loadservicetemplate($id);
	} else {
		$db->close();
		header("Location: /");
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
			
	switch ($id) {
		case 2: // If logged passthru login 
				$smarty->assign('message', "Introduce los datos del formulario para dar de alta un negocio esquirol o solidario:");
				$mytemplate=loadservicetemplate(16);
			break;
		case 8: // Send Contact Form
			$username=strip_tags($_POST['name']);
			$userphone=strip_tags($_POST['phone']);
			$useremail=strip_tags($_POST['email']);
			$userquestion=strip_tags($_POST['question']);
			// Now send email
			$techdata="Dirección IP: ".$_SERVER[REMOTE_ADDR]."-".getenv('HTTP_CLIENT_IP')."-".getenv('HTTP_X_FORWARDED_FOR')." Navegador=".$_SERVER['HTTP_USER_AGENT'];
			$message = "Nombre: ".$username."\n\nTeléfono de Contacto: ".$userphone."\n\nEmail: ".$useremail."\n\nComentario:\n".$userquestion."\n\n\n--------------------------------------------------\nInformación técnica: ".$techdata;
			$to_email = $my_email;
			$subject= "Contacto desde ".$arka_session->data['domainname'];
			$to_name=$arka_session->data['domainemail'];
			$from=$useremail;
			if ($to_email && $message && $subject) {
				$to = "\"$to_name\" <$to_email>";
				$to = str_replace("\\'", "'", $to);
				$from = str_replace("\\'", "'", $from);
				$subject = str_replace("\\'", "'", $subject);
				$message = str_replace("\\'", "'", $message);
				mail($to, $subject, $message, "From: $from");
			}
			break;
		case 16: // Check Login, start session
			$ownermail=strip_tags($_POST['email']);
			$ownerpass=strip_tags($_POST['password']);
			$sql="select id_user from users where email='".$ownermail."' and password='".$ownerpass."' and verify='1' and repository=".$repository." limit 1";
			$queryresult = $db->fetch_all_array($sql);
			if (count($queryresult) > 0){ //user found
				$smarty->assign('message', "Bienvenido a su cuenta, introduzca los datos del formulario para dar de alta su negocio:");
				$arka_session->data['logged_in']=true;
				$arka_session->data['userid']=$queryresult[0]['id_user'];
				$arka_session->save();
			} else { // User not found
				$smarty->assign('message', "Su email o su clave son incorrectos, por favor verifique que ha introducido correctamente sus datos de acceso.");
			}
			break;
		case 17: // Generate Verify code and mail it to registered user
    	$verifycode="";
  		for ($i=0;$i<10;$i++){
  			$myselect=rand(0,2);
  			switch ($myselect){
  				case 0:
  					$codechar=rand(65,90);
  					break;
  				case 1:
  					$codechar=rand(48,57);
  					break;
  				case 2:
  					$codechar=rand(97,122);
  					break;
  				default:
  					$codechar=rand(97,122);
  					break;
  			}
  			$verifycode=$verifycode.chr($codechar);
  		}
  		// Get Post info
  		$username=strip_tags($_POST['username']);
  		$userpassword=strip_tags($_POST['userpassword']);
  		$usermail=strip_tags($_POST['email']);
  		$userphone=strip_tags($_POST['phone']);
  		// Verify That user isn't registered
  		$sql="select id_user from users where email='".$usermail."' and repository=".$repository." limit 1";
  		$queryresult = $db->fetch_all_array($sql);
  		if (count($queryresult) > 0){
  			$smarty->assign('username', $username);
  			$smarty->assign('userpassword', $userpassword);
  			$smarty->assign('usermail', $usermail);
  			$smarty->assign('userphone', $userphone);
  			$smarty->assign('errortext', "Ya existe un usuario con ese email");
				$mytemplate="services_registerowner.tpl";
  		} else { // User ins't registered, let's register and mail
				$data = array('name'=>$username,'password'=>$userpassword,'email'=>$usermail,'phone'=>$userphone,'verify'=>$verifycode,'type'=>2,'repository'=>$repository);
				$returnid = $db->query_insert("users", $data);
				// Now send confirmation email
				$message = "Gracias por registrarse en ".$arka_session->data['domainname']."\n\nPara finalizar el proceso de registro pinche sobre el siguiente enlace o cópielo y péguelo en su navegador de internet:\n\nhttp://".$arka_session->data['domain']."/verificar/".$verifycode."\n\nUna vez que realice este paso ya podrá dar de alta su negocio en nuestras guías.\n\nRecuerde que sus datos de acceso son:\n\nEmail: ".$usermail."\nContraseña: ".$userpassword."\n\nAtentamente\nEl equipo de ".$arka_session->data['domainname'];
				$to_email = $usermail;
				$subject= "Registro ".$arka_session->data['domainname'];
				$to_name=$username;
				$from=$arka_session->data['domainemail'];
				if ($to_email && $message && $subject) {
					$to = "\"$to_name\" <$to_email>";
					$to = str_replace("\\'", "'", $to);
					$from = str_replace("\\'", "'", $from);
					$subject = str_replace("\\'", "'", $subject);
					$message = str_replace("\\'", "'", $message);
					mail($to, $subject, $message, "From: $from");
				}
  		}
  	  break;
  	case 18: // Verify email sent code
  		$verifycode=strip_tags($_GET['verifycode']);
  		$sql="select id_user,name from users where verify='".$verifycode."' limit 1";
  		$queryresult = $db->fetch_all_array($sql);
  		if (count($queryresult) > 0){
  			$smarty->assign('verifymessage', "Su cuenta est&aacute; ahora activa, ya puede dar de alta su negocio.");
  			$data = array('verify'=>'1');
				$db->query_update("users",$data,"id_user=".$queryresult[0]['id_user']);
  		} else { // Verify Code not found
  			$smarty->assign('verifymessage', "No se encuentra este c&oacute;digo, compruebe que ha escrito bien la url enviada por email.");
  		}
  		break;
  	case 19: // Register business and show map
	  		$businessname=mystringencoder(strip_tags($_POST['businessname']));
  			$typestreet=mystringencoder(strip_tags($_POST['typestreet']));
  			$street=mystringencoder(strip_tags($_POST['street']));
  			$address=$typestreet." ".$street;
	  		$city=intval(strip_tags($_POST['city']));
  			$altcity=mystringencoder(strip_tags($_POST['altcity']));
  			$phone=strip_tags($_POST['phone']);
  			$mobile=strip_tags($_POST['mobile']);
	  		$fax=strip_tags($_POST['fax']);
  			$email=strip_tags($_POST['email']);
  			$web=strip_tags($_POST['web']);
  			$description=mystringencoder(strip_tags($_POST['description']));
	  		$activity=intval(strip_tags($_POST['activity']));
  			$altactivity=strip_tags($_POST['altactivity']);
  			$owner=$arka_session->data['userid'];
  			list($status,$accuracy,$latitude,$longitude)=explode("/",geocodeitem($address,$city));
  			switch ($accuracy) {
  					case 0 : $smarty->assign('accuracy', "Direcci&oacute;n no encontrada, por favor b&uacute;squela en el mapa"); break;
  					case 1 : $smarty->assign('accuracy', "Direcci&oacute;n no encontrada, por favor b&uacute;squela en el mapa"); break;
  					case 2 : $smarty->assign('accuracy', "Direcci&oacute;n no encontrada, por favor b&uacute;squela en el mapa"); break;
  					case 3 : $smarty->assign('accuracy', "Direcci&oacute;n no encontrada, por favor b&uacute;squela en el mapa"); break;
  					case 4 : $smarty->assign('accuracy', "Direcci&oacute;n no encontrada, por favor b&uacute;squela en el mapa"); break;
  					case 5 : $smarty->assign('accuracy', "Direcci&oacute;n no encontrada, por favor b&uacute;squela en el mapa"); break;
  					case 6 : $smarty->assign('accuracy', "Direcci&oacute;n encontrada, n&uacute;mero no encontrado, por favor confirme la posici&oacute;n en el mapa"); break;
  					case 7 : $smarty->assign('accuracy', "Direcci&oacute;n encontrada, n&uacute;mero no encontrado, por favor confirme la posici&oacute;n en el mapa"); break;
  					case 8 : $smarty->assign('accuracy', "Direcci&oacute;n encontrada, por favor confirme la posici&oacute;n en el mapa"); break;
  					case 9 : $smarty->assign('accuracy', "Direcci&oacute;n encontrada, por favor confirme la posici&oacute;n en el mapa"); break;
  			}
				$data = array('id_category'=>$activity,'title'=>$businessname,'description'=>$description,'address'=>$address,'city'=>$city,'mobile'=>$mobile,'fax'=>$fax,'email'=>$email,'phone'=>$phone,'web'=>$web,'owner'=>$owner,'active'=>0,'type'=>5,'lat'=>$latitude,'lng'=>$longitude,'id_repository'=>$arka_session->data['repository']);
				$returnid = $db->query_insert("items", $data);
				$smarty->assign('id', $returnid);
				$smarty->assign('latitude', $latitude);
				$smarty->assign('longitude', $longitude);
				// Send info email
				$message_add = "Datos adicionales no registrados en base de datos:\n\n";
				if ($altcity!=""){
					$message_add.="Ciudad Alternativa: ".$altcity."\n\n";
				}
				if ($altactivity!=""){
					$message_add.="Actividad Alternativa: ".$altactivity."\n\n";
				}
				$message = "Nuevo Negocio dado de alta ".$arka_session->data['domainname']."\n\n".$businessname." con ID ".$returnid."\n\n".$message_add."Verificarlo";
				$to_email = $arka_session->data['domainemail'];
				$subject= "Alta ".$arka_session->data['domainname'];
				$to_name=$arka_session->data['domainname'];
				$from=$arka_session->data['domainemail'];
				if ($to_email && $message && $subject) {
					$to = "\"$to_name\" <$to_email>";
					$to = str_replace("\\'", "'", $to);
					$from = str_replace("\\'", "'", $from);
					$subject = str_replace("\\'", "'", $subject);
					$message = str_replace("\\'", "'", $message);
					mail($to, $subject, $message, "From: $from");
				}

  		break;
  	case 20: // Save map point and ask for subscription type
  			$id=intval(strip_tags($_POST['id']));
  			$latitude=strip_tags($_POST['latitude']);
  			$longitude=strip_tags($_POST['longitude']);
  			$data = array('lat'=>$latitude,'lng'=>$longitude);
				$db->query_update("items",$data,"id=".$id);
				$arka_session->data['item']=$id;
				$sql="select id,price,description,suscribe from subscriptiontype where repository=".$repository." order by id ASC";
				$queryresult = $db->fetch_all_array($sql);
				$smarty->assign('subscription', $queryresult);
  		break;
  	case 21: // Free suscription
  		if ($arka_session->data['logged_in'] == true){
  			$data = array('repository'=>$repository,'user'=>$arka_session->data['userid'],'item'=>$arka_session->data['item'],'type'=>1);
				$returnid = $db->query_insert("subscriptions", $data);
  		}
  		break;
	}
	
	$smarty->assign('template_body', $mytemplate);
	$smarty->display('index.tpl');
	
	$db->close();

?>
