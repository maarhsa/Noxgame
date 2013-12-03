<form action="{link}trader" method="post">
<input type="hidden" name="action" value="2">
<table width="100%">
		<tr>
			<td colspan="3"><font color="#FFFFFF">{mod_ma_title}</font><td>
		</tr>
		<tr>
			<td colspan="3"><img src="images/Games/banniere/marchand.png" alt="{mod_ma_title}" title="{mod_ma_title}" {mobile}/><td>
		</tr>
		<tr>
			<td>{Metal}</td>
			<td>{Crystal}</td>
			<td>{Deuterium}</td>
		</tr>
		<tr>
			<td><a href="{link}trader&choix=metal" alt="{Metal}" title="{Metal}"><img class="marchand" src="images/Games/marchand/marchand_m.png" alt="{Metal}" title="{Metal}"/></a></td>
			<td><a href="{link}trader&choix=cristal" alt="{Crystal}" title="{Crystal}"><img class="marchand" src="images/Games/marchand/marchand_c.png" alt="{Crystal}" title="{Crystal}"/></a></td>
			<td><a href="{link}trader&choix=deuterium" alt="{Deuterium}" title="{Deuterium}"><img class="marchand" src="images/Games/marchand/marchand_d.png" alt="{Deuterium}" title="{Deuterium}"/></a></td>
		</tr>
		<tr>
			<td colspan="3">{mod_ma_rates}<td>
		</tr>
		<tr>
			<td colspan="3">Pour utiliser le marchand , vous devez avoir au minimum 5 points Votes !!!<br>
		{error_vote}<td>
		</tr>
</table>
</form>