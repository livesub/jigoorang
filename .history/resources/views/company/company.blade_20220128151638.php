@extends('layouts.head')

@section('content')

<script src="{{ asset('/design/js/modal-back02.js') }}"></script>

    <!-- 메인 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('company') }}">지구랭 소개</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area">
            <h2>지구랭 소개</h2>
            <div class="text_02 wt-nm">
                더 많은 사람들이 친환경 제품을 경험할 수 있도록<br>
                지구랭은 경험을 모으고 나눕니다.
            </div>
            <div class="title_img"></div>
            <div class="line_14-100"></div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 게시판 시작  -->
        <div class="eval">

            <div class="board mypage_list">
                <!-- 리스트 시작 -->
                <div class="board_wrap">

                    <div class="about block">
                        <img src="{{ asset('/design/recources/imgs/bitmap01@3x.png') }}" alt="">
                        <img src="{{ asset('/design/recources/imgs/bitmap02@3x.png') }}" alt="">
                        <img src="{{ asset('/design/recources/imgs/bitmap03@3x.png') }}" alt="">
                        <img src="{{ asset('/design/recources/imgs/bitmap04@3x.png') }}" alt="" onclick="detilopenmodal_001()" id="rink">
                        <img src="{{ asset('/design/recources/imgs/bitmap05@3x.png') }}" alt="">
                        <a href="{{ route('exp.list') }}"><img src="{{ asset('/design/recources/imgs/bitmap06@3x.png') }}" alt=""></a>
                        <img src="{{ asset('/design/recources/imgs/bitmap07@3x.png') }}" alt="">
                        <img src="{{ asset('/design/recources/imgs/bitmap08@3x.png') }}" alt="">
                        <img src="{{ asset('/design/recources/imgs/bitmap09@3x.png') }}" alt="">
                        <img src="{{ asset('/design/recources/imgs/bitmap10@3x.png') }}" alt="">
                        <img src="{{ asset('/design/recources/imgs/bitmap11@3x.png') }}" alt="">
                    </div>


                    <div class="about none">
                        <img src="{{ asset('/design/recources/imgs/bitmap_m_01@3x.png') }}" alt="">
                        <img src="{{ asset('/design/recources/imgs/bitmap_m_02@3x.png') }}" alt="">
                        <img src="{{ asset('/design/recources/imgs/bitmap03@3x.png') }}" alt="">
                        <img src="{{ asset('/design/recources/imgs/bitmap04@3x.png') }}" alt="" onclick="detilopenmodal_001()" id="rink">
                        <img src="{{ asset('/design/recources/imgs/bitmap05@3x.png') }}" alt="">
                        <a href="{{ route('exp.list') }}"><img src="{{ asset('/design/recources/imgs/bitmap06@3x.png') }}" alt=""></a>
                        <img src="{{ asset('/design/recources/imgs/bitmap07@3x.png') }}" alt="">
                        <img src="{{ asset('/design/recources/imgs/bitmap08@3x.png') }}" alt="">
                        <img src="{{ asset('/design/recources/imgs/bitmap09@3x.png') }}" alt="">
                        <img src="{{ asset('/design/recources/imgs/bitmap10@3x.png') }}" alt="">
                        <img src="{{ asset('/design/recources/imgs/bitmap11@3x.png') }}" alt="">
                    </div>

                </div>
                <!-- 리스트 끝 -->
            </div>

        </div>
        <!-- 게시판 끝  -->



    </div>
    <!-- 메인 컨테이너 끝 -->



     <!-- 상세 모달 (상세보기) -->
     <div class="modal_001 modal fade">
        <div class="modal-background" onclick="detilclosemodal_001()"></div>
        <div class="modal-dialog">
            <div class="modal-dialog-title">
                <h4>랭킹산정방식 안내</h4>
                <div class="btn-close" onclick="detilclosemodal_001()">
                </div>
            </div>
            <div class="modal-dialog-contents">
                <div class="modal-dialog-contents-title">
                    <div class="about_mo">
                        <h3 class="mo_01">광고성 체험단 No!</h3>
                        <p class="mt-10">직접 사용한 분들이 남긴 양질의 리뷰가 쌓여 만들어집니다</p>

                        <img src="{{ asset('/design/recources/imgs/img_about01@3x.png') }}" alt="" class="mt-20 mb-20">

                        <p>지구를 아끼는 마음으로 친환경 제품을 <span class="cr_02">[실제 구매한 분들(상시)]과 [정직한 평가단(비정기)]</span>의 <br>
                           평가 결과가 쌓여 만들어집니다</p>
                    </div>

                    <div class="about_mo mt-40">
                        <h3 class="mo_02"> 판매량? 인기순? 획일적 평가 NO!</h3>
                        <p class="mt-10">총 5가지 중 관심있는 기준을 선택해서 볼 수 있습니다<br>
                            사용 후 자유롭게 작성된 리뷰를 함께 볼 수 있습니다</p>

                        <img src="{{ asset('/design/recources/imgs/img_about02@3x.png') }}" alt="" class="mt-20 mb-20">

                        <p class="about_ft">※  지구랭은 평가 및 결과에 대해 일체 개입하지 않습니다.<br>
                            다만, 악의적/광고적 평가 리뷰로 판단시 통보 없이 삭제될 수 있습니다 .
                        </p>
                    </div>

                </div>
                <div class="modal-dialog btn normal" onclick="detilclosemodal_001()">
                    닫기
                </div>
        </div>
        </div>
    </div>
    <!-- 상세 모달 끝 -->



@endsection
