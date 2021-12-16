    @php
        $dip_name = '';
    @endphp

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
            for($i = 1; $i <= 5; $i++){
                $tmp = "item_name".$i;
                $score_tmp = "score".$i;
                $dip_name .= $rating_item_info->$tmp." ".number_format($review_saves_exp_info->$score_tmp, 2)." 점 / ";
            }
            $dip_name = substr($dip_name, 0, -2);

            //리뷰 첨부 이미지 구하기
            $review_save_imgs = DB::table('review_save_imgs')->where('rs_id', $review_saves_exp_info->id);
            $review_save_imgs_cnt = $review_save_imgs->count();
            $review_save_imgs_infos = array();
            if($review_save_imgs_cnt > 0) $review_save_imgs_infos = $review_save_imgs->get();

            if($review_saves_exp_info->review_blind == 'Y') $blind_ment = '삭제된 리뷰';
        @endphp

    <tr>
        <td> 신청일자: {{ substr($review_saves_exp_info->created_at, 0, 10) }}</td>
    </tr>

    <tr>
        <td>
            <table border=1>
                <tr>
                    <td><a href="{{ route('sitemdetail','item_code='.$review_saves_exp_info->item_code) }}"><img src="{{ $main_image_name_disp }}"></a></td>
                    <td>{{ $exp_list_info->title }}</td>
                    <td>{{ $blind_ment }}</td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td>{{ $dip_name }}&nbsp&nbsp&nbsp&nbsp&nbsp{{ substr($review_saves_exp_info->updated_at, 0, 10) }}</td>
    </tr>
    <tr>
        <td>{!! nl2br($review_saves_exp_info->review_content) !!}</td>
    </tr>

        @if($review_save_imgs_cnt > 0)
    <tr>
        <td>
            <table border=1>
                <tr>
            @foreach($review_save_imgs_infos as $review_save_imgs_infos)
                @php
                    $review_img_cut = '';
                    $review_img_disp = '';

                    $review_img_cut = explode("@@",$review_save_imgs_infos->review_img);
                    $review_img_disp = "/data/review/".$review_img_cut[2];
                @endphp
                    <td><img src="{{ $review_img_disp }}"></td>
            @endforeach
                </tr>
            </table>
        </td>
    </tr>
        @endif

    <tr>
        <td height="40"></td>
    </tr>
    @endforeach


<script>
    $("#po_page").val('{{ $exp_page }}');
    if({{ $exp_end_cnt }} == 0){
        $("#po_more").hide();
    }
</script>
