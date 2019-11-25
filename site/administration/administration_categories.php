<?php
    require("../fctAux.inc.php");

    enTete("page administration des catégories","styles/style_admin.css",NULL,"styles/icon.bmp");
    contenu();
    pied();

    function contenu()
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

        echo "Ceci est la page administration des catégories";
    }
?>
