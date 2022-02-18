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
                                    파손 및 불량
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">상세사유</div>
                                <div class="col">
                                    <p>
                                    개봉하니 제품이 다 망가져서 왔어요. 그냥 반품 처리 할게요. 당장 오늘 필요했던거라 교환할 시간이 없네요빠른처리 부탁드립니다.
                                    개봉하니 제품이 다 망가져서 왔어요. 그냥 반품 처리 할게요. 당장 오늘 필요했던거라 교환할 시간이 없네요빠른처리 부탁드립니다.
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">상태</div>
                                <div class="col">
                                    미처리
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col">처리</div>
                                <div class="col">
                                    <select>
                                        <option>미처리</option>
                                        <option>교환</option>
                                        <option>교환 불가</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">현재수량</div>
                                <div class="col">
                                    3
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">교환 수량 입력</div>
                                <div class="col">
                                    <input type="number" name="" placeholder=""> 개
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn wd-100" onclick="closemodal_001()">확인</button>
                        <!-- 버튼 비활성화시 사용 <button type="button" class="btn wd-100 ddd">확인</button> -->
                    </form>
                    </div>
                </div>

