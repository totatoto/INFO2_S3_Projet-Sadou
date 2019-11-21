var expanded = new Map();

function showCheckboxes(link) {
var checkboxes = document.getElementById(link);
if (!expanded[link] || expanded[link]==false) {
checkboxes.style.display = "block";
expanded[link] = true;
} else {
checkboxes.style.display = "none";
expanded[link] = false;
}
}
