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
                        $review_exp_temporary_yn = DB::table('review_saves')->where([['exp_id', $exp_appinfo->id], ['exp_app_id', $exp_appinfo->exp_app_id], ['user_id', Auth::user()->user_id], ['temporary_yn', 'n']])->count();
                    @endphp
                @if($review_exp_temporary_yn == 0)
                        @php
                            $review = DB::table('review_saves')->select('temporary_yn')->where([['exp_id', $exp_appinfo->id], ['exp_app_id', $exp_appinfo->exp_app_id], ['user_id', Auth::user()->user_id]])->count();
                            if($review == '1') $btn_ment = '임시저장중';
                            else $btn_ment = '리뷰작성';
                        @endphp
                <tr>
                    <td>
                    {{ substr($exp_appinfo->regi_date, 0, 10) }}
                    </td>
                </tr>
                <tr>
                    <td><img src="{{ $main_image_name_disp }}"></td>
                    <td>{{ stripslashes($exp_appinfo->title) }}</td>
                    <td><button type="button" onclick="exp_review('{{ $exp_appinfo->id }}', '{{ $exp_appinfo->exp_app_id }}', '{{ $exp_appinfo->item_id }}', '{{ $exp_appinfo->sca_id }}', '{{ $exp_appinfo->exp_review_start }}')">{{ $btn_ment }}</button></td>
                </tr>

                @endif
                @endforeach

<script>
    $("#po_page").val('{{ $page }}');
    if({{ $po_end_cnt }} == 0){
        $("#po_more").hide();
    }
</script>