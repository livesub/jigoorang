@extends('layouts.head')

@section('content')

<script src="{{ asset('/design/js/modal-back02.js') }}"></script>



 <!-- 상품 내역 모달 시작 -->
 <div class="modal_001 modal fade">
  <div class="modal-background" onclick="detilclosemodal_001()"></div>
  <div class="modal-container">
      <div class="modal-container-body">
          <div class="modal-container-title">
              <h4>상품선택</h4>
              <div class="btn-close" onclick="detilclosemodal_001()"></div>
          </div>

          <div class="scroll">
            @foreach($order_infos as $order_info)
                @php
                    $carts = DB::table('shopcarts')->where([['user_id', Auth::user()->user_id], ['od_id', $order_info->order_id]])->get();
                @endphp
              <div class="modal-cot mt-10">
                  <div class="modal-cot-tt">
                      <div class="md-cot-inp">
                          <input type="radio" name="order_id" id="m_rd_{{ $order_info->order_id }}" value="{{ $order_info->order_id }}">
                          <label for="m_rd_{{ $order_info->order_id }}"></label>
                      </div>
                      <div>
                          <ul>
                              <li class="cr_04">{{ substr($order_info->created_at, 0, 10) }} </li>
                          </ul>
                          <ul class="prd_num">
                              <li>주문번호</li>
                              <li>{{ $order_info->order_id }}</li>
                          </ul>
                      </div>
                  </div>


                @foreach($carts as $cart)
                    @php
                        $item_infos = DB::table('shopitems')->where('item_code', $cart->item_code)->first();
                        $image = $CustomUtils->get_item_image($cart->item_code, 3);
                        if($image == "") $image = asset("img/no_img.jpg");

                        //제조사
                        $item = DB::table('shopitems')->where('item_code', $cart->item_code)->first();
                        if($item->item_manufacture == "") $item_manufacture = "";
                        else $item_manufacture = "[".$item->item_manufacture."] ";

                        //제목
                        $item_name = $item_manufacture.stripslashes($cart->item_name);

                        if(strpos($cart->sct_option, " / ") !== false) {
                            $item_options = $cart->sct_option;
                        } else {
                            $item_options = "";
                        }
                    @endphp
                  <div class="modal-inner">
                      <ul class="modal-cot-img">
                          <li>
                            <img src="{{ $image }}" alt="">
                          </li>
                      </ul>

                      <ul class="modal-cot-pd">
                         <h5>
                          {{ $item_name }}
                         </h5>
                         <ul class="pd_tt">
                              <li class="cr_04">{{ $item_options }}</li>
                              <li class="pd_pr">{{ number_format($cart->sct_price + $cart->sio_price) }}원 X
                              <span class="">{{ number_format($cart->sct_qty_cancel) }}개</span></li>
                          </ul>
                      </ul>
                  </div>
                @endforeach

                  <div class="sol-g-b mt-20 block"></div>
              </div>
            @endforeach

          </div>
      </div>

      <div class="btn btn_2ea">
          <button class="modal_btn01" onclick="detilclosemodal_001()">
              취소
          </button>
          <button
              class="modal_btn02" onclick="order_choice()">
              확인
          </button>
      </div>
  </div>
