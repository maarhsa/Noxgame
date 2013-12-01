<script type="text/javascript" >
function calcul() {
	var Metal = document.forms['marchand'].elements['metal'].value;
	var Deuterium = document.forms['marchand'].elements['deut'].value;

	Metal = Metal * {mod_ma_res_a};
	Deuterium = Deuterium * {mod_ma_res_b};

	var Cristal = Metal + Deuterium;
	document.getElementById("cristal").innerHTML=Cristal;

	if (isNaN(document.forms['marchand'].elements['metal'].value)) {
		document.getElementById("cristal").innerHTML="{mod_ma_nbre}";
	}
	if (isNaN(document.forms['marchand'].elements['deut'].value)) {
		document.getElementById("cristal").innerHTML="{mod_ma_nbre}";
	}
}
</script>
<form id="marchand" action="{link}trader&choix=cristal" method="post">
<input type="hidden" name="ress" value="cristal">
<table width="100%">
<tr>
	<td colspan="3"><img src="images/Games/banniere/marchand.png" alt="{mod_ma_title}" title="{mod_ma_title}" {mobile}/><td>
</tr>
<tr>
	<td class="c" colspan="3"><b>{mod_ma_buton}</b></td>
</tr>
<tr>
	<th colspan="3">{mod_ma_cours}</th>
</tr>
<tr>
<tr>
	<th>{Crystal}</th>
	<th><span id='cristal'></span></th>
	<th>{mod_ma_res}</th>
</tr>
<tr>
	<th>{Metal}</th>
	<th><input name="metal" type="text" value="0" onkeyup="calcul()"/></th>
	<th>{mod_ma_res_a}</th>
</tr>
<tr>
	<th>{Deuterium}</th>
	<th><input name="deut" type="text" value="0" onkeyup="calcul()"/></th>
	<th>{mod_ma_res_b}</th>
</tr>
<tr>
	<th colspan="3"><input type="submit" value="{mod_ma_excha}" /></th>
</tr>
</table>
</form>