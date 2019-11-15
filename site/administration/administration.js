function modify(oldLink)
{
	let inputs = document.getElementById(oldLink).getElementsByTagName("input");

	let newLink = null;
	for (var i = 0; i < inputs.length; i++)
	{
		let input = inputs[i];
		if (input.getAttribute("type") == "text" && input.value)
		{
			newLink = input.value;
		}
	};

	if (oldLink && newLink)
	{
		var xhttp = new XMLHttpRequest();
		xhttp.addEventListener("readystatechange",function(_event) {resultRequest(xhttp);});
		xhttp.open("GET", "updateFluxRss.php?oldLink=" + oldLink + "&newLink=" + newLink, true);
		xhttp.send();
	}
	else
	{
		console.log("erreur param");
	}
}

function updateIHM()
{

}

function resultRequest(req)
{
	if (req.readyState == 4 && req.status == 200) {
		if (req.responseText == "Done")
		{
			updateIHM();
		}
		else
		{
			console.log("erreurRequête");
		}
	}
}
