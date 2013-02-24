		// Create a trigger for form
		
		function formtrigger(){
			var category=document.getElementById('formactivity').value;
			var city=document.getElementById('formcity').value;
			var categorytext=document.getElementById('formactivity').options[document.getElementById('formactivity').selectedIndex].text;
			var destinationlist="";
			for (var i=0; i < document.formsearch.formview.length; i++) {
		  	 if (document.formsearch.formview[i].checked){
      		destinationlist=document.formsearch.formview[i].value;
       	}
    	}
			showmyinfo(category,city,categorytext);
		}

		function specialtrigger(mycategory,mycategorytext){
				showmyinfo(mycategory,0,'Jornadas Gastron&oacute;micas');
		}

		
		// Show Popup
		var g_popup=null;
		
		function showinfopopup(id,inftext) {
			g_popup = new PopupLayer("PopupMasterContainer","Informaci&oacute;n");
			g_popup.center();
			document.getElementById("PopupContent").innerHTML="";
			g_popup.show();
			g_popup.open("/contenido/ver/"+id,inftext);
			var iconclose=document.getElementById("IcnClose")
			iconclose.addEventListener("click",document_Click);
		}
		
		function showhelppopup(id,inftext) {
			g_popup = new PopupLayer("PopupMasterContainer","Informaci&oacute;n");
			g_popup.center();
			document.getElementById("PopupContent").innerHTML="";
			g_popup.show();
			g_popup.open("/ayuda/"+id,inftext);
			var iconclose=document.getElementById("IcnClose")
			iconclose.addEventListener("click",document_Click);
		}
		
		// Close Popup
		function document_Click(evt) {
			var obj = new EventHandler().getProperSourceFromEvent(evt);

			if(obj.className!="popupCloseIcon"&&obj.tagName.toLowerCase()!="select"&&obj.tagName.toLowerCase()!="option") {
				g_popup.show();
			}
		}
