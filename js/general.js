var menu_on = false;        // needed for the toggleMenu
cart_array = [];            // needed for the shopping cart
N = 20;                    // maximum value for a productID
// we initialize the array with zero quantities
for (let i = 1; i <= N; ++i){
    cart_array.push([i, 0]);
}
/*
class Order {
    constructor(userID, productArray, quantityArray){
        this.userID = userID;
        this.productVector = new Array();
        this.quantityVector = new Array();
    }
}
*/
/*
function filterProducts(filter){
    const filter_menuElem = document.getElementById("filter_menu");
    const prod_containerElem = document.getElementById("prod_container");
}
*/

function change_cart(id){
    index = Number(id);
    cart_array[index][1]++;
    xhr = new XMLHttpRequest();
    if (xhr == null){
        alert ("Problem creating the XMLHttpRequest object");
    }
    else{
        var url = "text";
    }
}

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

function validatePassword(){
    let password1 = document.getElementById("js_pass");
    let password2 = document.getElementById("js_pass_rep");
    if (password1.value == " ")
    {
        alert("Please insert a password");
    }
    else if (password2.value == " ")
    {
        alert("Please repeat your password");
    }
    else if (password1.value != password2.value)
    {
        alert("\nPasswords did not match: Please try again ...");
    }
}

