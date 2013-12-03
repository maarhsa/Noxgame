<br>Production Actuelle:
<script  type="text/javascript">
v  = new Date();
p  = 0;
g  = {b_hangar_id_plus};
d  = {d};
s  = 0;
hs = 0;
of = 1;
c  = new Array({c}'');
b  = new Array({b}'');
a  = new Array({a}'');
aa = '{completed}';

function t() {
	if ( hs == 0 ) {
		xd();
		hs = 1;
	}
	n = new Date();
	s = c[p] - g - Math.round((n.getTime() - v.getTime()) / 1000.);
	s = Math.round(s);
	m = 0;
	h = 0;
	if ( s < 0 ) {
		a[p]--;
		xd();
		if ( a[p] <= 0 ) {
			p++;
			xd();
		}
		g = 0;
		v = new Date();
		s = 0;
	}
	if ( s > 59 ) {
		m = Math.floor(s / 60);
		s = s - m * 60;
	}
	if ( m > 59 ) {
		h = Math.floor(m / 60);
		m = m - h * 60;
	}
	if ( s < 10 ) {
		s = "0" + s;
    }
    if (m < 10) {
      m = "0" + m;
	}
	if ( p > b.length - 2 ) {
		document.getElementById("bx").innerHTML=aa ;
    } else {
		document.getElementById("imgds").innerHTML='<img class="build" src="images/Games/item/'+ d +'.png">';
		document.getElementById("namesthi").innerHTML=b[p];
		document.getElementById("tempsd").innerHTML=h+":"+m+":"+s;
    }
	window.setTimeout("t();", 200);
}

function xd() {
	while (document.Atr.auftr.length > 0) {
		document.Atr.auftr.options[document.Atr.auftr.length-1] = null;
	}
	
	if ( p > b.length - 2 ) {
		document.Atr.auftr.options[document.Atr.auftr.length] = new Option(aa);
	}
	for ( iv = p; iv <= b.length - 2; iv++ ) {
		if ( a[iv] < 2 ) {
			ae = " ";
		} else {
			ae = " ";
		}
		if ( iv == p ) {
			act = " ({in_working})";
			document.getElementById("number").innerHTML=a[iv];
			document.getElementById("name").innerHTML=b[iv] ;
		} else {
			act = "";
		}
		//document.getElementById("number").innerHTML=a[iv];
		document.Atr.auftr.options[document.Atr.auftr.length] = new Option( a[iv] + ae + " \"" + b[iv] + "\"" + act, iv + of );
	}
}

window.onload = t;
</script>
<br />
<form name="Atr" method="POST" action="{link}chantier&type=inventaire">
<table class=construct>

<tr>
<td id=imgds></td> 
<td id=namesthi ></td> 
<td id=tempsd ></td>
<td class="c" ><select name="auftr" size="10"></select></td>
</tr>
<tr>
<td colspan=2>Terminer maintenant</td>
<td><span id=name></span> : <i><span id=number></span></i></td> 
<td ><input type=submit name=finish value=terminer /></td> 
</tr>
</table>
</form>
<br />
{total_left_time} {pretty_time_b_hangar}<br></center>
<br />