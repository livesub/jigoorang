let headeron = document.getElementsByClassName("navi_li");


function headerClick(event) {

    if (event.target.classList[1] === "on") {
        event.target.classList.remove("on");
    } else {
        for (var i = 0; i < headeron.length; i++) {
            headeron[i].classList.remove("on");
        }
        event.target.classList.add("on");
    }
}

function init() {
    for (var i = 0; i < headeron.length; i++) {
        headeron[i].addEventListener("click", headerClick);
    }
}

init();