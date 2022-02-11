@extends('layouts.head')

@section('content')



    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('mypage.index') }}">마이페이지</a></li>
                <li><a href="{{ route('mypage.exp_app_list') }}">평가단 신청 결과 확인</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area list">
            <h2>평가단 신청 결과 확인</h2>
            <div class="line_14-100"></div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 평가단 신청 결과 확인 시작  -->
        <div class="eval">

            <div class="board mypage_list">
                <!-- 리스트 시작 -->
                <div class="board_wrap">

                @if(count($exp_app_rows) > 0)
                    @foreach($exp_app_rows as $exp_app_row)
                        @php
                            $exp_ok = false;
                            $exp_ment = '';
                            $exp_app_cnt = '';
                            $exp_list = DB::table('exp_list')->where('id', $exp_app_row->exp_id)->first();
                            $now_date = date("Y-m-d", time());
                            $exp_app_cnt = DB::table('exp_application_list')->where([['exp_id', $exp_list->id], ['access_yn', 'y']])->count();

                            if($exp_app_cnt > 0){   //승인 난 상태
                                if($exp_app_row->access_yn == 'y'){
                                    //$exp_ment = "<span class='cr_02 line bold' onclick=\"alert('평가단 제품 수령 및 사용 후\\n[마이페이지] - [제품 평가 및 리뷰]에서\\n정직한 평가를 작성해주세요');\">선정되었어요</span>";
                                    $exp_ment = "<span class='cr_02 line bold' onclick=\"if(confirm('평가단 제품 수령 및 사용 후\\n[마이페이지] - [제품 평가 및 리뷰]에서\\n정직한 평가를 작성해주세요') == true){ location.href='".route('mypage.review_possible_list')."' }else{ return false; }\">선정되었어요</span>";
                                }
                                else $exp_ment = "<span class='cr_06'onclick=\"alert('기간이 만료되어 확인이 불가합니다');\">다음에 만나요</span>";
                            }else{
                                if($now_date <= $exp_list->exp_release_date) $exp_ment = '신청중';
                                else $exp_ment = "<span class='cr_06'onclick=\"alert('기간이 만료되어 확인이 불가합니다');\">다음에 만나요</span>";
                            }

                        @endphp
                    <div class="list ev_rul">

                            <div class="title">
                                {{ stripslashes($exp_list->title) }}
                            </div>
                            <div class="date">
                                {{ substr($exp_list->created_at, 0, 10) }}
                            </div>


                        <div class="result">
                            {!! $exp_ment !!}
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="list-none">
                        <img src="{{ asset('/design/recources/imgs/combined-shape.png') }}" alt="">
                        <br><br>
                        <p>평가단 신청 내역이 없습니다.</p>
                    </div>
                @endif


                </div>

                <!-- 리스트 끝 -->

                <!-- 페이징 시작 -->
                <div class="paging">
                    {!! $pnPage !!}
                </div>
                <!-- 페이징 끝 -->
            </div>

        </div>
        <!-- 평가단 신청 결과 확인 끝  -->



    </div>
    <!-- 서브 컨테이너 끝 -->


@endsection
