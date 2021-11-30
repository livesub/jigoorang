@extends('layouts.head')

@section('content')


<div class='page-header'>
      <h4>
            마이페이지
      </h4>
</div>

<table border=1>
    <tr>
        <td><span onclick="location.href='{{ route('mypage.review_possible_list') }}'">작성가능리뷰</a></td>
        <td><span onclick="location.href='{{ route('mypage.review_my_list') }}'">내가쓴리뷰</span></td>
    </tr>
</table>

<table border=1>
    <tr>
        <td><span onclick="location.href='{{ route('mypage.review_my_list', 'date_type=one_month') }}'">1개월내</span></td>
        <td><span onclick="location.href='{{ route('mypage.review_my_list', 'date_type=three_month') }}'">3개월내</span></td>
        <td><span onclick="location.href='{{ route('mypage.review_my_list', 'date_type=six_month') }}'">6개월내</span></td>
        <td><span onclick="location.href='{{ route('mypage.review_my_list', 'date_type=one_year') }}'">1년내</span></td>
        <td><span onclick="location.href='{{ route('mypage.review_my_list', 'date_type=three_year') }}'">3년내</span></td>
        <td><span onclick="location.href='{{ route('mypage.review_my_list', 'date_type=all') }}'">전체</span></td>
    </tr>
</table>

<table border=1>
    <tr>
        <td>[평가단선정]</td>
    </tr>
</table>

<table border=1>
    @php
        $aa = '';
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

        @if($aa != $bb)
    <tr>
        <td> 신청일자: {{ substr($review_saves_exp_info->created_at, 0, 10) }}</td>
    </tr>
            @php
            $aa = substr($review_saves_exp_info->created_at, 0, 10);
            @endphp
        @endif


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
</table>


<table border=1>
    <tr>
        <td>[쇼핑]</td>
    </tr>
</table>


<table border=1>
    @php
        $cc = '';
    @endphp
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

        @if($cc != $dd)
    <tr>
        <td>주문일자: {{ substr($order_info->created_at, 0, 10) }}</td>
    </tr>
            @php
            $cc = substr($order_info->created_at, 0, 10);
            @endphp
        @endif


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
</table>








@endsection
