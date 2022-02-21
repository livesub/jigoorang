

<!--

<script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>

<table border=1>
    <tr>
        <td>교환 요청</td>
    </tr>
</table>

<table border=1>
    <form name="returnpopform" id="returnpopform" method="post" action="{{ route('return_popup_process') }}">
    {!! csrf_field() !!}
    <input type="hidden" name="order_id" value="{{ $order_id }}">
    <input type="hidden" name="cart_num" value="{{ $cart_num }}">
    <tr>
        <td>작성일자</td>
        <td>{{ $return_regi_date }}</td>
    </tr>
    <tr>
        <td>처리일자</td>
        <td>{{ $return_process_date }}</td>
    </tr>
    <tr>
        <td>사유</td>
        <td>{{ $return_story }}</td>
    </tr>
    <tr>
        <td>상세사유</td>
        <td>{{ $return_story_content }}</td>
    </tr>
    <tr>
        <td>상태</td>
        <td>{{ $return_process_ment }}</td>
    </tr>
    <tr>
        <td>현재수량</td>
        <td>{{ $sct_qty_cancel }}</td>
    </tr>

    <tr>
        <td>처리</td>
        <td>
            <select name="return_process" id="return_process">
                <option value="N" {{ $selected1 }}>미처리</option>
                <option value="Y" {{ $selected2 }}>교환</option>
                <option value="T" {{ $selected3 }}>교환불가</option>
            </select>
        </td>
    </tr>

    <tr>
        <td>교환수량</td>
        <td><input type="text" name="cancel_qty" id="cancel_qty" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">개</td>
    </tr>

    <tr>
        <td><button type="button" onclick="return_proc();">확인</button></td>
    </tr>
    </form>
</table>

<script>
    function return_proc(){
        var ment = "";
        var return_process = $("#return_process option:selected").val();

        switch(return_process) {
            case 'N':
                ment = "미처리 상태를 선택하셨습니다";
            break;
            case 'Y':
                ment = "교환 상태를 선택하셨습니다";
            break;
            case 'T':
                ment = "교환불가 상태를 선택하셨습니다";
            break;
        }

        if($.trim($("#cancel_qty").val()) == ""){
            alert("교환수량을 입력하세요");
            $("#cancel_qty").focus();
            return false;
        }

        if (confirm(ment + "\n선택하신대로 처리하시겠습니까?")) {
            $("#returnpopform").submit();
        }
    }
</script>
-->