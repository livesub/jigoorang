@php
    header ('Pragma: no-cache');
    header('Cache-Control: no-store, private, no-cache, must-revalidate');
    header('Cache-Control: pre-check=0, post-check=0, max-age=0, max-stale = 0', false);
    header('Pragma: public');

    //url 주소의 / 를 잘라내어 마지막 배열값(페이지명)을 가져 온다
    //메뉴 class="on" 하기 위해
    $path_cut = explode("/",Request::path());
    //$path_chk = array_pop($path_cut);
    $menu_exp = '';
    $menu_center = '';
    $menu_ranking = '';
    $menu_shop = '';
    $menu_notice = '';

    if($path_cut[0] == "exp" || $path_cut[0] == "list" || $path_cut[0] == "") $menu_exp = ' class="on" ';
    else if($path_cut[0] == "customer_center") $menu_center = ' class="on" ';
    else if($path_cut[0] == "customer_center") $menu_ranking = ' class="on" ';


@endphp

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta property="og:title" content="지구랭">
    <meta property="og:description" content="지구랭">
    <meta property="og:image" content="{{ asset('/design/resources/logo.png') }}">
    <meta name="naver-site-verification" content="fb44216dac5adf92f534a7f19c86a31276e15416" />

    <link rel="canonical" href="http://jigoorang.com/">
    <meta name="description" content="지구랭은 사용자들의 실사용 리뷰와 평가 점수를 통한 랭킹을 산출하여 지구를 위한 친환경 제품의 소비를 지향하는 플랫폼 입니다.">
    <link rel="shortcut icon" href="{{ asset('/design/recources/icons/sym.png') }}"><!-- 파비콘 -->


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8DZ8MQSET7"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-8DZ8MQSET7');
    </script>

    <link rel="stylesheet" href="{{ asset('/design/css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('/design/css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('/design/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/design/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('/design/css/goods.css') }}"> <!-- 추가 css-->
    <link rel="stylesheet" href="{{ asset('/design/css/goods_responsive.css') }}">  <!-- 추가 css-->
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('/design/js/star.js') }}"></script>
    <title>지구랭</title>
</head>
<body>

<script src="{{ mix('js/common.js') }}"></script>
<!-- 암호화 복호화를 위한 js 추가 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/sha256.js"></script>
<script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>

