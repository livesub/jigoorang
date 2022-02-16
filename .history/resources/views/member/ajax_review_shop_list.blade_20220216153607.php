
                                        @if(count($orders) > 0)
                                            @foreach($orders as $order)
                                                @php
                                                    $image = $CustomUtils->get_item_image($order->item_code, 3);
                                                    if($image == "") $image = asset("img/no_img.jpg");
                                                    $kk = substr($order->regi_date, 0, 10);
                                                    //$review_temporary_yn = DB::table('review_saves')->where([['cart_id', $order->id], ['item_code', $order->item_code], ['user_id', Auth::user()->user_id], ['temporary_yn', 'n']])->count();
                                                @endphp

                                                {{-- @if($review_temporary_yn == 0) --}}
                                                    @php
                                                        $review = DB::table('review_saves')->select('temporary_yn')->where([['cart_id', $order->id], ['item_code', $order->item_code], ['user_id', Auth::user()->user_id]])->count();
                                                        if($review == '1') $btn_ment = '임시저장중';
                                                        else $btn_ment = '리뷰작성';
                                                    @endphp
                                        <div class="cot_body">
                                            <p class="cr_04 mb-20">{{ substr($order->regi_date, 0, 10) }}</p>
                                            <img src="{{ asset($image) }}" alt="">
                                            <div class="info">
                                                <p>aaaaaa</p>
                                                <span>{{ $order->sct_option }}1111111111111111111</span>
                                            </div>

                                            <button class="btn-sd" type="button" onclick="cart_review('{{ $order->id }}', '{{ $order->order_id }}', '{{ $order->item_code }}', '{{ substr($order->regi_date, 0, 10) }}')">{{ $btn_ment }}</button>
                                        </div>
                                                {{-- @endif --}}
                                            @endforeach
                                        @else
                                            <div class="list-none">
                                                <img src="{{ asset('/design/recources/imgs/combined-shape.png') }}" alt="">
                                                <br><br>
                                                <p>쇼핑 내역이 없습니다.</p>
                                            </div>
                                        @endif

<script>
    $("#shop_page").val('{{ $shop_page }}');
    if({{ $shop_end_cnt }} == 0){
        $("#shop_more").hide();
    }
</script>