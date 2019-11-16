<!DOCTYPE html>
<html>
    <?php include("../site_victor/head.php"); ?>

    <body>
        <?php include("../site_victor/header.php"); ?>

		</br></br>

        <form method="post" action="administration.php">
            <p>
                PSEUDO
                </t>
                <input class="max_box" type="text" name="pseudo_user"  />
                </br>
                PASSWORD
                <input class="max_box" type="password" name="password_user"  />
                </br></br>
                <input class="max_box" type="submit" value="Send" />
            </p>
        </form>

        <?php include("../site_victor/footer.php"); ?>

    </body>
</html>
