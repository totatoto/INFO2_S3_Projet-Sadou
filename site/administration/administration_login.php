<!DOCTYPE html>
<html>
    <?php include("../site_victor/head.php"); ?>

    <body>
        <?php include("../site_victor/header.php"); ?>
    
        <form method="post" action="administration.php">
            <p>
                PSEUDO
                </t>
                <input type="text" name="pseudo_user"  />
                </br>
                PASSWORD
                <input type="password" name="password_user"  />
                </br></br>
                <input type="submit" value="Send" />
            </p>
        </form>
        
        <?php include("../site_victor/footer.php"); ?>
        
    </body>
</html>