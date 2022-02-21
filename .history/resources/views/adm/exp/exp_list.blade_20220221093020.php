@extends('layouts.admhead')

@section('content')

<!-- datepicker -->
<link rel="stylesheet" href="{{ asset('/datepicker/dist/css/datepicker.min.css') }}">
<script src="{{ asset('/datepicker/dist/js/datepicker.min.js') }}"></script>
<script src="{{ asset('/datepicker/dist/js/i18n/datepicker.ko.js') }}"></script>

        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>평가단 리스트</h2>
                <div class="button_box">
                    <button type="button" onclick="location.href='{{ route('adm_exp_view_create') }}'">평가단 등록</button>
<!--
                    <button type="button" class="gray" onclick="location.href='#'">선택 삭제</button>
-->
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area expr">
            <form>
                <!-- 검색창 시작 -->
                <div class="box_search">
                    <ul>
                        <li>모집시작일</li>
                        <li>
                            <input class="aln_left" type="number" name="exp_date_start" id="exp_date_start" placeholder="">
                            <button type="button" class="btn-sm ddd-ln" onclick="">초기화</button>
                        </li>
                        <li>분류</li>
                        <li>
                            <select>
                                <option>전체</option>
                                <option>욕실</option>
                                <option>└ 치약</option>
                                <option>└ 샴푸바</option>
                            </select>
                            <input class="wd250" type="text" name="" placeholder="">
                        </li>
                    </ul>
                    <button type="button" onclick="">검색</button>
                </div>
                <!-- 검색창 끝-->

                <!-- 보드 시작 -->
                <div class="board">
                    <table>
                        <colgroup>
<!--
                            <col style="width: 40px;">
-->
                            <col style="width: 50px;">
                            <col style="width: 100px;">
                            <col style="width: auto;">
                            <col style="width: 150px;">
                            <col style="width: 195px;">
                            <col style="width: 50px;">
                            <col style="width: 50px;">
                            <col style="width: 100px;">
                            <col style="width: 100px;">
                            <col style="width: 100px;">
                            <col style="width: 50px;">
                            <col style="width: 90px;">
                            <col style="width: 90px;">
                        </colgroup>
                        <thead>
                            <tr>
<!--
                                <th><input type="checkbox" class="mg00" id=""></th>
-->
                                <th>번호</th>
                                <th>이미지</th>
                                <th>제목</th>
                                <th>분류</th>
                                <th>상품</th>
                                <th>모집</th>
                                <th>신청</th>
                                <th>모집기간</th>
                                <th>평가가능기간</th>
                                <th>발표일</th>
                                <th>진행</th>
                                <th colspan="2">관리</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
<!--
                                <td><input type="checkbox" class="mg00" id=""></td>
