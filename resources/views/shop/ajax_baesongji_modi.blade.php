<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="{{ asset('/js/zip.js') }}"></script>

<table border=1>
<input type="hidden" name="num" id="num" value="{{ $baesongji->id }}">
    <tr>
        <td>배송지 수정</td>
    </tr>
    <tr>
        <td>
            @php
                $ad_default_chk = '';
                if($baesongji->ad_default == 1) $ad_default_chk = 'checked';
            @endphp
            <input type="checkbox" name="ad_default" id="ad_default" value="1" {{ $ad_default_chk }}>
            <label for="ad_default">기본배송지로 설정</label>
        </td>
    </tr>
    <tr>
        <td>수령인</td>
        <td><input type="text" name="od_c_name" id="od_c_name" value="{{ $baesongji->ad_name }}"></td>
    </tr>

    <tr>
        <th scope="row">주소</th>
        <td id="sod_frm_addr">
            <label for="od_c_zip" class="sound_only">우편번호<strong class="sound_only"> 필수</strong></label>
            <input type="text" name="od_c_zip" id="od_c_zip" readonly required class="frm_input required" size="8" maxlength="6" placeholder="우편번호" value="{{ $baesongji->ad_zip1 }}">
            <button type="button" class="btn_address" onclick="win_zip('wrap_c','od_c_zip', 'od_c_addr1', 'od_c_addr2', 'od_c_addr3', 'od_c_addr_jibeon', 'btnFoldWrap_c');">주소 검색</button>
<div id="wrap_c" style="display:none;border:1px solid;width:500px;height:300px;margin:5px 0;position:relative">
    <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap_c" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" alt="접기 버튼">
</div>
            <br>
            <input type="text" name="od_c_addr1" id="od_c_addr1" required class="frm_input frm_address required" size="60" placeholder="기본주소" value="{{ $baesongji->ad_addr1 }}" readonly>
            <label for="od_c_addr1" class="sound_only">기본주소<strong> 필수</strong></label><br>
            <input type="text" name="od_c_addr2" id="od_c_addr2" class="frm_input frm_address" size="60" placeholder="상세주소" value="{{ $baesongji->ad_addr2 }}">
            <label for="od_c_addr2" class="sound_only">상세주소</label>
            <br>
            <input type="text" name="od_c_addr3" id="od_c_addr3" readonly="readonly" class="frm_input frm_address" size="60" placeholder="참고항목" value="{{ $baesongji->ad_addr3 }}">
            <label for="od_c_addr3" class="sound_only">참고항목</label><br>
            <input type="hidden" name="od_c_addr_jibeon" id="od_c_addr_jibeon" value="{{ $baesongji->ad_jibeon }}">
        </td>
    </tr>

    <tr>
        <td>핸드폰</td>
        <td><input type="text" name="od_c_hp" id="od_c_hp" value="{{ $baesongji->ad_hp }}" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"></td>
    </tr>
    <tr>
        <td>
            <button type="button" onclick="baesongji_modi();">수정</button>
            <button type="button" onclick="baesongji_cancel();">취소</button>
        </td>
    </tr>
</table>


<script>
    function baesongji_modi(){
        if($.trim($("#od_c_name").val()) == ""){
            alert("수령인 이름을 입력해 주세요.");
            $("#od_c_name").focus();
            return false;
        }

        if($.trim($("#od_c_zip").val()) == ""){
            alert("주소 검색을 하세요.");
            $("#od_c_zip").focus();
            return false;
        }

        if($.trim($("#od_c_addr1").val()) == ""){
            alert("배송지 주소를 입력해 주세요.");
            $("#od_c_addr1").focus();
            return false;
        }

        if($.trim($("#od_c_addr2").val()) == ""){
            alert("배송지 상세 주소를 입력 하세요.");
            $("#od_c_addr2").focus();
            return false;
        }

        if($.trim($("#od_c_hp").val()) == ""){
            alert("휴대폰 번호를 입력해 주세요.");
            $("#od_c_hp").focus();
            return false;
        }

        var form_var = $("#forderform").serialize();

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
            type : 'post',
            url : '{{ route('ajax_baesongji_modify_save') }}',
            data : form_var,
            dataType : 'text',
            success : function(result){
                if(result == "ok"){
                    alert("수정 되었습니다.");
                    baesongji();
                }
            },
            error: function(result){
                console.log(result);
            },
        });
    }

    function baesongji_cancel(){
        baesongji();
    }
</script>