@php
header ('Pragma: no-cache');
header('Cache-Control: no-store, private, no-cache, must-revalidate');
header('Cache-Control: pre-check=0, post-check=0, max-age=0, max-stale = 0', false);
header('Pragma: public');
@endphp


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
    <script id="rendered-js" >
        /* lnb */
        (function ($) {

            var lnbUI = {
                click: function (target, speed) {
                    var _self = this,
                        $target = $(target);
                    _self.speed = speed || 300;

                    $target.each(function () {
                        if (findChildren($(this))) {
                            return;
                        }
                        $(this).addClass('noDepth');
                    });

                    function findChildren(obj) {
                        return obj.find('> ul').length > 0;
                    }

                    $target.on('click', 'a', function (e) {
                        e.stopPropagation();
                        var $this = $(this),
                            $depthTarget = $this.next(),
                            $siblings = $this.parent().siblings();

                        $this.parent('li').find('ul li').removeClass('on');
                        $siblings.removeClass('on');
                        $siblings.find('ul').slideUp(250);

                        if ($depthTarget.css('display') == 'none') {
                            _self.activeOn($this);
                            $depthTarget.slideDown(_self.speed);
                        } else {
                            $depthTarget.slideUp(_self.speed);
                            _self.activeOff($this);
                        }

                    });

                },
                activeOff: function ($target) {
                    $target.parent().removeClass('on');
                },
                activeOn: function ($target) {
                    $target.parent().addClass('on');
                } };



            // Call lnbUI
            $(function () {
                lnbUI.click('.lnb li', 300);
            });


        })(jQuery);
        //# sourceURL=pen.js
    </script>

</head>
<body>
<div class="wrap">

    <!-- 헤더 시작 -->
    <div class="header">
        @if(auth()->user())
        <a href="{{ route('logout.destroy') }}" class="log">로그아웃</a>
        @endif
        <div class="left_menu">
            <a href="./index.html" class="logo_sm">
                <h1>지구랭</h1>
            </a>
            <div class="lnb">
                <ul>
                    <li>
                        <a href="#none">상품관리</a>
                        <ul>
                            <li>
                                <a href="./page/product/category.html">카테고리관리</a>
                            </li>
                            <li>
                                <a href="./page/product/product.html">상품관리</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="./page/order/order_01.html">주문관리</a>
                    </li>
                    <li>
                        <a href="#none">평가단관리</a>
                        <ul>
                            <li>
                                <a href="./page/experience/experience.html">평가단 리스트</a>
                            </li>
                            <li>
                                <a href="./page/experience/experience_choice.html">평가단 선정</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#none">리뷰 관리</a>
                        <ul>
                            <li><a href="./page/review/review.html">리뷰 관리</a></li>
                            <li><a href="./page/review/review_item.html">정량평가 항목 관리</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="./page/qna/qna.html">1:1 문의 관리</a>
                    </li>
                    <li>
                        <a href="#none">컨텐츠 관리</a>
                        <ul>
                            <li><a href="#none">디스플레이관리</a>
                                <ul>
                                    <li><a href="./page/contents/banner_top.html">상단배너</a></li>
                                    <li><a href="./page/contents/banner_btm.html">하단배너</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="./page/contents/jigoorok.html">지구록 관리</a>
                            </li>
                            <li>
                                <a href="./page/contents/pop.html">팝업 관리</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="./page/member/member.html">회원관리</a>
                    </li>
                    <li>
                        <a href="#none">설정</a>
                        <ul>
                            <li><a href="./page/set/basic.html">기본 설정</a></li>
                            <li><a href="./page/set/del_price.html">추가 배송비 설정</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- 헤더 끝 -->


    <!-- 컨테이너 시작 / 대쉬보드 -->
    <div class="container">

        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>대쉬보드</h2>
            </div>
        </div>

        <!-- 컨텐츠 영역 -->
        <div class="contents_area dashboard">

            <!-- 주문현황 -->
            <h3>주문 현황</h3>
            <div class="box_noti">
                <ul>
                    <li>
                        <div>신규주문(결제완료)</div>
                        <div><a href="./page/order/order_01.html">20건</a></div>
                    </li>
                    <li>
                        <div>주문확인</div>
                        <div><a href="./page/order/order_02.html">30건</a></div>
                    </li>
                    <li>
                        <div>발송</div>
                        <div><a href="./page/order/order_03.html">200건</a></div>
                    </li>
                </ul>
            </div>

            <!-- 교환 -->
            <h3>교환</h3>
            <div class="box_noti">
                <ul>
                    <li>
                        <div>교환 요청</div>
                        <div><a href="./page/order/order_05.html">3건</a></div>
                    </li>
                </ul>
            </div>

            <!-- 1:1 문의 -->
            <h3>1:1 문의</h3>
            <div class="box_noti">
                <ul>
                    <li>
                        <div>미처리 문의건</div>
                        <div><a href="./page/qna/qna.html">2건</a></div>
                    </li>
                </ul>
            </div>

            <!-- 평가/리뷰 현황 -->
            <h3>평가/리뷰 현황</h3>
            <div class="box_noti">
                <ul>
                    <li>
                        <div>누적 평가 리뷰</div>
                        <div><a href="./page/review/review.html">200건</a></div>
                    </li>
                    <li>
                        <div>신규리뷰 (2022-01-05)</div>
                        <div><a href="./page/review/review.html">15건</a></div>
                    </li>
                </ul>
            </div>

            <!-- 회원 현황 -->
            <h3>회원 현황</h3>
            <div class="box_noti">
                <ul>
                    <li>
                        <div>총회원수</div>
                        <div><a href="./page/member/member.html">23,123명</a></div>
                    </li>
                    <li>
                        <div>신규가입</div>
                        <div><a href="./page/member/member.html">24명</a></div>
                    </li>
                    <li>
                        <div>탈퇴</div>
                        <div><a href="./page/member/member.html">38명</a></div>
                    </li>
                </ul>
            </div>

        </div>
        <!-- 컨텐츠 영역 끝 -->

    </div>
    <!-- 컨테이너 끝 -->


</div>
</body>
</html>




















