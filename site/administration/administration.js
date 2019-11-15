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
					input.setValue(oldLink);
				}
			};
			console.log("erreurRequête");
		}
	}
}


// Delete buttons

function deleteLink(link)
{
	let linkElem = document.getElementById(link);

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
