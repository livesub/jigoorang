// let btn = document.getElementById('btn1');
// let btn2 = document.getElementById('btn2');

// btn.addEventListener("click",function(){
//   btn.classList.toggle('btn-50-active');
// });

// btn2.addEventListener("click",function(){
//   btn2.classList.toggle('btn-50-active');
// });


// let numbtn = document.getElementById('numbtn');
// numbtn.addEventListener("click",function(){
//   numbtn.classList.toggle('btn-50-active');
// });

let btn = document.getElementsByClassName("btn-50");


function handleClick(event) {

  if (event.target.classList[1] === "btn-50-active") {
    event.target.classList.remove("btn-50-active");
  } else {
    for (var i = 0; i < btn.length; i++) {
      btn[i].classList.remove("btn-50-active");
    }
    event.target.classList.add("btn-50-active");
  }
}

function init() {
  for (var i = 0; i < btn.length; i++) {
    btn[i].addEventListener("click", handleClick);
  }
}

init();