//
// FLUXRSS ADMINISTRATION
//

// Modify FluxRss Link buttons

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


// Delete FluxRss buttons

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


// Insert FluxRss buttons

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


//
// ACCOUNT ADMINISTRATION
//

// Modify Account buttons

/*function modifyLink(oldLink)
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

*/
// Delete Account buttons

function deleteAccount(username)
{
	if (username)
	{
		let xhttp = new XMLHttpRequest();
		xhttp.addEventListener("readystatechange",function(_event) {resultDeleteAccountRequest(xhttp, username);});
		xhttp.open("GET", "updateAccount.php?deleteUsername=" + username, true);
		xhttp.send();
	}
	else
	{
		console.log("erreur param");
	}
}

function resultDeleteAccountRequest(req, username)
{
	if (req.readyState == 4 && req.status == 200) {
		if (req.responseText == "done")
		{
			let div = document.getElementById(username);
			div.remove();
		}
		else
		{
			console.log("erreurRequête");
		}
	}
}

/*
// Insert FluxRss buttons

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
}*/


//
// UTIL FUNCTION
//


// LogOut button

function logOut()
{
	let xhttp = new XMLHttpRequest();
	xhttp.addEventListener("readystatechange",function(_event) {resultLogOutRequest(xhttp);});
	xhttp.open("GET", "../disconnect.php", true);
	xhttp.send();
}

function resultLogOutRequest(req)
{
	if (req.readyState == 4 && req.status == 200)
	{
		document.location.href = "administration_login.php";
	}
}

// Redirect button

function redirect(link)
{
	if (link)
		document.location.href = link;
}







// JS DROPDOWN
var expanded = new Map();

function showCheckboxes(link) {
var checkboxes = document.getElementById(link);
if (!expanded[link] || expanded[link]==false) {
checkboxes.style.display = "block";
expanded[link] = true;
} else {
checkboxes.style.display = "none";
expanded[link] = false;
}
}
