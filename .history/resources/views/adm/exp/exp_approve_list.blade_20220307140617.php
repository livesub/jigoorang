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
                            <select name="exp_id" id="exp_id" class="wd800">
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

                        $seach_selected1 = "";
                        $seach_selected2 = "";
                        $seach_selected3 = "";

                        if($seach_select != ""){
                            if($seach_select == "user_name") $seach_selected1 = "selected";
                            else if($seach_select == "user_id") $seach_selected2 = "selected";
                            else if($seach_select == "user_phone") $seach_selected3 = "selected";
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
                <form name="app_form" method="get">
                    <ul>
                        <li>분류</li>
                        <li>
                            <select name="seach_select">
                                <option value="user_name" {{ $seach_selected1 }}>이름</option>
                                <option value="user_id" {{ $seach_selected2 }}>아이디(이메일)</option>
                                <option value="user_phone" {{ $seach_selected3 }}>휴대폰 번호</option>
                            </select>
                            <input class="wd250" type="text" name="seach_keyword" id="seach_keyword" value="{{ $seach_keyword }}">
                        </li>
                    </ul>
                    <button type="submit">검색</button>
                </form>
                </div>
                <!-- 검색창 끝-->

                <!-- 보드 시작 -->
                <div class="board">
                    <!-- 상단 버튼영역 시작 -->
                    <div class="btn_area">
                        <div>
                            <span id="chk_cnt">0</span> / {{ $exp_limit_personnel }}
                        </div>
                        <div class="right">
                            <button type="button" class="btn-ln" onclick="excel_download();">엑셀다운로드</button>
                        </div>
                    </div>
                    <!-- 상단 버튼영역 끝 -->

                    <!-- 평가단 선정 리스트 시작 -->
                    <form name="exp_app_form" id="exp_app_form" method="post" action="" autocomplete="off">
                    {!! csrf_field() !!}
                    <input type="hidden" name="exp_id" id="exp_id_1" value="{{ $exp_app_id }}">
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
                                <th rowspan="2">
                                <!--
                                <input type="checkbox" class="mg00" name="exp_id" id="exp_id" value="{{ $exp_app_id }}">
                                -->
                                <input type="checkbox" class="mg00" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
                                </th>
                                <th rowspan="2">번호</th>
                                <th rowspan="2">아이디</th>
                                <th rowspan="2">이름</th>
                                <th rowspan="2">휴대폰번호</th>
                                <th rowspan="2">평가단참여 이유</th>
                            </tr>
                        </thead>


                        <!-- 리스트 시작 -->
                        @foreach($exp_app_lists as $exp_app_list)
                        @php
                            $exp_info = DB::table('exp_list')->where('id', $exp_app_list->exp_id)->first();

                            $checked = '';
                            if($exp_app_list->access_yn == 'y') $checked = 'checked';

                            //$user_info = DB::table('users')->where('user_id', $exp_app_list->user_id)->first();

                        @endphp
                        <tbody>
                            <tr>
                                <td rowspan="2">
                                <input type="checkbox" class="mg00" name="chk[]" id="chk_{{ $exp_app_list->id }}" value="{{ $exp_app_list->id }}" onclick='checkbox_cnt();' {{ $checked }}></td>
                                <td>{{ $k }}</td>
                                <td>{{ $exp_app_list->user_id }}</td>
                                <td>{{ $exp_app_list->user_name }}</td>
                                <td>{{ $exp_app_list->user_phone }}</td>
                                <td class="usertxt">
                                    {{ $exp_app_list->reason_memo }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="delivery">
                                    <div>배송지 정보</div>
                                    <ul>
                                        <li><span>이름</span>{{ $exp_app_list->ad_name }}</li>
                                        <li><span>주소</span>{{ $exp_app_list->ad_zip1 }}) {{ $exp_app_list->ad_addr1 }} {{ $exp_app_list->ad_addr2 }} {{ $exp_app_list->ad_addr3 }}</li>
                                        <li><span>연락처</span>{{ $exp_app_list->ad_hp }}</li>
                                        <li><span>배송메세지</span>{{ $exp_app_list->shipping_memo }}</li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                        @php
                            $k++;
                        @endphp
                        @endforeach
                        <!-- 리스트 끝 -->
                    </table>
                    <!-- 평가단 선정 리스트 끝 -->

                </div>
                <!-- 보드 끝 -->
            </form>
        </div>
        <!-- 컨텐츠 영역 끝 -->

<script>
    function all_checked(sw) {
        var f = document.itemlist;

        for (var i=0; i<f.length; i++) {
            if (f.elements[i].name == "chk[]")
                f.elements[i].checked = sw;
        }
    }
</script>


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
