<script src="{{ asset('/design/js/modal-back02.js') }}"></script>

                                                    @foreach($review_infos as $review_info)

                                                    <div class="cot_list">
                                                        <div class="cot_body">
                                                          <div class="cot_review mt-20 mb-20">
                                                              <div class="cot_id_day mb-20">
                                                                  <p class="cot_id">{{ substr($review_info->user_id, 0, 3) . "*****" }}</p>
                                                                  <p class="cot_day">2021-10-10</p>
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
                                                                    <div class="cot_rating_01" id="project_200">
                                                                        <span>{{ $rating_item_info->$item_name }}</span>
                                                                        <div class="inline">
                                                                            <div class="stars-outer">
                                                                                <div class="stars-inner"></div>
                                                                            </div>
                                                                            <p class="number">{{ number_format($review_info->$score, 2) }}</p>
                                                                            <p class="number">{{ number_format($review_info->$score, 2) }}</p>
                                                                        </div>
                                                                    </div>
                                                                    <script>
                                                                        star({{ number_format($review_info->$score, 2) }}, 200);
                                                                    </script>
                                                                            @endif
                                                                        @endfor

                                                                </div>
                                                              </div>

                                                              <div class="cot_review_text">
                                                                    <p>{{ $review_info->review_content }}</p>

                                                                <div class="cot_more">
                                                                    <p>더보기</p>
                                                                    <span class="arr_bt"></span>
                                                                </div>
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
<!--
                                                                        <img src="../../recources/imgs/sample_img.png" alt="">
                                                                        <img src="../../recources/imgs/sample_img.png" alt="">
                                                                        <img src="../../recources/imgs/sample_img.png" alt="">
                                                                        <img src="../../recources/imgs/sample_img.png" alt="">
-->
                                                                    </div>
                                                                </div>
                                                                @endif

                                                            </div>
                                                          </div>
                                                        </div>
                                                    </div>
                                                    @endforeach


<!-- 리뷰 사진확대 모달 시작 -->
     <div class="modal_002 modal fade">
        <div class="modal-background" onclick="addressclosemodal_001()"></div>
         <div class="modal-container dt_img_s">
            <div class="btn-close" onclick="addressclosemodal_001()">
          </div>
                <img id="big_img" src="../../recources/imgs/sample_img.png" alt="">
         </div>
     </div>
     <!-- 리뷰 사진확대 모달 끝 -->
