"use strict";
document.addEventListener('DOMContentLoaded', load);
function displayForm() {
    let form = document.getElementById("form");
    if (form == null)
        return;
    if (form.style.display == "none") {
        form.style.display = "block";
        sessionStorage.setItem("displayForm", "block");
    }
    else {
        form.style.display = "none";
        sessionStorage.setItem("displayForm", "none");
    }
}
function load() {
    createButton();
    modifyForm();
}
function createButton() {
    let element = document.createElement("button");
    element.id = "show-form-button";
    element.onclick = displayForm;
    element.innerHTML = "Dodaj własną grę";
    let container = document.getElementsByClassName("flex-container")[0];
    container.appendChild(element);
}
function modifyForm() {
    console.log("modifying form buttons...");
    $("[type='text']");
}
