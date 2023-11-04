document.addEventListener('DOMContentLoaded', load);
function displayForm() {
    var form = document.getElementById("form");
    if (form == null)
        return;
    if (form.style.display == "none") {
        form.style.display = "block";
    }
    else {
        form.style.display = "none";
    }
}
function load() {
    console.log("loading");
    createButton();
    console.log("loaded");
}
function createButton() {
    var element = document.createElement("button");
    element.id = "show-form-button";
    element.onclick = displayForm;
    element.innerHTML = "Dodaj własną grę";
    var container = document.getElementsByClassName("flex-container")[0];
    container.appendChild(element);
    console.log("button added");
}
