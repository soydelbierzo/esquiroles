<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Esquiroles #14N</title>
{literal}
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=AQUIVATUAPIKEYDEGOOGLE" type="text/javascript"></script>
<script type="text/javascript" src="/js/sardalyaDrag.js"></script>
<script type="text/javascript" src="/js/DOMManager.js"></script>
<script type="text/javascript" src="/js/XHRequest.js"></script>
<script type="text/javascript" src="/js/PopupLayer.js"></script>
<script type="text/javascript" src="/js/gmap-wms.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
<link rel="stylesheet" type="text/css" href="/css/main.css" />
<link rel="stylesheet" type="text/css" href="/css/popup.css" />
{/literal}
</head>

<body background="/imagenesfondo.gif" onunload="GUnload()">
<table width="900" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td background="/imagenes/cabecera.jpg">
    	<table width="900" border="0" cellpadding="0" cellspacing="0">
    		<tr>
    			<td width="400"><a href="/"><img src="/imagenes/trans.gif" width="400" height="80" border="0"></a></td>
    			<td width="500">
					</td>
				</tr>
    	</table>
    </td>
  </tr>
  <tr>
    <td><img src="/imagenes/trans.gif" width="1" height="5" /></td>
  </tr>
  <tr>
    <td><table width="900" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tr>
        <td width="170" valign="top">
		<table width="166" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" bgcolor="#000000">
          <tr>
            <td>
			<table width="166" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="128" height="10">
				<table width="166" border="0" cellspacing="0" cellpadding="0" background="/imagenes/barrafondo.gif" height="20">
                    <tr>
                      <td><span class="Estilo1">&nbsp;BUSCADOR</span></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
 	              <td width="128" height="12" bgcolor="#FFFFFF" class="Estilo2"><br />
 	                <form id="formsearch" name="formsearch" method="post" action="/directorio/guias/"><input type="hidden" name="searchid" value="1">
					&nbsp;Esquiroles o Solidarios
					&nbsp;<select id="formactivity" name="activity" class="EstiloForm1">
							<option value="1" selected>Esquiroles</option>
							{foreach key=cid item=con from=$menu}
<option value="{$con.id_category}">{$con.category}</option>
							{/foreach}
					  </select>
					<br /><br />
					&nbsp;Municipio
					&nbsp;<select id="formcity" name="city" class="EstiloForm1">
							<option value="0" selected>Todas</option>
							{foreach key=cid item=con from=$cities}
<option value="{$con.id}">{$con.city}</option>
							{/foreach}
					  </select>
					<br /><br />
					&nbsp;Visualizar en<br />
					<input id="formviewmap" name="formview" type="radio" value="map" checked /><span id="tagviewmap">Mapa</span><br />
					<div align="center"><input type="button" name="Submit" value="Buscar" class="Estilo2" onclick="javascript:formtrigger();" /></div>
					</form>
					<br /><br />
					<span class="Estilo1"><a href="/alta/negocio/servicios/2">PINCHA AQUI PARA DAR DE ALTA UN NEGOCIO ESQUIROL O SOLIDARIO</a></span><br /><br />
<span class="Estilo2">Si tu negocio aparece aqu&iacute; y no est&aacute;s de acuerdo o no lo has puesto t&uacute;, por favor h&aacute;noslo saber usando el formulario de <a href="http://esquiroles.soydelbierzo.com/contacto/servicios/14" class="Estilo2">contacto</a>, gracias.</span>
 	              	</td>
   	          </tr>
            </table></td>
          </tr>
        </table>
        <br />
</td>
        <td width="10" valign="top"><img height="1" src="/imagenes/trans.gif" width="10" /></td>
        <td width="600" valign="top">{include file="$template_body"}
        </td>
        <td width="10" valign="top"><img height="1" src="/imagenes/trans.gif" width="10" /></td>
        <td width="100" valign="top" class="Estilo2">Leyenda:<br /><br /><img src="http://esquiroles.soydelbierzo.com/imagenes/iconos/iglesias.png"> Solidarios<br /><br /><img src="http://esquiroles.soydelbierzo.com/imagenes/iconos/ayuntamiento.png"> Esquiroles</td>
        <td width="10" valign="top"><img height="1" src="/imagenes/trans.gif" width="10" /></td>
  </tr>
      
</table>
    <br />
    <table width="900" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><img src="/imagenes/trans.gif" width="1" height="5" /></td>
      </tr>
      <tr>
        <td align="center" class="Estilo5">&copy;left 2012 SoydelBierzo - <a href="http://esquiroles.soydelbierzo.com/aviso/legal/servicios/12" class="Estilo5">Aviso Legal</a> - <a href="http://esquiroles.soydelbierzo.com/aviso/legal/servicios/14" class="Estilo5">Contacto</a></td>
      </tr>
      <tr>
        <td><img src="/imagenes/trans.gif" width="1" height="5" /></td>
      </tr>
    </table></td>
  </tr>
</table>
<div id="PopupMasterContainer">
	<div id="PopupTopHandle" class="popupDragBar">
		<div id="PopupTopButtons" class="popupButtonContainer"><img src="/imagenes/close.gif" class="popupCloseIcon" id="IcnClose" alt="Cierra la Ventana" /></div>
		<div id="PopupTopTitle" class="popupWindowTitle">Titulo</div>
	</div>
	<div id="PopupContent" class="popupConsole">
		<p>Contenido</p>
	</div>
</div>
<script src="http://esquiroles.soydelbierzo.com/js/{$mapscript}.js" type="text/javascript"></script>
</body>
</html>