<div class="wrap">
    <!-- 탭바 시작 -->
    <div class="tabar">
        <ul>
            <li><a href="/">홈</a></li>
            <li><a href="{{ route('ranking_list') }}">랭킹</a></li>
            <li><a href="{{ route('shop.index') }}">쇼핑</a></li>
            <li><a href="{{ route('notice') }}">소식</a></li>
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
                    @if(!auth()->user())
                        <a href="{{ route('login.index') }}">
                        <li>로그인 <p class="jo_p">(회원가입)</p></li></a>
                        <span class="m-menu-my-boder"></span>
                        <a href="{{ route('login.index') }}"><li>마이페이지</li></a>
                    @else
                        <a href="{{ route('logout.destroy') }}"><li>로그아웃</li></a>
                        <span class="m-menu-my-boder"></span>
                        <a href="{{ route('mypage.index') }}"><li>마이페이지</li></a>
                    @endif
                    </ul>

                    <ul class="m-menu-child">
                        <a href="{{ route('company') }}">
                            <li>지구랭 소개</li>
                        </a>
                        <a href="{{ route('ranking_list') }}">
                                <li><b>지</b>구를 <b>구</b>하는 <b>랭</b>킹 </li>
                        </a>
                        <a href="{{ route('shop.index') }}">
                                <li><b>지</b>구를 <b>구</b>하는 <b>쇼</b>핑 </li>
                        </a>
                        <a href="{{ route('notice') }}">
                                <li><b>지</b>구를 <b>구</b>하는 기<b>록</b> </li>
                        </a>
                        <a href="{{ route('exp.list') }}"><li {!! $menu_exp !!}>정직한 평가단</li></a>
                        <a href="{{ route('customer_center') }}"><li {!! $menu_center !!}>고객센터 </li></a>
                    </ul>
                </div>
            </div>
            <!-- 모바일 메뉴 끝 -->

            <!-- 수정껀 생길때 또 막음 -->
                <ul class="menu">
                    <li class="search" onclick="openmodal_001()">
                        <a>
                            <span>검색</span>
                            <p class="block">검색</p>
                            <p class="none">검색</p>
                        </a>
                    </li>

                    @if(!auth()->user())
                     @php
                            $cart_cnt = 0;
                            if(Auth::user()){
                                //장바구니 갯수 처리
                                $cart_cnt = DB::table('shopcarts as a')->where([['a.user_id', Auth::user()->user_id], ['a.sct_status','쇼핑'], ['a.sct_direct','0']])->count();
                            }
                        @endphp

                    <li class="cart">
                        <a href="{{ route('cartlist') }}">
                            <p id="" class="conunt">{{ $cart_cnt }}</p>
                            <span>장바구니</span>
                            <p class="block">장바구니</p>
                            <p class="none">장바구니</p>
                        </a>
                    </li>
                    <li class="my">
                        <a href="{{ route('login.index') }}">
                            <span>마이페이지</span>
                            <p class="block">마이페이지</p>
                            <p class="none">MY</p>
                        </a>
                    </li>
                    <li class="login">
                        <a href="{{ route('login.index') }}">
                            <span>로그인</span>
                            <p>로그인/가입</p>
                        </a>
                    </li>

                    @else
                        @php
                            $cart_cnt = 0;
                            if(Auth::user()){
                                //장바구니 갯수 처리
                                $cart_cnt = DB::table('shopcarts as a')->where([['a.user_id', Auth::user()->user_id], ['a.sct_status','쇼핑'], ['a.sct_direct','0']])->count();
                            }
                        @endphp

                    <li class="cart">
                        <a href="{{ route('cartlist') }}">
                            <p id="" class="conunt">{{ $cart_cnt }}</p>
                            <span>장바구니</span>
                            <p class="block">장바구니</p>
                            <p class="none">장바구니</p>
                        </a>
                    </li>
                    <li class="my">
                        <a href="{{ route('mypage.index') }}">
                            <span>마이페이지</span>
                            <p class="block">마이페이지</p>
                            <p class="none">MY</p>
                        </a>
                    </li>
                    <li class="login">
                        <a href="{{ route('logout.destroy') }}">
                        <span>로그아웃</span>
                        <p>로그아웃</p>
                        </a>
                    </li>

                    @endif

            <!-- 오픈전 메뉴
            <ul class="menu2">
            @if(!auth()->user())
                <li class="my"><a href="{{ route('login.index') }}">
                <span>마이페이지</span>
                <p class="block">마이페이지</p>
                <p class="none">MY</p>
                </a></li>
                <li class="login"><a href="{{ route('login.index') }}">
                <span>로그인</span>
                <p>로그인/가입</p>
                </a></li>
            @else
                <li class="my"><a href="{{ route('mypage.index') }}">
                    <span>마이페이지</span>
                    <p class="block">마이페이지</p>
                    <p class="none">MY</p>
                </a></li>

                <li class="loginout"><a href="{{ route('logout.destroy') }}">
                    <span>로그아웃</span>
                    <p class="ml-7">로그아웃</p>
                </a></li>
            @endif
             -->
            </ul>

        </div>

        <div class="btm">
            <ul class="navi">
                <li><a href="{{ route('company') }}">지구랭 소개</a></li>
                <li><a href="{{ route('ranking_list') }}"><b>지</b>구를 <b>구</b>하는 <b>랭</b>킹</a></li>
                <li><a href="{{ route('shop.index') }}"><b>지</b>구를 <b>구</b>하는 <b>쇼</b>핑</a></li>
                <li><a href="{{ route('notice') }}"><b>지</b>구를 <b>구</b>하는 기<b>록</b></a></li>

                <li {!! $menu_exp !!}><a href="{{ route('exp.list') }}">정직한 평가단</a></li>
                <li {!! $menu_center !!}><a href="{{ route('customer_center') }}">고객센터</a></li>
            </ul>
        </div>
    </div>
    <!-- 헤더 끝 -->


    <!-- 검색창 모달 -->
    <div class="modal_001 modal_sh fade">
        <div class="modal-background" onclick="closemodal_001()"></div>

        <div class="modal-dialog">

            <div class="sh_1200">
                <div class="modal-dialog-title">
                    <div class="btn-close" onclick="closemodal_001()"></div>
                </div>

                <div class="modal-dialog-contents">

                    <!-- 최근 검색어 -->
                    <div class="search-wrap">
                        <form class="search" method="get" action="{{ route('search') }}" onsubmit="return handleSearchSubmit();">
                            <input required maxlength="25" name="search_w" type="text" placeholder="검색어를 입력해 주세요" id="search-input" >
                            <button type="submit" id="serach_btn">
                                <span>검색</span>
                            </button>
                        </form>

                        <div class="search-inner">
                            <div class="sh_terms">최근 검색어</div>
                            <ul id="search-list"></ul>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>

    <script src="{{ asset('/design/js/serach.js') }}"></script>
    <script src="{{ asset('/design/js/serch_modal.js') }}"></script>








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
                <li><a href="{{ route('terms_use') }}">이용약관</a></li>
                <li><a href="{{ route('privacy') }}">개인정보처리방침</a></li>
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
                    {{-- <li>대표전화 : {{ $company_tel }}</li> --}}
                    <li>{{ $company_zip }} {{ $company_addr }}</li>
                    <li>이메일 : {{ $company_info_email }}</li>
                </ul>
            </div>
            <div class="logo_f"></div>
            <div class="copy">ⓒ JIGOORANG ALL RIGHTS RESERVED</div>
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