-->
                                <td>10</td>
                                <td class="thumb"><img src="../../img/img_prod_01.png"></td>
                                <td class="title">
                                    2022 샴푸바 평가단 모집
                                    1차 진행! 어서옵쇼
                                </td>
                                <td class="cate_name">
                                    <div>
                                        욕실
                                        <div>└ 페이셜 클렌징바</div>
                                    </div>
                                </td>
                                <td class="prod_name">
                                    <div>
                                        <div>
                                            <img src="../../img/img_prod_01.png">
                                        </div>
                                        <div>
                                            [대나무샵]친환경칫솔 친환경칫솔친환경칫솔친환경칫
                                        </div>
                                    </div>
                                </td>
                                <td>500</td>
                                <td>1,500</td>
                                <td>2021-11-01~<br>2021-11-31</td>
                                <td>2021-12-01~<br>2021-12-31</td>
                                <td>2022-01-01</td>
                                <td>진행</td>
                                <td><button type="button" class="btn-sm-ln" onclick="location.href='../../page/experience/experience_rgst.html'">수정</button></td>
                                <td><button type="button" class="btn-sm-ln" onclick="">삭제</button></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="mg00" id=""></td>
                                <td>10</td>
                                <td class="thumb"><img src="../../img/img_prod_01.png"></td>
                                <td class="title">
                                    2022 샴푸바 평가단 모집
                                    1차 진행! 어서옵쇼
                                </td>
                                <td class="cate_name">
                                    <div>
                                        욕실
                                        <div>└ 페이셜 클렌징바</div>
                                    </div>
                                </td>
                                <td class="prod_name">
                                    <div>
                                        <div>
                                            <img src="../../img/img_prod_01.png">
                                        </div>
                                        <div>
                                            [대나무샵]친환경칫솔 친환경칫솔친환경칫솔친환경칫
                                        </div>
                                    </div>
                                </td>
                                <td>500</td>
                                <td>1,500</td>
                                <td>2021-11-01~<br>2021-11-31</td>
                                <td>2021-12-01~<br>2021-12-31</td>
                                <td>2022-01-01</td>
                                <td>진행</td>
                                <td><button type="button" class="btn-sm-ln" onclick="location.href='../../page/experience/experience_rgst.html'">수정</button></td>
                                <td><button type="button" class="btn-sm-ln" onclick="">삭제</button></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="mg00" id=""></td>
                                <td>10</td>
                                <td class="thumb"><img src="../../img/img_prod_01.png"></td>
                                <td class="title">
                                    2022 샴푸바 평가단 모집
                                    1차 진행! 어서옵쇼
                                </td>
                                <td class="cate_name">
                                    <div>
                                        욕실
                                        <div>└ 페이셜 클렌징바</div>
                                    </div>
                                </td>
                                <td class="prod_name">
                                    <div>
                                        <div>
                                            <img src="../../img/img_prod_01.png">
                                        </div>
                                        <div>
                                            [대나무샵]친환경칫솔 친환경칫솔친환경칫솔친환경칫
                                        </div>
                                    </div>
                                </td>
                                <td>500</td>
                                <td>1,500</td>
                                <td>2021-11-01~<br>2021-11-31</td>
                                <td>2021-12-01~<br>2021-12-31</td>
                                <td>2022-01-01</td>
                                <td>진행</td>
                                <td><button type="button" class="btn-sm-ln" onclick="location.href='../../page/experience/experience_rgst.html'">수정</button></td>
                                <td><button type="button" class="btn-sm-ln" onclick="">삭제</button></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="mg00" id=""></td>
                                <td>10</td>
                                <td class="thumb"><img src="../../img/img_prod_01.png"></td>
                                <td class="title">
                                    2022 샴푸바 평가단 모집
                                    1차 진행! 어서옵쇼
                                </td>
                                <td class="cate_name">
                                    <div>
                                        욕실
                                        <div>└ 페이셜 클렌징바</div>
                                    </div>
                                </td>
                                <td class="prod_name">
                                    <div>
                                        <div>
                                            <img src="../../img/img_prod_01.png">
                                        </div>
                                        <div>
                                            [대나무샵]친환경칫솔 친환경칫솔친환경칫솔친환경칫
                                        </div>
                                    </div>
                                </td>
                                <td>500</td>
                                <td>1,500</td>
                                <td>2021-11-01~<br>2021-11-31</td>
                                <td>2021-12-01~<br>2021-12-31</td>
                                <td>2022-01-01</td>
                                <td>종료</td>
                                <td><button type="button" class="btn-sm-ln" onclick="location.href='../../page/experience/experience_rgst.html'">수정</button></td>
                                <td><button type="button" class="btn-sm-ln" onclick="">삭제</button></td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- 페이지네이션 시작 -->
                    <div class="paging_box">
                        <div class="paging">
                            <a class="wide">처음</a>
                            <a class="wide">이전</a>
                            <a class="on">1</a>
                            <a>2</a>
                            <a>3</a>
                            <a>4</a>
                            <a>5</a>
                            <a>6</a>
                            <a>7</a>
                            <a>8</a>
                            <a>9</a>
                            <a>10</a>
                            <a class="wide">다음</a>
                            <a class="wide">마지막</a>
                        </div>
                    </div>
                    <!-- 페이지네이션 끝 -->

                </div>
                <!-- 보드 끝 -->
            </form>
        </div>
        <!-- 컨텐츠 영역 끝 -->

<script>
   $(function() {
       //input을 datepicker로 선언
       $("#datepicker").datepicker({
           dateFormat: 'yy-mm-dd' //달력 날짜 형태
           ,showOtherMonths: true //빈 공간에 현재월의 앞뒤월의 날짜를 표시
           ,showMonthAfterYear:true // 월- 년 순서가아닌 년도 - 월 순서
           ,changeYear: true //option값 년 선택 가능
           ,changeMonth: true //option값  월 선택 가능
           ,showOn: "both" //button:버튼을 표시하고,버튼을 눌러야만 달력 표시 ^ both:버튼을 표시하고,버튼을 누르거나 input을 클릭하면 달력 표시
           ,buttonImage: "http://jqueryui.com/resources/demos/datepicker/images/calendar.gif" //버튼 이미지 경로
           ,buttonImageOnly: true //버튼 이미지만 깔끔하게 보이게함
           ,buttonText: "선택" //버튼 호버 텍스트
           ,yearSuffix: "년" //달력의 년도 부분 뒤 텍스트
           ,monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'] //달력의 월 부분 텍스트
           ,monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'] //달력의 월 부분 Tooltip
           ,dayNamesMin: ['일','월','화','수','목','금','토'] //달력의 요일 텍스트
           ,dayNames: ['일요일','월요일','화요일','수요일','목요일','금요일','토요일'] //달력의 요일 Tooltip
           ,minDate: "-5Y" //최소 선택일자(-1D:하루전, -1M:한달전, -1Y:일년전)
           ,maxDate: "+5y" //최대 선택일자(+1D:하루후, -1M:한달후, -1Y:일년후)
       });

       //초기값을 오늘 날짜로 설정해줘야 합니다.
       $('#exp_date_start').datepicker('setDate', 'today'); //(-1D:하루전, -1M:한달전, -1Y:일년전), (+1D:하루후, -1M:한달후, -1Y:일년후)
   });
</script>


<script>
    function exp_modi(num){
        var url = "{{ route('adm_exp_view_restore', ':num') }}";
        url = url.replace(':num', num);
        location.href = url;
    }

    function exp_del(num){
        if (confirm("정말 삭제하시겠습니까?") == true){    //확인
            var url = "{{ route('adm_exp_view_delete', ':num') }}";
            url = url.replace(':num', num);
            location.href = url;
        }else{   //취소
            return false;
        }
    }
</script>


@endsection