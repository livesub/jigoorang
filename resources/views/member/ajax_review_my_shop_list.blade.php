                                @if(count($review_saves_shop_infos) > 0)
                                    @foreach($review_saves_shop_infos as $review_saves_shop_info)
                                        @php
                                            $image = '';
                                            $cart_info = DB::table('shopcarts')->where('id', $review_saves_shop_info->cart_id)->first();
                                            $item_info = DB::table('shopitems')->where([['item_code', $cart_info->item_code], ['sca_id', $review_saves_shop_info->sca_id]])->first();
                                            $order_info = DB::table('shoporders')->select('created_at')->where('order_id', $cart_info->od_id)->first();

                                            $image = $CustomUtils->get_item_image($item_info->item_code, 3);
                                            $dd = substr($order_info->created_at, 0, 10);

                                            //평가 멘트/점수 표현과 이미지 처리를 같이 for 로 처리
                                            $kk = 0;
                                            $tmp = '';
                                            $score_tmp= '';
                                            $dip_name = '';
                                            $review_img_tmp = '';
                                            $review_img_cut = '';
                                            $review_img_disp_shop = array();
                                            $blind_ment = '';

                                            $rating_item_info = DB::table('rating_item')->where('sca_id', $review_saves_shop_info->sca_id)->first();

                                            //리뷰 첨부 이미지 구하기
                                            $review_save_shop_imgs = DB::table('review_save_imgs')->where('rs_id', $review_saves_shop_info->id);
                                            $review_save_imgs_shop_cnt = $review_save_shop_imgs->count();
                                            $review_save_imgs_shop_infos = array();
                                            if($review_save_imgs_shop_cnt > 0) $review_save_imgs_shop_infos = $review_save_shop_imgs->get();

                                        @endphp

                                <div class="cot_body pd-00">
                                    <p class="cr_04 mb-20">{{ substr($order_info->created_at, 0, 10) }}</p>
                                        <img src="{{ $image }}" alt="">
                                    <div class="info tab">

                                        @if($review_saves_shop_info->review_blind == 'Y')
                                        <div class="rm_v">삭제된리뷰</div>
                                        @endif

                                        <p>{{ $cart_info->item_name }}</p>
                                        <p>{{ $cart_info->sct_option }}</p>
                                    </div>

                                  <div class="cot_review mt-20 mb-20">
                                      <div class="cot_box">
                                          <div class="cot_rating">
                                            <div class="cot_rating_02">

                                                @for($i = 1; $i <= 5; $i++)
                                                    @php
                                                        $tmp = "item_name".$i;
                                                        $score_tmp = "score".$i;
                                                        $dip_score = number_format($review_saves_shop_info->$score_tmp, 2);
                                                    @endphp

                                                    @if($i < 5)
                                                <span>
                                                  <p class="text">{{ $rating_item_info->$tmp }}</p>
                                                  <p class="bold">{{ $dip_score }}</p>
                                                </span>
                                                    @endif

                                                    @if($i == 5)
                                            </div>
                                            <div class="cot_rating_01" id="project_{{ $review_saves_shop_info->id }}">
                                                <span>{{ $rating_item_info->$tmp }}</span>
                                                <div class="inline">
                                                    <div class="stars-outer">
                                                        <div class="stars-inner"></div>
                                                    </div>
                                                    <p class="number"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            star({{ $dip_score }},{{ $review_saves_shop_info->id }});
                                        </script>
                                                    @endif
                                                @endfor
                                      </div>

                                       <div class="cot_review_text box">

                                            <div class="text_content" id="content_{{ $review_saves_shop_info->id }}">
                                                {!! nl2br($review_saves_shop_info->review_content) !!}
                                            </div>
                                            <div class="cot_more" id="cot_more_{{ $review_saves_shop_info->id }}"></div>
                                       </div>


                                        <div class="cot_photo">
                                        @foreach($review_save_imgs_shop_infos as $review_save_imgs_shop_info)
                                            @php
                                                $review_img_shop_cut = '';
                                                $review_img_shop_disp = '';
                                                $review_img_shop_cut = explode("@@",$review_save_imgs_shop_info->review_img);
                                                $review_img_shop_disp = "/data/review/".$review_img_shop_cut[2];
                                            @endphp
                                                <img src="{{ $review_img_shop_disp }}" alt="">
                                        @endforeach
                                        </div>
                                  </div>
                                    @endforeach

                                @else
                                            <div class="list-none">
                                                <img src="{{ asset('/design/recources/imgs/combined-shape.png') }}" alt="">
                                                <br><br>
                                                <p>구매 리뷰 내역이 없습니다.</p>
                                            </div>
                                @endif




<script>
    $("#shop_page").val('{{ $shop_page }}');
    if({{ $shop_end_cnt }} == 0){
        $("#shop_more").hide();
    }
</script>

<script>
    $('.box').each(function(cnt){
        var content = $('#content_'+ cnt);
        var content_txt = content.text();
        var content_txt_short = content_txt.substr(0,150)+"...";
        var btn_more = $('#cot_more_'+ cnt);
        if(content_txt.length > 150){
            btn_more.html('더보기');
            content.html(content_txt_short);
        }
        btn_more.click(toggle_content);
        function toggle_content(){
        if($(this).hasClass('short')){
            // 접기 상태
            $(this).html('더보기');
            content.html(content_txt_short);
            $(this).removeClass('short');
        }else{
            // 더보기 상태
            $(this).html('접기');
            content.html(content_txt);
            $(this).addClass('short');
            }
        }
    });
</script>




