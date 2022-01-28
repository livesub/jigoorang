let nav = document.getElementById("Sidenav");
let background = document.querySelector(".background");

function openNav() {
    nav.style.width = "320px";
    nav.style.display = "block";
    background.style.display = "block";
}

function closeNav() {
    nav.style.width = "0";
    nav.style.overflow = "hidden";
    background.style.display = "none";
}