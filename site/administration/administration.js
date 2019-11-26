// Modify buttons

function modifyLink(oldLink)
{
	let inputs = document.getElementById(oldLink).getElementsByTagName("input");

	let newLink = null;
	for (let i = 0; i < inputs.length; i++)
	{
		let input = inputs[i];
		if (input.getAttribute("type") == "text" && input.value)
		{
			newLink = input.value;
		}
	};

	if (oldLink && newLink)
	{
		let xhttp = new XMLHttpRequest();
		xhttp.addEventListener("readystatechange",function(_event) {resultUpdateRequest(xhttp, oldLink, newLink);});
		xhttp.open("GET", "updateFluxRss.php?oldLink=" + oldLink + "&newLink=" + newLink, true);
		xhttp.send();
	}
	else
	{
		console.log("erreur param");
	}
}

function resultUpdateRequest(req, oldLink, newLink)
{
	if (req.readyState == 4 && req.status == 200) {
		if (req.responseText == "done")
		{
			let div = document.getElementById(oldLink)
			div.setAttribute("id",newLink);

			let inputs = div.getElementsByTagName("span")[0].getElementsByTagName("input");
			for (let i = 0; i < inputs.length; i++)
			{
				let input = inputs[i];
				if (input.getAttribute("type") == "button")
				{

					if (input.getAttribute("type") == "button" && input.value == "Modify")
					{
						input.setAttribute("onclick","modifyLink(" + "'" + newLink + "'" + ")");
					}
					else
					{
						input.setAttribute("onclick","deleteLink(" + "'" + newLink + "'" + ")");
					}
				}
			};
		}
		else
		{
			let inputs = document.getElementById(oldLink).getElementsByTagName("input");
			for (let i = 0; i < inputs.length; i++)
			{
				let input = inputs[i];
				if (input.getAttribute("type") == "text" && input.value)
				{
					input.value = oldLink;
				}
			};
			console.log("erreurRequête");
		}
	}
}


// Delete buttons

function deleteLink(link)
{
	if (link)
	{
		let xhttp = new XMLHttpRequest();
		xhttp.addEventListener("readystatechange",function(_event) {resultDeleteRequest(xhttp, link);});
		xhttp.open("GET", "updateFluxRss.php?deleteLink=" + link, true);
		xhttp.send();
	}
	else
	{
		console.log("erreur param");
	}
}

function resultDeleteRequest(req, link)
{
	if (req.readyState == 4 && req.status == 200) {
		if (req.responseText == "done")
		{
			let div = document.getElementById(link);
			div.remove();
		}
		else
		{
			console.log("erreurRequête");
		}
	}
}


// Insert buttons

function insertLink()
{
	let divInsert = document.getElementById("insertLink");
	let inputs = divInsert.getElementsByTagName("input");

	let newLink = null;
	let newLinkInput = null;

	for (let i = 0; i < inputs.length; i++)
	{
		let input = inputs[i];
		if (input.getAttribute("type") == "text" && input.value)
		{
			newLink = input.value;
			newLinkInput = input;
		}
	};

	if (newLink)
	{
		let xhttp = new XMLHttpRequest();
		xhttp.addEventListener("readystatechange",function(_event) {resultInsertRequest(xhttp, newLink, newLinkInput);});
		xhttp.open("GET", "updateFluxRss.php?insertLink=" + newLink, true);
		xhttp.send();
	}
	else
	{
		console.log("erreur param");
	}
}

function resultInsertRequest(req, link, newLinkInput)
{
	if (req.readyState == 4 && req.status == 200) {
		if (req.responseText == "done")
		{
			let divCurrentLinks = document.getElementById("divCurrentLinks");

			let newDivHtml = '<div id="' + link + '" class="divLinks">';
			newDivHtml += '<span style="float: right; text-align: right;">';
			newDivHtml += '<input class="favorite styledgreen" type="button" value="Modify" onclick="modifyLink(' + "'" + link + "'" + ')">';
			newDivHtml += '&nbsp;&nbsp;&nbsp;';
			newDivHtml += '<input class="favorite styledred" type="button" value="Delete" onclick="deleteLink(' + "'" + link + "'" + ')">';
			newDivHtml += '&nbsp;&nbsp;&nbsp;';
			newDivHtml += '</span>';
			newDivHtml += '<input type="text" class="inputRSS" value="' + link + '"/>';
			newDivHtml += '</div>';

			divCurrentLinks.insertAdjacentHTML('beforeend', newDivHtml);
			newLinkInput.value = "";
		}
		else
		{
			console.log("erreurRequête");
		}
	}
}


// LogOut button

function logOut()
{
	let xhttp = new XMLHttpRequest();
	xhttp.addEventListener("readystatechange",function(_event) {resultLogOutRequest(xhttp);});
	xhttp.open("GET", "../disconnect.php", true);
	xhttp.send();
}


	
function redirect(link)
{
	if ($link)
		document.location.href = link;
}

function resultLogOutRequest(req)
{
	if (req.readyState == 4 && req.status == 200)
	{
		document.location.href = "administration_login.php";
	}
}
