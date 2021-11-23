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
                    @endphp
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
                    <td><button type="button" onclick="exp_review('{{ $exp_appinfo->id }}', '{{ $exp_appinfo->exp_review_start }}')">리뷰작성</button></td>
                </tr>
                @endforeach
            </table>
        </td>
    </tr>
</table>



<table border=1>
    <tr>
        <td>[쇼핑]</td>
    </tr>
    <tr>
        <td>
            <table border=1>
                @php
                    $cc = '';
                @endphp

                @foreach($carts as $cart)
                    @php
                        $image = $CustomUtils->get_item_image($cart->item_code, 3);
                        $dd = substr($cart->regi_date, 0, 10);
                    @endphp

                @if($cc != $dd)
                <tr>
                    <td>{{ substr($cart->regi_date, 0, 10) }}</td>
                </tr>
                    @php
                    $cc = substr($cart->regi_date, 0, 10);
                    @endphp
                @endif
                <tr>
                    <td><img src="{{ asset($image) }}"></td>
                    <td>
                        {{ $cart->item_name }}<br>
                        {{ $cart->sct_option }}
                    </td>
                    <td><button type="button" onclick="cart_review('{{ $cart->id }}', '{{ substr($cart->regi_date, 0, 10) }}')">리뷰작성</button></td>
                </tr>
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
    var dateString = year + '-' + month  + '-' + day;

    function exp_review(num, review_start){
        if(dateString < review_start){
            alert("평가 가능 시작일은 " + review_start + "입니다.");
            return false;
        }else{
            alert("넘어 간다~~~~");
        }
    }

    function cart_review(num, review_start){
        var arr = review_start.split('-');
        var dat = new Date(arr[0], arr[1], arr[2]);
        var date_3day = dat.getFullYear() + "-" + dat.getMonth() + "-" + (dat.getDate() + 3);
        var date_30day = dat.getFullYear() + "-" + dat.getMonth() + "-" + (dat.getDate() + 30);
alert(date_3day);




    }
</script>









@endsection
