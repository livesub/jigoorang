@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td><h4>추가 배송비 관리</h4></td>
    </tr>
</table>

<table border=1>
<form name="send_form" id="send_form" method="post" action="">
{!! csrf_field() !!}
    <tr>
        <td colspan=4>추가 배송비 내역</td>
    </tr>
    <tr>
        <td><input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)"></td>
        <td>지역명</td>
        <td>우편번호</td>
        <td>추가배송비</td>
    </tr>
    @php
        $i = 0;
    @endphp
    @foreach($sendcosts as $sendcost)
    <tr>
        <td><input type="checkbox" id="chk_{{ $i }}" name="chk[]" value="{{ $sendcost->id }}"></td>
        <td>{{ $sendcost->sc_name }}</td>
        <td>{{ $sendcost->sc_zip1 }} ~ {{ $sendcost->sc_zip2 }}</td>
        <td>{{ number_format($sendcost->sc_price) }}원</td>
    </tr>
    @php
        $i++;
    @endphp
    @endforeach
    <tr>
        <td colspan=4><button type="button" onclick="choice_del()">선택삭제</button></td>
    </tr>
</table>
<table border=1>
    <tr>
        <td>지역명</td>
        <td><input type="text" name="sc_name" id="sc_name"></td>
    </tr>
    <tr>
        <td>우편번호 시작</td>
        <td><input type="text" name="sc_zip1" id="sc_zip1" size=5 maxlength="5">예)01234</td>
    </tr>
    <tr>
        <td>우편번호 끝</td>
        <td><input type="text" name="sc_zip2" id="sc_zip2" size=5 maxlength="5">예)01234</td>
    </tr>
    <tr>
        <td>추가 배송비</td>
        <td><input type="text" name="sc_price" id="sc_price" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" size="5">원</td>
    </tr>
    <tr>
        <td><button type="button" onclick="sendcost_regi();">등록</button></td>
    </tr>
</form>
</table>


<script>
    function sendcost_regi(){
        if($("#sc_name").val() == ""){
            alert("지역명을 입력 하세요.");
            $("#sc_name").focus();alert(result);
            return false;
        }

        if($("#sc_zip1").val() == ""){
            alert("우편번호 시작을 입력 하세요.");
            $("#sc_zip1").focus();
            return false;
        }

        if($("#sc_zip2").val() == ""){
            alert("우편번호 끝을 입력 하세요.");
            $("#sc_zip2").focus();
            return false;
        }

        if($("#sc_price").val() == ""){
            alert("추가 배송비를 입력 하세요.");
            $("#sc_price").focus();
            return false;
        }

        var queryString = $("#send_form").serialize();
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
            type : 'post',
            url : '{{ route('shop.sendcost.ajax_regi_sendcost') }}',
            data : queryString,
            dataType : 'text',
            success : function(result){
                if(result == "ok"){
                    location.href = "{{ route('shop.sendcost.index') }}";
                }
            },
            error: function(result){
                console.log(result);
            },
        });
    }
</script>

<script>
    function check_all(f)
    {
        var chk = document.getElementsByName("chk[]");

        for (i=0; i<chk.length; i++)
            chk[i].checked = f.chkall.checked;
    }
</script>


<script>
    function choice_del(){
        var chk_count = 0;
        var f = document.send_form;

        for (var i = 0; i < f.length; i++) {
            if (f.elements[i].name == "chk[]" && f.elements[i].checked)
                chk_count++;
        }

        if (!chk_count) {
            alert("삭제할 지역을 하나 이상 선택하세요.");
            return false;
        }

        if (confirm("선택 하신 지역을 삭제 하시겠습니까?") == true){    //확인
            var queryString = $("#send_form").serialize();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type : 'post',
                url : '{{ route('shop.sendcost.ajax_del_sendcost') }}',
                data : queryString,
                dataType : 'text',
                success : function(result){
                    if(result == "ok"){
                        alert('삭제 되었습니다.');
                        location.href = "{{ route('shop.sendcost.index') }}";
                    }
                },
                error: function(result){
                    console.log(result);
                },
            });
        }else{
            return;
        }
    }
</script>








@endsection
