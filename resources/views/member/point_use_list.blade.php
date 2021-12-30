@extends('layouts.head')

@section('content')


    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('mypage.index') }}">마이페이지</a></li>
                <li><a href="{{ route('mypage.user_point_list') }}">포인트 현황</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area list">
            <h2 class="pdb-40">포인트 현황</h2>

            <div class="point_num">
                <h4>보유포인트</h4>
                <span>{{ number_format(Auth::user()->user_point) }}P</span>
            </div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 고객센터 시작  -->
        <div class="eval">

            <div class="board mypage_list">
                <!-- 리스트 시작 -->
                <div class="board_wrap">
                    <div class="tab_menu">
                        <ul class="list_tab">
                            <li>
                                <a href="{{ route('mypage.user_point_list') }}" class="btn_list">포인트 누적</a>
                            </li>
                            <li class="is_on">
                                <a href="{{ route('mypage.user_use_point_list') }}" class="btn_list">포인트 사용</a>
                            </li>
                        </ul>

                        <div class="cont_area">
                            <div id="tab1" class="cont">
                                @if(count($shoppoint_rows) > 0)
                                    @foreach($shoppoint_rows as $shoppoint_row)
                                        @php
                                            $point_type = "";
                                            if($shoppoint_row->po_point < 0){
                                                $disp_class = "cr_03";
                                            }else{
                                                $point_type = "+";
                                                $disp_class = "cr_02";
                                            }
                                        @endphp
                                <div class="list ev_rul">
                                    <div class="title">{{ $shoppoint_row->po_content }}</div>
                                    <div class="date">{{ substr($shoppoint_row->created_at, 0, 10) }} </div>
                                    <div class="result {{ $disp_class }}">{{ $point_type }}{{ number_format($shoppoint_row->po_point) }}P</div>
                                </div>
                                    @endforeach
                                @else
                                <div class="list-none">
                                    <img src="{{ asset('/design/recources/imgs/combined-shape.png') }}" alt="">
                                    <br><br>
                                    <p>포인트 사용 내역이 없습니다.</p>
                                </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
                <!-- 고객센터 끝  -->


                 <!-- 페이징 시작 -->
                 <div class="paging">
                    {!! $pnPage !!}
                </div>
                <!-- 페이징 끝 -->


           </div>
       </div>
   </div>
  <!-- 서브 컨테이너 끝 -->



@endsection
