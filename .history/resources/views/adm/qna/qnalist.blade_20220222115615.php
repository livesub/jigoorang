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

            <form>

                <!-- 검색창 시작 -->
                <div class="box_search">
                    <ul>
                        <li>답변 여부</li>
                        <li>
                            <label>
                                <input type="radio" name="answer_type" value="all" checked="checked">전체
                            </label>
                            <label>
                                <input type="radio" name="answer_type" value="N">답변대기
                            </label>
                            <label>
                                <input type="radio" name="answer_type" value="Y">답변완료
                            </label>
                        </li>
                        <li>분류</li>
                        <li>
                            <select>
                                <option>상품 관련</option>
                                <option>전체</option>
                                <option>배송관련</option>
                                <option>주문/결제 관련</option>
                                <option>취소/교환/반품 관련</option>
                                <option>포인트 관련</option>
                                <option>기타문의</option>
                            </select>
                            <select>
                                <option>이름</option>
                                <option>아이디</option>
                            </select>
                            <input class="wd250" type="text" name="" placeholder="">
                        </li>
                    </ul>
                    <button type="button" onclick="">검색</button>
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

            </form>

        </div>
        <!-- 컨텐츠 영역 끝 -->






@endsection
