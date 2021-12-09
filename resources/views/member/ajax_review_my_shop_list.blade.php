
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

            for($i = 1; $i <= 5; $i++){
                $tmp = "item_name".$i;
                $score_tmp = "score".$i;
                $dip_name .= $rating_item_info->$tmp." ".number_format($review_saves_shop_info->$score_tmp, 2)." 점 / ";
            }
            $dip_name = substr($dip_name, 0, -2);

            //리뷰 첨부 이미지 구하기
            $review_save_shop_imgs = DB::table('review_save_imgs')->where('rs_id', $review_saves_shop_info->id);
            $review_save_imgs_shop_cnt = $review_save_shop_imgs->count();
            $review_save_imgs_shop_infos = array();
            if($review_save_imgs_shop_cnt > 0) $review_save_imgs_shop_infos = $review_save_shop_imgs->get();

            if($review_saves_shop_info->review_blind == 'Y') $blind_ment = '삭제된 리뷰';
        @endphp

    <tr>
        <td>주문일자: {{ substr($order_info->created_at, 0, 10) }}</td>
    </tr>

    <tr>
        <td>
            <table border=1>
                <tr>
                    <td><a href="{{ route('sitemdetail','item_code='.$review_saves_shop_info->item_code) }}"><img src="{{ $image }}"></a></td>
                    <td>{{ $cart_info->item_name }}<br>
                        {{ $cart_info->sct_option }}</td>
                    <td>{{ $blind_ment }}</td>
                </tr>
            </table>
        </td>
    </tr>


    <tr>
        <td>{{ $dip_name }}&nbsp&nbsp&nbsp&nbsp&nbsp{{ substr($review_saves_shop_info->updated_at, 0, 10) }}</td>
    </tr>
    <tr>
        <td>{!! nl2br($review_saves_shop_info->review_content) !!}</td>
    </tr>

    @if($review_save_imgs_shop_cnt > 0)
    <tr>
        <td>
            <table border=1>
                <tr>
            @foreach($review_save_imgs_shop_infos as $review_save_imgs_shop_info)
                @php
                    $review_img_shop_cut = '';
                    $review_img_shop_disp = '';
                    $review_img_shop_cut = explode("@@",$review_save_imgs_shop_info->review_img);
                    $review_img_shop_disp = "/data/review/".$review_img_shop_cut[2];
                @endphp
                    <td><img src="{{ $review_img_shop_disp }}"></td>
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
    $("#shop_page").val('{{ $shop_page }}');
    if({{ $shop_end_cnt }} == 0){
        $("#shop_more").hide();
    }
</script>
