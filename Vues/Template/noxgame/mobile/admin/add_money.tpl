<br><br>
<h2>{adm_am_ttle}</h2>
<form action="add_money.php" method="post">
<input type="hidden" name="mode" value="addit">
<table width="305">
<tbody>
<tr>
	<td class="c" colspan="6">{adm_am_form}</td>
</tr>
<tr>
<td class="c" ></td>
<td class="c" >{adm_am_gala}</td>
<td class="c" >{adm_am_syst}</td>
<td class="c">{adm_am_plant}</td>
<td class="c">{adm_am_type}</td>
</tr><tr>
	<th width="130">{adm_am_coor}</th>
	<th><input name="gala" type="text" value="0" size="3" /></th>
	<th><input name="syst" type="text" value="0" size="3" /></th>
	<th><input name="plant" type="text" value="0" size="3" /></th>
		<th><SELECT name="typeplant">
		<OPTION VALUE="1">{adm_am_plant}</OPTION>
	</SELECT></th>
</tr>
<tr>
	<td class="c" colspan="6">{adm_am_ress}</td>
</tr>
<tr>
	<th>{Metal}</th>
	<th colspan="4"><input name="metal" type="text" value="0" /></th>
</tr><tr>
	<th>{Crystal}</td>
	<th colspan="4"><input name="cristal" type="text" value="0" /></th>
</tr><tr>
	<th>{Deuterium}</td>
	<th colspan="4"><input name="deut" type="text" value="0" /></th>
</tr>
<tr>
	<th colspan="6"><input type="Submit" value="{adm_am_add}" /></th>
</tbody>
</tr>
</table>
</form>