
    //<![CDATA[
    
    // Change form
    if (!document.getElementById("map")){
    	document.getElementById("formviewmap").style.visibility = 'hidden';
    	document.getElementById("tagviewmap").innerHTML='<a href="/">Mapa</a>';
    	document.formsearch.formview[1].checked=true;
    }
    
    // Change info shown on map
    function showmyinfo(category,city,categorytext){
    	map.clearOverlays();
    	GDownloadUrl("contenido/negocios/"+category+"/localidad/"+city, process_it);
    	map.setCenter(new GLatLng(40.411209,-3.697994), 6,G_HYBRID_MAP);
    }
    
    // This function picks up the click and opens the corresponding info window
    function myclick(i) {
 	    GEvent.trigger(gmarkers[i], "click");
   	}

    function overthetop(marker,b) {
      return 1000;
    }

    // arrays to hold copies of the markers used by the side_bar
    // because the function closure trick doesnt work there
 	  var gmarkers = [];
 	  
		// Variable for map representation
		var map="";
		
		// Other Variables
		var side_bar_html = "";

 	  // Array for icons
		var gicons=[];  

    // === Create a custom Control ===
    var labelContainer;

      if (GBrowserIsCompatible() && document.getElementById("map")) {
      	

	      var baseIcon = new GIcon();
  	        baseIcon.iconSize=new GSize(32,32);
    	      baseIcon.shadowSize=new GSize(56,32);
      	    baseIcon.iconAnchor=new GPoint(16,32);
        	  baseIcon.infoWindowAnchor=new GPoint(16,0);

				gicons[1] = new GIcon(baseIcon, "http://esquiroles.soydelbierzo.com/imagenes/iconos/esquirol.png", null, "http://esquiroles.soydelbierzo.com/imagenes/iconos/sombra.png");
				gicons[2] = new GIcon(baseIcon, "http://esquiroles.soydelbierzo.com/imagenes/iconos/solidario.png", null, "http://esquiroles.soydelbierzo.com/imagenes/iconos/sombra.png");
				



    	  function LabelControl() {  }
	      LabelControl.prototype = new GControl();

  	    LabelControl.prototype.initialize = function(map) {
        	labelContainer = document.createElement("div");
	        labelContainer.style.overflow="auto";
  	      labelContainer.style.backgroundColor = "#0071ba";
    	    labelContainer.style.border = "1px solid black";
      	  labelContainer.style.height="100px";
        	labelContainer.style.width="140px";
	        labelContainer.style.paddingLeft="5px";

  	      map.getContainer().appendChild(labelContainer);
        	return labelContainer;
      	}

    	  LabelControl.prototype.getDefaultPosition = function() {
  	      return new GControlPosition(G_ANCHOR_TOP_LEFT, new GSize(70, 7));
	      }

    
      	var i = 0;

				// A function to create the marker and set up the event window
  	    function createMarker(point,name,html,iconize,itemorder) {
        	
  	    	if (itemorder > 2) {
    	    	var marker = new GMarker(point,{icon:gicons[iconize],zIndexProcess:overthetop});
    	    } else {
    	    	var marker = new GMarker(point,gicons[iconize]);
    	    }
      	  GEvent.addListener(marker, "click", function() {
      	  	map.setCenter(marker.getPoint(), 16,map.get_mapTypeId);
        	  marker.openInfoWindowHtml(html);
        	});
	        // save the info we need to use later for the side_bar
  	      gmarkers[i] = marker;
  	      
    	    // add a line to the side_bar html
      	  side_bar_html += '<a href="javascript:myclick(' + i + ');" class="Estilo7">* ' + name + '</a><br>';
        	i++;
        	return marker;
	      }

// Add special layer

				var WMS_URL_ROUTE='http://www.idee.es/wms/PNOA/PNOA?';
				var G_MAP_WMS_SPEC = createWMSSpec(WMS_URL_ROUTE, "Ortofoto", "Ortofoto", "pnoa", "Default", "JPEG", "1.1.1");

        map = new GMap2(document.getElementById("map"));
				map.addMapType(G_MAP_WMS_SPEC);        
	      map.addControl(new GMapTypeControl(),new GControlPosition(G_ANCHOR_BOTTOM_RIGHT,new GSize(7, 20)));
  	    map.addControl(new GLargeMapControl());
        map.setCenter(new GLatLng(40.411209,-3.697994), 6,G_HYBRID_MAP);
        
        side_bar_html += '<div class="Estilo6">Municipios</div>';
        
	      // Read the data 
	      process_it = function(doc) {
	        // === split the document into lines ===
  	      lines = doc.split("\n");
  	      var i=0;
    	    for (i=0; i<lines.length; i++) {
      	    if (lines[i].length > 1) {
        	    // === split each line into parts separated by "|" and use the contents ===
          	  parts = lines[i].split("|");
            	var lat = parseFloat(parts[0]);
	            var lng = parseFloat(parts[1]);
    	        var label = parts[2];
    	        var icontype = parseInt(parts[3]);
  	          var html = parts[4];
  	          var itemtype = parseInt(parts[5]);
  	          if (itemtype > 2)
  	          	icontype=icontype+1000;
      	      var point = new GLatLng(lat,lng);
        	    // create the marker
          	  var marker = createMarker(point,label,html,icontype,itemtype);
	            map.addOverlay(marker);
  	        }
    	    }
        	// put the assembled side_bar_html contents into the side_bar div
    	  }          
          
	      GDownloadUrl("contenido/portada/", process_it);

      } else {
      //alert("Las APIs de Google Maps no son compatibles con este navegador.");
	    }

    //]]>
