                <div class="modal-background" onclick="closemodal_001()"></div>
                <div class="modal-dialog">
                    <div class="top_close" onclick="closemodal_001()"></div>
                    <div class="modal_area">
                    <form name="returnpopform" id="returnpopform" method="post" action="{{ route('return_popup_process') }}">
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

