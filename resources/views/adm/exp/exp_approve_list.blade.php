@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td>
            <h4>체험단 선정</h4>
        </td>
    </tr>
</table>

<table>
    <tr>
        <td>체험단 리스트</td>
        <td>
            <select name="exp_id" id="exp_id">
                @foreach($exp_lists as $exp_list)
                @php
                    $exp_selected = '';
                    if($exp_list->id == $exp_id) $exp_selected = "selected";
                @endphp
                <option value="{{ $exp_list->id }}" {{ $exp_selected }}>{{ $exp_list->title }}</option>
                @endforeach
            </select>
        </td>
    </tr>
</table>
<table border=1>
    @php
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
    <tr>
        <td>체험단명</td>
        <td>{{ stripslashes($exp_info2->title) }}</td>
    <tr>
    <tr>
        <td>모집기간</td>
        <td>{{ $exp_info2->exp_date_start }} ~ {{ $exp_info2->exp_date_end }}</td>
    <tr>
    <tr>
        <td>모집인원</td>
        <td>{{ $exp_info2->exp_limit_personnel }}</td>
    <tr>
    <tr>
        <td>당첨자발표일</td>
        <td>{{ $exp_info2->exp_release_date }}</td>
    <tr>
    <tr>
        <td>평가가능기간</td>
        <td>{{ $exp_info2->exp_review_start }} ~ {{ $exp_info2->exp_review_end }}</td>
    <tr>
    @endif
</table>

<table>
    <tr>
        <td><span id="chk_cnt">0</span> / {{ $exp_info2->exp_limit_personnel }}</td>
        <td>신청인원 {{ number_format($total_record) }} 명
        <td><button type="button" onclick="exp_app_ok();">선정</button></td>
    </tr>
</table>

<form name="exp_app_form" id="exp_app_form" method="post" action="" autocomplete="off">
{!! csrf_field() !!}
<input type="hidden" name="exp_id" id="exp_id" value="{{ $exp_info2->id }}">
<table border=1>
    <tr>
        <td>선택</td>
        <td>번호</td>
        <td>아이디</td>
        <td>이름</td>
        <td>휴대폰번호</td>
    </tr>

    @foreach($exp_app_lists as $exp_app_list)
        @php
            $exp_info = DB::table('exp_list')->where('id', $exp_app_list->exp_id)->first();

            $checked = '';
            if($exp_app_list->access_yn == 'y') $checked = 'checked';

            $user_info = DB::table('users')->where('user_id', $exp_app_list->user_id)->first();
        @endphp

    <tr>
        <td colspan=6>
            <table border=1>
                <tr>
                    <td><input type="checkbox" name="chk[]" id="chk_{{ $exp_app_list->id }}" value="{{ $exp_app_list->id }}" onclick='checkbox_cnt();' {{ $checked }}></td>
                    <td>{{ $k }}</td>
                    <td>{{ $exp_app_list->user_id }}</td>
                    <td>{{ $exp_app_list->user_name }}</td>
                    <td>{{ $user_info->user_phone }}</td>
                </tr>
                <tr>
                    <td>평가단 참여이유</td>
                    <td colspan=5>{{ $exp_app_list->reason_memo }}</td>
                </tr>
                <tr>
                    <td>배송메모</td>
                    <td colspan=5>{{ $exp_app_list->shipping_memo }}</td>
                </tr>

                <tr>
                    <td>배송지</td>
                    <td colspan=5>({{ $exp_app_list->ad_zip1 }}) {{ $exp_app_list->ad_addr1 }} {{ $exp_app_list->ad_addr2 }} {{ $exp_app_list->ad_addr3 }}</td>
                </tr>
            </table>
        </td>
    </tr>
        @php
            $k++;
        @endphp
    @endforeach
</table>


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






@endsection