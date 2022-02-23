@extends('layouts.admhead')

@section('content')

        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>상품 관리</h2>
                <div class="button_box">
                    <button type="button" onclick="location.href='{{ route('shop.item.create') }}'">상품 등록</button>
                    <button type="button" class="gray" onclick="choice_del();">선택 삭제</button>
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area cate">
                <!-- 검색창 시작 -->
                <div class="box_search">
                <form name="search_form" id="search_form" method="get" action="{{ route('shop.item.index') }}">
                    <ul>
                        <li>카테고리 선택</li>
                        <li>
                            <select name="ca_id" id="ca_id">
                                <option value="">전체</option>
                                @foreach($search_selectboxs as $search_selectbox)
                                    @php
                                        $len = strlen($search_selectbox->sca_id) / 2 - 1;
                                        $nbsp = '';
                                        for ($i=0; $i<$len; $i++) $nbsp .= '└ ';
                                        if($search_selectbox->sca_id === $ca_id) $cate_selected = "selected";
                                        else $cate_selected = "";
                                    @endphp
                                    <option value="{{ $search_selectbox->sca_id }}" {{ $cate_selected }}>{!! $nbsp !!}{{ $search_selectbox->sca_name_kr }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li>기획전 구분(작업 해야 함)</li>
                        <li>
                            <select name="special" id="special">
                                <option value="all">전체</option>
                                <option value="noregi">미등록</option>
                                <option value="item_special">기획전1</option>
                                <option value="item_special2">기획전2</option>
                                <option value="item_new_arrival">New Arrivals</option>
                            </select>


<!--
                            <label>
                                <input type="checkbox" name="un_regi" value="Y" checked="checked">기획전 미등록 상품
                            </label>
                            <label>
                                <input type="checkbox" name="item_special" value="Y" checked="checked">기획전1
                            </label>
                            <label>
                                <input type="checkbox" name="item_special2" value="Y" checked="checked">기획전2
                            </label>
                            <label>
                                <input type="checkbox" name="item_new_arrival" value="Y" checked="checked">New Arrivals
                            </label>
-->
                        </li>
                        <li>상품</li>
                        <li>
                            <select name="item_search" id="item_search">
                            @php
                                if($item_search == "item_name" || $item_search == "") $item_name_selected = "selected";
                                else $item_name_selected = "";

                                if($item_search == "item_code") $item_code_selected = "selected";
                                else $item_code_selected = "";
                            @endphp
                                <option value="item_name" {{ $item_name_selected }}>상품명</option>
                                <option value="item_code" {{ $item_code_selected }}>상품코드</option>
                            </select>
                            <input type="text"  name="keyword" id="keyword" value="{{ $keyword }}" placeholder="">
                        </li>
                    </ul>
                    <button type="submit">검색</button>
                </form>
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
