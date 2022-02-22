@extends('layouts.admhead')

@section('content')

        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>회원 관리</h2>
                <div class="button_box">
                    <button type="button" onclick="mem_out();">탈퇴/가입 처리</button>
                    <button type="button" class="gray" onclick="mem_regi('regi');">회원등록</button>
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area member">

            <!-- 가이드 문구 시작 -->
            <div class="box_guide">
                <ul>
                    <li>총회원 : {{ number_format($totalCount) }}명</li>
                    <li>탈퇴회원 : {{ number_format($member_draw) }}명</li>
                    <li>평가단 블랙리스트 : {{ number_format($member_blacklist) }}명</li>
                    <li>사이트 블랙리스트 : {{ number_format($member_site_access_no) }}명</li>
                </ul>
            </div>
            <!-- 가이드 문구 끝-->

            <form>

                <!-- 검색창 시작 -->
                <div class="box_search">
                    <ul>
                        <li>분류</li>
                        <li>
                            <select>
                                <option>전체</option>
                                <option>회원</option>
                                <option>탈퇴회원</option>
                                <option>체험단 블랙리스트</option>
                                <option>사이트 블랙리스트</option>
                            </select>
                            <select>
                                <option>아이디</option>
                                <option>이름</option>
                                <option>휴대폰 번호</option>
                            </select>
                            <input type="text" name="" placeholder="">
                        </li>
                    </ul>
                    <button type="button" onclick="">검색</button>
                </div>
                <!-- 검색창 끝-->

                <!-- 보드 시작 -->
                <div class="board">
                    <!-- 회원 리스트 시작 -->
                    <table class="member_table">
                        <colgroup>
                            <col style="width: 40px;">
                            <col style="width: 80px;">
                            <col style="width: 150px;">
                            <col style="width: auto;">
                            <col style="width: 160px;">
                            <col style="width: 120px;">
                            <col style="width: 80px;">
                            <col style="width: 80px;">
                            <col style="width: 60px;">
                            <col style="width: 140px;">
                            <col style="width: 140px;">
                        </colgroup>
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="mg00" id=""></th>
                                <th>번호</th>
                                <th>이름</th>
                                <th>아이디</th>
                                <th>가입일</th>
                                <th>휴대폰 번호</th>
                                <th>가입경로</th>
                                <th>포인트</th>
                                <th>상태</th>
                                <th>평가단 블랙리스트</th>
                                <th>사이트 블랙리스트</th>
                            </tr>
                        </thead>
                        <!-- 리스트 시작 -->
                        <tbody>
                            <tr>
                                <td><input type="checkbox" class="mg00" id=""></td>
                                <td>10</td>
                                <td><a href="../../page/member/member_detail.html">지구랭</a></td>
                                <td>g9g9g9@g9r.com</td>
                                <td>2021-11-01 13:13:12</td>
                                <td>01021543265</td>
                                <td>회원가입</td>
                                <td>5,000</td>
                                <td>가입</td>
                                <td>X</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="mg00" id=""></td>
                                <td>10</td>
                                <td><a href="../../page/member/member_detail.html">지구랭</a></td>
                                <td>g9g9g9@g9r.com</td>
                                <td>2021-11-01 13:13:12</td>
                                <td>01021543265</td>
                                <td>회원가입</td>
                                <td>5,000</td>
                                <td>가입</td>
                                <td>X</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="mg00" id=""></td>
                                <td>10</td>
                                <td><a href="../../page/member/member_detail.html">지구랭</a></td>
                                <td>g9g9g9@g9r.com</td>
                                <td>2021-11-01 13:13:12</td>
                                <td>01021543265</td>
                                <td>카카오</td>
                                <td>5,000</td>
                                <td>가입</td>
                                <td>X</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="mg00" id=""></td>
                                <td>10</td>
                                <td><a href="../../page/member/member_detail.html">지구랭</a></td>
                                <td>g9g9g9@g9r.com</td>
                                <td>2021-11-01 13:13:12</td>
                                <td>01021543265</td>
                                <td>네이버</td>
                                <td>5,000</td>
                                <td>가입</td>
                                <td>X</td>
                                <td>X</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="mg00" id=""></td>
                                <td>10</td>
                                <td><a href="../../page/member/member_detail.html">지구랭</a></td>
                                <td>g9g9g9@g9r.com</td>
                                <td>2021-11-01 13:13:12</td>
                                <td>01021543265</td>
                                <td>회원가입</td>
                                <td>5,000</td>
                                <td>탈퇴</td>
                                <td>X</td>
                                <td>Y</td>
                            </tr>
                        </tbody>
                        <!-- 리스트 끝 -->

                    </table>
                    <!-- 리뷰 리스트 끝 -->

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

<form action="" id="mem_form" method="GET">
    <input type="hidden" name="mode" id="mode">
    <input type="hidden" name="num" id="num">
</form>

<script>
    function mem_regi(value, num=''){
        $("#mode").val(value);
        $("#num").val(num);
        $("#mem_form").attr("action", "member/member_regi");
        $("#mem_form")[0].submit();
    }
</script>

<script>
    function all_checked(sw) {
        var f = document.memlist;

        for (var i=0; i<f.length; i++) {
            if (f.elements[i].name == "chk_id[]")
                f.elements[i].checked = sw;
        }
    }

    function mem_out(){
        var chk_count = 0;
        var f = document.memlist;

        for (var i = 0; i < f.length; i++) {
            if (f.elements[i].name == "chk_id[]" && f.elements[i].checked)
                chk_count++;
        }

        if (!chk_count) {
            alert("탈퇴/가입 할 회원을 한명 이상 선택하세요.");
            return false;
        }
        if (confirm("탈퇴 회원은 가입 처리 되며, 가입자는 탈퇴 처리 됩니다.\n회원 정보는 삭제 되지 않습니다.\n선택 하신 회원을 탈퇴/가입 하시겠습니까?") == true){    //확인
            f.submit();
        }else{
            return;
        }
    }
</script>

<script>
    function user_type_change(val){
        location.href = "{{ route('adm.member.index') }}?user_type="+val;
    }
</script>


@endsection
