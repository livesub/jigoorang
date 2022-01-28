//일주일 동안 보지 않기 팝업

$( document ).ready(function() { //로드될때 오픈
	cookiedata = document.cookie;
	if ( cookiedata.indexOf("popcookie=done") < 0 ){
		document.getElementById('popup').style.display = "block";
	} else {
		document.getElementById('popup').style.display = "none";
	}
});

function setCookie( name, value, expiredays ) { //쿠키 생성
	var todayDate = new Date();
	todayDate.setDate( todayDate.getDate() + expiredays );
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
}



function closeWin() { //닫기
	document.getElementById('popup').style.display = "none";
}

function daycloseWin() { //일주일동안 보지 않기 쿠키 가져오기

    if(document.getElementById("pop_today").checked){ //체크박스 눌렀을때
        setCookie( "popcookie", "done" , 7 );// 저장될 쿠키명 , 쿠키 value값 , 기간( ex. 1은 하루, 7은 일주일)
       }
	//document.getElementById('popup').style.display = "none";
    closeWin();
}