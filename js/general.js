var menu_on = false;        // needed for the toggleMenu

// Functions to update the Shopping Cart Quantity Number
function createQueryStringToUpdateCart(id){
    var items_in_cart = parseInt(document.getElementById("counter").innerHTML) + 1;
    var queryString = "n_items=" + items_in_cart + "&id_article=" + id;
    return queryString;
}

function change_cart(id){
    xhr = new XMLHttpRequest();
    if (xhr == null){
        alert("Problem creating the XMLHttpRequest object");
    }
    else {
        var url = "./scripts/update_cart.php?timeStamp=" + new Date().getTime();
        var queryString = createQueryStringToUpdateCart(id);

        xhr.onreadystatechange = showCartNumber;
        xhr.open("POST", url, true);  // true for asynchronous!!
        /* add an HTTP header with setRequestHeader().
        Specify the data you want to send in the send() method,
        in this case you specify the data in the format of a form
        */
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(queryString);
    }
}

function showCartNumber(){
    var items_in_cart = parseInt(document.getElementById("counter").innerHTML) + 1;
    var counter = document.getElementById("counter");
    if (xhr.readyState == 4) {
        if (xhr.status == 200) {
            counter.innerHTML = items_in_cart;
        }
    }
}
// End of functions to update Cart Quantity Number

// Functions to update the total price of the Order
function createQueryStringToUpdatetotal(){
    var cart_items = document.getElementsByClassName("cart_items");
    var set_number = cart_items.length;
    var total_to_pay = 0;
    for (let i = 0; i < set_number; ++i){
        total_to_pay += parseFloat(cart_items[i].value) * parseFloat(cart_items[i].id);
    }
    var queryString = "new_total=" + total_to_pay;
    return queryString;
}

function onlyNaturals(e){
    // The static strin.fromCharCode() method returns a string created from the specified sequence of UTF-16 code units.
    var ch = String.fromCharCode(e.which)
    if(!(/[0-9]/.test(ch))){
        e.preventDefault();
        alert("The field quantity can only contain natural numbers: 0, 1, 2, 3, ...");
    }
}

function updateTotal(){
    xhr = new XMLHttpRequest();
    if (xhr == null){
        alert("Problem creating the XMLHttpRequest object");
    }
    else {
        var url = "./scripts/update_cart.php?timeStamp=" + new Date().getTime();
        var queryString = createQueryStringToUpdatetotal();

        xhr.onreadystatechange = showTotalPrice;
        xhr.open("POST", url, true);  // true for asynchronous!!
        /* add an HTTP header with setRequestHeader().
        Specify the data you want to send in the send() method,
        in this case you specify the data in the format of a form
        */
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(queryString);
    }
}

function showTotalPrice(){
    var cart_items = document.getElementsByClassName("cart_items");
    var set_number = cart_items.length;
    var total_to_pay = 0;
    var regex = new RegExp('^[0-9][0-9]*$');
    for (let i = 0; i < set_number; ++i){
        if (!regex.test(cart_items[i].value)){
            break;
        }
        total_to_pay += parseFloat(cart_items[i].value) * parseFloat(cart_items[i].id);
    }
    if (xhr.readyState == 4) {
        if (xhr.status == 200) {
            document.getElementById("total_price").innerHTML = "Total: &euro;" + total_to_pay.toFixed(2).toString();
        }
    }
}
// End of functions to update the Total price of the Order



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
