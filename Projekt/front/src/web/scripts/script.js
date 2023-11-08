document.addEventListener('DOMContentLoaded', load);
function displayForm(display) {
    var form = document.getElementById("form");
    if (form == null)
        return;
    form.style.display = display;
    sessionStorage.setItem("displayForm", display);
}
function displayFormOnClick() {
    var form = document.getElementById("form");
    if (form == null)
        return;
    if (form.style.display == "none") {
        displayForm("block");
    }
    else {
        displayForm("none");
    }
}
function displayFormOnLoad() {
    var display = sessionStorage.getItem("displayForm");
    if (display == null)
        return;
    displayForm(display);
}
function load() {
    if ($("header h1")[0].innerHTML == "Forum") {
        createButton();
        displayFormOnLoad();
        modifyForm();
    }
    if ($("#page")[0].innerHTML == "Kolekcja") {
        $("#tabs").tabs(); //fixme: open tab on nav click
        // @ts-ignore
        $('a').smoothScroll();
    }
}
function createButton() {
    var element = document.createElement("button");
    element.id = "show-form-button";
    element.onclick = displayFormOnClick;
    element.innerHTML = "Dodaj własną grę";
    var container = document.getElementsByClassName("flex-container")[0];
    container.appendChild(element);
}
function modifyForm() {
    $("#show-form-button").button();
}
