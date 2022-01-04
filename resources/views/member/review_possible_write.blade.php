@extends('layouts.head')

@section('content')


    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('mypage.index') }}">마이페이지</a></li>
                <li><a href="">리뷰작성</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area list">
            <h2>리뷰작성</h2>
            <img src="{{ asset('/design/recources/imgs/sub_banner_2pc@3x.png') }}" alt="" class="block">
            <img src="{{ asset('/design/recources/imgs/sub_banner_2mo@3x.png') }}" alt="" class="none">
            <div class="line_14-100"></div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 리뷰작성 시작  -->
        <div class="eval">
        <form name="review_form" id="review_form" method="post" action="" enctype='multipart/form-data' autocomplete="off">
        {!! csrf_field() !!}
        <!-- 쇼핑몰 관련 -->
        <input type="hidden" name="cart_id" id="cart_id" value="{{ $cart_id }}">
        <input type="hidden" name="content_length" id="content_length">
        <input type="hidden" name="order_id" id="order_id" value="{{ $order_id }}">
        <input type="hidden" name="item_code" id="item_code" value="{{ $item_code }}">
        <input type="hidden" name="temporary_yn" id="temporary_yn">
        <input type="hidden" name="average" id="average">

        <!-- 체험단 관련 -->
        <input type="hidden" name="exp_id" id="exp_id" value="{{ $exp_id }}">
        <input type="hidden" name="exp_app_id" id="exp_app_id" value="{{ $exp_app_id }}">
        <input type="hidden" name="sca_id" id="sca_id" value="{{ $sca_id }}">
        <input type="hidden" name="form_route" id="form_route" value="{{ route('mypage.review_possible_save') }}">

            <div class="board mypage_list">
                <!-- 리스트 시작 -->
                <div class="board_wrap">

                       <div class="information review">
                          <div class="tt_sub">
                            <h4>정량평가</h4>
                            <span class="point">(필수)</span>
                          </div>
                          <div class="tt_sub_02">별점은 0.5점(반별)씩 평가 가능합니다</div>

                        @for($i = 1; $i <= 5; $i++)
                            @php
                                $tmp = "item_name".$i;
                            @endphp

                        <input type="hidden" name="score{{ $i }}" id="score{{ $i }}">

                          <div class="bg_05 pdl-20">
                            <div class="review_star">
                              <ul class="rs_0{{ $i }}">
                                <li class="cr_04" id="ment{{ $i }}">{{ $rating_item_info->$tmp }}</li>
                                <li>
                                  <span class="star cr_01">
                                    ★★★★★
                                    <span id="star_0{{ $i }}">★★★★★</span>
                                    <input type="range" oninput="drawStar{{ $i }}(this);" value="0.5" step="0.5" min="0" max="5">
                                  </span>
                                </li>
                                <li>
                                  <p id="value_0{{ $i }}">0</p><p>/5</p>
                                </li>
                              </ul>
                            </div>
                          </div>
                        @endfor

                      </div>


                      <div class="information review">
                          <div class="tt_sub">
                            <h4>리뷰작성</h4>
                            <span class="point">(필수)</span>
                          </div>

                          <div class="wt_text">
                                <textarea name="review_content" id="review_content" cols="30" rows="10" placeholder="최소 20자 이상 작성해주세요
                                &#13;&#10;- 좋았던 점과 아쉬운 점을 포함하여 최대한 자세하게 작성해 주세요
                                &#13;&#10;- 상품과 무관한 리뷰나 악의적 비방,욕설이 포함된  리뷰는 통보 없이 삭제되며 적립 혜택이 회수됩니다"></textarea>
                          </div>
                      </div>

                        <div class="information review">
                          <div class="tt_sub">
                            <h4>포토리뷰</h4>
                            <span class="point">(선택)</span>

                            <div class="file_uploader">
                              <label>사진첨부 + <input type="file" id="file_uploader" accept="image/*" onchange="changeWriteFile()"
                              /></label>
                            </div>
                          </div>


                          <div class="upload pdb-40">
                            <p>- 최소 1개 이상의 사진을 등록해주세요</p>
                            <p>- 상품과 무관한 사진을 첨부한 리뷰는  통보 없이 삭제 및 적립 혜택이 회수됩니다.</p>
                          </div>

                          <div class="flies"></div>
                         </div>


                </div>
                <!-- 리스트 끝 -->

            </div>

            <div class="btn-3ea">
                <button type="button" class="btn-50 sol-g" onclick="history.back(-1);">취소</button>
                <button type="button" class="btn-50" id="tmp_save_y" onclick="review_save('y');">임시저장</button>
                <button type="button" class="btn-50 bg-01" id="tmp_save_n" onclick="review_save('n');">등록</button>
            </div>
        </div>
        <!-- 리뷰 작성 끝  -->
    </form>
    </div>
    <!-- 서브 컨테이너 끝 -->

<script>
    $('#review_content').on('keyup', function() {
        var content = $(this).val();
        //var srtlength = getTextLength(content);
        var srtlength = content.length;
        $("#content_length").val(srtlength);
    });

    function getTextLength(str) {
        var len = 0;

        for (var i = 0; i < str.length; i++) {
            if (escape(str.charAt(i)).length == 6) {
                len++;
            }
            len++;
        }
        return len;
    }
</script>



<script src="{{ asset('/design/js/onclick_star.js') }}"></script>
<script src="{{ asset('/design/js/flieupload.js') }}"></script>

@endsection