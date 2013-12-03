<html>
    <head>
        <title>Envoi d'email en masse aux membres</title>
    </head>
    
    <body background="/skins/xnova/img/background2.jpg">
        <center>
            <p><font color=white>Envoi d'email en masse aux membres</font></p>
            <form method="POST" action="email_mass.php?send=ok">
                <p>
                    <font color=white>Titre : </font>
                    <p></p>
                    <textarea name="titre" cols="30" rows="1"></textarea>
                </p>
                <p>
                    <font color=white>Message :</font>
                    <p></p>
                    <textarea name="message" cols="50" rows="20"></textarea>
                </p>
                <INPUT type="submit" value="Envoyer">
            </form>
        </center>
    </body>
</html>