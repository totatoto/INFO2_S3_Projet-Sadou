window.addEventListener("load", function() {
  console.log("load fini");
  setInterval(fUpdateRssItems,20000);//120000); // update rss items every 2 minutes
  setInterval(fUpdateLinksCategs,20000);//120000); // update rssLinksCategs every 5 minutes
  fUpdateRssItems();
},false);

function fUpdateRssItems()
{
    var xhttp = new XMLHttpRequest();
    xhttp.addEventListener("readystatechange",function(_event) {fResultUpdateRssItems(xhttp);});
	if (document.getElementById("conteneurItem").getAttribute("linksCategs"))
		xhttp.open("GET", "getRssItems.php?linksCategs=" + document.getElementById("conteneurItem").getAttribute("linksCategs"), true);
    xhttp.send();
}

function fResultUpdateRssItems(req)
{
    if (req.readyState == 4 && req.status == 200) {

        var i = 0;
        var s = "<div class=\"mySlides\">\n";

         resultat = JSON.parse(req.responseText);
         // s string qui contient tous les items suivant une orga donnée à refaire suivant le php exemple
         resultat.forEach(function(element) {
            if (i == 3)
            {
                s += "</div>\n\n<div class=\"mySlides\">\n";
                i=0;
            }
            s += '<p class="RSSTitle">\n' + element["title"] + "\n</p>\n";
            if(element["description"] != null)
            {
                s += element["description"];
            }
            s += '<p class="RSSDate">\n' + element["pub_date"].substr(0,10) + "\n</p>\n";
            i++;
         });

         s += "</div>\n\n";

        document.getElementById("conteneurItem").innerHTML = s;
    }
}

function fUpdateLinksCategs()
{
    var xhttp = new XMLHttpRequest();
    xhttp.addEventListener("readystatechange",function(_event) {fResultUpdateLinksCategs(xhttp);});
	if (document.getElementById("conteneurItem").getAttribute("numpage"))
		xhttp.open("GET", "getRssItems.php?numPage=" + document.getElementById("conteneurItem").getAttribute("numpage"), true);
    xhttp.send();
}

function fResultUpdateLinksCategs(req)
{
    if (req.readyState == 4 && req.status == 200)
	{
		console.log('updated');
        document.getElementById("conteneurItem").setAttribute("linksCategs",req.responseText);
    }
}
