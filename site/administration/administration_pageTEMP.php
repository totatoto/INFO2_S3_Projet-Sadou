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
			echo '<div id="choix_page">';
				echo '<h1>Sélection Pages</h1>';
				echo '<ul>';
				
					$pages = getPages();
					
					$selectedPage = -1;
					
					foreach($pages as $page)
					{
						echo '<li>';
						echo '<input type="radio" name="page_selector" value="page'.$page.'" '.($selectedPage == -1 ? 'checked="checked"' : '').'> Page 1';
						echo '</li>';
						
						if ($selectedPage == -1)
							$selectedPage = $page;
					}
					
					echo <br/>;
					echo $selectedPage;
					echo <br/>;
				
				echo '</ul>';
			echo '</div>';

			// creation de la gestion lien-categ
			echo '<div>';
			// creation de la div currentLinks
			echo '<div id="currentLinks">';
			
			print_r(getLinksOfPage($selectedPage));
			foreach(getLinksOfPage($selectedPage) as $link)
			{
				// création d'une divLink
				echo '<div id="'.$link.'">';
				// création de l'inputLink
				if (isConnected(true))
					echo '<input type="text" class="inputRSS" value="'.$link.'"/>';
				else
					echo '<p>'.$link.'</p>';

				// création du dropDown
				echo '<div class="multiselect">';
				  echo '<div class="selectBox" onclick='."'".'showCheckboxes("link1")'."'".'>';
					echo '<select>';
					  echo '<option>Select categories</option>';
					echo '</select>';
				  echo '</div>';
				  echo '<div class="checkboxes" id="'.$link.'">';
				  
					foreach(getCategsOfLinksOfPage($selectedPage,$link) as $categ)
					{
						echo '<label for="'.$categ.'">';
						echo '<input type="checkbox" name="f2" id="'.$categ.'" />'.$categ.'</label>';
					}
					
				  echo '</div>';
				echo '</div>';

				// création du span
				if (isCoonected(true))
				{
					echo '<span style="float: right; text-align: right;">';
					echo '<input class="favorite styledgreen" type="button" value="Modify" onclick="modifyLinkOfPage('."'".$link."'".')">';
					echo '<input class="favorite styledred" type="button" value="Delete" onclick="deleteLinkOfPage('."'".$link."'".')">';
					echo '</span>';
				}

				echo '</div>';
			}

			echo '</div>';

			// creation de la div InsertLink
			
			if (isConnected(true))
			{
				echo '<div>';
				
				echo '<span style="float: right; text-align: right;">';
				echo '<input class="favorite styledgreen" type="button" value="Insert" onclick="insertLinkOfPage('."'".$selectedPage."'".')">';
				echo '</span>';
				echo '<input type="text" class="inputRSS" value="" hint="insert the Link to add here"/>';
				
				echo '</div>';
			}


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
