@extends('layouts.head')

@section('content')


<div class='page-header'>
      <h4>
            마이페이지
      </h4>
</div>

<table border=1>
    <tr>
        <td>작성가능리뷰</td>
        <td>내가쓴리뷰</td>
    </tr>
</table>


<table border=1>
    <tr>
        <td>[평가단선정]</td>
    </tr>
    <tr>
        <td>
            <form name="exp_form" id="exp_form" method="get" action="{{ route('mypage.review_possible_expwrite') }}">
            <input type="hidden" name="exp_id" id="exp_id">
            <input type="hidden" name="exp_app_id" id="exp_app_id">
            <input type="hidden" name="item_id" id="item_id">
            <input type="hidden" name="sca_id" id="sca_id">

            <table border=1>
                @php
                    $aa = '';
                @endphp

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
                    @if($aa != $bb)
                <tr>
                    <td>{{ substr($exp_appinfo->regi_date, 0, 10) }}</td>
                </tr>
                        @php
                        $aa = substr($exp_appinfo->regi_date, 0, 10);
                        @endphp
                    @endif
                <tr>
                    <td><img src="{{ $main_image_name_disp }}"></td>
                    <td>{{ stripslashes($exp_appinfo->title) }}</td>
                    <td><button type="button" onclick="exp_review('{{ $exp_appinfo->id }}', '{{ $exp_appinfo->exp_app_id }}', '{{ $exp_appinfo->item_id }}', '{{ $exp_appinfo->sca_id }}', '{{ $exp_appinfo->exp_review_start }}')">리뷰작성</button></td>
                </tr>
                @endif
                @endforeach
            </table>
            </form>
        </td>
    </tr>
</table>



<table border=1>
    <tr>
        <td>[쇼핑]</td>
    </tr>
    <tr>
        <td>
            <form name="shop_form" id="shop_form" method="get" action="{{ route('mypage.review_possible_shopwrite') }}">
            <input type="hidden" name="cart_id" id="cart_id">
            <input type="hidden" name="order_id" id="order_id">
            <input type="hidden" name="item_code" id="item_code">

            <table border=1>
                @php
                    $cc = '';
                @endphp

                @foreach($orders as $order)
                    @php
                        $image = $CustomUtils->get_item_image($order->item_code, 3);
                        $dd = substr($order->regi_date, 0, 10);
                        $review_temporary_yn = DB::table('review_saves')->where([['cart_id', $order->id], ['item_code', $order->item_code], ['user_id', Auth::user()->user_id], ['temporary_yn', 'n']])->count();
                    @endphp

                    @if($review_temporary_yn == 0)
                        @if($cc != $dd)
                <tr>
                    <td>{{ substr($order->regi_date, 0, 10) }}</td>
                </tr>
                        @php
                        $cc = substr($order->regi_date, 0, 10);
                        @endphp
                        @endif
                <tr>
                    <td><img src="{{ asset($image) }}"></td>
                    <td>
                        {{ $order->item_name }}<br>
                        {{ $order->sct_option }}
                    </td>
                    <td><button type="button" onclick="cart_review('{{ $order->id }}', '{{ $order->order_id }}', '{{ $order->item_code }}', '{{ substr($order->regi_date, 0, 10) }}')">리뷰작성</button></td>
                </tr>
                    @endif
                @endforeach
            </table>
        </td>
    </tr>
</table>

<script>
    var today = new Date();
    var year = today.getFullYear();
    var month = ('0' + (today.getMonth() + 1)).slice(-2);
    var day = ('0' + today.getDate()).slice(-2);
    var todayString = year + '-' + month  + '-' + day;

    function exp_review(exp_id, exp_app_id, item_id, sca_id, review_start){
        if(todayString < review_start){
            alert("평가 가능 시작일은 " + review_start + "입니다.");
            return false;
        }else{
            $("#exp_id").val(exp_id);
            $("#exp_app_id").val(exp_app_id);
            $("#item_id").val(item_id);
            $("#sca_id").val(sca_id);
            $("#exp_form").submit();
        }
    }

    function cart_review(cart_id, order_id, item_code, order_pay_date){
        var arr = order_pay_date.split('-');
        var dat = new Date(arr[0], arr[1], arr[2]);
        var date_2day = dat.getFullYear() + "-" + ("0" + dat.getMonth()).slice(-2) + "-" + ("0" + (dat.getDate() + 2)).slice(-2);

        if(todayString < date_2day){
            alert("구매 리뷰 작성 가능일은 " + date_2day + "입니다.");
            return false;
        }else{
            $("#cart_id").val(cart_id);
            $("#order_id").val(order_id);
            $("#item_code").val(item_code);
            $("#shop_form").submit();
        }
    }
</script>









@endsection
