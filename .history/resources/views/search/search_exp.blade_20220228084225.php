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
                            <li>
                                <a href="{{ route('search', 'search_w='.$search_w) }}" class="btn_list">전체 ({{ number_format($total_cnt) }})</a>
                            </li>
                            <li>
                                <a href="{{ route('search_shop', 'search_w='.$search_w) }}" class="btn_list">쇼핑 ({{ number_format(count($item_infos)) }})</a>
                            </li>
                            <li>
                                <a href="{{ route('search_notice', 'search_w='.$search_w) }}" class="btn_list">소식 ({{ number_format(count($notice_infos)) }})</a>
                            </li>
                            <li class="is_on">
                                <a href="{{ route('search_exp', 'search_w='.$search_w) }}" class="btn_list">평가단 ({{ number_format($exp_cnt) }})</a>
                            </li>
                        </ul>

                        <div class="cont_area">
                            @if(count($exp_infos) > 0)
                            <div class="cont pd-00 mt-30">

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

                                <!-- 페이징 시작 -->
                                <div class="paging">
                                    {!! $pnPage !!}
                                </div>
                                <!-- 페이징 끝 -->


                            </div>
                            @else
                                <div class="list-none">
                                    <img src="{{ asset('/design/recources/imgs/combined-shape.png') }}" alt="">
                                    <br><br>
                                    <p>검색 결과가 없습니다.</p>
                                </div>
                            @endif



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


<script src="{{ asset('/design/js/sidenav.js') }}"></script>
<script src="{{ asset('/design/js/modal.js') }}"></script>


@endsection


