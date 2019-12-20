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
						echo "&nbsp;&nbsp;" . "User :" . "&nbsp" . test_input($_SESSION['pseudo_user']) . "&nbsp;&nbsp;";
					echo '</span>';
					echo "&nbsp;&nbsp;" . date("d/m/Y");
				echo '</div>';
			echo '</header>';

			echo '<button class="bouton_retour" onclick=redirect('."'".'administration.php'."'".')>';
				echo 'Retour';
			echo '</button>';

			// creation de la sélection de la page
			echo '<div id="choix_page">';
				echo '<h1>Sélection Pages</h1>';
				echo '<ul>';

					$pages = getPages();

					$selectedPage = -1;

					foreach($pages as $page)
					{
						echo '<li>';
						echo '<input type="radio" name="page_selector" value="page'.test_input($page).'" '.($selectedPage == -1 ? 'checked="checked"' : '').'> Page 1';
						echo '</li>';

						if ($selectedPage == -1)
							$selectedPage = $page;
					}

				echo '</ul>';
			echo '</div>';

			// creation de la gestion lien-categ
			echo '<div class="central_wrapper" id="central_pages">';
			 echo '<div id="wrapper_droit">';

			// creation de la div currentLinks
			echo '<div id="divCurrentLinks">';

			foreach(getLinksOfPage($selectedPage) as $link)
			{
				// création d'une divLink
				echo '<div id="Link:'.test_input($link).'">';
				// création de l'inputLink
				if (isConnected(true))
					echo '<input type="text" class="inputRSS" value="'.test_input($link).'"/>';
				else
					echo '<p>'.test_input($link).'</p>';

				// création du dropDown
				echo '<div class="multiselect">';
				  echo '<div class="selectBox" onclick='."'".'showCheckboxes("'.test_input($link).'")'."'".'>';
					echo '<select>';
					  echo '<option>Select categories</option>';
					echo '</select>';
					echo '<div class="overSelect"></div>';
				  echo '</div>';
				  echo '<div class="checkboxes" id="'.$link.'">';

					$categsOfLinksOfPage = getCategsOfLinksOfPage($selectedPage,$link);
					foreach(DB::getInstance()->getAllCategoriesOfFluxRss($link) as $categ)
					{
						echo '<label for="'.test_input($categ->getName()).'">';
						echo '<input type="checkbox" id="'.test_input($categ->getName()).'" '.(in_array($categ->getName(),$categsOfLinksOfPage) ? "checked " : "").'/>'.test_input($categ->getName()).'</label>';
					}

				  echo '</div>';
				echo '</div>';

				// création du span
				if (isConnected(true))
				{
					echo '<span style="float: right; text-align: right;">';
					echo '<input class="favorite styledgreen" type="button" value="Modify" onclick="modifyLinkOfPage('."'".test_input($link)."'".')">';
					echo '<input class="favorite styledred" type="button" value="Delete" onclick="deleteLinkOfPage('."'".test_input($link)."'".')">';
					echo '</span>';
				}

				echo '</div>';
			}

			echo '</div>';

			// creation de la div InsertLink

			if (isConnected(true))
			{
				echo '<div id="insertLink_pages">';

				echo '<span style="float: right; text-align: right;">';
				echo '<input class="favorite styledgreen" type="button" value="Insert" onclick="insertLinkOfPage('."'".test_input($selectedPage)."'".')">';
				echo '</span>';
				echo '<input type="text" class="inputRSS" value="" hint="insert the Link to add here"/>';

				echo '</div>';
			}

			echo '</div>';
			echo '</div>';
        }
        else
        {
            echo '<script>document.location.href = "administration_login.php";</script>';
        }
    }
?>
