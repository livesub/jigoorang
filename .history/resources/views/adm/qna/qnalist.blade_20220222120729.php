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
                                if($qna_cate == "") $qna_cate_selected1 = "selected";
                                else if($qna_cate == "상품 관련") $qna_cate_selected2 = "selected";
                                else if($qna_cate == "배송 관련") $qna_cate_selected3 = "selected";
                                else if($qna_cate == "주문/결제 관련") $qna_cate_selected4 = "selected";
                            @endphp
                            <select name="qna_cate" id="qna_cate">
                                <option value="">선택해주세요</option>
                                <option value="상품 관련">상품 관련</option>
                                <option value="배송 관련">배송 관련</option>
                                <option value="주문/결제 관련">주문/결제 관련</option>
                                <option value="취소/교환/반품 관련">취소/교환/반품 관련</option>
                                <option value="포인트 관련">포인트 관련</option>
                                <option value="기타 문의">평가단 관련</option>
                                <option value="기타 문의">기타 문의</option>
                            </select>
                            <select name="user_type">
                                <option value="user_name">이름</option>
                                <option value="user_id">아이디</option>
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
                            <tr>
                                <td>10</td>
                                <td class="title"><a href="../../page/qna/qna_detail.html">샴푸바 문의 드립니다.</a></td>
                                <td>상품관련</td>
                                <td>김치맨</td>
                                <td>aaaa@gmail.com</td>
                                <td class="answer">
                                    <div class="acc">답변대기</div>
                                </td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td class="title"><a href="../../page/qna/qna_detail.html">샴푸바 문의 드립니다.</a></td>
                                <td>배송관련</td>
                                <td>김치맨</td>
                                <td>aaaa@gmail.com</td>
                                <td class="answer">
                                    <div class="acc">답변대기</div>
                                </td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td class="title"><a href="../../page/qna/qna_detail.html">샴푸바 문의 드립니다.</a></td>
                                <td>주문/결제 관련</td>
                                <td>김치맨</td>
                                <td>aaaa@gmail.com</td>
                                <td class="answer">
                                    <div>답변완료</div>
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td class="title"><a href="../../page/qna/qna_detail.html">샴푸바 문의 드립니다.</a></td>
                                <td>취소/교환/반품 관련</td>
                                <td>김치맨</td>
                                <td>aaaa@gmail.com</td>
                                <td class="answer">
                                    <div>답변완료</div>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td class="title"><a href="../../page/qna/qna_detail.html">샴푸바 문의 드립니다.</a></td>
                                <td>포인트 관련</td>
                                <td>김치맨</td>
                                <td>aaaa@gmail.com</td>
                                <td class="answer">
                                    <div>답변완료</div>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td class="title"><a href="../../page/qna/qna_detail.html">샴푸바 문의 드립니다.</a></td>
                                <td>기타</td>
                                <td>김치맨</td>
                                <td>aaaa@gmail.com</td>
                                <td class="answer">
                                    <div>답변완료</div>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td class="title"><a href="../../page/qna/qna_detail.html">샴푸바 문의 드립니다.</a></td>
                                <td>기타</td>
                                <td>김치맨</td>
                                <td>aaaa@gmail.com</td>
                                <td class="answer">
                                    <div>답변완료</div>
                                </td>
                            </tr>
                        </tbody>
                        <!-- 리스트 끝 -->
                    </table>
                    <!-- 1:1문의 리스트 끝 -->

                    <!-- 페이지네이션 시작 -->
                    <div class="paging_box">
                        <div class="paging">
                            <a class="wide">처음</a>
                            <a class="wide">이전</a>
                            <a class="on">1</a>
                            <a>2</a>
                            <a>3</a>
                            <a>4</a>
                            <a>5</a>
                            <a>6</a>
                            <a>7</a>
                            <a>8</a>
                            <a>9</a>
                            <a>10</a>
                            <a class="wide">다음</a>
                            <a class="wide">마지막</a>
                        </div>
                    </div>
                    <!-- 페이지네이션 끝 -->

                </div>
                <!-- 보드 끝 -->

        </div>
        <!-- 컨텐츠 영역 끝 -->






@endsection