</div>
<!-- 상품 내역 모달 끝 -->


    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('customer_center') }}">고객센터</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area list">
            <h2>고객센터</h2>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 1:1문의 시작  -->
        <div class="eval">

            <div class="board mypage_list">
                <!-- 리스트 시작 -->
                <div class="board_wrap">
                      <div class="tab_menu">
                        <ul class="list_tab">
                          <li class="is_on">
                            <a href="#tab1" class="btn_list">1:1문의</a>
                          </li>
                          <li>
                            <a href="#tab2" class="btn_list">입점/제휴 문의</a>
                          </li>
                        </ul>

                        <div class="cont_area">

                        @if(Auth::user() == "")

                        <div id="tab1" class="cont">
                            <div class="list-none">
                                <img src="{{ asset('/design/recources/imgs/combined-shape.png') }}" alt="">
                                <br><br>
                                <p>로그인 후 이용 가능합니다.</p>
                            </div>
                            <div class="btn_area_50">
                             <button class="btn-50-full" onclick="location.href='{{ route('login.index') }}'">로그인</button>
                            </div>
                        </div>
                        <div id="tab2" class="cont con_02"></div>
                        @else

                          <div id="tab1" class="cont">
                          <form name="qna_form" id="qna_form" method="post" action="{{ route('mypage.qna_write_save') }}">
                          {!! csrf_field() !!}

                            <ul class="tab-01">
                                <li>
                                <p>문의 / 카테고리</p>
                                    <select name="qna_cate" id="qna_cate">
                                        <option value="">선택해주세요</option>
                                        <option value="상품 관련">상품 관련</option>
                                        <option value="배송 관련">배송 관련</option>
                                        <option value="주문/결제 관련">주문/결제 관련</option>
                                        <option value="취소/교환/반품 관련">취소/교환/반품 관련</option>
                                        <option value="포인트 관련">포인트 관련</option>
                                        <option value="기타 문의">평가단 관련</option>
                                        <option value="기타 문의">기타 문의</option>
                                    </select>
                                </li>
                              </ul>
                              <ul class="tab-02">
                                <li>
                                    <p>글제목</p>
                                    <input type="text" name="qna_subject" id="qna_subject" placeholder="제목을 입력하세요(50자 이내)">
                                </li>
                              </ul>

                            @php
                                if(count($order_infos) > 0) $onclick_chk = "detilopenmodal_001();";
                                else $onclick_chk = "javascript:alert('주문 상품이 없습니다');";
                            @endphp
                              <ul class="tab-03">
                                    <li>
                                        <p>주문번호</p>
                                        <span>
                                            <input type="text" name="order_id" id="order_id" value="" readonly placeholder="주문한 제품 문의 시 입력해주세요">
                                            <button type="button" class="btn-10" onclick="{{ $onclick_chk }}">구매상품 선택</button>
                                            <!--<button type="reset" class="btn-10-g">초기화</button>
                                        </span>
                                    </li>
                              </ul>

                              <ul class="tab-04">
                                <li>
                                    <p>문의 글</p>
                                    <textarea name="qna_content" id="qna_content" placeholder="내용을 입력해 주세요"></textarea>
                                </li>
                            </ul>
                            <div class="btn_area_50">
                             <button type="button" class="btn-50-full" onclick="qna_form_submit();">등록</button>
                            </div>
                          </form>
                          </div>
                          <div id="tab2" class="cont con_02">
                            <p>지구랭과의 제휴/입점 문의는<br>
                            <span>jigoorang_hehe@naver.com</span> 으로 메일 주세요<br>
                            (담당자분 성함과 연락처를 꼭 기입해 주세요)</p>
                          </div>
                        </div>
                        @endif



                      </div>
                </div>
                <!-- 1:1문의 끝  -->

            </div>
        </div>
    </div>
</div>
    <!-- 서브 컨테이너 끝 -->



<script>
    function qna_form_submit(){
        if($("#qna_cate option:selected").val() == ""){
            alert("문의 카테고리를 선택 하세요.");
            $("#qna_cate").focus();
            return false;
        }

        if($.trim($("#qna_subject").val()) == ""){
            alert("문의 제목을 입력 하세요.");
            $("#qna_subject").focus();
            return false;
        }

        if($.trim($("#qna_content").val()) == ""){
            alert("문의 내용을 입력 하세요.");
            $("#qna_content").focus();
            return false;
        }

        $("#qna_form").submit();
    }
</script>


<script>
    function order_choice(){
        var order_id = $(':radio[name="order_id"]:checked').val();

        if(order_id == undefined){
            alert('구매상품을 선택해주세요');
            return false;
        }

        $("#order_id").val(order_id);
        detilclosemodal_001();
    }
</script>



<script src="{{ asset('/design/js/tabar.js') }}"></script>


@endsection