document.addEventListener('DOMContentLoaded', load)

function displayForm(): void {
    let form: HTMLElement = document.getElementById("form");

    if (form == null) return;

    if(form.style.display == "none") {
        form.style.display = "block"
    }
    else {
        form.style.display = "none"
    }
}

function load(): void {
    console.log("loading");
    createButton();
    console.log("loaded");
}

function createButton(): void {
    let element: HTMLElement = document.createElement("button");
        element.id = "show-form-button";
        element.onclick = displayForm;
        element.innerHTML = "Dodaj własną grę";

    let container: Element = document.getElementsByClassName("flex-container")[0];
    
    container.appendChild(element);

    console.log("button added");
}

