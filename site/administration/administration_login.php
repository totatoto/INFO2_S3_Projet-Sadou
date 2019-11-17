<!DOCTYPE html>
<html>
    <?php include("../site_victor/head.php"); ?>

    <body>
        <?php include("../site_victor/header.php"); ?>

		</br>
        </br></br></br>
		<p class="titre">
			<FONT size="8">Page Administration</FONT>
			
        <form method="post" action="administration.php">
            <h1>CONNEXION</h1>
            </br>
                <p>
                    <span>PSEUDO</span>
                    <input type="text" name="pseudo_user"  />
                </p>
                </br>
                <p>
                    <span>PASSWORD</span>
                    <input type="password" name="password_user"  />
                </p>
            </br>
            <input id="send_button" type="submit" value="Send" />
        </form>

        <?php include("../site_victor/footer.php"); ?>

    </body>
</html>
