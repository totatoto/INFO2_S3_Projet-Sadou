window.addEventListener("load", function() {
  console.log("load fini");
  setInterval(f1,120000);
  f1();
},false);

function f1()
{
    var xhttp = new XMLHttpRequest();
    xhttp.addEventListener("readystatechange",function(_event) {f2(xhttp);});
	if (document.getElementById("conteneurItem").getAttribute("link"))
		xhttp.open("GET", "getRssItems.php?link=" + document.getElementById("conteneurItem").getAttribute("link"), true);
	else
		xhttp.open("GET", "getRssItems.php?links=" + document.getElementById("conteneurItem").getAttribute("links"), true);
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
             s += '<p class="RSSDate">\n' + element["pub_date"] + "\n</p>\n";
             s += element["description"];
             i++;
         });

         s += "</div>\n\n";

        document.getElementById("conteneurItem").innerHTML = s;
    }
}
