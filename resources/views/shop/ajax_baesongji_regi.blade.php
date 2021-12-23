<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="{{ asset('/js/zip.js') }}"></script>
<script src="{{ asset('/design/js/modal-back02.js') }}"></script>

    <div class="modal-background" onclick="addressclosemodal_001()"></div>
        <div class="modal-container">
           <div class="modal-container-body adress">

            <div class="modal-container-title">
                 <h4>배송지 입력</h4>
                 <div class="btn-close" onclick="addressclosemodal_001()"></div>
            </div>

            <div class="adress_input">
                    <label for="">수령인</label>
                    <input type="text" name="od_c_name" id="od_c_name">

                    <label for="">휴대폰</label>
                    <input type="text" name="od_c_hp" id="od_c_hp" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="11">

                <div class="adress_input02">
                    <p>배송지</p>
                    <input type="text" name="od_c_zip" id="od_c_zip" readonly required class="adress_input03" maxlength="6" placeholder="우편번호">
                    <label for="">
                        <button type="button" class="btn_address adress_input03_btn" onclick="win_zip('wrap_c','od_c_zip', 'od_c_addr1', 'od_c_addr2', 'od_c_addr3', 'od_c_addr_jibeon', 'btnFoldWrap_c');">우편번호 찾기</button>
                    </label>
                </div>

                <div class="adress_input04">
                    <div id="wrap_c" class="adress_pop"><!-- 다음 우편번호 찾기  -->
                        <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap_c" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" alt="접기 버튼">
                    </div>


                    <input type="text" name="od_c_addr1" id="od_c_addr1" required size="60" placeholder="기본주소" readonly>
                    <input type="text" name="od_c_addr2" id="od_c_addr2" size="60" placeholder="상세주소">
                    <input type="text" name="od_c_addr3" id="od_c_addr3" readonly="readonly" size="60" placeholder="참고항목">
                    <input type="hidden" name="od_c_addr_jibeon" id="od_c_addr_jibeon" value="">
                </div>
            </div>

            <div class="checkbox"><!-- 체크박스 시작 -->
                  <input type="checkbox" name="ad_default" id="ad_default" value="1">
                  <label for="">기본배송지 등록</label>
            </div><!-- 체크박스 끝 -->
        </div>
            <div class="btn btn_2ea"><!-- 버튼 시작 -->
                <button class="modal_btn01" type="button" onclick="addressclosemodal_001()">
                    닫기
                </button>
                <button class="modal_btn02" type="button" onclick="baesongji_regi();">
                    등록
                </button>
            </div><!-- 버튼 끝 -->

    </div>


<script>
    function baesongji_regi(){
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
            url : '{{ route('ajax_baesongji_save') }}',
            data : form_var,
            dataType : 'text',
            success : function(result){
                if(result == "ok"){
                    //baesongji();
                    location.reload();
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