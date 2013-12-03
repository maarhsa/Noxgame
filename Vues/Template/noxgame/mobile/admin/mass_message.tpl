<script language="javascript" type="text/javascript" src="scripts/jquery-1.6.1.min.js"></script>
<table width="750">
	<form id="formular" action="" method="post">
		<tr>
			<td class="c">{MassMessageTitle}</td>
		</tr>
		
		<tr>
			<td class="c">{Subject}</td>
		</tr>
		
		<tr>
			<th>
				<input type="text" name="subject_text" size="200" />
			</th>
		</tr>

		<tr>
			<td class="c">{Message}</td>
		</tr>

		<tr>
			<th>
				<textarea name="message_text" rows="10" cols="40"></textarea>
			</th>
		</tr>

		<tr>
			<td class="c">{Receiver}</td>
		</tr>

		<tr>
			<th style="text-align: left;">
				<input id="c_administrators" type="checkbox" name="c_administrators" />{Administrators}<br />
				<input id="c_operators" type="checkbox" name="c_operators" />{Operators}<br />
				<input id="c_moderators" type="checkbox" name="c_moderators" />{Moderators}<br />
				<input id="c_members" type="checkbox" name="c_members" />{Members}
			</th>
		</tr>

		<tr>
			<th>
				<input id="send" type="submit" name="send" value="{SendMessage}" />
			</th>
		</tr>
	</form>
</table>
<script language="javascript">
	$("#formular").submit(function()
	{
		if ($("#c_administrators").is(":checked") === false && $("#c_operators").is(":checked") === false && $("#c_moderators").is(":checked") === false && $("#c_members").is(":checked") === false )
		{
			alert("Veuillez s\351lectionner au moins un groupe comme exp\351diteur");
			return false;
		}
	});
</script>
		
		