document.onclick = function(event) {
    var el = event.target;
    if (/add_cart_([0-9]+)]/.test(el.id)) {
        alert("div.new clicked");
    }
};