@extends('layouts.head')

@section('content')

    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('mypage.index') }}">마이페이지</a></li>
                <li><a href="{{ route('mypage.orderview') }}">교환신청</a></li>

            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area list">
            <h2>교환신청</h2>
            <div class="line_14-100"></div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 주문 배송내역 시작  -->
        <div class="eval">

            <div class="board mypage_list">
                <!-- 리스트 시작 -->
                <div class="board_wrap">
                <form name="returnform" id="returnform" method="post" action="">
                {!! csrf_field() !!}
                    <div class="list ev_rul inner">
                      <div class="sub_title"><h4 class="bold">주문 내역</h4></div>
                      <div class="pr_body pd-00">
                            <div class="pr-t pd-00">
                                <div class="pr_img">
                                    <img src="{{ $image }}" alt="">
                                </div>

                                <div class="pr_name">
                                    <span class="cr_02">{{ $ment }}</span>

                                    <ul>
                                        <a href=""><li><h4 class="mt-10">{{ $item_name }}</h4></li></a>
                                        <li>{{ $item_options }}</li>
                                        <li class="price_pd">{{ number_format($price) }}원 {{ number_format($qty) }}개</li>
                                    </ul>

                                </div>
                            </div>
                      </div>
                    </div>

                       <div class="list ev_rul inner">
                        <div class="sub_title"><h4>교환사유</h4></div>
                           <div class="pr_body pd-00">
                             <div class="pr_name m-00">

                                 <ul class="oder_name wt-00 wt-01">
                                   <li>사유 <span class="cr_03">(필수)</span></li>
                                   <li>
                                   <select name="return_story" id="return_story">
                                      <option value="">선택 하세요</option>
                                      <option value="단순 변심 (배송비 구매자 부담)">단순 변심 (배송비 구매자 부담)</option>
                                      <option value="주문 실수 (배송비 구매자 부담)">주문 실수 (배송비 구매자 부담)</option>
                                      <option value="파손 및 불량 (배송비 판매자 부담)">파손 및 불량 (배송비 판매자 부담)</option>
                                      <option value="오배송 (배송비 판매자 부담)">오배송 (배송비 판매자 부담)</option>
                                      <option value="그 외 기타사유">그 외 기타사유</option>
                                   </select>
                                  </li>
                                 </ul>

                                 <ul class="oder_name wt-00 wt-01">
                                  <li>상세사유 (선택)</li>
                                  <li><textarea name="return_story_content" id="return_story_content" cols="30" rows="10" placeholder="내용을 입력해 주세요"></textarea></li>
                                </ul>

                              </div>
                          </div>

                          <div class="pd-20">
                            <div class="oder">
                              <h4 class="cr_06">안내사항</h4>
                               <ul>
                                <li class="text">
                                  <span class="cr_06">
                                   관리자가 확인 후 조치 해 드리겠습니다.<br>
                                   경우에 따라 추가 배송비가 발생할 수 있습니다.
                                  </span>
                                </li>
                              </ul>
                            </div>
                        </div>
                      </div>

                      <div class="btn">
                        <button type="button" class="btn-50-bg" onclick="return_sign_up_regi();">등록</button>
                      </div>
                </form>
                </div>
                <!-- 리스트 끝 -->
            </div>
        </div>
        <!-- 주문 배송 내역 끝  -->
    </div>
    <!-- 서브 컨테이너 끝 -->

<script>
    function return_sign_up_regi(){
        if($("#return_story option:selected").val() == ""){
            alert("사유를 선택해 주세요");
            return false;
        }

        $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
            url : '{{ route('mypage.return_sign_up_regi') }}',
            type: 'post',
            dataType: 'text',
            data: {
                'order_id'  : {{ $order_id }},
                'cart_num'  : {{ $cart_num }},
                'return_story'  : $("#return_story option:selected").val(),
                'return_story_content'  : $("#return_story_content").val(),
            },
        }).done(function(result) { // 환불 성공시 로직
//alert(result);
//return false;
            if(result == "ok"){
                alert("요청이 완료되었습니다.\n관리자 확인후 조치해 드리겠습니다");
                location.href = "{{ route('mypage.orderview') }}";
            }

            if(result == "process"){
                alert("환불요청이 처리중입니다.");
                location.href = "{{ route('mypage.orderview') }}";
            }
            if(result == "error"){
                alert("환불요청이 실패 하였습니다. 관리자에게 문의 하세요.-1");
            }
        }).fail(function(error) { // 환불 실패시 로직
            alert("환불요청이 실패 하였습니다. 관리자에게 문의 하세요.-2");
        });
    }
</script>




@endsection
