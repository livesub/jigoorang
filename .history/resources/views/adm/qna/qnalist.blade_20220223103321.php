@extends('layouts.admhead')

@section('content')




        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>1:1 문의 관리</h2>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area qna">

            <!-- 가이드 문구 시작 -->
            <div class="box_guide">
                <ul>
                    <li>총문의 : {{ number_format($total_record) }}건</li>
                    <li>답변대기 : <b>{{ number_format($qna_answer_cnt) }}</b>건</li>
                </ul>
            </div>
            <!-- 가이드 문구 끝-->

                <!-- 검색창 시작 -->
                <div class="box_search">
                <form name="qna_search" id="qna_search" action="{{ route('adm.qna_list') }}" method="get">
                    <ul>
                        <li>답변 여부</li>
                        @php
                            $answer_type_checked1 = "";
                            $answer_type_checked2 = "";
                            $answer_type_checked3 = "";

                            if($answer_type == "" || $answer_type == "all") $answer_type_checked1 = "checked";
                            else if($answer_type == "N") $answer_type_checked2 = "checked";
                            else if($answer_type == "Y") $answer_type_checked3 = "checked";
                        @endphp
                        <li>
                            <label>
                                <input type="radio" name="answer_type" value="all" {{ $answer_type_checked1 }}>전체
                            </label>
                            <label>
                                <input type="radio" name="answer_type" value="N" {{ $answer_type_checked2 }}>답변대기
                            </label>
                            <label>
                                <input type="radio" name="answer_type" value="Y" {{ $answer_type_checked3 }}>답변완료
                            </label>
                        </li>
                        <li>분류</li>
                        <li>
                            @php
                                $qna_cate_selected1 = "";
                                $qna_cate_selected2 = "";
                                $qna_cate_selected3 = "";
                                $qna_cate_selected4 = "";
                                $qna_cate_selected5 = "";
                                $qna_cate_selected6 = "";
                                $qna_cate_selected7 = "";
                                $qna_cate_selected8 = "";
                                $qna_cate_selected9 = "";

                                if($qna_cate == "") $qna_cate_selected1 = "selected";
                                else if($qna_cate == "상품 관련") $qna_cate_selected2 = "selected";
                                else if($qna_cate == "배송 관련") $qna_cate_selected3 = "selected";
                                else if($qna_cate == "주문/결제 관련") $qna_cate_selected4 = "selected";
                                else if($qna_cate == "취소/부분취소/반품 관련") $qna_cate_selected5 = "selected";
                                else if($qna_cate == "교환 관련") $qna_cate_selected9 = "selected";
                                else if($qna_cate == "포인트 관련") $qna_cate_selected6 = "selected";
                                else if($qna_cate == "평가단 관련") $qna_cate_selected7 = "selected";
                                else if($qna_cate == "기타 문의") $qna_cate_selected8 = "selected";

                                $user_type_selected1 = "";
                                $user_type_selected2 = "";
                                if($user_type == "user_name") $user_type_selected1 = "selected";
                                else if($user_type == "user_id") $user_type_selected2 = "selected";
                            @endphp
                            <select name="qna_cate" id="qna_cate">
                                <option value="" {{ $qna_cate_selected1 }}>선택해주세요</option>
                                <option value="상품 관련" {{ $qna_cate_selected2 }}>상품 관련</option>
                                <option value="배송 관련" {{ $qna_cate_selected3 }}>배송 관련</option>
                                <option value="주문/결제 관련" {{ $qna_cate_selected4 }}>주문/결제 관련</option>
                                <option value="취소/부분취소/반품 관련" {{ $qna_cate_selected5 }}>취소/부분취소/반품 관련</option>
                                <option value="교환 관련" {{ $qna_cate_selected9 }}>교환 관련</option>
                                <option value="포인트 관련" {{ $qna_cate_selected6 }}>포인트 관련</option>
                                <option value="평가단 관련" {{ $qna_cate_selected7 }}>평가단 관련</option>
                                <option value="기타 문의" {{ $qna_cate_selected8 }}>기타 문의</option>
                            </select>
                            <select name="user_type">
                                <option value="user_name" {{ $user_type_selected1 }}>이름</option>
                                <option value="user_id" {{ $user_type_selected2 }}>아이디</option>
                            </select>
                            <input class="wd250" type="text" name="keyword" id="keyword" value="{{ $keyword }}">
                        </li>
                    </ul>
                    <button type="submit">검색</button>
                </form>
                </div>
                <!-- 검색창 끝-->

                <!-- 보드 시작 -->
                <div class="board">

                    <!-- 1:1문의 리스트 시작 -->
                    <table>
                        <colgroup>
                            <col style="width: 60px;">
                            <col style="width: auto;">
                            <col style="width: 200px;">
                            <col style="width: 200px;">
                            <col style="width: 250px;">
                            <col style="width: 120px;">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>번호</th>
                                <th>제목</th>
                                <th>문의 항목</th>
                                <th>글쓴이</th>
                                <th>아이디(이메일)</th>
                                <th>답변여부</th>
                            </tr>
                        </thead>
                        <!-- 리스트 시작 -->
                        <tbody>
                            @foreach($qna_rows as $qna_row)
                            <tr>
                                <td>{{ $virtual_num }}</td>
                                <td class="title"><a href="{{ route('adm.qna_answer','id='.$qna_row->id) }}&{!! $page_move !!}">{{ stripslashes($qna_row->qna_subject) }}</a></td>
                                <td>{{ $qna_row->qna_cate }}</td>
                                <td>{{ $qna_row->user_name }}</td>
                                <td>{{ $qna_row->user_id }}</td>
                                <td class="answer">
                                @php
                                    if($qna_row->qna_answer == null){
                                        $answer_class = "acc";
                                        $answer_ment = "답변대기";
                                    }else{
                                        $answer_class = "";
                                        $answer_ment = "답변완료";
                                    }
                                @endphp

                                    <div class="{{ $answer_class }}">{{ $answer_ment }}</div>
                                </td>
                            </tr>
                            @php
                                $virtual_num--;
                            @endphp
                            @endforeach

                        </tbody>
                        <!-- 리스트 끝 -->
                    </table>
                    <!-- 1:1문의 리스트 끝 -->

                    <!-- 페이지네이션 시작 -->
                    <div class="paging_box">
                        <div class="paging">
                            {!! $pnPage !!}
                        </div>
                    </div>
                    <!-- 페이지네이션 끝 -->

                </div>
                <!-- 보드 끝 -->

        </div>
        <!-- 컨텐츠 영역 끝 -->






@endsection
