                <div class="modal-background" onclick="closemodal_001()"></div>
                <div class="modal-dialog">
                    <div class="top_close" onclick="closemodal_001()"></div>
                    <div class="modal_area">
                    <form name="returnpopform" id="returnpopform" method="post" action="">
                    {!! csrf_field() !!}
                    <input type="hidden" name="order_id" value="{{ $order_id }}">
                    <input type="hidden" name="cart_num" value="{{ $cart_num }}">

                        <h3 class="line">교환 요청</h3>
                        <div class="box_cont">
                            <div class="row">
                                <div class="col">작성일자</div>
                                <div class="col">
                                    {{ $return_regi_date }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">처리일자</div>
                                <div class="col">
                                    {{ $return_process_date }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">사유</div>
                                <div class="col">
                                    {{ $return_story }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">상세사유</div>
                                <div class="col">
                                    <p>
                                    {{ $return_story_content }}
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">상태</div>
                                <div class="col">
                                    {{ $return_process_ment }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col">처리</div>
                                <div class="col">
                                    <select name="return_process" id="return_process">
                                        <option value="N" {{ $selected1 }}>미처리</option>
                                        <option value="Y" {{ $selected2 }}>교환</option>
                                        <option value="T" {{ $selected3 }}>교환불가</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">현재수량</div>
                                <div class="col">
                                    {{ $sct_qty_cancel }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">교환 수량 입력</div>
                                <div class="col">
                                    <input type="number" name="cancel_qty" id="cancel_qty" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');"> 개
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn wd-100" onclick="return_proc();">확인</button>
                        <!-- 버튼 비활성화시 사용 <button type="button" class="btn wd-100 ddd">확인</button> onclick="closemodal_001()"-->
                    </form>
                    </div>
                </div>

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
            var form_var = $("#returnpopform").serialize();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type : 'post',
                url : '{{ route('return_popup_process') }}',
                data : form_var,
                dataType : 'text',
                success : function(result){
                    if(result == "error"){
                        alert("잘못된 경로 입니다");
                        return false;
                    }

                    if(result == "ok"){
                        alert("처리 되었습니다");
                        location.reload();
                    }

                },
                error: function(result){
                    console.log(result);
                },
            });
            //$("#returnpopform").submit();
        }
    }
</script>