<?php
    require("../fctAux.inc.php");

    enTete("page administration","styles/style_admin.css","administration.js","styles/icon.bmp");
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

        echo '<div class="central_wrapper">';
            echo '<p id="admin_pages" class="choix_type_admin">';
                echo '<a title="Administration des pages" href="administration_pages.php">Administration des pages</a>';
            echo '</p>';
            echo '<p id="admin_flux" class="choix_type_admin">';
                echo '<a title="Administration des flux RSS" href="administration_flux.php">Administration des flux RSS</a>';
            echo '</p>';
            echo '<p id="admin_categories" class="choix_type_admin">';
                echo '<a title="Administration des catégories" href="administration_categories.php">Administration des catégories</a>';
            echo '</p>';
            echo '<p id="admin_comptes" class="choix_type_admin">';
                echo '<a title="Administration des comptes" href="administration_users.php">Administration des comptes</a>';
            echo '</p>';
        echo '</div>';
    }
?>
