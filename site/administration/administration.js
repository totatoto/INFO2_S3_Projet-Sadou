function modify(link)
{
	let inputs = document.getElementById(link).getElementsByTagName("input");

	let newLink = null;
	inputs.foreach( input =>
		{
			if (input.getAttribute("type") == "text" && input.hasAttribute("value"))
			{
				newLink = input.getAttribute("value");
			}
		}
	)

	console.log(newLink);
}
