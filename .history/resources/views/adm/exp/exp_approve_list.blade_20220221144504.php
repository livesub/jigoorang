@extends('layouts.admhead')

@section('content')

        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>평가단 선정</h2>
                <div class="button_box">
                    <button type="button" onclick="exp_app_ok();">평가단 선정</button>
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area expr">
            <form>
                <div class="box_cont">
                    <div class="row">
                        <div class="col">평가단 리스트</div>
                        <div class="col">
                            <select name="exp_id" id="exp_id" class="wd800"
                                @foreach($exp_lists as $exp_list)
                                @php
                                    $exp_selected = '';
                                    if($exp_list->id == $exp_id) $exp_selected = "selected";
                                @endphp
                                <option value="{{ $exp_list->id }}" {{ $exp_selected }}>{{ $exp_list->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                    @php
                        $exp_limit_personnel = 0;
                        $exp_app_id = 0;

                        if($exp_id == ''){
                            if(is_null($exp_last)){
                                $exp_info2 = DB::table('exp_list')->first();
                            }else{
                                $exp_info2 = DB::table('exp_list')->where('id', $exp_last->id)->first();
                            }

                        }else{
                            $exp_info2 = DB::table('exp_list')->where('id', $exp_id)->first();
                        }

                        $k = 1;
                    @endphp

                    @if(!is_null($exp_last))
                    @php
                        $exp_limit_personnel = $exp_info2->exp_limit_personnel;
                        $exp_app_id = $exp_info2->id;
                    @endphp
                        <div class="col">평가단명</div>
                        <div class="col">
                            {{ stripslashes($exp_info2->title) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">모집인원</div>
                        <div class="col">
                            {{ number_format($exp_limit_personnel) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">신청인원</div>
                        <div class="col">
                            {{ number_format($total_record) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">모집기간</div>
                        <div class="col">
                            {{ $exp_info2->exp_date_start }} ~ {{ $exp_info2->exp_date_end }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">평가가능기간</div>
                        <div class="col">
                            {{ $exp_info2->exp_review_start }} ~ {{ $exp_info2->exp_review_end }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">발표일</div>
                        <div class="col">
                            {{ $exp_info2->exp_release_date }}
                        </div>
                    </div>
                @endif
                </div>

                <!-- 검색창 시작 -->
                <div class="box_search">
                    <ul>
                        <li>분류</li>
                        <li>
                            <select>
                                <option>이름</option>
                                <option>아이디(이메일)</option>
                                <option>휴대폰 번호</option>
                            </select>
                            <input class="wd250" type="text" name="" placeholder="">
                        </li>
                    </ul>
                    <button type="button" onclick="">검색</button>
                </div>
                <!-- 검색창 끝-->

                <!-- 보드 시작 -->
                <div class="board">
                    <!-- 상단 버튼영역 시작 -->
                    <div class="btn_area">
                        <div>
                            0 / 100
                        </div>
                        <div class="right">
                            <button type="button" class="btn-ln" onclick="">엑셀다운로드</button>
                        </div>
                    </div>
                    <!-- 상단 버튼영역 끝 -->

                    <!-- 평가단 선정 리스트 시작 -->
                    <table class="ord_table">
                        <colgroup>
                            <col style="width: 40px;">
                            <col style="width: 60px;">
                            <col style="width: 200px;">
                            <col style="width: 130px;">
                            <col style="width: 130px;">
                            <col style="width: auto;">
                        </colgroup>
                        <thead>
                            <tr>
                                <th rowspan="2"><input type="checkbox" class="mg00" id=""></th>
                                <th rowspan="2">번호</th>
                                <th rowspan="2">아이디</th>
                                <th rowspan="2">이름</th>
                                <th rowspan="2">휴대폰번호</th>
                                <th rowspan="2">평가단참여 이유</th>
                            </tr>
                        </thead>
                        <!-- 리스트 시작 -->
                        <tbody>
                            <tr>
                                <td rowspan="2"><input type="checkbox" class="mg00" id=""></td>
                                <td>10</td>
                                <td>kim9ryong@gmail.com</td>
                                <td>지구랭</td>
                                <td>01021219898</td>
                                <td class="usertxt">
                                    일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="delivery">
                                    <div>배송지 정보</div>
                                    <ul>
                                        <li><span>이름</span>지구랭</li>
                                        <li><span>주소</span>경기도 지구시 지구10길 111동 100호(지구동, 지구아파트)</li>
                                        <li><span>연락처</span>01012359875</li>
                                        <li><span>배송메세지</span>안녕!</li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                        <!-- 리스트 끝 -->
                        <!-- 리스트 시작 -->
                        <tbody>
                            <tr>
                                <td rowspan="2"><input type="checkbox" class="mg00" id=""></td>
                                <td>9</td>
                                <td>kim9ryong@gmail.com</td>
                                <td>지구랭</td>
                                <td>01021219898</td>
                                <td class="usertxt">
                                    1213213154545452312312132123131 23231231231321313
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="delivery">
                                    <div>배송지 정보</div>
                                    <ul>
                                        <li><span>이름</span>지구랭</li>
                                        <li><span>주소</span>경기도 지구시 지구10길 111동 100호(지구동, 지구아파트)</li>
                                        <li><span>연락처</span>01012359875</li>
                                        <li><span>배송메세지</span>안녕!</li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                        <!-- 리스트 끝 -->
                        <!-- 리스트 시작 -->
                        <tbody>
                            <tr>
                                <td rowspan="2"><input type="checkbox" class="mg00" id=""></td>
                                <td>8</td>
                                <td>kim9ryong@gmail.com</td>
                                <td>지구랭</td>
                                <td>01021219898</td>
                                <td class="usertxt">
                                    일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="delivery">
                                    <div>배송지 정보</div>
                                    <ul>
                                        <li><span>이름</span>지구랭</li>
                                        <li><span>주소</span>경기도 지구시 지구10길 111동 100호(지구동, 지구아파트)</li>
                                        <li><span>연락처</span>01012359875</li>
                                        <li><span>배송메세지</span>안녕!</li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                        <!-- 리스트 끝 -->
                        <!-- 리스트 시작 -->
                        <tbody>
                            <tr>
                                <td rowspan="2"><input type="checkbox" class="mg00" id=""></td>
                                <td>7</td>
                                <td>kim9ryong@gmail.com</td>
                                <td>지구랭</td>
                                <td>01021219898</td>
                                <td class="usertxt">
                                    일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="delivery">
                                    <div>배송지 정보</div>
                                    <ul>
                                        <li><span>이름</span>지구랭</li>
                                        <li><span>주소</span>경기도 지구시 지구10길 111동 100호(지구동, 지구아파트)</li>
                                        <li><span>연락처</span>01012359875</li>
                                        <li><span>배송메세지</span>안녕!</li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                        <!-- 리스트 끝 -->
                        <!-- 리스트 시작 -->
                        <tbody>
                            <tr>
                                <td rowspan="2"><input type="checkbox" class="mg00" id=""></td>
                                <td>6</td>
                                <td>kim9ryong@gmail.com</td>
                                <td>지구랭</td>
                                <td>01021219898</td>
                                <td class="usertxt">
                                    일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="delivery">
                                    <div>배송지 정보</div>
                                    <ul>
                                        <li><span>이름</span>지구랭</li>
                                        <li><span>주소</span>경기도 지구시 지구10길 111동 100호(지구동, 지구아파트)</li>
                                        <li><span>연락처</span>01012359875</li>
                                        <li><span>배송메세지</span>안녕!</li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                        <!-- 리스트 끝 -->
                        <!-- 리스트 시작 -->
                        <tbody>
                            <tr>
                                <td rowspan="2"><input type="checkbox" class="mg00" id=""></td>
                                <td>5</td>
                                <td>kim9ryong@gmail.com</td>
                                <td>지구랭</td>
                                <td>01021219898</td>
                                <td class="usertxt">
                                    일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="delivery">
                                    <div>배송지 정보</div>
                                    <ul>
                                        <li><span>이름</span>지구랭</li>
                                        <li><span>주소</span>경기도 지구시 지구10길 111동 100호(지구동, 지구아파트)</li>
                                        <li><span>연락처</span>01012359875</li>
                                        <li><span>배송메세지</span>안녕!</li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                        <!-- 리스트 끝 -->
                        <!-- 리스트 시작 -->
                        <tbody>
                            <tr>
                                <td rowspan="2"><input type="checkbox" class="mg00" id=""></td>
                                <td>4</td>
                                <td>kim9ryong@gmail.com</td>
                                <td>지구랭</td>
                                <td>01021219898</td>
                                <td class="usertxt">
                                    일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공일이삼사오륙칠팔구공
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="delivery">
                                    <div>배송지 정보</div>
                                    <ul>
                                        <li><span>이름</span>지구랭</li>
                                        <li><span>주소</span>경기도 지구시 지구10길 111동 100호(지구동, 지구아파트)</li>
                                        <li><span>연락처</span>01012359875</li>
                                        <li><span>배송메세지</span>안녕!</li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                        <!-- 리스트 끝 -->
                    </table>
                    <!-- 평가단 선정 리스트 끝 -->

                </div>
                <!-- 보드 끝 -->
            </form>
        </div>
        <!-- 컨텐츠 영역 끝 -->


<script>
    $("#exp_id").change(function(){
        location.href = "{{ route('adm.approve.index') }}?exp_id="+$(this).val();
    });
</script>

<script>
    var checked_cnt = $('input[name="chk[]"]:checked').length;
    $("#chk_cnt").html(checked_cnt);

    function checkbox_cnt(){
        checked_cnt = $('input[name="chk[]"]:checked').length;
        $("#chk_cnt").html(checked_cnt);
    }
</script>

<script>

    function exp_app_ok(){

/*
        var chk_cnt = $('input[name="chk[]"]:checked').length;
        if(chk_cnt == 0){
            alert('한명 이상 선택 하세요.');
            return false;
        }
*/
        if (confirm("승인/취소 처리 하시겠습니까?") == true){    //확인
            var form_var = $("#exp_app_form").serialize();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type : "post",
                url : "{{ route('adm.approve.approve_ok') }}",
                data : form_var,
                dataType : 'text',
                success : function(result){
    //alert(result);
    //return false;
                    if(result == 'no'){
                        alert('잘못된 경로 입니다.');
                        return false;
                    }

                    if(result == 'yes'){
                        alert('승인/취소 처리 되었습니다.');
                        location.reload();
                    }
                },
                error: function(result){
                    console.log(result);
                },
            });
        }else{   //취소
            return false;
        }
    }
</script>

<script>
    function excel_download(){
        location.href = "{{ route('adm.exceldown') }}?exp_id="+$("#exp_id").val();
    }
</script>




@endsection