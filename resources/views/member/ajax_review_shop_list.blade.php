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
                        @php
                            $review = DB::table('review_saves')->select('temporary_yn')->where([['cart_id', $order->id], ['item_code', $order->item_code], ['user_id', Auth::user()->user_id]])->count();
                            if($review == '1') $btn_ment = '임시저장중';
                            else $btn_ment = '리뷰작성';
                        @endphp
                <tr>
                    <td>{{ substr($order->regi_date, 0, 10) }}</td>
                </tr>
                <tr>
                    <td><img src="{{ asset($image) }}"></td>
                    <td>
                        {{ $order->item_name }}<br>
                        {{ $order->sct_option }}
                    </td>
                    <td><button type="button" onclick="cart_review('{{ $order->id }}', '{{ $order->order_id }}', '{{ $order->item_code }}', '{{ substr($order->regi_date, 0, 10) }}')">{{ $btn_ment }}</button></td>
                </tr>
                    @endif
                @endforeach

<script>
    $("#shop_page").val('{{ $shop_page }}');
    if({{ $shop_end_cnt }} == 0){
        $("#shop_more").hide();
    }
</script>