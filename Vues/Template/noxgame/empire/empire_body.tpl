<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>

<table width="100%">
	<tr>
		<td class="c" colspan="3">{List_Planets_Title}</td>
	</tr>
	
	<tr>
		<td class="c" colspan="3">Cliquez sur le nom de la plan&egrave;te pour avoir plus d'informations</td>
	</tr>
</table>

<table width="100%">	
	<tr>
		<td class="c">{id}</td>
		<td class="c">{name}</td>
		<td class="c">{coordinates}</td>
	</tr>
	
	{List_Planets}
</table>


<table class="more_infos" width="100%"></table>

<script language="javascript">
	$(".planet_id").click(function()
	{		
		$.ajax
		({
			type: "POST", 
			url: "index.php?page=empire", 
			data: "mode=more_infos&id=" + $(this).attr("id"), 
			success: function(msg)
			{
				if (msg == "Error:0")
					window.alert("Erreur !!! Ce n'est pas votre plan\350te.");
				else
				$(".more_infos").html(msg);
			}
		});
	});
</script>