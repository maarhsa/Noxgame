<div class="officier">
<u><i>Principal</i></u>
	<table class="officier">
		<tr>
			<td class="officier_img"><a href="{link}officier&type=mineur" alt="{mineur_offi}" title="{officier} {mineur_offi}"><img class="arrondie" {border1} src="{dpath}Games/officiers/{design1}.jpg" alt="mineur" title="{officier} {mineur_offi}" /></a></td>
		</tr>
		<tr>
			<td class="officier_img"><a href="{link}officier&type=raideur" alt="{raideur_offi}" title="{officier} {raideur_offi}"><img class="arrondie" {border2} src="{dpath}Games/officiers/{design2}.jpg" alt="{raideur_offi}" title="{officier} {raideur_offi}" /></a></td>
		</tr>
		<tr>
			<td class="officier_img"><a href="{link}officier&type=technopere" alt="{techno_offi}" title="{officier} {techno_offi}"><img class="arrondie" {border3} src="{dpath}Games/officiers/{design3}.jpg" alt="{techno_offi}" title="{officier} {techno_offi}"/></a></td>
		</tr>
		<tr>
			<td class="officier_img"><a href="{link}officier&type=defenseur" alt="{defense_offi}" title="{officier} {defense_offi}"><img class="arrondie" {border4} src="{dpath}Games/officiers/{design4}.jpg" alt="{defense_offi}" title="{officier} {defense_offi}"/></a></td>
		</tr>
	</table>
<u><i>Bonus</i></u>
	<table class="officier">
		<tr>
			<td class="officier_img"><a href="{link}officier&type=alliance" alt="{alliance_offi}" title="{officier} {alliance_offi}"><img class="arrondie" {border5} src="{dpath}Games/officiers/{design5}.jpg" alt="{alliance_offi}" title="{officier} {alliance_offi}" /></a></td>
		</tr>
	</table>
</div>
<div class="topnav_game">
	<table class="top">
			<tr>
				<td class="header_planet" ROWSPAN="2">
					<img class="planet" src="{dpath}Games/planete/min/min_{image}.jpg" alt="{name_planet}" title="{name_planet}" height="50" width="50">
				</td>
				<td class="header_img" ><img class="ressources" src="{dpath}Games/topnav/metal.gif" alt="{Metal}" title="capacité de stockage: {metal_max}" /></td>
				<td class="header_img" ><img class="ressources" src="{dpath}Games/topnav/cristal.gif" alt="{Crystal}" title="capacité de stockage: {crystal_max}"/></td>
				<td class="header_img" ><img class="ressources" src="{dpath}Games/topnav/deuterium.gif" alt="{Deuterium}" title="capacité de stockage: {deuterium_max}"/></td>
				<td class="header_img" ><img class="ressources" src="{dpath}Games/topnav/energie.gif" alt="{Energy}" title="{Energy}"/></td>
				<td class="header_img" ><img class="ressources" src="{dpath}Games/topnav/mp.gif" alt="{Message}" title="{Message}" /></td>
				<td class="header_img" ><img class="ressources" src="{dpath}Games/topnav/pv.gif" alt="{pointv}" title="point vote :{nbvotees}"/></td>
			</tr>
			<tr>
				<td class="header_name" ><b>{Metal}</b></td>
				<td class="header_name" ><b>{Crystal}</b></td>
				<td class="header_name" ><b>{Deuterium}</b></td>
				<td class="header_name" ><b>{Energy}</b></td>
				<td class="header_name" ><b>{Message}</b></td>
				<td class="header_name" ><b>{pointv}</b></td>
			</tr>
			<tr>
				<td class="header_name_planet" >
					<select size="1" onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
						{planetlist}
					</select>
				</td>
				<td class="header_ressource" >{metal}</td>
				<td class="header_ressource" >{crystal}</td>
				<td class="header_ressource" >{deuterium}</td>
				<td class="header_ressource" >{energy}</td>
				<td class="header_ressource" >{message}</td>
				<td class="header_ressource" >{nbvotees}</td>
			</tr>
	</table>
</div>
{OverviewNewsText}
