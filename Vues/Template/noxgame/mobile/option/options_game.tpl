<div class="corp_main">
<form action="{link}options&type=jeu" method="post">
<table>
<tr>
	<td class="c" colspan="2"><h1>{general_settings}</h1></td>
</tr><tr>
	<th>{opt_lst_ord}</th>
	<th>
		<select name="settings_sort">
		{opt_lst_ord_data}
		</select>
	</th>
</tr><tr>
	<th>{opt_lst_cla}</th>
	<th>
		<select name="settings_order">
		{opt_lst_cla_data}
		</select>
	</th>
</tr><tr>
	<th><a title="{untoggleip_tip}">{untoggleip}</a></th>
	<th><input name="noipcheck"{opt_noipc_data} type="checkbox" /></th>
</tr><tr>
	<th><a title="afficher chat">Afficher le chat dans la vue g&eacuten&eacuterale</a></th>
	<th><input name="add_chat"{opt_chat_data} type="checkbox" /></th>
</tr><tr>
	<td class="c" colspan="2">{galaxyvision_options}</td>
</tr><tr>
	<th><a title="{spy_cant_tip}">{spy_cant}</a></th>
	<th><input name="spio_anz" maxlength="2" size="2" value="{opt_probe_data}" type="text"></th>
</tr><tr>
	<th>{mess_ammount_max}</th>
	<th><input name="settings_fleetactions" maxlength="2" size="2" value="{opt_fleet_data}" type="text"></th>
</tr><tr>
	<th>{show_ally_logo}</th>
	<th><input name="settings_allylogo"{opt_allyl_data} type="checkbox" /></th>
</tr><tr>
	<th>{shortcut}</th>
	<th>{show}</th>
</tr><tr>
	<th><img src="images/Games/img/e.gif" alt="">   {spy}</th>
	<th><input name="settings_esp"{user_settings_esp} type="checkbox" /></th>
</tr><tr>
	<th><img src="images/Games/img/m.gif" alt="">   {write_a_messege}</th>
	<th><input name="settings_wri"{user_settings_wri} type="checkbox" /></th>
</tr><tr>
	<th><img src="images/Games/img/b.gif" alt="">   {add_to_buddylist}</th>
	<th><input name="settings_bud"{user_settings_bud} type="checkbox" /></th>
</tr>
<tr>
	<th colspan="2"><input value="{save_settings}" name="game" type="submit"></th>
</tr>
{return}
</table>
</form>
</div>