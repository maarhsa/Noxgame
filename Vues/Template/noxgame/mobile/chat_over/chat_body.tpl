
<style>

</style>
</head>
<script language="JavaScript" type="text/javascript" src="script/chat.js"></script>

<table align="center">
    <tbody>
        <tr>
            <td height="60" class="c" style="font-size:13px;color:white">
                <b>{chat_disc}</b>
            </td>
        </tr>

        <tr>
            <th width="100">
                <div id="shoutbox" style="color:white;font-size:13px;margin: 5px; vertical-align: text-top; height: 140px; overflow:auto;"></div>
            </th>
        </tr>



        <tr width="100">
           <th colspan="1"><input style="margin-top:-5px;border-radius:7px;border:1px solid black" name="msg" type="text" id="msg" size="45" maxlength="45" onKeyPress="if(event.keyCode == 13){ addMessage(); } if (event.keyCode==60 || event.keyCode==62) event.returnValue = false; if (event.which==60 || event.which==62) return false;"> <input type="image" name="send" value="{chat_send}" id="send" onClick="addMessage()" src="http://stargate-adventure.com/design/image/fond_active.jpg"></th>
        </tr>
    </tbody>
</table>