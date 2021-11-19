var menu_on = false;

function toggleMenu(){
    menu_on = !menu_on;
    let wrapper = document.getElementsByClassName("wrapper")[0];
    let menu = document.getElementsByClassName("menu_items")[0];
    let cross = document.getElementById("menu");
    if (menu_on){
        menu.style.display = "block";
        menu.style.transform = "translateX(100%)";
        setTimeout(animateIn, 100);
    }
    else{
        wrapper.style.opacity = "1";
        menu.style.zIndex = "0";
        menu.style.visibility = "hidden";
        menu.style.transform = "translateX(96%)";
        cross.style.transform = "rotate(0deg)";
        setTimeout(displayNone, 2000);
    }   
}

function displayNone(){
    let menu = document.getElementsByClassName("menu_items")[0];
    let wrapper = document.getElementsByClassName("wrapper")[0];
    let cross = document.getElementById("menu");
    menu.style.display = "none";
    wrapper.style.position = "auto";
    cross.style.color = "#555454"; //"#69a73b";
    cross.style.backgroundColor = "white";

}

function animateIn(){
    let wrapper = document.getElementsByClassName("wrapper")[0];
    let menu = document.getElementsByClassName("menu_items")[0];
    let cross = document.getElementById("menu"); 
    wrapper.style.position = "absolute";
    wrapper.style.opacity = "0.5";
    menu.style.zIndex = "1";
    menu.style.transition = "all 2s";
    menu.style.transform = "translateX(0%)";
    menu.style.visibility = "visible";
    cross.style.transform = "rotate(45deg)";
    cross.style.backgroundColor = "#69a73b";
    cross.style.color = "white";
    wrapper.style.width = "100%";
}

/*
function lightsupLangs(){
    let mangs = document.getElementsByClassName("mang");
    let archs = document.getElementsByClassName("arch");
    for (let i = 0; i < mangs.length; i++){
        mangs[i].style.opacity= "0.1";
    }
    for (let i = 0; i < archs.length; i++){
        archs[i].style.opacity= "0.3";
    }
    document.getElementById("management").style.opacity = "0.1";
    document.getElementById("architecture").style.opacity = "0.1";
}

function lightsoutLangs(){
    let mangs = document.getElementsByClassName("mang");
    let archs = document.getElementsByClassName("arch");
    for (let i = 0; i < mangs.length; i++){
        mangs[i].style.opacity= "1";
    }
    for (let i = 0; i < archs.length; i++){
        archs[i].style.opacity= "1";
    }
    document.getElementById("management").style.opacity = "1";
    document.getElementById("architecture").style.opacity = "1";
}

function lightsupMangs(){
    let mangs = document.getElementsByClassName("lang");
    let archs = document.getElementsByClassName("arch");
    for (let i = 0; i < mangs.length; i++){
        mangs[i].style.opacity= "0.1";
    }
    for (let i = 0; i < archs.length; i++){
        archs[i].style.opacity= "0.3";
    }
    document.getElementById("languages").style.opacity = "0.1";
    document.getElementById("architecture").style.opacity = "0.1";
}

function lightsoutMangs(){
    let mangs = document.getElementsByClassName("lang");
    let archs = document.getElementsByClassName("arch");
    for (let i = 0; i < mangs.length; i++){
        mangs[i].style.opacity= "1";
    }
    for (let i = 0; i < archs.length; i++){
        archs[i].style.opacity= "1";
    }
    document.getElementById("languages").style.opacity = "1";
    document.getElementById("architecture").style.opacity = "1";
}

function lightsupArchs(){
    let mangs = document.getElementsByClassName("mang");
    let archs = document.getElementsByClassName("lang");
    for (let i = 0; i < mangs.length; i++){
        mangs[i].style.opacity= "0.1";
    }
    for (let i = 0; i < archs.length; i++){
        archs[i].style.opacity= "0.3";
    }
    document.getElementById("management").style.opacity = "0.1";
    document.getElementById("languages").style.opacity = "0.1";
}

function lightsoutArchs(){
    let mangs = document.getElementsByClassName("mang");
    let archs = document.getElementsByClassName("lang");
    for (let i = 0; i < mangs.length; i++){
        mangs[i].style.opacity= "1";
    }
    for (let i = 0; i < archs.length; i++){
        archs[i].style.opacity= "1";
    }
    document.getElementById("management").style.opacity = "1";
    document.getElementById("languages").style.opacity = "1";
}
*/