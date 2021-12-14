@extends('layouts.head')

@section('content')


    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('mypage.index') }}">마이페이지</a></li>
                <li><a href="{{ route('mypage.qna_list') }}">1:1 문의 내역 / 답변</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area list">
            <h2>1:1 문의 내역 답변</h2>
            <div class="line_14-100"></div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 1:1문의내역 리스트 시작  -->
        <div class="eval">

            <div class="board mypage_list">
                <!-- 리스트 시작 -->
                <div class="board_wrap">
                    <div class="serch">
                    <form name="qna_search" id="qna_search" action="{{ route('mypage.qna_list') }}" method="get">
                        <input type="text" name="keyword" id="keyword" value="{{ $keyword }}">
                        <label for=""><button class="serch" type="submit">검색</button></label>
                    </form>
                    </div>

                    @if(count($qna_rows) == 0)
                    <div class="list-none">
                        <img src="{{ asset('/design/recources/imgs/combined-shape.png') }}" alt="">
                        <br><br>
                        <p>검색 결과가 없습니다.</p>
                    </div>
                    @else
                        @foreach($qna_rows as $qna_row)
                    <div class="list">
                        <div class="body">
                            <div class="title">
                                <p>{{ $qna_row->qna_cate }}</p>
                                <a href="{{ route('mypage.qna_view', 'id='.$qna_row->id.'&page='.$page.'&keyword='.$keyword) }}">{{ stripslashes($qna_row->qna_subject) }}</a>
                            </div>
                            <dl>
                                <dd>{{ substr($qna_row->created_at, 0, 10) }}</dd>
                            </dl>
                        </div>

                            @if($qna_row->qna_answer == "")
                        <div class="title_sub point01"><!-- class="point01" (비활성) -->
                           답변대기
                        </div>
                            @else
                        <div class="title_sub point02"> <!-- class="point02" (답변완료일때 활성) -->
                            답변완료
                        </div>
                            @endif
                    </div>
                        @endforeach
                    @endif
                </div>
                <!--  1:1문의내역 리스트  끝  -->

                @if(count($qna_rows) > 0)
                 <!-- 페이징 시작 -->
                 <div class="paging">
                    {!! $pnPage !!}
                </div>
                <!-- 페이징 끝 -->
                @endif
            </div>
        </div>
    </div>
    <!-- 서브 컨테이너 끝 -->


@endsection
