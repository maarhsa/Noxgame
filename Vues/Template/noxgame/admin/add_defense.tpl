				<script>
				function writediv(texte)
				{
				document.getElementById('pseudobox').innerHTML = texte;
				}
				function showUser()
				{
					var targetGalaxy;
					var targetSystem;
					var targetPlanet;
					
					targetGalaxy = document.getElementsByName("gala")[0].value;
					targetSystem = document.getElementsByName("syst")[0].value;
					targetPlanet = document.getElementsByName("plant")[0].value;

				
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
				xmlhttp.open("GET","verif/verifdef.php?galaxie="+ targetGalaxy +"&systeme="+ targetSystem +"&planete="+ targetPlanet,false);
				xmlhttp.send();
				
					// pour visualiser le resultat
					console.log(targetGalaxy+"   -  "+targetSystem+"   -  "+targetPlanet);   
				}
				</script>
<br><br>
<h2>ajout defense</h2>
<form method="POST">
<input type="hidden" name="mode" value="addit">
<table width="305">
<tbody>
<tr>
	<td class="c" colspan="6">{adm_am_form}</td>
</tr>
<tr>
<td class="c" ></td>
<td class="c" >{adm_am_gala}</td>
<td class="c" >{adm_am_syst}</td>
<td class="c" >{adm_am_plant}</td>
<td class="c">{adm_am_type}</td>
</tr><tr>
	<th width="130">{adm_am_coor}</th>
	<th><input name="gala" type="text" size="3" onchange="showUser(this.value)"/></th>
	<th><input name="syst" type="text" size="3" onchange="showUser(this.value)"/></th>
	<th><input name="plant" type="text"size="3" onchange="showUser(this.value)"/></th>
		<th><SELECT name="typeplant">
		<OPTION VALUE="1">{adm_am_plant}</OPTION>
	</SELECT></th>
</tr>
</table><
<br>
{defense}
<br>
<table width="305">
<tr>
	<th colspan="6"><input type="Submit" value="{adm_am_add}" /></th>
</tbody>
</tr>
</table>
</form>