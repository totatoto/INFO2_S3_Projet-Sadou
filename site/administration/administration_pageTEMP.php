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

        // creation de la sélection de la page
        echo '<div>';

        echo '</div>';

        // creation de la gestion lien-categ
        echo '<div>';
        // creation de la div currentLinks
        echo '<div id="currentLinks">';

        foreach(getLinksOfPage($selectedPage) as $link)
        {
            // création d'une divLink
            echo '<div id="'.$link.'">';
            // création de l'inputLink
            echo '<input type="text" value="'.$link.'"/>';

            // création du dropDown
            echo ''

            // création du span
            echo '<span style="float: right; text-align: right;">';
            echo '<input class="favorite styledgreen" type="button" value="Modify" onclick="modifyLinkOfPage('."'".$link."'".')">';
            echo '<input class="favorite styledred" type="button" value="Delete" onclick="deleteLinkOfPage('."'".$link."'".')">';
            echo '</span>';

            echo '</div>'
        }

        echo '</div>';

        // creation de la div InsertLink
        echo '<div>';

        echo '</div>';

        // FIN creation de la div InsertLink
        echo '</div>';

        // FIN creation de la gestion lien-categ
        echo '</div>';
        }
        else
        {
            echo '<script>document.location.href = "administration_login.php";</script>';
        }
    }
?>
