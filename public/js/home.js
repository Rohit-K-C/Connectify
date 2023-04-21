function settings() {
    var element = document.getElementById("set");
    if (element.style.display === "block") {
        element.style.display = "none";
    } else {
        element.style.display = "block";
    }
}

window.addEventListener("scroll", function () {
    var element = document.getElementById("set");
    element.style.display = "none";
});


