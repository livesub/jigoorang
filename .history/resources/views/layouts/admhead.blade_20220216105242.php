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
            <a href="{{ route('adm.dashboard.index') }}" class="logo_sm">
                <h1>지구랭</h1>
            </a>
            <div class="lnb">
                <ul>
                    <li>
                        <a href="#none">상품관리</a>
                        <ul>
                            <li>
                                <a href="{{ route('shop.cate.index') }}">카테고리관리</a>
                            </li>
                            <li>
                                <a href="{{ route('shop.item.index') }}">상품관리</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('orderlist') }}">주문관리</a>
                    </li>
                    <li>
                        <a href="#none">평가단관리</a>
                        <ul>
                            <li>
                                <a href="{{ route('adm_exp_index') }}">평가단 리스트</a>
                            </li>
                            <li>
                                <a href="{{ route('adm.approve.index') }}">평가단 선정</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#none">리뷰 관리</a>
                        <ul>
                            <li><a href="{{ route('adm.review.reviewlist') }}">리뷰 관리</a></li>
                            <li><a href="{{ route('admRating.index') }}">정량평가 항목 관리</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('adm.qna_list') }}">1:1 문의 관리</a>
                    </li>
                    <li>
                        <a href="#none">컨텐츠 관리</a>
                        <ul>
                            <li><a href="#none">디스플레이관리</a>
                                <ul>
                                    <li><a href="{{ route('adm.banner.index', 1) }}">상단배너</a></li>
                                    <li><a href="{{ route('adm.banner.index', 2) }}">하단배너</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="{{ route('adm.notice') }}">지구록 관리</a>
                            </li>
                            <li>
                                <a href="{{ route('adm.popup.index') }}">팝업 관리</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('adm.member.index') }}">회원관리</a>
                    </li>
                    <li>
                        <a href="#none">설정</a>
                        <ul>
                            <li><a href="{{ route('shop.setting.index') }}">기본 설정</a></li>
                            <li><a href="{{ route('shop.sendcost.index') }}">추가 배송비 설정</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- 헤더 끝 -->

    <div class="container">
    @yield('content')
    </div>


    {{-- alert_messages Error --}}
    @if (Session::has('alert_messages'))
    <script>
        alert('{!! Session::get('alert_messages') !!}');
    </script>
    @endif

</div>
</body>
</html>