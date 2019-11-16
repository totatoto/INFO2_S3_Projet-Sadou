<!DOCTYPE html>
<html>
    <?php include("../site_victor/head.php"); ?>

    <body>
        <?php include("../site_victor/header.php"); ?>

		</br></br>
        <div class="formulaire">
            <form method="post" action="administration.php">
                <h1>CONNEXION</h1>
                </br>
                PSEUDO
                </t>
                <input type="text" name="pseudo_user"  />
                </br>
                PASSWORD
                <input type="password" name="password_user"  />
                </br></br>
                <input type="submit" value="Send" />
            </form>
        </div>
        <?php include("../site_victor/footer.php"); ?>

    </body>
</html>
