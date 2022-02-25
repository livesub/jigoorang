@extends('layouts.head')

@section('content')




    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('mypage.index') }}">마이페이지</a></li>
                <li><a href="{{ route('mypage.wish_list') }}">응원한 상품</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area list">
            <h2>응원한 상품</h2>
            <div class="line_14-100"></div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 1:1문의내역 리스트 시작  -->
        <div class="eval">

            <div class="board mypage_list">
                <!-- 리스트 시작 -->
                <div class="board_wrap sol-bb">

                    @if(count($wish_rows) > 0)
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

                                if($item_info->item_stock_qty == 0 || $item_info->item_del == 'Y'){
                                    $ment = "javascript:alert('죄송합니다. 단종된 상품입니다.');";
                                }else{
                                    $ment = route('sitemdetail','item_code='.$wish_row->item_code);
                                }

                                $dip_score = number_format($item_info->avg_score5, 2);

                                //응원하기 부분
                                if(Auth::user() != ""){
                                    $wish_chk = DB::table('wishs')->where([['user_id', Auth::user()->user_id], ['item_code', $item_info->item_code]])->count();
                                    $wish_class = "wishlist";
                                    if($wish_chk > 0) $wish_class = "wishlist_on";
                                }else{
                                    $wish_class = "wishlist";
                                }
                            @endphp
                    <div class="list ev_rul pd-00">
                        <div class="wsl_lt pd-00">

                            <div class="block_01">
                                <div class="pr_img">
                                    <a href="{{ $ment }}">
                                    <img src="{{ $item_img_disp }}" alt="">
                                    </a>
                                </div>

                                <div class="pr_title">

                                @if($item_info->item_type1 != 0)
                                    {!! $CustomUtils->item_icon($item_info) !!}
                                @else
                                    <div class="icon_none">
                                    <p></p>
                                    </div>
                                @endif
                                    <ul>
                                @php
                                    if($item_info->item_manufacture == "") $item_manufacture = "";
                                    else $item_manufacture = "[".$item_info->item_manufacture."]";
                                @endphp
                                        <a href="{{ $ment }}">
                                        <li class="mt-10">
                                            <h4>{{ $item_manufacture }}{{ stripslashes($item_info->item_name) }}</h4>
                                        </li>
                                        </a>
                                    </ul>

                                    <ul class="pdt-10">
                                    @if($item_info->item_cust_price != 0)
                                        @php
                                            //시중가격 값이 있을때 할인율 계산
                                            $discount = (int)$item_info->item_cust_price - (int)$item_info->item_price; //할인액
                                            $discount_rate = ($discount / (int)$item_info->item_cust_price) * 100;  //할인율
                                            $disp_discount_rate = round($discount_rate);    //반올림
                                        @endphp
                                        @if($disp_discount_rate != 0)
                                        <li class="pct">{{ $disp_discount_rate }}%</li>
                                        @else
                                        <li class="pct"></li>
                                        @endif
                                    @else
                                        <li class="pct"></li>
                                    @endif
                                        <li>
                                            <span class="price">{{ $CustomUtils->display_price($item_info->item_price, $item_info->item_tel_inq) }}</span>
                                    @if($item_info->item_cust_price != 0)
                                        @if($item_info->item_cust_price == $item_info->item_price)
                                            <span class="sale-price"></span>
                                        @else
                                            <span class="sale-price ml-10">{{ $CustomUtils->display_price($item_info->item_cust_price) }}</p>
                                        @endif
                                    @else
                                            <span class="sale-price"></span>
                                    @endif

                                        </li>
                                    </ul>

                                </div>
                            </div>

                            <div class="block_02">

                                <div class="star" id="project_{{ $item_info->id }}">
                                    <div class="stars-outer">
                                        <div class="stars-inner"></div>
                                    </div>
                                    <p class="number">{{ $dip_score }}/5.00</p>
                                </div>

                                <script>
                                    star({{ $dip_score }},{{ $item_info->id }});
                                </script>

                                <div class="re_num">
                                    <ul>
                                    <a href="{{ $ment }}#section1">
                                        <li>리뷰</li>
                                        <li>{{ $item_info->review_cnt }}</li>
                                    </a>
                                    </ul>
                                </div>

                                <div class="heart">
                                    <p>응원하기</p>
                                    <div class="{{ $wish_class }}" id="wish_css_{{ $item_info->item_code }}" onclick="item_wish('{{ $item_info->item_code }}', {{ Auth::user() }});"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!--  1:1문의내역 리스트  끝  -->

                 <!-- 페이징 시작 -->
                 <div class="paging">
                    {!! $pnPage !!}
                </div>
                <!-- 페이징 끝 -->

                    @else
                    <div class="list-none">
                        <img src="{{ asset('/design/recources/imgs/combined-shape.png') }}" alt="">
                        <br><br>
                        <p>응원한 상품이 없습니다.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- 서브 컨테이너 끝 -->



<script>
    // wish 상품보관
    function item_wish(item_code, auth)
    {
        if(auth == undefined){
            alert('회원만 이용 가능합니다.\n로그인 후 이용해 주세요');
            return false;
        }else{
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
                    if(result == "ok"){
                        $("#wish_css_"+item_code).addClass('wishlist_on');
                    }

                    if(result == "del"){
                        location.reload();
                        //$("#wish_css_"+item_code).removeClass('wishlist_on');
                        //$("#wish_css_"+item_code).addClass('wishlist');
                    }

                    if(result == "no_item"){
                        alert('죄송합니다. 단종된 상품입니다.');
                        return false;
                    }
                },error: function(result) {
                    console.log(result);
                }
            });
        }
    }
</script>



@endsection
