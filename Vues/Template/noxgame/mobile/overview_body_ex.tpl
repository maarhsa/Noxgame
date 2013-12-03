<div class="corp_main">
	<script language="JavaScript" type="text/javascript" src="http://localhost/Cetus/Vues/scripts/time.js"></script>
	<table>
		<tr><td class="c" colspan="4"><a href="{link}overview&mode=renameplanet" title="{Planet_menu}">{Planet} "{planet_name}"</a> ({user_username})</td></tr>
		{Have_new_message}
		{Have_new_level_mineur}
		{Have_new_level_raid}
		<tr><th>{Server_time}</th>
		<th colspan="3"><div id="dateheure"></div></th></tr>
		<tr><th>{MembersOnline}</th>
		<th colspan="3">{NumberMembersOnline}</th></tr>
			{fleet_list}
		<tr><th>Facebook</th>
		<th colspan="3"><center><div class="fb-like" data-href="https://www.facebook.com/pages/Vectoron/162665977224686" data-send="true" data-layout="button_count" data-width="180" data-show-faces="true" data-colorscheme="dark"></div></center></th></tr>
		{voting}
		{voting2}
		{NewsFrame}
		<tr><td colspan="4" class="c">{Events}</td>
		</tr>
		<tr>
		<th colspan="2" ><img src="{dpath}planeten/{planet_image}.jpg" width="{width}"><br>{building}</th>
		<th class="s"><table class="s" align="top" border="0"><tr>{anothers_planets}</tr></table></th></tr>
		<tr><th>{Diameter}</th>
		<th colspan="3">{planet_diameter} km (<a title="{Developed_fields}">{planet_field_current}</a> / <a title="{max_eveloped_fields}">{planet_field_max}</a> {fields})</th></tr>
		<th>{Developed_fields}</th>
		<th colspan="3" align="center"><div  style="border: 1px solid rgb(153, 153, 255); width: {casw}px;"><div  id="CaseBarre" style="background-color: {case_barre_barcolor}; width: {case_barre}px;"><font color="#CCF19F">{case_pourcentage}</font></div></th></tr>
		<tr>
			<th>{Temperature}</th>
		<th colspan="3">{ov_temp_from} {planet_temp_min}{ov_temp_unit} {ov_temp_to} {planet_temp_max}{ov_temp_unit}</th>
		</tr>
		<tr>
		<th colspan="4">{Metal} : {metal_debris} / {Crystal} : {crystal_debris}{get_link}</th></tr>
		<tr>
		<th colspan="4"><table border="0"  class="principal"><tbody><tr>
			<td align="right" width="50%" style="background-color: transparent;"><b>{ov_pts_build} :</b></td>
			<td align="left" width="50%" style="background-color: transparent;"><b>{user_points}</b></td></tr>
			<tr><td align="right" width="50%" style="background-color: transparent;"><b>{ov_pts_fleet} :</b></td>
			<td align="left" width="50%" style="background-color: transparent;"><b>{user_fleet}</b></td></tr>
			<tr><td align="right" width="50%" style="background-color: transparent;"><b>{ov_pts_def} :</b></td>
			<td align="left" width="50%" style="background-color: transparent;"><b>{user_def}</b></td></tr>
			<tr><td align="right" width="50%" style="background-color: transparent;"><b>{ov_pts_reche} :</b></td>
			<td align="left" width="50%" style="background-color: transparent;"><b>{player_points_tech}</b></td></tr>
			<tr><td align="right" width="50%" style="background-color: transparent;"><b>{ov_pts_total} :</b></td>
			<td align="left" width="50%" style="background-color: transparent;"><b>{total_points}</b></td></tr>
			<tr><td colspan="2" align="center" width="100%" style="background-color: transparent;"><b>({Rank} <a href="{link}stat&range={u_user_rank}">{user_rank}</a> {of} {max_users})</b></td></tr></tbody></table></th></tr>
		<th colspan="4"><table border="0" width="100%" class="principal"><tbody><tr>
			<td align="right" width="50%" style="background-color: transparent;"><b>{NumberOfRaids} :</b></td>
			<td align="left" width="50%" style="background-color: transparent;"><b>{raids}</b></td></tr>
			<tr><td align="right" width="50%" style="background-color: transparent;"><b>{RaidsWin} :</b></td>
			<td align="left" width="50%" style="background-color: transparent;"><b>{raidswin}</b></td></tr></tr>
			<tr><td align="right" width="50%" style="background-color: transparent;"><b>{RaidsLoose} :</b></td>
			<td align="left" width="50%" style="background-color: transparent;"><b>{raidsloose}</b></td></tr></tbody></table></th></tr>
		{bannerframe}
		{ExternalTchatFrame}
	</table>
	<br>
	{ClickBanner}
	</div>
</div>