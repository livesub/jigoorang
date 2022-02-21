@extends('layouts.admhead')

@section('content')


  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />


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
  $(function(){
    $('.exp_date_start').datepicker();
  })
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