<script type="text/javascript">
    function clear_att(){
        document.getElementById('military_tech_us').value = 0;
		document.getElementById('defence_tech_us').value  = 0;
		document.getElementById('shield_tech_us').value   = 0;
		document.getElementById('pourc_att').value 		  = 100;
		for(i=200;i<400;i++) {
			if (document.forms["general"].elements['fleet_us['+i+']']) {
				document.getElementById('fleet_us['+i+']').value = 0;
			}
		}
    }
	
	function clear_def(){
        document.getElementById('military_tech_them').value = 0;
		document.getElementById('defence_tech_them').value  = 0;
		document.getElementById('shield_tech_them').value   = 0;
		document.getElementById('sim_metal').value 			= 0;
		document.getElementById('sim_crystal').value  		= 0;
		document.getElementById('sim_deuterium').value   	= 0;
		document.getElementById('pourc_def').value 		  	= 100;
		for(i=200;i<500;i++) {
			if (document.forms["general"].elements['fleet_them['+i+']']) {
				document.getElementById('fleet_them['+i+']').value = 0;
			}
		}
    }
</script>



<br>
	<form action='{link}simulation' method='post' name="general">
		<table width="680">
			<tr>
				<td align="center">&nbsp;</td>
				<td align="center"><h2>Attaquant</h2></td>
				<td align="center"><h2>D&eacute;fenseur</h2></td>
			</tr>
			<tr>
				<td align="center">&nbsp;</td>
				<td align="center"> Puissance de la flotte &agrave;
					<select name="pourc_att" id="pourc_att">
						<option value="10">10%</option> 
						<option value="20">20%</option> 
						<option value="30">30%</option> 
						<option value="40">40%</option> 
						<option value="50">50%</option> 
						<option value="60">60%</option> 
						<option value="70">70%</option> 
						<option value="80">80%</option> 
						<option value="90">90%</option> 
						<option value="100" selected>100%</option>
						<option value="110">110%</option> 
						<option value="120">120%</option> 
						<option value="130">130%</option> 
						<option value="140">140%</option> 
						<option value="150">150%</option> 
						<option value="160">160%</option> 									
					</select>
				</td>
				<td align="center"> Puissance de la flotte &agrave;
					<select name="pourc_def" id="pourc_def">
						<option value="10">10%</option> 
						<option value="20">20%</option> 
						<option value="30">30%</option> 
						<option value="40">40%</option> 
						<option value="50">50%</option> 
						<option value="60">60%</option> 
						<option value="70">70%</option> 
						<option value="80">80%</option> 
						<option value="90">90%</option> 
						<option value="100" selected>100%</option>
						<option value="110">110%</option> 
						<option value="120">120%</option> 
						<option value="130">130%</option> 
						<option value="140">140%</option> 
						<option value="150">150%</option> 
						<option value="160">160%</option> 									
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="3">Technologies</td>
			</tr>
			<tr>
				<th>Arme</th>
				<th><input type='text' id='military_tech_us' name='military_tech_us' value="{military}"></th>
				<th><input type='text' id='military_tech_them' name='military_tech_them' value='0'></th>
			</tr>
			<tr>
				<th>Bouclier</th>
				<th><input type='text' id='defence_tech_us' name='defence_tech_us' value="{defence}"></th>
				<th><input type='text' id='defence_tech_them' name='defence_tech_them' value='0'></th>
			</tr>
			<tr>
				<th>Coque</th>
				<th><input type='text' id='shield_tech_us' name='shield_tech_us' value="{shield}"></th>
				<th><input type='text' id='shield_tech_them' name='shield_tech_them' value='0'></th>
			</tr>
			{lst_vaisseaux}
			<tr>
				<td colspan="3">Ressources</td>
			</tr>
			<tr>
				<th>M&eacute;tal</th>
				<th>&nbsp;</th>
				<th><input type='text' id='sim_metal' name='metal' value="0"></th>
			</tr>
			<tr>
				<th>Cristal</th>
				<th>&nbsp;</th>
				<th><input type='text' id='sim_crystal' name='crystal' value="0"></th>
			</tr>
			<tr>
				<th>Deut&eacute;rium</th>
				<th>&nbsp;</th>
				<th><input type='text' id='sim_deuterium' name='deuterium' value="0"></th>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<th><input type="button" class="submit2" value="R&eacute;initialiser" onclick="clear_att();" /></th>
				<th><input type="button" class="submit2" value="R&eacute;initialiser" onclick="clear_def();" /></th>
			</tr>
			<tr>
				<th colspan='3'><input type='submit' class="submit" name='submit' value="Simuler le combat"></th>
			</tr>
		</table>
		
	</form>	
</body>				

	