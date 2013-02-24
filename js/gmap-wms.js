/*
 * Create GoogleMap WMS (transparent) layers on any GoogleMap.
 *
 * Just van den Broecke - just AT justobjects.nl - www.justobjects.nl - www.geoskating.com
 * version: $Id: gmap-wms.js,v 1.11 2008-12-16 11:19:26 just Exp $
 *
 * This (experimental) code can be downloaded from
 * http://www.geotracing.com/gt/script/gmap.js
 *
 * CREDITS
 * This code is based on and inspired by:
 * Brian Flood - http://www.spatialdatalogic.com/cs/blogs/brian_flood/archive/2005/07/11/39.aspx and
 * Kyle Mulka - http://blog.kylemulka.com/?p=287
 * I have merely merged the two approaches taken by each of these great minds !
 *
 * EXAMPLE
 *   // Fake WMS server to be used for overlaying map with transparent GIF
 *   // Use a real WMS server here.
 *   var WMS_URL_ROUTE='http://www.geoskating.com/gmap/route-wms.jsp?';
 *
 *   // Create WMSSpec
 *   // need: wmsURL, gName, gShortName, wmsLayers, wmsStyles, wmsFormat, [wmsVersion], [wmsBgColor], [wmsSrs]
 *   var G_MAP_WMS_SPEC = createWMSSpec(WMS_URL_ROUTE, "MyWMS", "MyWMS", "routes", "default", "image/gif", "1.0.0");
 *
 *   // Use WMSSpec to create transparent overlay on a standard Google MapSpec
 *   var G_MAP_WMS_OVERLAY_SPEC = createWMSOverlaySpec(G_SATELLITE_MAP, G_MAP_WMS_SPEC, "MyOvWMS", "MyOvWMS");
 *
 *   // Setup the map
 *   var map = new GMap2(document.getElementById("map"));
 *   // Create mapspecs array
 *	 map.addMapType(G_NORMAL_MAP);
 *	 map.addMapType(G_SATELLITE_MAP);
 * 	 map.addMapType(G_MAP_WMS_SPEC);
 *	 map.addMapType(G_MAP_WMS_OVERLAY_SPEC);
 *   map.addControl(new GMapTypeControl());
 *   map.setCenter(new GLatLon(52.35, 4.9), 10, G_MAP_WMS_OVERLAY_SPEC);
 */



/*
 Call generic wms service for GoogleMaps v2
 John Deck, UC Berkeley
 Inspiration & Code from:
 Mike Williams http://www.econym.demon.co.uk/googlemaps2/ V2 Reference & custommap code
 Brian Flood http://www.spatialdatalogic.com/cs/blogs/brian_flood/archive/2005/07/11/39.aspx V1 WMS code
 Kyle Mulka http://blog.kylemulka.com/?p=287  V1 WMS code modifications
 http://search.cpan.org/src/RRWO/GPS-Lowrance-0.31/lib/Geo/Coordinates/MercatorMeters.pm
 */

var MAGIC_NUMBER = 6356752.3142;
var DEG2RAD = 0.0174532922519943;
var PI = 3.14159267;
function dd2MercMetersLng(p_lng) {
    return MAGIC_NUMBER * (p_lng * DEG2RAD);
}

function dd2MercMetersLat(p_lat) {
    if (p_lat >= 85) p_lat = 85;
    if (p_lat <= -85) p_lat = -85;
    return MAGIC_NUMBER * Math.log(Math.tan(((p_lat * DEG2RAD) + (PI / 2)) / 2));
}

var CustomGetTileUrl = function(a, b, c) {
    if (typeof(window['this.myMercZoomLevel']) == "undefined") this.myMercZoomLevel = 0;
    if (typeof(window['this.myStyles']) == "undefined") this.myStyles = "";
    var lULP = new GPoint(a.x * 256, (a.y + 1) * 256);
    var lLRP = new GPoint((a.x + 1) * 256, a.y * 256);
    var lUL = G_NORMAL_MAP.getProjection().fromPixelToLatLng(lULP, b, c);
    var lLR = G_NORMAL_MAP.getProjection().fromPixelToLatLng(lLRP, b, c);
    // switch between Mercator and DD if merczoomlevel is set
    if (this.myMercZoomLevel != 0 && map.getZoom() < this.myMercZoomLevel) {
        var lBbox = dd2MercMetersLng(lUL.lngDegrees) + "," + dd2MercMetersLat(lUL.latDegrees) + "," + dd2MercMetersLng(lLR.lngDegrees) + "," + dd2MercMetersLat(lLR.latDegrees);
        var lSRS = "EPSG:54004";
    } else {
        var lBbox = lUL.x + "," + lUL.y + "," + lLR.x + "," + lLR.y;
        var lSRS = "EPSG:4326";
    }
    var lURL = this.myBaseURL;
    lURL += "&REQUEST=GetMap";
    lURL += "&SERVICE=WMS";
    lURL += "&VERSION=" + this.myVersion;
    lURL += "&LAYERS=" + this.myLayers;
    lURL += "&STYLES=" + this.myStyles;
    lURL += "&FORMAT=" + this.myFormat;
    lURL += "&BGCOLOR=" + this.myBgColor;
    lURL += "&TRANSPARENT=TRUE";
    lURL += "&SRS=" + lSRS;
    lURL += "&BBOX=" + lBbox;
    lURL += "&WIDTH=256";
    lURL += "&HEIGHT=256";
    lURL += "&reaspect=false";
    return lURL;
}



/** Create WMS type spec as a GMap Spec. */
function createWMSSpec(wmsURL, gName, gShortName, wmsLayers, wmsStyles, wmsFormat, wmsVersion, wmsBgColor, wmsSrs) {
    var tile =new GTileLayer(new GCopyrightCollection("Imagenes &copy; IDEE"), 7, 19);
    tile.myLayers = wmsLayers;
    tile.myStyles = (wmsStyles ? wmsStyles : "");
    tile.myFormat = (wmsFormat ? wmsFormat : "image/gif");
    tile.myVersion = (wmsVersion ? wmsVersion : "1.1.1");
    tile.myBgColor = (wmsBgColor ? wmsBgColor : "0xFFFFFF");
    tile.myBaseURL = wmsURL;
    tile.getTileUrl = CustomGetTileUrl;
	  //tileCounty.getOpacity = function() {return 0.5;}


    var layer = [tile,G_HYBRID_MAP.getTileLayers()[1]];

    var mapType = new GMapType(layer, G_SATELLITE_MAP.getProjection(), gName, G_SATELLITE_MAP);

    return mapType;
}

/** Create transparent WMS overlay layer on standard GMap Spec. */
function createWMSOverlaySpec(gSpec, wmsSpec, gName, gShortName) {
    wmsSpec.getTileLayers()[0].getOpacity = function() {
        return 1.0;
    }
    var layers = [gSpec.getTileLayers()[0], wmsSpec.getTileLayers()[0]];
    return new GMapType(layers, gSpec.getProjection(), gShortName);

}
