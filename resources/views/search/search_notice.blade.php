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
                            <li class="is_on">
                                <a href="{{ route('search_notice', 'search_w='.$search_w) }}" class="btn_list">소식 ({{ number_format($notice_cnt) }})</a>
                            </li>
                            <li>
                                <a href="{{ route('search_exp', 'search_w='.$search_w) }}" class="btn_list">평가단 ({{ number_format(count($exp_infos)) }})</a>
                            </li>
                        </ul>

                        <div class="cont_area">
                            @if(count($notice_infos) > 0)
                            <div class="cont pd-00 mt-30">
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

                                <!-- 페이징 시작 -->
                                <div class="paging">
                                    {!! $pnPage !!}
                                </div>
                                <!-- 페이징 끝 -->

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
                </div>
                <!-- 고객센터 끝  -->

           </div>
       </div>
   </div>
  <!-- 서브 컨테이너 끝 -->


<script src="{{ asset('/design/js/sidenav.js') }}"></script>
<script src="{{ asset('/design/js/modal.js') }}"></script>


@endsection


