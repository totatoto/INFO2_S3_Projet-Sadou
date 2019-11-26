<?php
    require("../fctAux.inc.php");

    enTete("page administration des pages","styles/style_admin.css","administration.js","styles/icon.bmp");
    contenu();
    pied();

    function contenu()
    {
        if (isConnected(false))
		{
        echo '<header>';
            echo '<div>';
                echo '<span style="float: right; text-align: right;">';
                echo '<input class="favorite styledwhite" type="button" value="Log Out" onclick="logOut()">';
                    echo "&nbsp;&nbsp;" . "User :" . "&nbsp" . $_SESSION['pseudo_user'] . "&nbsp;&nbsp;";
                echo '</span>';
                echo "&nbsp;&nbsp;" . date("d/m/Y");
            echo '</div>';
        echo '</header>';

        echo '<button class="bouton_retour" onclick=redirect('."'".'administration.php'."'".')>';
            echo 'Retour';
        echo '</button>';

        echo '<div class="central_wrapper">';
            echo "Ceci est la page administration des pages";
        echo '</div>';
        }
        else
        {
            echo '<script>document.location.href = "administration_login.php";</script>';
        }
    }
?>
