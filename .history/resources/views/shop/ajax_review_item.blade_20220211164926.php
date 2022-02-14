                                                <script src="{{ asset('/design/js/modal-back02.js') }}"></script>
                                                <script src="{{ asset('/design/js/text_more_btn.js') }}"></script><!--글자 더보기 스크립트 -->

                                                    @php
                                                        $exp_num = $page * 100;
                                                    @endphp

                                                    @foreach($review_infos as $review_info)
                                                    <div class="cot_list">
                                                        <div class="cot_body pos">
                                                          <div class="cot_review mt-20 mb-20">
                                                              <div class="cot_id_day mb-20">
                                                                  <p class="cot_id">{{ substr($review_info->user_id, 0, 3) . "*****" }}</p>
                                                                  <p class="cot_day">{{ substr($review_info->created_at, 0, 10) }}</p>
                                                              </div>
                                                              <div class="cot_box">
                                                                  <div class="cot_rating">
                                                                    <div class="cot_rating_02">
                                                                        @for($p = 1; $p <= 5; $p++)
                                                                            @php
                                                                                $rating_item_info = DB::table('rating_item')->where('sca_id', $review_info->sca_id)->first();
                                                                                $item_name = "item_name".$p;
                                                                                $score = "score".$p;
                                                                            @endphp

                                                                            @if($p < 5)
                                                                        <span>
                                                                          <p class="text">{{ $rating_item_info->$item_name }}</p>
                                                                          <p class="bold">{{ number_format($review_info->$score, 2) }}</p>
                                                                        </span>
                                                                            @endif

                                                                            @if($p == 5)
                                                                    </div>
                                                                    <div class="cot_rating_01" id="project_{{ $exp_num }}">
                                                                        <span>{{ $rating_item_info->$item_name }}</span>
                                                                        <div class="inline">
                                                                            <div class="stars-outer">
                                                                                <div class="stars-inner"></div>
                                                                            </div>
                                                                           <!-- <p class="number">{{ number_format($review_info->$score, 2) }}</p>-->
                                                                            <p class="number">{{ number_format($review_info->$score, 2) }}</p>
                                                                        </div>
                                                                    </div>
                                                                            @endif
                                                                    <script>
                                                                        star2({{ number_format($review_info->$score, 2) }}, {{ $exp_num }});
                                                                    </script>
                                                                        @endfor

                                                                </div>
                                                              </div>


                                                              <div class="cot_review_text box">

                                                                    <div class="text_content notshort" id="shop_content_{{ $review_info->id }}" style="word-break: break-all;">
                                                                        <p>{{ $review_info->review_content }}</p>
                                                                    </div>
                                                                    <div class="cot_more" id="shop_cot_more_{{ $review_info->id }}" onclick="shop_more({{ $review_info->id }});">
                                                                        <p>더보기</p>
                                                                        <span class="arr_bt"></span>
                                                                    </div>

                                                                </div>
                                                                <script>
                                                                    shop_btn({{ $review_info->id }});
                                                                </script>

                                                                @php
                                                                    $review_imgs = DB::table('review_save_imgs')->where('rs_id', $review_info->id)->orderby('id','asc')->get();
                                                                @endphp

                                                                @if(count($review_imgs) > 0)
                                                                <div id="toggle" class="toggle">
                                                                    <div class="cot_photo">
                                                                        @foreach($review_imgs as $review_img)
                                                                            @php
                                                                                $img_cut = explode("@@",$review_img->review_img);
                                                                                $img_big = '/data/review/'.$img_cut[0];
                                                                                $img_small = '/data/review/'.$img_cut[2];
                                                                            @endphp
                                                                        <img src="{{ asset($img_small) }}" alt="" onclick="review_big('{{ asset($img_big) }}')">
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                                @endif

                                                            </div>
                                                          </div>
                                                        </div>
                                                    </div>

                                                        @php
                                                            $exp_num++;
                                                        @endphp
                                                    @endforeach

<script>
    $("#review_page").val('{{ $page }}');
    if({{ $review_end_cnt }} == 0){
        $("#review_more").hide();
    }
</script>

<!-- 리뷰 사진확대 모달 시작 -->
     <div class="modal_002 modal fade">
        <div class="modal-background" onclick="addressclosemodal_001()"></div>
         <div class="modal-container dt_img_s">
            <div class="btn-close" onclick="addressclosemodal_001()">
          </div>
                <img id="big_img" src="" alt="">
         </div>
     </div>
     <!-- 리뷰 사진확대 모달 끝 -->
