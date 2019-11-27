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
            echo '<div id="choix_page">';
                echo '<h1>Sélection</h1>';
                echo '<ul>';
                    echo '<li>';
                        echo '<input type="radio" name="page_selector" value="page1" checked="checked"> Page 1';
                    echo '</li>';
                    echo '<li>';
                        echo '<input type="radio" name="page_selector" value="page2"> Page 2';
                    echo '</li>';
                    echo '<li>';
                        echo '<input type="radio" name="page_selector" value="page3"> Page 3';
                    echo '</li>';
                    echo '<li>';
                        echo '<input type="radio" name="page_selector" value="page4"> Page 4';
                    echo '</li>';
                echo '</ul>';
            echo '</div>';

            echo '<div id="wrapper_droit">';
                echo '<div id="divLinks">';
                    if (isConnected(true))
                    {
                        echo '<span style="float: right; text-align: right;">';
                        echo '<input class="favorite styledgreen" type="button" value="Modify" onclick="modifyLink('."'".$link."'".')">';
                        echo '&nbsp;&nbsp;&nbsp;';
                        echo '<input class="favorite styledred" type="button" value="Delete" onclick="deleteLink('."'".$link."'".')">';
                        echo '&nbsp;&nbsp;&nbsp;';
                        echo '</span>';
                        echo '<input type="text" class="inputRSS" value="'.$link.'"/>';
                    }
                    else
                    {
                        echo '<p>'.$link.'</p>';
                    }

                    if (isConnected(true))
                    {
                        echo '<div id="insertLink">';
                        echo '<span style="float: right; text-align: right;">';
                        echo '<input class="favorite styledgreen" type="button" value="Insert" onclick="insertLink()">';
                        echo '</span>';
                        echo '<input type="text" class="inputRSS" value="" hint="insert the Link to add here"/>';
                        echo '</div>';
                    }
                echo '</div>';
            echo '</div>';
        echo '</div>';
        }
        else
        {
            echo '<script>document.location.href = "administration_login.php";</script>';
        }
    }
?>
