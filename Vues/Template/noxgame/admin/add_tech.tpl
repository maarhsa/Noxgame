				<script>
				function showUser(str)
				{
				if (str=="")
				  {
				  document.getElementById("txtHint").innerHTML="";
				  return;
				  }
				if (window.XMLHttpRequest)
				  {// code for IE7+, Firefox, Chrome, Opera, Safari
				  xmlhttp=new XMLHttpRequest();
				  }
				else
				  {// code for IE6, IE5
				  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				  }
				xmlhttp.onreadystatechange=function()
				  {
					  if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
								document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
						}
				  }
				xmlhttp.open("GET","verif/veriftech.php?idpseudo="+str,false);
				xmlhttp.send();
				}
				</script>
<br><br>
<h2>Ajout de Technologie</h2>
<form method="POST" action="">
<input type="hidden" name="mode" value="addit">
<br>
<table width="519">
<tbody>
<tr>
	<td class="c" colspan="6">{adm_am_form}</td>
</tr>
<tr>
<td class="c" >Pseudo</td>
</tr><tr>
<th>{select}</th>
</tr>
</table>
<br>
{tech}
<br>
<table width="519">
<tr>
	<th colspan="6"><input type="Submit" value="{adm_am_add}" /></th>
</tbody>
</tr>
</table>
</form>