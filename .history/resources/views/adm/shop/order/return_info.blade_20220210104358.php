<script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>

<table border=1>
    <tr>
        <td>교환 요청</td>
    </tr>
</table>

<table border=1>
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
                <option value="N">미처리</option>
                <option value="Y">교환</option>
                <option value="T">교환불가</option>
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
</table>

<script>
    function return_proc(){
        var ment = "";
        var return_process = $("#return_process option:selected").val();

        switch(return_process) {
            case 'N':
                ment = "미처리";
            break;
            case 'Y':
                ment = "교환";
            break;
            case 'T':
                ment = "교환불가";
            break;
        }

        if($.trim($("#cancel_qty").val()) == ""){

        }
    }
</script>