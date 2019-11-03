window.addEventListener("load", function() {
  console.log("load fini");
  setInterval(f1,120000);
  f1();
},false);

window.addEventListener("load", initGestionEvents, false);

function f1()
{
    console.log("f1 appelee");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = f2();
    xhttp.open("GET", "5.50.179.242/sit/getRssItems.php", true);
    xhttp.send();
}

function f2()
{
    if (this.readyState == 4 && this.status == 200) {
         console.log("retour reçu");
         resultat = JSON.parse(this.responseText);
         // s string qui contient tous les items suivant une orga donnée à refaire suivant le php exemple
         s = resultat.forEach(function(element) {
             console.log(element);
            })

        document.getElementById("tableItem").innerHTML = s;
    }
}
