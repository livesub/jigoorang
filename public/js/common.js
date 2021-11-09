/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************!*\
  !*** ./resources/js/common.js ***!
  \********************************/
//쿠키 생성
window.setCookie = function setCookie(cName, cValue, cMinutes) {
  var expire = new Date();
  expire.setMinutes(expire.getMinutes() + cMinutes);
  cookies = cName + '=' + escape(cValue) + '; path=/ '; // 한글 깨짐을 막기위해 escape(cValue)를 합니다.

  if (typeof cMinutes != 'undefined') cookies += ';expires=' + expire.toGMTString() + ';';
  document.cookie = cookies;
}; // 쿠키 가져오기 함수


window.getCookie = function getCookie(cName) {
  cName = cName + '=';
  var cookieData = document.cookie;
  var start = cookieData.indexOf(cName);
  var cValue = '';

  if (start != -1) {
    start += cName.length;
    var end = cookieData.indexOf(';', start);
    if (end == -1) end = cookieData.length;
    cValue = cookieData.substring(start, end);
  }

  return unescape(cValue);
}; //쿠키삭제 


window.deleteCookie = function deleteCookie(name, domain, path) {
  //document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
  document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;domain=' + domain + ';path=' + path + ';';
}; //생년월일(ex: 971029)등의 형식을 받아 만나이구하기


window.get_age = function get_age(yymmdd) {
  var check_y = yymmdd.substr(0, 2);
  console.log("연도 : " + check_y); //현재 날짜 구하기

  var date = new Date();
  var year = date.getFullYear();
  var month = date.getMonth() + 1;
  var day = date.getDate();
  if (month < 10) month = '0' + month;
  if (day < 10) day = '0' + day;
  var monthDay = month + day;
  var checked_y = String(year).substr(2, 2);

  if (check_y <= checked_y) {
    yymmdd = "20" + yymmdd;
    console.log("연도 포함 : " + yymmdd);
  } else {
    yymmdd = "19" + yymmdd;
    console.log("연도 포함 : " + yymmdd);
  }

  var birthdayy = yymmdd.substr(0, 4);
  var birthdaymd = yymmdd.substr(4, 4);
  var age = monthDay < birthdaymd ? year - birthdayy - 1 : year - birthdayy; //return age;

  return age;
};
/******/ })()
;