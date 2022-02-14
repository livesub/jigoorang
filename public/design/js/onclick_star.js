const drawStar1 = (target) => {
    document.querySelector(`#star_01`).style.width = `${target.value * 20}%`; //값만큼 칠해줌
    document.getElementById('value_01').innerHTML = target.value; //1번 별
    document.getElementById('score1').value = target.value; //1번 별
}
const drawStar2 = (target) => {
    document.querySelector(`#star_02`).style.width = `${target.value * 20}%`; //값만큼 칠해줌
    document.getElementById('value_02').innerHTML = target.value;//2번 별
    document.getElementById('score2').value = target.value; //1번 별
}
const drawStar3 = (target) => {
    document.querySelector(`#star_03`).style.width = `${target.value * 20}%`; //값만큼 칠해줌
    document.getElementById('value_03').innerHTML = target.value;//3번 별
    document.getElementById('score3').value = target.value; //1번 별
}
const drawStar4 = (target) => {
    document.querySelector(`#star_04`).style.width = `${target.value * 20}%`; //값만큼 칠해줌
    document.getElementById('value_04').innerHTML = target.value;//4번 별
    document.getElementById('score4').value = target.value; //1번 별
}
const drawStar5 = (target) => {
    document.querySelector(`#star_05`).style.width = `${target.value * 20}%`; //값만큼 칠해줌
    document.getElementById('value_05').innerHTML = target.value;//5번 별
    document.getElementById('score5').value = target.value; //1번 별
}