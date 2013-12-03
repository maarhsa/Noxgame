	<table width="100%">
		{Have_new_message}
		<tr>
			<td colspan="3"><img src="{dpath}Games/planete/{planet_image}.png" width="300px"><br>{Developed_fields}<div  style="border: 1px solid rgb(153, 153, 255); width: {casw}px;margin-left:25%;"><div  id="CaseBarre" style="background-color: {case_barre_barcolor}; width: {case_barre}px;"><font color="#CCF19F">{case_pourcentage}</font></div></div></td>
		</tr>
		<tr>
			<td VALIGN=top>
				<table style='margin-top:25px;'>
					<tr>
						<td colspan=2>
						<form method="POST" action="">
							{building}
						</form>
						</td>
					</tr>
					<tr>
						<td>nom de la planete</td>
						<td><a href="{link}overview&mode=renameplanet" title="{Planet_menu}">{Planet} "{planet_name}"</a></td>
					</tr>
					<tr>
						<td>{Diameter}</td>
						<td>{planet_diameter} km ({planet_field_current} /{planet_field_max} {fields})</td>
					</tr>
					<tr>
						<td>{Temperature}</td>
						<td>{ov_temp_from} {planet_temp_min}{ov_temp_unit} {ov_temp_to} {planet_temp_max}{ov_temp_unit}</td>
					</tr>
					<tr>
						<td colspan="2">{Metal} : {metal_debris} / {Crystal} : {crystal_debris}{get_link}</td></tr>
					<tr>
					<tr>
						<td colspan=2>information complementaire:</td>
					</tr>
					<tr>
						<td><b>{ov_pts_build} :</b></td>
						<td><b>{user_points}</b></td>
					</tr>
					<tr>
						<td><b>{ov_pts_fleet} :</b></td>
						<td><b>{user_fleet}</b></td>
					</tr>
					<tr>
						<td><b>{ov_pts_def} :</b></td>
						<td><b>{user_def}</b></td>
					</tr>
					<tr>
						<td><b>{ov_pts_reche} :</b></td>
						<td><b>{player_points_tech}</b></td>
					</tr>
					<tr>
						<td><b>Point pertes :</b></td>
						<td><b>{player_points_pertes}</b></td>
					</tr>
					<tr>
						<td><b>{ov_pts_total} :</b></td>
						<td><b>{total_points}</b></td>
					</tr>
					<tr>
						<td colspan=2><b>({Rank} <a href="{link}stat&range={u_user_rank}">{user_rank}</a> {of} {max_users})</b></td>
					</tr>
					<tr>
						<td colspan=2>Nombre de raid</td>
					</tr>
					<tr>
						<td><b>{NumberOfRaids} :</b></td>
						<td><b>{raids}</b></td>
					</tr>
					<tr>
						<td><b>{RaidsWin} :</b></td>
						<td><b>{raidswin}</b></td></tr>
					<tr>
						<td><b>{RaidsLoose} :</b></td>
						<td><b>{raidsloose}</b></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>