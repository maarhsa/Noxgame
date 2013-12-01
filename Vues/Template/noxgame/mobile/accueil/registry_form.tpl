<div class="corp">
<form action="" method="post">
<table>
	  <tr>
	    <td colspan="2" class="c"><b>{form}</b></td>
</tr><tr>
	<td>{GameName}</td>
    <td><input name="character" size="20" maxlength="20" type="text" /></td>
</tr>
<tr>
  <td>{neededpass}</td>
  <td><input name="passwrd" size="20" maxlength="20" type="password" /></td>
</tr>
<tr>
  <td>{E-Mail}</td>
  <td><input name="email" size="20" maxlength="40" type="text" /></td>
</tr>
<tr>
  <td>{MainPlanet}</td>
  <td><input name="planet" size="20" maxlength="20" type="text" /></td>
</tr>
<tr>
  <td>{Sex}</td>
  <td><select name="sex">
		<option value="*">{Undefined}</option>
		<option value="M">{Male}</option>
		<option value="F">{Female}</option>
		</select></td>
</tr>
<tr>
  <td>choix de race:</td>
  <td><select name="race">
		<option value="*">{Undefined}</option>
		<option value="1">Humain</option>
		<option value="2">Minbari</option>
		<option value="3">Centauri</option>
		<option value="4">Narn</option>
		<option value="5">Ombre</option>
		<option value="6">Vorlon</option>
		</select></td>
</tr>
<tr>
	<td><img alt="image de protection" src="{secu}"/></td>
	<td><input type="text" name="verif" value=""></td>
</tr>
<tr>
{code_secu}
<td>{affiche}</td>
</tr>
<tr>
  <td><input name="rgt" type="checkbox" />
    {accept}</td>
  <td><input name="submit" type="submit" value="{signup}" /></td>
</tr>
</table>
</form>
</div>