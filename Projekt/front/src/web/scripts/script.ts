document.addEventListener('DOMContentLoaded', load)

function displayForm(display: string): void {
    let form = document.getElementById("form");
    if (form == null) return;

    form.style.display = display;
    sessionStorage.setItem("displayForm", display);
}

function displayFormOnClick(): void {
    let form = document.getElementById("form");
    if (form == null) return;

    if(form.style.display == "none") {
        displayForm("block");
    }
    else {
        displayForm("none");
    }
}

function displayFormOnLoad(){
    let display = sessionStorage.getItem("displayForm");
    if (display == null) return;

    displayForm(display);
}

function load(): void {
    createButton();

    displayFormOnLoad();
    modifyForm();
}

function createButton(): void {
    let element: HTMLElement = document.createElement("button");
        element.id = "show-form-button";
        element.onclick = displayFormOnClick;
        element.innerHTML = "Dodaj własną grę";

    let container: Element = document.getElementsByClassName("flex-container")[0];
    
    container.appendChild(element);
}

function modifyForm(): void {
    console.log("modifying form...");
    $("#show-form-button").button();
    $("form").resizable({
        handles: "n, e, s, w"
    });
}
//todo use jquery ui plugin


//todo find new jquery plugin