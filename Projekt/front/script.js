function displayForm() {
    
    console.log("I'm alive!");
    let form = document.getElementById("form");
    // let computedStyle = window.getComputedStyle(form).display;
    // let currentStyle = form.style.display; 

    // if (currentStyle == "") currentStyle = computedStyle;
    // console.log("computed:"+ computedStyle);
    // console.log("set:"+ currentStyle);

    // if (currentStyle == "none") currentStyle = "block";
    // else if (currentStyle == "block") currentStyle = "none";
    // console.log("update:"+ currentStyle);

    if(form.style.display == "none") {
        form.style.display = "block"
    }
    else {
        form.style.display = "none"
    }
}