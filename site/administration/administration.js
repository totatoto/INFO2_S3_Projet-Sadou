function modify(link)
{
	let inputs = document.getElementById(link).getElementsByTagName("input");

	let newLink = null;
	for (var i = 0; i < inputs.length; i++)
	{
		let input = inputs[i];
		if (input.getAttribute("type") == "text" && input.hasAttribute("value"))
		{
			newLink = input.getAttribute("value");
		}
	};

	console.log(newLink);
}
