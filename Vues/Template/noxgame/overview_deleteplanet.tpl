<h1>{ov_rena_dele}</h1>
<form action="{link}overview&mode=renameplanet&pl={planet_id}" method="POST">
<table width="100%">
<tr>
	<td colspan="3" class="c">{security_query}</td>
</tr><tr>
	<td colspan="3">{confirm_planet_delete} {galaxy_galaxy}:{galaxy_system}:{galaxy_planet} {confirmed_with_password}</td>
</tr><tr>
	<td>{password}</td>
	<td><input type="password" name="pw"></td>
	<td><input type="submit" name="action" value="{deleteplanet}" alt="{colony_abandon}"></td>
</tr>
</table>
<input type="hidden" name="kolonieloeschen" value="1">
<input type="hidden" name="deleteid" value ="{planet_id}">
</form>