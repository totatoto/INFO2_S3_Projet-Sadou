document.addEventListener("DOMContentLoaded", function() {
  setInterval(f1,120000);
});

function f1()
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = f2();
    xhttp.open("GET", "ajax_info.php", true);
    xhttp.send();
}

function f2()
{
    if (this.readyState == 4 && this.status == 200) {
         resultat = JSON.parse(this.responseText);
         // s string qui contient tous les items suivant une orga donnée à refaire suivant le php exemple
         s = resultat.forEach(function(element) {
             console.log(element);
            })

        document.getElementById("tableItem").innerHTML = s;
    }
}
