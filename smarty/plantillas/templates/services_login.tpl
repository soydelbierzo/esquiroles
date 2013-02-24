<div class="Estilo5">ALTA EN EL BUSCADOR</div><br />
<div class="Estilo8">{$message}</div><br />
<div class="Estilo8">
<form id="form1" name="form1" method="post" action="/alta/negocio/servicios/19" onSubmit="return check(this);"> 
	Nombre del negocio:<br />
	<input type="text" name="businessname" id="businessname" maxlength="80" class="EstiloForm1"><br /><br />
	Direcci&oacute;n:<br /><br />
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td width="30%">Tipo de v&iacute;a:</td>
			<td width="70%">Nombre y N&uacute;mero de la v&iacute;a:</td>
		</tr>
		<tr>
			<td width="30%">
				<select name="typestreet" id="typestreet" class="EstiloForm1">
					<option id="" name="" value="" selected>Seleccionar</option>
					<option id="ALAMEDA" name="ALAMEDA" value="Alameda">Alameda</option>
					<option id="AVENIDA" name="AVENIDA" value="Avenida">Avenida</option>
					<option id="AUTOPISTA" name="AUTOPISTA" value="Autopista">Autopista</option>
					<option id="AUTOVIA" name="AUTOVIA" value="Autov&iacute;a">Autov&iacute;a</option>
					<option id="BARRIO" name="BARRIO" value="Barrio">Barrio</option>
					<option id="CALLE" name="CALLE" value="Calle">Calle</option>
					<option id="CAMINO" name="CAMINO" value="Camino">Camino</option>
					<option id="CARRETERA" name="CARRETERA" value="Carretera">Carretera</option>
					<option id="C. COMERCIAL" name="C. COMERCIAL" value="Centro Comercial">C. Comercial</option>
					<option id="ESTRADA" name="ESTRADA" value="Estrada">Estrada</option>
					<option id="GLORIETA" name="GLORIETA" value="Glorieta">Glorieta</option>
					<option id="PASAJE" name="PASAJE" value="Pasaje">Pasaje</option>
					<option id="PASEO" name="PASEO" value="Paseo">Paseo</option>
					<option id="PLAZA" name="PLAZA" value="Plaza">Plaza</option>
					<option id="POLIGONO" name="POLIGONO" value="Pol&iacute;gono Industrial">Pol&iacute;gono Industrial</option>
					<option id="RONDA" name="RONDA" value="Ronda">Ronda</option>
					<option id="RUA" name="RUA" value="R&uacute;a">R&uacute;a</option>
					<option id="SECTOR" name="SECTOR" value="Sector">Sector</option>
					<option id="TRAVES&Iacute;A" name="TRAVES&Iacute;A" value="Traves&iacute;a">Traves&iacute;a</option>
					<option id="URBANIZACI&Oacute;N" name="URBANIZACI&Oacute;N" value="Urbanizaci&oacute;n">Urbanizaci&oacute;n</option>
					<option id="V&Iacute;A" name="V&Iacute;A" value="V&iacute;a">V&iacute;a</option>	
				</select>
			</td>
			<td width="70%"><input type="text" name="street" id="street" maxlength="60" class="EstiloForm1"></td>
		</tr>
	</table><br />
	<table border="0" cellpadding="0" cellspacing="0" width="100%">

		<tr>
			<td width="30%">Municipio</td>
			<td width="70%"></td>
		</tr>
		<tr>
			<td width="30%">
				<select id="city" name="city" class="EstiloForm1">
					<option value="0" selected>Seleccionar...</option>
				{foreach key=cid item=con from=$cities}
					<option value="{$con.id}">{$con.city}</option>
				{/foreach}
				</select>
			</td>
			<td width="70%"></td>
		</tr>
	</table><br />
	Contacto:<br /><br />
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td width="30%">Tel&eacute;fono Fijo:</td>
			<td width="70%">Tel&eacute;fono M&oacute;vil:</td>
		</tr>
		<tr>
			<td width="30%"><input type="text" name="phone" id="phone" maxlength="15" class="EstiloForm1"></td>
			<td width="70%"><input type="text" name="mobile" id="mobile" maxlength="15" class="EstiloForm1"></td>
		</tr>
		<tr>
			<td width="30%">Fax:</td>
			<td width="70%">Email:</td>
		</tr>
		<tr>
			<td width="30%"><input type="text" name="fax" id="fax" maxlength="15" class="EstiloForm1"></td>
			<td width="70%"><input type="text" name="email" id="email" maxlength="100" class="EstiloForm1"></td>
		</tr>
		<tr>
			<td colspan="2">P&aacute;gina Web:</td>
		</tr>
		<tr>
			<td colspan="2"><input type="text" name="web" id="web" maxlength="100" class="EstiloForm1"></td>
		</tr>
	</table><br />
	Descripci&oacute;n del negocio:<br />
	<textarea name="description" cols="50" rows="6" id="description" class="EstiloForm2"></textarea><br />	<br />	
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td width="30%">Esquirol o Solidario</td>
			<td width="70%"></td>
		</tr>
		<tr>
			<td width="30%">
				<select id="activity" name="activity" class="EstiloForm1">
					<option value="1" selected>Esquirol</option>
					<option value="2">Solidario</option>
				</select>
			</td>
			<td width="70%"></td>
		</tr>
	</table><br />
  <div class="Estilo8">
    <input name="acepto" type="checkbox" id="acepto" value="acepto" />
    He le&iacute;do y acepto las condiciones expresadas en el <a href="/aviso/legal/servicios/12">Aviso Legal</a>
  </div><br />
	<div align="center"><input type="submit" name="Submit" value="Continuar" /></div>
</form>
</div><br />

{literal}
<script type="text/javascript">

	function check(form){
		if (form.activity.value=="0" && form.altactivity.value==""){
			alert("Debe seleccionar una actividad para su negocio o sugerir una si no se ajusta a ninguna de las que aparece en el listado");
			return false;
		}
		if (form.city.value=="0" && form.altcity.value==""){
			alert("Debe seleccionar una localidad o bien sugerir una si la suya no aparece en el listado");
			return false;
		}
    if (form.typestreet.value=="0"){
    	alert("Debe elegir el tipo de via en la que se encuentra su negocio");
    	return false;
    }
    if (form.businessname.value==""){
    	alert("Debe introducir el nombre de su negocio");
    	return false;
    }
    if (form.street.value==""){
    	alert("Debe introducir la direccion de su negocio");
    	return false;
    }
    if (form.acepto.checked==false){
    	alert("Debe aceptar las condiciones del Aviso Legal y la Politica de Privacidad para poder registrarse");
    	return false;
    }
    return true;
	}
</script>
{/literal}
