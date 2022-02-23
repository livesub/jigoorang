<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, minimum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta property="og:title" content="지구랭">
    <meta property="og:description" content="지구랭">
    <meta property="og:image" content="{{ asset('/design/resources/logo.png') }}">

    <title>지구랭 관리자</title>
    <link rel="icon" href="{{ asset('/design/adm/img/sym.png') }}">

    <!-- css-->
    <link rel="stylesheet" href="{{ asset('/design/adm/css/reset_adm.css') }}">
    <link rel="stylesheet" href="{{ asset('/design/adm/css/layout_adm.css') }}">
    <link rel="stylesheet" href="{{ asset('/design/adm/css/style_adm.css') }}">

    <!-- script -->
    <!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script> -->
    <script src='//code.jquery.com/jquery-3.3.1.min.js'></script>



</head>
<body>
<div class="wrap">

            <!-- 모달 시작-->
            <div class="modal_002 modal fade" id="exp_pop">




                <div class="modal-background" onclick="closemodal_002()"></div>
                <div class="modal-dialog">
                    <div class="top_close" onclick="closemodal_002()"></div>
                    <div class="modal_area">
                        <div>
                            <select>
                                <option>전체</option>
                                <option>욕실</option>
                                <option>└ 페이셜 클렌징바</option>
                            </select>
                            <select>
                                <option>상품명</option>
                                <option>상품코드</option>
                            </select>
                            <input type="text" name="" placeholder="">
                            <button type="button" class="btn-ln blk-ln" onclick="">검색</button>
                        </div>

                        <!-- 보드 시작 -->
                        <div class="board">
                            <table>
                                <colgroup>
                                    <col style="width: 40px;">
                                    <col style="width: 60px;">
                                    <col style="width: 180px;">
                                    <col style="width: 180px;">
                                    <col style="width: auto;">
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>번호</th>
                                        <th>분류</th>
                                        <th>상품코드</th>
                                        <th>상품명</th>
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
                                        <td>
                                            sitem_1212121212
                                        </td>
                                        <td class="prod_name">
                                            <div>
                                                <div>
                                                    <img src="../../img/img_prod_01.png">
                                                </div>
                                                <div>
                                                    [대나무샵]친환경칫솔 친환경칫솔친환경칫솔친환경칫 환경칫솔친환경칫솔친환
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" class="mg00" id=""></td>
                                        <td>10</td>
                                        <td class="cate_name">
                                            <div>
                                                욕실
                                                <div>└ 페이셜 클렌징바</div>
                                            </div>
                                        </td>
                                        <td>
                                            sitem_1212121212
                                        </td>
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
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" class="mg00" id=""></td>
                                        <td>10</td>
                                        <td class="cate_name">
                                            <div>
                                                욕실
                                                <div>└ 페이셜 클렌징바</div>
                                            </div>
                                        </td>
                                        <td>
                                            sitem_1212121212
                                        </td>
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
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" class="mg00" id=""></td>
                                        <td>10</td>
                                        <td class="cate_name">
                                            <div>
                                                욕실
                                                <div>└ 페이셜 클렌징바</div>
                                            </div>
                                        </td>
                                        <td>
                                            sitem_1212121212
                                        </td>
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
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" class="mg00" id=""></td>
                                        <td>10</td>
                                        <td class="cate_name">
                                            <div>
                                                욕실
                                                <div>└ 페이셜 클렌징바</div>
                                            </div>
                                        </td>
                                        <td>
                                            sitem_1212121212
                                        </td>
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
                </div>






            </div>
            <!-- 모달 끝 -->




    </div>
</body>
</html>