let counterVal = 0;

function incrementClick() {
    updateDisplay(++counterVal);
}

function updateDisplay(val) {
    document.getElementById("conunt").innerHTML = val;
}