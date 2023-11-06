document.addEventListener('DOMContentLoaded', load)

function displayForm(): void {
    let form = document.getElementById("form");

    if (form == null) return;

    if(form.style.display == "none") {
        form.style.display = "block";
        sessionStorage.setItem("displayForm", "block")
    }
    else {
        form.style.display = "none";
        sessionStorage.setItem("displayForm", "none")
    }
}

function load(): void {
    createButton();
    modifyForm();
}

function createButton(): void {
    let element: HTMLElement = document.createElement("button");
        element.id = "show-form-button";
        element.onclick = displayForm;
        element.innerHTML = "Dodaj własną grę";

    let container: Element = document.getElementsByClassName("flex-container")[0];
    
    container.appendChild(element);
}

function modifyForm(): void {
    console.log("modifying form buttons...");
    $("[type='text']");
}
