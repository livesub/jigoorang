@extends('layouts.head')

@section('content')


<div class='page-header'>
      <h4>
            응원한 상품
      </h4>
</div>


<table border=1>
    @foreach($wish_rows as $wish_row)
        @php
            $item_info = DB::table('shopitems')->where('item_code', $wish_row->item_code)->first();
            if($item_info->item_img1 == "") {
                $item_img_disp = asset("img/no_img.jpg");
            }else{
                $item_img_cut = explode("@@",$item_info->item_img1);

                if(count($item_img_cut) == 1) $item_img = $item_img_cut[0];
                else $item_img = $item_img_cut[2];

                $item_img_disp = "/data/shopitem/".$item_img;
            }
        @endphp
    <tr>
        <td><a href="{{ route('sitemdetail','item_code='.$wish_row->item_code) }}"><img src="{{ $item_img_disp }}"></a></td>
        <td>
            <table border=1>
                @if($item_info->item_stock_qty == 0)
                <tr>
                    <td>품절</td>
                </tr>
                @endif
                <tr>
                    <td>{{ stripslashes($item_info->item_name) }}</td>
                </tr>

                @if($item_info->item_cust_price != "0")
                @php
                    if($item_info->item_cust_price > 0){
                        //시중가격 값이 있을때 할인율 계산
                        $discount = (int)$item_info->item_cust_price - (int)$item_info->item_price; //할인액
                        $discount_rate = ($discount / (int)$item_info->item_cust_price) * 100;  //할인율
                        $disp_discount_rate = round($discount_rate);    //반올림
                    }
                    //시중 가격이 0이 아니거나 시중가격과 판매가격이 다를때 시중가격표시
                @endphp
                <tr>
                    <td>{{ $disp_discount_rate }}%</td>
                </tr>
                @endif

                <tr>
                    <td><strong>{{ $CustomUtils->display_price($item_info->item_price) }}</strong> {{ $CustomUtils->display_price($item_info->item_cust_price) }}</td>
                </tr>
            </table>
        </td>
        <td>{{ number_format($item_info->item_average, 2) }}<br>{{ number_format($item_info->item_average, 2) }}/5.00</td>
        <td>리뷰<br>{{ number_format($item_info->review_cnt) }}</td>
        <td><span onclick="item_wish('{{ $item_info->item_code }}');">응원하기</span></td>
    </tr>
    @endforeach
</table>
<table>
    <tr>
        <td>{!! $pnPage !!}</td>
    </tr>
</table>


<script>
    // wish 상품보관
    function item_wish(item_code)
    {
        $.ajax({
            type: 'get',
            url: '{{ route('ajax_wish') }}',
            dataType: 'text',
            data: {
                'item_code' : item_code,
            },
            success: function(result) {
//alert(result);
//return false;
                if(result == "no_item"){
                    alert('죄송합니다. 단종된 상품입니다.');
                    return false;
                }

                if(result == "del"){
                    location.reload();
                    return false;
                }
            },error: function(result) {
                console.log(result);
            }
        });
    }
</script>



@endsection
