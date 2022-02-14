<script src="{{ asset('/design/js/text_more_btn.js') }}"></script>

                            @if(count($review_saves_exp_infos) > 0)
                                @foreach($review_saves_exp_infos as $review_saves_exp_info)

                                @php
                                    $exp_list_info = DB::table('exp_list')->where('id', $review_saves_exp_info->exp_id)->first();

                                    //이미지 처리
                                    if($exp_list_info->main_image_name == "") {
                                        $main_image_name_disp = asset("img/no_img.jpg");
                                    }else{
                                        $main_image_name_cut = explode("@@",$exp_list_info->main_image_name);
                                        $main_image_name_disp = "/data/exp_list/".$main_image_name_cut[2];
                                    }

                                    $bb = substr($review_saves_exp_info->created_at, 0, 10);

                                    //평가 멘트/점수 표현과 이미지 처리를 같이 for 로 처리
                                    $kk = 0;
                                    $tmp = '';
                                    $score_tmp= '';
                                    $dip_name = '';
                                    $review_img_tmp = '';
                                    $review_img_cut = '';
                                    $review_img_disp = array();
                                    $blind_ment = '';

                                    $rating_item_info = DB::table('rating_item')->where('sca_id', $review_saves_exp_info->sca_id)->first();

                                    //리뷰 첨부 이미지 구하기
                                    $review_save_imgs = DB::table('review_save_imgs')->where('rs_id', $review_saves_exp_info->id);
                                    $review_save_imgs_cnt = $review_save_imgs->count();
                                    $review_save_imgs_infos = array();
                                    if($review_save_imgs_cnt > 0) $review_save_imgs_infos = $review_save_imgs->get();
                                @endphp

                                <div class="cot_body pos pd-00">
                                    <p class="cr_04 mb-20">{{ substr($review_saves_exp_info->created_at, 0, 10) }}</p>
                                    <img src="{{ $main_image_name_disp }}" alt="">
                                    <div class="info tab">

                                        @if($review_saves_exp_info->review_blind == 'Y')
                                        <div class="rm_v">삭제된리뷰</div>
                                        @endif

                                        <p>{{ $exp_list_info->title }}</p>
                                    </div>

                                  <div class="cot_review mt-20 mb-20">
                                      <div class="cot_box">
                                          <div class="cot_rating">
                                            <div class="cot_rating_02">

                                                @for($i = 1; $i <= 5; $i++)
                                                    @php
                                                        $tmp = "item_name".$i;
                                                        $score_tmp = "score".$i;
                                                        $dip_score = number_format($review_saves_exp_info->$score_tmp, 2);
                                                    @endphp

                                                    @if($i < 5)
                                                <span>
                                                  <p class="text">{{ $rating_item_info->$tmp }}</p>
                                                  <p class="bold">{{ $dip_score }}</p>
                                                </span>
                                                    @endif

                                                    @if($i == 5)
                                            </div>


                                            <div class="cot_rating_01" id="project_{{ $review_saves_exp_info->id }}">
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
                                            star({{ $dip_score }},{{ $review_saves_exp_info->id }});
                                          </script>
                                                    @endif
                                                @endfor
                                      </div>

                                      <div class="cot_review_text box">

                                            <div class="text_content notshort" id="content_{{ $review_saves_exp_info->id }}" style="word-break: break-all;">
                                                {!! nl2br($review_saves_exp_info->review_content) !!}
                                            </div>
                                            <div class="cot_more" id="cot_more_{{ $review_saves_exp_info->id }}" onclick="more({{ $review_saves_exp_info->id }});">더보기</div>
                                       </div>

                                        <script>
                                       btn({{ $review_saves_exp_info->id }});
                                       </script>

                                        <div class="cot_photo">
                                        @foreach($review_save_imgs_infos as $review_save_imgs_infos)
                                            @php
                                                $review_img_cut = '';
                                                $review_img_disp = '';

                                                $review_img_cut = explode("@@",$review_save_imgs_infos->review_img);
                                                $review_img_disp = "/data/review/".$review_img_cut[2];
                                            @endphp

                                                <img src="{{ $review_img_disp }}" alt="">
                                        @endforeach
                                        </div>

                                    </div>
                                </div>
                                @endforeach
                            @else
                                        <div class="list-none">
                                            <img src="{{ asset('/design/recources/imgs/combined-shape.png') }}" alt="">
                                            <br><br>
                                            <p>평가단 리뷰 내역이 없습니다.</p>
                                        </div>
                            @endif

<script>
    $("#po_page").val('{{ $exp_page }}');
    if({{ $exp_end_cnt }} == 0){
        $("#po_more").hide();
    }
</script>



