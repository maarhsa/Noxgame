<script language="JavaScript" type="text/javascript" src="script/chat.js"></script>
<br>
<br>
<br>
<table>
    <tbody>
        <tr>
            <td class="c">
                <b>{chat_disc}</b>
            </td>
        </tr>

        <tr>
            <th width="100%">
                <div id="shoutbox" style="margin: 5px; vertical-align: text-top; height: 400px; overflow:auto;"></div>
            </th>
        </tr>



        <tr>
            <th colspan="2">{chat_message} : <input name="msg" type="text" id="msg" size="130" maxlength="100" onKeyPress="if(event.keyCode == 13){ addMessage(); } if (event.keyCode==60 || event.keyCode==62) event.returnValue = false; if (event.which==60 || event.which==62) return false;"> <input type="button" name="send" value="{chat_send}" id="send" onClick="addMessage()"></th>
        </tr>
			<tr><th colspan="2"><img src="images/smileys/cry.gif" align="absmiddle" title=":c" alt=":c" width="15" height="15" onClick="addSmiley(':c')">
		    <img src="images/smileys/confused.gif" align="absmiddle" title=":/" alt=":/" width="15" height="15" onClick="addSmiley(':/')">
		    <img src="images/smileys/dizzy.gif" align="absmiddle" title="o0" alt="o0" width="15" height="15" onClick="addSmiley('o0')">
		    <img src="images/smileys/happy.gif" align="absmiddle" title="^^" alt="^^" width="15" height="15" onClick="addSmiley('^^')">
		    <img src="images/smileys/lol.gif" align="absmiddle" title=":D" alt=":D" width="15" height="15" onClick="addSmiley(':D')">
		    <img src="images/smileys/neutral.gif" align="absmiddle" title=":|" alt=":|" width="15" height="15" onClick="addSmiley(':|')">
		    <img src="images/smileys/smiley.gif" align="absmiddle" title=":)" alt=":)" width="15" height="15" onClick="addSmiley(':)')">
		    <img src="images/smileys/omg.gif" align="absmiddle" title=":o" alt=":o" width="15" height="15" onClick="addSmiley(':o')">
		    <img src="images/smileys/tongue.gif" align="absmiddle" title=":p" alt=":p" width="15" height="15" onClick="addSmiley(':p')">
		    <img src="images/smileys/sad.gif" align="absmiddle" title=":(" alt=":(" width="15" height="15" onClick="addSmiley(':(')">
		    <img src="images/smileys/wink.gif" align="absmiddle" title=";)" alt=";)" width="15" height="15" onClick="addSmiley(';)')">
		    <img src="images/smileys/embarrassed.gif" align="absmiddle" title=":s" alt=":s" width="15" height="15" onClick="addSmiley(':s')">
			<img src="images/smileys/shit.gif" align="absmiddle" title="hihi" alt="hihi" width="15" height="15" onClick="addSmiley('hihi')"></th></tr>
    </tbody>
</table>