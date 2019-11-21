window.addEventListener("load", function() {
  console.log("load fini");
  setInterval(f1,120000);
  f1();
},false);

function f1()
{
    var xhttp = new XMLHttpRequest();
    xhttp.addEventListener("readystatechange",function(_event) {f2(xhttp);});
	if (document.getElementById("conteneurItem").getAttribute("linksCategs"))
		xhttp.open("GET", "getRssItems.php?linksCategs=" + document.getElementById("conteneurItem").getAttribute("linksCategs"), true);
    xhttp.send();
}

function f2(req)
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
