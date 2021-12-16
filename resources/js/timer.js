//타이머 실행함수
window.start_timer = function start_timer(id, flag) {

    clearInterval(timer); // 타이머 우선 초기화 시켜주기(time initialize)

    // 타이머 함수 1초씩 호출하는 함수 만들기
    timer = setInterval("myTimer('"+id+"',"+flag+")", 1000);

  }

  //타이머 함수 flag 값을 이용해 지난 후 로직을 위한 함수를 정의해 이용가능
window.myTimer = function myTimer(value_id, flag=0) {

    time = time - 1; // 타이머 선택 숫자에서 -1씩 감산함(갱신되기 때문)

    var time2 = timer_func(time);
    //console.log("get Id value : "+document.getElementById(id));
    document.getElementById(value_id).innerHTML = time2+"내에 인증해주세요";
    if (time == 0) {
      clearInterval(timer); // 시간 초기화
      //alert("시간이 완료되었습니다.");
      document.getElementById(value_id).innerHTML = "입력시간이 지났습니다. 다시 진행해주세요";
      time = return_time;
      console.log('시간 값 : '+time);
      console.log('리턴시간 값 : '+return_time);

      //지난 후 로직을 위한 함수를 필요한 곳에서 정의
      if(flag != 0){
        //지난 후 사용할 함수 이름
        return_to_sms();
      }
    }
  }

//시간 정지 함수
window.time_stop = function time_stop(value_id){

  time = return_time;
  clearInterval(timer); //타이머 초기화
  document.getElementById(value_id).innerHTML = "";
  console.log('시간 값 : '+time);

}

  //초를 시:분:초로 변경하는 함수
window.timer_func = function timer_func(seconds) {
    //3항 연산자를 이용하여 10보다 작을 경우 0을 붙이도록 처리 하였다.
    //var hour = parseInt(seconds/3600) < 10 ? '0'+ parseInt(seconds/3600) : parseInt(seconds/3600);
    var min = parseInt((seconds%3600)/60) < 10 ? '0'+ parseInt((seconds%3600)/60) : parseInt((seconds%3600)/60);
    var sec = seconds % 60 < 10 ? '0'+seconds % 60 : seconds % 60;
    //연산한 값을 화면에 뿌려주는 코드
    //document.getElementById(id).innerHTML = hour+":"+min+":" + sec;

    //return 값
    //return hour+":"+min+":" + sec;
    return min+":" + sec;
  }