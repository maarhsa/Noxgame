<div class="topnav_game">
	<table width=320>
			<tr>
				<td class="header_name" ><b>{Metal}</b></td>
				<td class="header_name" ><b>{Crystal}</b></td>
				<td class="header_name" ><b>{Deuterium}</b></td>
				<td class="header_name" ><b>{Energy}</b></td>
				<td class="header_name" ><b>{Message}</b></td>
				<td class="header_name" ><b>{pointv}</b></td>
			</tr>
			<tr>
				<td class="header_ressource" >{metal}</td>
				<td class="header_ressource" >{crystal}</td>
				<td class="header_ressource" >{deuterium}</td>
				<td class="header_ressource" >{energy}</td>
				<td class="header_ressource" >{message}</td>
				<td class="header_ressource" >{nbvotees}</td>
			</tr>
			<tr>
				<td colspan="6">
					<select size="1" onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
						{planetlist}
					</select>
				</td>
			<tr>
	</table>
</div>