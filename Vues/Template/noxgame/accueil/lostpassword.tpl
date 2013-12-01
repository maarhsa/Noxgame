<div class="corp">
	<h1>{ResetPass}</h1>
	<form action="{link}perdu&action=1" method="post">
	<table>
	<tbody><tr>
		 <td colspan="2" class="c"><b>{PassForm}</b></td>
	</tr><tr>
		<th colspan="2">{TextPass1} {servername} {TextPass2}</th>
		</tr>
		  <tr>
		   <th>{pseudo}:</th>
		   <th><input name="pseudo" maxlength="30" size="20" value="" type="text">   </tr>
		   <tr>
		   <th>{email}:</th>
		   <th><input name="email" maxlength="50" size="20" value="" type="text">   </th>
		  </tr>
			   <tr>
			 <th colspan="2"><input value="{ButtonSendPass}" type="submit"></th>
		  </tr>
		</tbody></table>
	</form>
</div>