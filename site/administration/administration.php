<?php
    require("../fctAux.inc.php");

    enTete("page administration","styles/style_admin.css","administration.js","styles/icon.bmp");
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

        echo '<div class="central_wrapper">';
            echo '<button id="admin_pages" class="choix_type_admin" onclick=redirect('."'".'administration_pages.php'."'".')>';
                echo 'Administration des pages';
            echo '</button>';
            echo '<button id="admin_flux" class="choix_type_admin" onclick=redirect('."'".'administration_flux.php'."'".')>';
                echo 'Administration des flux RSS';
            echo '</button>';
            echo '<button id="admin_categories" class="choix_type_admin" onclick=redirect('."'".'administration_categories.php'."'".')>';
                echo 'Administration des catégories';
            echo '</button>';
            echo '<button id="admin_comptes" class="choix_type_admin" onclick="redirect('."'".'administration_users.php'."'".')">';
                echo 'Administration des comptes';
            echo '</button>';
        echo '</div>';
        }
        else
        {
            echo '<script>document.location.href = "administration_login.php";</script>';
        }
    }
?>
