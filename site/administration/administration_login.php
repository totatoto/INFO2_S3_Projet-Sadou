<!DOCTYPE html>
<html>
    <?php include("styles/head.php"); ?>

    <body>
        <?php include("styles/header.php"); ?>

		</br>
		<p class="titre"><strong>Page Administration</strong></p>

        <form method="post" action="administration.php">
            <h1 id="connexion">CONNEXION</h1>
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

        <?php include("styles/footer.php"); ?>

    </body>
</html>
