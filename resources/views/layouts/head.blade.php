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

    <link rel="stylesheet" href="{{ asset('/design/css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('/design/css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('/design/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/design/css/responsive.css') }}">

    <title>지구랭</title>
</head>
<body>

<script src="{{ mix('js/common.js') }}"></script>
<!-- 암호화 복호화를 위한 js 추가 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/sha256.js"></script>
<script src='//code.jquery.com/jquery-3.3.1.min.js'></script>

<div class="wrap">

    <!-- 탭바 시작 -->
    <div class="tabar">
        <ul>
            <li><a href="#">홈</a></li>
            <li><a href="#">랭킹</a></li>
            <li><a href="#">쇼핑</a></li>
            <li><a href="#">기록</a></li>
        </ul>
    </div>
    <!-- 탭바 끝 -->

    <!-- 헤더 시작-->
    <div class="header">
        <div class="top">
            <div class="logo">
                <a href="/"></a>
                <h1>지구랭</h1>
            </div>

            <!-- 모바일 메뉴 시작 -->
            <div class="ham">
                <a class="btn_ham" onclick="openNav()"><span class="name">햄버거</span></a>
            </div>

            <div class="background"></div>
            <div id="Sidenav" class="sidenav">
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">
                  <img src="{{ asset('/design/recources/icons/icon-cls.png') }}" alt="">
                </a>

                <div class="m-menu">
                    <ul class="m-menu-my">
                        <a href="#"><li>로그인<span class="m-menu-my-boder"></span></li></a>
                        <!-- <a href="#"><li>로그아웃<span class="m-menu-my-boder"></span></li></a>  -->

                        <a href="../../page/mypage/mypage.html"><li>마이페이지</li></a>
                    </ul>

                    <ul class="m-menu-child">
                        <a href="#">
                            <li>지구랭소개</li>
                        </a>
                        <a href="#">
                                <li><b>지</b>구랭 <b>구</b>하는 <b>랭</b>킹 </li>
                        </a>
                        <a href="#">
                                <li><b>지</b>구랭 <b>구</b>하는 <b>쇼핑</b> </li>
                        </a>
                        <a href="#">
                                <li><b>지</b>구랭 <b>구</b>하는 기<b>록</b> </li>
                        </a>
                        <a href="{{ route('exp.list') }}"><li>정직한 평가단 </li></a>
                        <a href="#"><li>고객센터 </li></a>
                    </ul>
                </div>
            </div>
            <!-- 모바일 메뉴 끝 -->

            <!-- <ul class="menu">
                <li class="search"><a href="#"><span>검색</span></a></li>
                <li class="cart">
                    <a class="conunt"><p id="">0</p></a>
                    <a><span>장바구니</span></a>
                </li>
                <li class="my"><a><span>마이페이지</span></a></li>
                <li class="login"><a href="/page/login/login.html"><span>로그인</span></a></li>
                <li class="loginout"><a href=""><span>로그아웃</span></a></li>
            </ul> -->

            <!-- 오픈전 메뉴 -->
            <ul class="menu2">
            @if(!auth()->user())
                <li class="my"><a href="{{ route('join.create_agree') }}"><span>마이페이지</span></a></li>
                <li class="login"><a href="{{ route('login.index') }}"><span>로그인</span></a></li>
            @else
                <li class="my"><a href="{{ route('mypage.index') }}"><span>마이페이지</span></a></li>
                <li class="loginout"><a href="{{ route('logout.destroy') }}"><span>로그아웃</span></a></li>
            @endif
            </ul>

        </div>

        <div class="btm">
            <ul class="navi">
                <li><a href="">지구랭 소개</a></li>
                <li><a href=""><b>지</b>구랭 <b>구</b>하는 <b>랭</b>킹</a></li>
                <li><a href=""><b>지</b>구랭 <b>구</b>하는 <b>쇼핑</b></a></li>
                <li><a href=""><b>지</b>구랭 <b>구</b>하는 기<b>록</b></a></li>
                <li class="on"><a href="{{ route('exp.list') }}">정직한 평가단</a></li>
                <li><a href="">고객센터</a></li>
            </ul>
        </div>
    </div>
    <!-- 헤더 끝 -->

    {{-- 각 내용 뿌리기 --}}
    @yield('content')




@php
    $setting_info = DB::table('shopsettings')->first();
    $company_name = '';
    $company_owner = '';
    $company_saupja_no = '';
    $company_tongsin_no = '';
    $company_info_name = '';
    $company_tel = '';
    $company_zip = '';
    $company_addr = '';
    $company_info_email = '';

    if($setting_info != ''){
        $company_name = $setting_info->company_name;
        $company_owner = $setting_info->company_owner;
        $company_saupja_no = $setting_info->company_saupja_no;
        $company_tongsin_no = $setting_info->company_tongsin_no;
        $company_info_name = $setting_info->company_info_name;
        $company_tel = $setting_info->company_tel;
        $company_zip = $setting_info->company_zip;
        $company_addr = $setting_info->company_addr;
        $company_info_email = $setting_info->company_info_email;
    }
@endphp

    <!-- 푸터 시작 -->
    <div class="footer">
        <div class="head">
            <ul>
                <li><a href="">이용약관</a></li>
                <li><a href="">개인정보처리방침</a></li>
            </ul>
        </div>
        <div class="bottom">
            <div class="con_01">
                <div class="title">{{ $company_name }}</div>
                <ul>
                    <li>대표이사 : {{ $company_owner }}</li>
                    <li>사업자등록번호 : {{ $company_saupja_no }} </li>
                    <li>통신판매업신고 : {{ $company_tongsin_no }}</li>
                    <li>개인정보관리책임자 : {{ $company_info_name }}</li>
                </ul>
            </div>
            <div class="con_01">
                <div class="title">CONTACT US</div>
                <ul>
                    <li>대표전화 : {{ $company_tel }}</li>
                    <li>{{ $company_zip }} {{ $company_addr }}</li>
                    <li>이메일 : {{ $company_info_email }}</li>
                </ul>
            </div>
            <div class="logo_f"></div>
            <div class="copy">ⓒ GIGURANG</div>
        </div>
    </div>
    <!-- 푸터 끝 -->

</div>
    <script src="{{ asset('/design/js/sidenav.js') }}"></script>


    {{-- alert_messages Error --}}
    @if (Session::has('alert_messages'))
    <script>
        alert('{!! Session::get('alert_messages') !!}');
    </script>
    @endif
    @yield('script')

</body>
</html>

