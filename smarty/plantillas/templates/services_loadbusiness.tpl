<div class="Estilo5">ALTA EN EL BUSCADOR</div><br />
<div class="Estilo8">Marca en el mapa la posici&oacute;n exacta en la que se encuentra el negocio y luego pincha en el bot&oacute;n <i>Guardar Posici&oacute;n</i>.<br /><br />
Puedes usar el zoom para ampliar o reducir la imagen del mapa, cambiar el modo del mapa con los botones <i>mapa, sat&eacute;lite</i> e <i>h&iacute;brido</i>, y moverlo arrastrando con el rat&oacute;n.
</div><br />
<div class="Estilo5">Estado de la Geolocalizaci&oacute;n: </div><div class="Estilo8">{$accuracy}</div><br />
<div id="mapitem" style="width: 400px; height: 400px;border: 1px solid #000;" align="center"></div><br />
		<form action="/alta/negocio/servicios/20" method="post">
			<input type="hidden" name="latitude" value="{$latitude}" id="pointy" />
			<input type="hidden" name="longitude" value="{$longitude}" id="pointx" />
			<input type="hidden" name="pointz" value="0" id="pointz" />
			<input type="hidden" name="defx" value="16" id="defx" />
			<input type="hidden" name="defy" value="16" id="defy" />
			<input type="hidden" name="defz" value="16" id="defz" />
			<input type="hidden" name="id" value="{$id}" id="id" />
			<input type="hidden" name="save" value="1" />
			<div align="center"><input type="submit" name="submit" value="Guardar Posici&oacute;n" /></div>
		</form>

<script type="text/javascript">
{literal}
//<![CDATA[

function load() {
  var map = new GMap2(document.getElementById("mapitem"));
  map.addControl(new GLargeMapControl());
  map.addControl(new GMapTypeControl());
  map.addControl(new GScaleControl());
{/literal}
  map.setCenter(new GLatLng({$latitude},{$longitude}), 16,G_HYBRID_MAP);

	map.addOverlay(new GMarker(new GLatLng({$latitude},{$longitude})));
{literal}
  GEvent.addListener(map, "click", function(marker, point) {
    if (marker) {
      map.removeOverlay(marker);
    } else {
      document.getElementById('pointx').value = point.x;
      document.getElementById('pointy').value = point.y;
      map.clearOverlays();
      map.addOverlay(new GMarker(point));
    }
  });

  GEvent.addListener(map, "zoomend", function(gold, gnew) {
    document.getElementById('defz').value = gnew;
    document.getElementById('pointz').value = gnew;
  });

  GEvent.addListener(map, "moveend", function() {
    document.getElementById('defx').value = map.getCenter().x;
    document.getElementById('defy').value = map.getCenter().y;
  });

}
load();
//]]>
{/literal}
</script>
