window.addEventListener("load", function() {
  console.log("load fini");
  setInterval(f1,120000);
  f1();
},false);

function f1()
{
    var xhttp = new XMLHttpRequest();
    xhttp.addEventListener("readystatechange",function(_event) {f2(xhttp);});
    xhttp.open("GET", "getRssItems.php?link=" + document.getElementById("tableItem").getAttribute("link"), true);
    xhttp.send();
}

function f2(req)
{
    if (req.readyState == 4 && req.status == 200) {

        var s = "\n<tr>\n"
        s += "<th>title</th>\n";
        s += "<th>link</th>\n";
        s += "<th>pub_date</th>\n";
        s += "</tr>\n";

         resultat = JSON.parse(req.responseText);
         // s string qui contient tous les items suivant une orga donnée à refaire suivant le php exemple
         resultat.forEach(function(element) {
             s += "<tr>\n";
             s += "<td>" + element["title"] + "</td>\n";
             s += "<td>" + element["link"] + "</td>\n";
             s += "<td>" + element["pub_date"] + "</td>\n";
             s += "</tr>\n";
         });

        document.getElementById("tableItem").innerHTML = s;
    }
}
