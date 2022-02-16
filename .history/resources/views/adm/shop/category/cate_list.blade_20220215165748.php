@extends('layouts.admhead')

@section('content')


    <!-- 컨테이너 시작 -->
    <div class="container">

        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>대분류/소분류 관리</h2>
                <div class="button_box">
                    <button type="button" onclick="location.href='../../page/product/category_rgst.html'">대분류 등록<!-- 수정 --></button>
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area cate">

            <!-- 가이드 문구 시작 -->
            <div class="box_guide">
                <h4>안내사항</h4>
                <p>-대분류/소분류로 등록 가능합니다.</p>
                <p>-카테고리 삭제는 하위 카테고리가 없거나 카테고리 내에 등록된 상품이 없는 경우에 삭제 가능합니다.</p>
                <p>-삭제하려는 카테고리에 상품 등록을 했을 경우는 상품의 카테고리를 변경 후 삭제가 가능합니다.(이미 삭제한 상품이 해당 카테고리에 속해 있는 경우 삭제 불가 합니다.)</p>
            </div>
            <!-- 가이드 문구 끝-->

            <!-- 보드 시작 -->
            <div class="board">
                <table>
                    <colgroup>
                        <col style="width: 80px;">
                        <col style="width: 100px;">
                        <col style="width: auto;">
                        <col style="width: 80px;">
                        <col style="width: 100px;">
                        <col style="width: 100px;">
                        <col style="width: 120px;">
                        <col style="width: 120px;">
                        <col style="width: 100px;">
                        <col style="width: 100px;">
                        <col style="width: 100px;">
                        <col style="width: 100px;">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>번호</th>
                            <th>분류코드</th>
                            <th>카테고리명</th>
                            <th>이미지</th>
                            <th>뎁스</th>
                            <th>노출여부</th>
                            <th>대분류<br>출력순위</th>
                            <th>소분류<br>출력순위</th>
                            <th>랭킹출력</th>
                            <th colspan="3">관리</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>20</td>
                            <td class="group">10</td>
                            <td class="cate_name">
                                <div>
                                    욕실
                                </div>
                            </td>
                            <td class="thumb"><img src="../../img/img_prod_01.png"></td>
                            <td>대분류</td>
                            <td>노출</td>
                            <td>1</td>
                            <td></td>
                            <td></td>
                            <td><button type="button" class="btn-sm-ln" onclick="location.href='../../page/product/category_rgst_sm.html'">추가</button></td>
                            <td><button type="button" class="btn-sm-ln" onclick="location.href='../../page/product/category_rgst.html'">수정</button></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>19</td>
                            <td class="group">1010</td>
                            <td class="cate_name">└ 치약</td>
                            <td class="thumb"><img src="../../img/img_prod_01.png"></td>
                            <td>소분류</td>
                            <td>노출</td>
                            <td></td>
                            <td>1</td>
                            <td>
                                <label>
                                    <input type="checkbox" id="">출력
                                </label>
                            </td>
                            <td></td>
                            <td><button type="button" class="btn-sm-ln" onclick="location.href='../../page/product/category_rgst_sm.html'">수정</button></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>18</td>
                            <td class="group">1020</td>
                            <td class="cate_name">└ 칫솔</td>
                            <td class="thumb"><img src="../../img/img_prod_01.png"></td>
                            <td>소분류</td>
                            <td>노출</td>
                            <td></td>
                            <td>2</td>
                            <td>
                                <label>
                                    <input type="checkbox" id="">출력
                                </label>
                            </td>
                            <td></td>
                            <td><button type="button" class="btn-sm-ln" onclick="location.href='../../page/product/category_rgst_sm.html'">수정</button></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>17</td>
                            <td class="group">1030</td>
                            <td class="cate_name">└ 샴푸바</td>
                            <td class="thumb"><img src="../../img/img_prod_01.png"></td>
                            <td>소분류</td>
                            <td>노출</td>
                            <td></td>
                            <td>0</td>
                            <td>
                                <label>
                                    <input type="checkbox" id="">출력
                                </label>
                            </td>
                            <td></td>
                            <td><button type="button" class="btn-sm-ln" onclick="location.href='../../page/product/category_rgst_sm.html'">수정</button></td>
                            <td><button type="button" class="btn-sm-ln" onclick="location.href='#'">삭제</button></td>
                        </tr>
                    </tbody>
                </table>

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

    </div>
    <!-- 컨테이너 끝 -->












@endsection
