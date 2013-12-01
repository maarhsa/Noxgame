<script src="http://localhost/Cetus/Vues/scripts/cntchar.js" type="text/javascript"></script>

<br />
<center>
<form action="{link}messages&mode=write&id={id}" method="post">
<table width="519">
<tr>
	<td class="c" colspan="2">{Send_message}</td>
</tr><tr>
	<th>{Recipient}</th>
	<th><input type="text" name="to" size="40" value="{to}" /></th>
</tr><tr>
	<th>{Subject}</th>
	<th><input type="text" name="subject" size="40" maxlength="40" value="{subject}" /></th>
</tr><tr>
	<th>{Message}(<span id="cntChars">0</span> / 5000 {characters})</th>
	<th><textarea name="text" cols="40" rows="10" size="100" onkeyup="javascript:cntchar(5000)">{text}</textarea></th>
</tr>
<tr>

</tr>
<tr>
	<th colspan="2"><input type="reset" value="Effacer" /></th>
</tr><tr>
	<th colspan="2"><input type="submit" value="Envoyer" size="20" style="font-weight:bold" onClick="this.form.submit();this.disabled=true;this.value='Patientez...'"/></th>
</tr><tr>
	<th colspan="2">&Eacute;moticones et BBCode :<br />Vous pouvez utiliser le BBCode et des &eacute;moticones pour embellir vos m&eacute;ssages...<br /><br />Pour utiliser les &eacute;moticones de base fournis par le staff :<br />
	<table>
	<tr>
		<td><img src="images/Games/emoticones/cry.png" alt="pleuré" width="50" height="50" /> = cry</td>
		<td><img src="images/Games/emoticones/dangerous.png" alt="Dangereux" width="50" height="50" /> = dangerous</td>
		<td><img src="images/Games/emoticones/evil.png" alt="demon" width="50" height="50" /> = evil</td>
		<td><img src="images/Games/emoticones/gomennasai.png" alt="gomennasai" width="50" height="50"> = gomennasai</td>
	</tr>
	<tr>
		
		<td><img src="images/Games/emoticones/hoho.png" alt="hoho" width="50" height="50"> = hoho</td>
		<td><img src="images/Games/emoticones/nyu.png" alt="nyu" width="50" height="50"> = nyu</td>
		<td><img src="images/Games/emoticones/reallyangry.png" alt="en colere" width="50" height="50"> = reallyangry</td>
		<td><img src="images/Games/emoticones/shamed.png" alt="géné" width="50" height="50"> = shamed</td>
	</tr>
	<tr>
		
		<td><img src="images/Games/emoticones/socute.png" alt="adoré" width="50" height="50"> = socute</td>
		<td><img src="images/Games/emoticones/sorry.png" alt="désolé" width="50" height="50"> = sorry</td>
		<td><img src="images/Games/emoticones/what.png" alt="quoi" width="50" height="50"> = what</td>
		<td><img src="images/Games/emoticones/xd.png" alt="xd" width="50" height="50"> = xd</td>
	</tr>
	</table>
	Texte en gras = [b]Texte[/b]<br />Texte souligné = [u]Texte[/u]<br />Texte en italliqiue = [i]Texte[/i]<br />Une image = [img]http://liendelimage.com[/img]</th>
</tr>
</table>
</form>
</center>