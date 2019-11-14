function modify(link)
{
	let inputs = document.getElementById(link).getElementsByTagName("input");

	let newLink = null;
	let newIpunt = null;
	for (var i = 0; i < inputs.length; i++)
	{
		let input = inputs[i];
		if (input.getAttribute("type") == "text" && input.value)
		{
			newLink = input.value;
			newIpunt = input;
		}
	};

	console.log(newLink,newIpunt);
}
