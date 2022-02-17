@extends('layouts.admhead')

@section('content')

        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>상품 관리</h2>
                <div class="button_box">
                    <button type="button" onclick="location.href='../../page/product/product_rgst.html'">상품 등록</button>
                    <button type="button" class="gray" onclick="">선택 삭제</button>
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area cate">

            <form>

                <!-- 검색창 시작 -->
                <div class="box_search">
                    <ul>
                        <li>카테고리 선택</li>
                        <li>
                            <select>
                                <option>전체</option>
                                <option>욕실</option>
                                <option>└ 치약</option>
                                <option>└ 샴푸바</option>
                            </select>
                        </li>
                        <li>기획전 구분</li>
                        <li>
                            <label>
                                <input type="checkbox" id="" checked="checked">기획전 미등록 상품
                            </label>
                            <label>
                                <input type="checkbox" id="" checked="checked">기획전1
                            </label>
                            <label>
                                <input type="checkbox" id="" checked="checked">기획전2
                            </label>
                            <label>
                                <input type="checkbox" id="" checked="checked">New Arrivals
                            </label>
                        </li>
                        <li>상품</li>
                        <li>
                            <select>
                                <option>상품명</option>
                                <option>상품코드</option>
                            </select>
                            <input type="text" name="" placeholder="">
                        </li>
                    </ul>
                    <button type="button" onclick="">검색</button>
                </div>
                <!-- 검색창 끝-->

                <!-- 보드 시작 -->
                <div class="board">
                    <table>
                        <colgroup>
                            <col style="width: 40px;">
                            <col style="width: 60px;">
                            <col style="width: 200px;">
                            <col style="width: 160px;">
                            <col style="width: auto;">
                            <col style="width: 100px;">
                            <col style="width: 100px;">
                            <col style="width: 100px;">
                            <col style="width: 100px;">
                            <col style="width: 120px;">
                        </colgroup>
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="mg00" id=""></th>
                                <th>번호</th>
                                <th>분류</th>
                                <th>상품코드</th>
                                <th>상품명</th>
                                <th>상품유형</th>
                                <th>기획전1</th>
                                <th>기획전2</th>
                                <th>New Arrival</th>
                                <th>관리</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="checkbox" class="mg00" id=""></td>
                                <td>10</td>
                                <td class="cate_name">
                                    <div>
                                        욕실
                                        <div>└ 페이셜 클렌징바</div>
                                    </div>
                                </td>
                                <td>sitem_1234512345</td>
                                <td class="prod_name">
                                    <div>
                                        <div>
                                            <img src="../../img/img_prod_01.png">
                                        </div>
                                        <div>
                                            [대나무샵]친환경칫솔 친환경칫솔친환경칫솔친환경칫
                                        </div>
                                    </div>
                                </td>
                                <td>SALE</td>
                                <td></td>
                                <td></td>
                                <td>등록</td>
                                <td><button type="button" class="btn-sm-ln" onclick="location.href='../../page/product/product_rgst.html'">수정</button></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="mg00" id=""></td>
                                <td>9</td>
                                <td class="cate_name">
                                    <div>
                                        욕실
                                        <div>└ 페이셜 클렌징바</div>
                                    </div>
                                </td>
                                <td>sitem_1234512345</td>
                                <td class="prod_name change">
                                    <div>
                                        <div>
                                            <img src="../../img/img_prod_01.png">
                                        </div>
                                        <div>
                                            [대나무샵]친환경칫솔 친환경칫솔친환경칫솔친환경칫
                                        </div>
                                    </div>
                                </td>
                                <td>HOT</td>
                                <td>등록</td>
                                <td></td>
                                <td></td>
                                <td><button type="button" class="btn-sm-ln" onclick="location.href='../../page/product/product_rgst.html'">수정</button></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="mg00" id=""></td>
                                <td>8</td>
                                <td class="cate_name">
                                    <div>
                                        욕실
                                        <div>└ 페이셜 클렌징바</div>
                                    </div>
                                </td>
                                <td>sitem_1234512345</td>
                                <td class="prod_name">
                                    <div>
                                        <div>
                                            <img src="../../img/img_prod_01.png">
                                        </div>
                                        <div>
                                            [대나무샵]친환경칫솔 친환경칫솔친환경칫솔친환경칫
                                        </div>
                                    </div>
                                </td>
                                <td>NEW</td>
                                <td></td>
                                <td>등록</td>
                                <td>등록</td>
                                <td><button type="button" class="btn-sm-ln" onclick="location.href='../../page/product/product_rgst.html'">수정</button></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="mg00" id=""></td>
                                <td>7</td>
                                <td class="cate_name">
                                    <div>
                                        욕실
                                        <div>└ 페이셜 클렌징바</div>
                                    </div>
                                </td>
                                <td>sitem_1234512345</td>
                                <td class="prod_name">
                                    <div>
                                        <div>
                                            <img src="../../img/img_prod_01.png">
                                        </div>
                                        <div>
                                            [대나무샵]친환경칫솔 친환경칫솔친환경칫솔친환경칫
                                        </div>
                                    </div>
                                </td>
                                <td>BIG SALE</td>
                                <td>등록</td>
                                <td>등록</td>
                                <td>등록</td>
                                <td><button type="button" class="btn-sm-ln" onclick="location.href='../../page/product/product_rgst.html'">수정</button></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" class="mg00" id=""></td>
                                <td>6</td>
                                <td class="cate_name">
                                    <div>
                                        욕실
                                        <div>└ 페이셜 클렌징바</div>
                                    </div>
                                </td>
                                <td>sitem_1234512345</td>
                                <td class="prod_name">
                                    <div>
                                        <div>
                                            <img src="../../img/img_prod_01.png">
                                        </div>
                                        <div>
                                            [대나무샵]친환경칫솔 친환경칫솔친환경칫솔친환경칫친환경칫솔 친환경칫솔친환경칫솔친환경칫
                                        </div>
                                    </div>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><button type="button" class="btn-sm-ln" onclick="location.href='../../page/product/product_rgst.html'">수정</button></td>
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

            </form>

        </div>
        <!-- 컨텐츠 영역 끝 -->


@endsection
