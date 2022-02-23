@extends('layouts.head')

@section('content')


    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 타이틀 시작 -->
        <div class="title_area list">
            <h2>검색결과</h2>
        </div>
        <!-- 타이틀 끝 -->

        <div class="serch_data">
            <span class="cr_02 bold">'{{ $search_w }}'</span> 검색결과
        </div>

        <!-- 고객센터 시작  -->
        <div class="eval">

            <div class="board mypage_list">
                <!-- 리스트 시작 -->
                <div class="board_wrap">
                    <div class="tab_menu">
                        <ul class="list_tab">
                            <li class="is_on">
                                <a href="{{ route('search', 'search_w='.$search_w) }}" class="btn_list">전체 ({{ number_format($total_cnt) }})</a>
                            </li>
                            <li>
                                <a href="{{ route('search_shop', 'search_w='.$search_w) }}" class="btn_list">쇼핑 ({{ number_format($item_cnt) }})</a>
                            </li>
                            <li>
                                <a href="{{ route('search_notice', 'search_w='.$search_w) }}" class="btn_list">소식 ({{ number_format(count($notice_infos)) }})</a>
                            </li>
                            <li>
                                <a href="{{ route('search_exp', 'search_w='.$search_w) }}" class="btn_list">평가단 ({{ number_format(count($exp_infos)) }})</a>
                            </li>
                        </ul>

                        <div class="cont_area">
                            <div class="cont pd-00">
                                <div class="filter_bg block">
                                    <ul class="filter_innner">
                                    @php
                                        $class_chk1 = 'fil_off';
                                        $mark_chk1 = '⦁';
                                        $selected_chk1 = '';
                                        $class_chk2 = 'fil_off';
                                        $mark_chk2 = '⦁';
                                        $selected_chk2 = '';
                                        $class_chk3 = 'fil_off';
                                        $mark_chk3 = '⦁';
                                        $selected_chk3 = '';
                                        $class_chk4 = 'fil_off';
                                        $mark_chk4 = '⦁';
                                        $selected_chk4 = '';
                                        $class_chk5 = 'fil_off';
                                        $mark_chk5 = '⦁';
                                        $selected_chk5 = '';

                                        switch ($orderby_type) {
                                            case 'recent':
                                                $class_chk1 = 'fil_on';
                                                $mark_chk1 = '✔';
                                                $selected_chk1 = 'selected';
                                                break;
                                            case 'sale':
                                                $class_chk2 = 'fil_on';
                                                $mark_chk2 = '✔';
                                                $selected_chk2 = 'selected';
                                                break;
                                            case 'high_price':
                                                $class_chk3 = 'fil_on';
                                                $mark_chk3 = '✔';
                                                $selected_chk3 = 'selected';
                                                break;
                                            case 'low_price':
                                                $class_chk4 = 'fil_on';
                                                $mark_chk4 = '✔';
                                                $selected_chk4 = 'selected';
                                                break;
                                            case 'review':
                                                $class_chk5 = 'fil_on';
                                                $mark_chk5 = '✔';
                                                $selected_chk5 = 'selected';
                                                break;
                                            default:
                                                $class_chk1 = 'fil_on';
                                                $mark_chk1 = '✔';
                                                $selected_chk1 = 'selected';
                                            }
                                    @endphp
                                        <li class="{{ $class_chk1 }}" onclick="location.href='{{ route('search', 'search_w='.$search_w.'&orderby_type=recent') }}'"><span>{{ $mark_chk1 }}</span> 등록순(최신순)</li> <!-- class="fil_on" 활성-->
                                        <li class="{{ $class_chk2 }}" onclick="location.href='{{ route('search', 'search_w='.$search_w.'&orderby_type=sale') }}'"><span>{{ $mark_chk2 }}</span>판매량순</li><!-- class="fil_off" 비활성-->
                                        <li class="{{ $class_chk3 }}" onclick="location.href='{{ route('search', 'search_w='.$search_w.'&orderby_type=high_price') }}'"><span>{{ $mark_chk3 }}</span>높은가격순</li>
                                        <li class="{{ $class_chk4 }}" onclick="location.href='{{ route('search', 'search_w='.$search_w.'&orderby_type=low_price') }}'"><span>{{ $mark_chk4 }}</span>낮은가격순</li>
                                        <li class="{{ $class_chk5 }}" onclick="location.href='{{ route('search', 'search_w='.$search_w.'&orderby_type=review') }}'"><span>{{ $mark_chk5 }}</span>후기숫자순</li>
                                    </ul>
                                </div>

                                <div class="filter_sel none">
                                    <select class="filter_innner" onchange="location.href='{{ route('search', 'search_w='.$search_w.'&orderby_type=') }}'+this.value">
                                        <option class="{{ $class_chk1 }}" value="recent" {{ $selected_chk1 }}>등록순(최신순)</option>
                                        <option class="{{ $class_chk2 }}" value="sale" {{ $selected_chk2 }}>판매량순</option>
                                        <option class="{{ $class_chk3 }}" value="high_price" {{ $selected_chk3 }}>높은가격순</option>
                                        <option class="{{ $class_chk4 }}" value="low_price" {{ $selected_chk4 }}>낮은가격순</option>
                                        <option class="{{ $class_chk5 }}" value="review" {{ $selected_chk5 }}>후기숫자순</option>
                                    </select>
                                </div>


                                <div class="f_tt_more">
                                    <ul>
                                        <li class="bold">쇼핑 ({{ number_format($item_cnt) }})</li>
                                        <li><a href="{{ route('shop.index') }}">더보기 +</a></li>
                                    </ul>
                                </div>

                                @if(count($item_infos) > 0)
                                <div class="goods_list">
                                    @foreach($item_infos as $item_info)
                                        @php
                                            if($item_info->item_img1 == "") {
                                                $item_img_disp = asset("img/no_img.jpg");
                                            }else{
                                                $item_img_cut = explode("@@",$item_info->item_img1);

                                                if(count($item_img_cut) == 1) $item_img = $item_img_cut[0];
                                                else $item_img = $item_img_cut[2];

                                                $item_img_disp = "/data/shopitem/".$item_img;
                                            }

                                            //$dip_score = number_format($item_info->item_average, 2);
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
                                    <div class="goods">
                                        <div class="goods_img">
                                        <a href="{{ route('sitemdetail') }}?item_code={{ $item_info->item_code }}">
                                            <img src="{{ $item_img_disp }}" alt="">
                                        </a>
                                        </div>

                                        @if($item_info->item_type1 != 0)
                                            {!! $CustomUtils->item_icon($item_info) !!}
                                        @else
                                            <div class="icon_none">
                                            <p></p>
                                            </div>
                                        @endif

                                        <div class="goods_title">
                                        @php
                                            if($item_info->item_manufacture == "") $item_manufacture = "";
                                            else $item_manufacture = "[".$item_info->item_manufacture."]";
                                        @endphp
                                            <a href="{{ route('sitemdetail') }}?item_code={{ $item_info->item_code }}"><h3>{{ $item_manufacture }}{{ stripslashes($item_info->item_name) }}</h3></a>

                                            <span class="goods_left">
                                                <p class="price">{{ $CustomUtils->display_price($item_info->item_price, $item_info->item_tel_inq) }}</p>
                                                @if($item_info->item_cust_price != 0)
                                                    @if($item_info->item_cust_price == $item_info->item_price)
                                                        <p class="sale-price"></p>
                                                    @else
                                                        <p class="sale-price ml-10">{{ $CustomUtils->display_price($item_info->item_cust_price) }}</p>
                                                    @endif
                                                @else
                                                <p class="sale-price"></p>
                                                @endif
                                            </span>

                                            <span class="goods_right">
                                            @if($item_info->item_cust_price != 0)
                                                @php
                                                    //시중가격 값이 있을때 할인율 계산
                                                    $discount = (int)$item_info->item_cust_price - (int)$item_info->item_price; //할인액
                                                    $discount_rate = ($discount / (int)$item_info->item_cust_price) * 100;  //할인율
                                                    $disp_discount_rate = round($discount_rate);    //반올림
                                                @endphp
                                                @if($disp_discount_rate != 0)
                                                <p>{{ $disp_discount_rate }}%</p>
                                                @endif
                                            @else
                                                <p class="pct_list"></p>
                                            @endif
                                            </span>

                                            <div class="goods_review" id="project_{{ $item_info->id }}">
                                                <div class="stars-outer">
                                                    <div class="stars-inner"></div>
                                                </div>
                                                <p class="number">{{ $dip_score }}/5.00</p>
                                            </div>

                                            <script>
                                                star({{ $dip_score }},{{ $item_info->id }});
                                            </script>

                                            <div class="goods_bottom">
                                                <span class="left">
                                                    <a href="{{ route('sitemdetail') }}?item_code={{ $item_info->item_code }}#section1"><p>리뷰 {{ $item_info->review_cnt }}</p></a>
                                                </span>
                                                <span class="right">
                                                    <p>응원하기</p>
                                                    <span class="sns_wish {{ $wish_class }}" id="wish_css_{{ $item_info->item_code }}" onclick="item_wish('{{ $item_info->item_code }}', {{ Auth::user() }});"></span>
                                                    <!-- <span class="wishlist_on"></span> 활성-->
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <div class="list-none">
                                    <img src="{{ asset('/design/recources/imgs/combined-shape.png') }}" alt="">
                                    <br><br>
                                    <p>검색 결과가 없습니다.</p>
                                </div>
                                @endif

                            <!-- 소식 컨텐츠 시작 -->
                            <div class="f_tt_more mb-20">
                                <ul>
                                    <li class="bold">소식 ({{ number_format(count($notice_infos)) }})</li>
                                    <li><a href="{{ route('notice') }}">더보기 +</a></li>
                                </ul>
                            </div>

                            @if(count($notice_infos) > 0)
                            @foreach($notice_infos as $notice_info)
                                @php
                                    $n_img = explode("@@",$notice_info->n_img);
                                @endphp
                            <div class="list">
                                <div class="thumb">
                                    <img src="{{ asset('/data/notice/'.$n_img[1]) }}" >
                                </div>

                                <div class="ev_rul">

                                    <div class="title_bord">{{ stripslashes($notice_info->n_subject) }}</div>
                                    <div class="sub_tt mt-10">{{ stripslashes($notice_info->n_explain) }}</div>
                                    <div class="date">{{ substr($notice_info->created_at,0,10) }} </div>

                                </div>
                            </div>
                            @endforeach

                            @else
                             <div class="list-none">
                                <img src="{{ asset('/design/recources/imgs/combined-shape.png') }}" alt="">
                                <br><br>
                                <p>검색 결과가 없습니다.</p>
                            </div>
                            @endif

                            <!-- 평가단 컨텐츠 시작 -->
                            <div class="f_tt_more mb-20">
                                <ul>
                                    <li class="bold">평가단 ({{ number_format(count($exp_infos)) }})</li>
                                    <li><a href="{{ route('exp.list') }}">더보기 +</a></li>
                                </ul>
                            </div>

                            @if(count($exp_infos) > 0)
                                @foreach($exp_infos as $exp_info)
                                    @php
                                        $main_image_name = explode("@@", $exp_info->main_image_name);
                                    @endphp
                            <div class="list">
                                <div class="thumb">
                                    <img src="{{ asset('/data/exp_list/'.$main_image_name[1]) }}" >
                                </div>
                                <div class="body">
                                    <div class="title">
                                        {{ stripslashes($exp_info->title) }}
                                    </div>
                                    <dl>
                                        <dt>평가단 모집인원</dt>
                                        <dd>{{ $exp_info->exp_limit_personnel }}명</dd>
                                        <dt>모집기간</dt>
                                        <dd>{{ $exp_info->exp_date_start }} ~ {{ $exp_info->exp_date_end }}</dd>
                                        <dt>평가 가능기간</dt>
                                        <dd>{{ $exp_info->exp_review_start }} ~ {{ $exp_info->exp_review_end }}</dd>
                                    </dl>
                                </div>
                                <div class="btn_area">
                                    <a href="{{ route('exp.list.detail', $exp_info->id) }}"><button>자세히 보기</button></a>
                                </div>
                            </div>
                                @endforeach
                            @else
                            <div class="list-none">
                                <img src="{{ asset('/design/recources/imgs/combined-shape.png') }}" alt="">
                                <br><br>
                                <p>검색 결과가 없습니다.</p>
                            </div>
                            @endif
                        </div> <!-- tab1 끝-->


                        </div>
                    </div>
                </div>
                <!-- 고객센터 끝  -->

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
                        $("#wish_css_"+item_code).removeClass('wishlist_on');
                        $("#wish_css_"+item_code).addClass('wishlist');
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


<script src="{{ asset('/design/js/modal.js') }}"></script>


@endsection


