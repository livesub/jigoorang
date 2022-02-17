
                                    @if(count($exp_appinfos) > 0)
                                        @foreach($exp_appinfos as $exp_appinfo)
                                            @php
                                                //이미지 처리
                                                if($exp_appinfo->main_image_name == "") {
                                                    $main_image_name_disp = asset("img/no_img.jpg");
                                                }else{
                                                    $main_image_name_cut = explode("@@",$exp_appinfo->main_image_name);
                                                    $main_image_name_disp = "/data/exp_list/".$main_image_name_cut[2];
                                                }

                                                $bb = substr($exp_appinfo->regi_date, 0, 10);
                                                //$review_exp_temporary_yn = DB::table('review_saves')->where([['exp_id', $exp_appinfo->id], ['exp_app_id', $exp_appinfo->exp_app_id], ['user_id', Auth::user()->user_id], ['temporary_yn', 'n']])->count();
                                            @endphp
                                        {{-- @if($review_exp_temporary_yn == 0) --}}
                                                @php
                                                    $review = DB::table('review_saves')->select('temporary_yn')->where([['exp_id', $exp_appinfo->id], ['exp_app_id', $exp_appinfo->exp_app_id], ['user_id', Auth::user()->user_id]])->count();
                                                    if($review == '1') $btn_ment = '임시저장중';
                                                    else $btn_ment = '리뷰작성';
                                                @endphp
                                        <div class="cot_body pos">
                                            <p class="cr_04 mb-20">{{ substr($exp_appinfo->regi_date, 0, 10) }}</p>
                                            <img src="{{ $main_image_name_disp }}" alt="">
                                            <div class="info">
                                                <p>{{ stripslashes($exp_appinfo->title) }}</p>
                                            </div>

                                            <button class="btn-sd" type="button" onclick="exp_review('{{ $exp_appinfo->id }}', '{{ $exp_appinfo->exp_app_id }}', '{{ $exp_appinfo->item_id }}', '{{ $exp_appinfo->sca_id }}', '{{ $exp_appinfo->exp_review_start }}')">{{ $btn_ment }}</button>

                                        </div>

                                        {{-- @endif --}}
                                        @endforeach
                                    @else
                                        <div class="list-none">
                                            <img src="{{ asset('/design/recources/imgs/combined-shape.png') }}" alt="">
                                            <br><br>
                                            <p>신청된 평가단 내역이 없습니다.</p>
                                        </div>
                                    @endif



<script>
    $("#po_page").val('{{ $page }}');
    if({{ $po_end_cnt }} == 0){
        $("#po_more").hide();
    }
</script>