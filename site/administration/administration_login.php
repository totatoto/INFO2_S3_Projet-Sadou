<!DOCTYPE html>
<html>
    <?php include("includes/head.php"); ?>

    <body>
        <?php include("includes/header.php"); ?>

		</br>
        </br></br></br></br>
		<p class="titre"><strong>Page Administration</strong></p>
			
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

        <?php include("includes/footer.php"); ?>

    </body>
</html>
