@extends('layouts.head')

@section('content')

    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('mypage.index') }}">마이페이지</a></li>
                <li><a href="{{ route('mypage.orderview') }}">취소/교환/반품</a></li>

            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area list">
            <h2>교환/반품 신청</h2>
            <div class="line_14-100"></div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 주문 배송내역 시작  -->
        <div class="eval">

            <div class="board mypage_list">
                <!-- 리스트 시작 -->
                <div class="board_wrap">

                    <div class="list ev_rul inner">
                      <div class="sub_title"><h4 class="bold">주문 내역</h4></div>
                      <div class="pr_body pd-00">
                            <div class="pr-t pd-00">
                                <div class="pr_img">
                                    <img src="{{ $image }}" alt="">
                                </div>

                                <div class="pr_name">
                                    <span class="cr_02">주문취소</span>

                                    <ul>
                                        <a href=""><li><h4 class="mt-10">[대나무숲] 요즘 인싸들만 쓴다는 아이템 000칫솔</h4></li></a>
                                        <li>소형 / 파랑</li>
                                        <li class="price_pd">6000원 1개</li>
                                    </ul>

                                </div>
                            </div>
                      </div>
                    </div>

                       <div class="list ev_rul inner">
                        <div class="sub_title"><h4>교환/반품 사유</h4></div>
                           <div class="pr_body pd-00">
                             <div class="pr_name m-00">

                                 <ul class="oder_name wt-00 wt-01">
                                   <li>사유 <span class="cr_03">(필수)</span></li>
                                   <li>
                                   <select name="" id="">
                                      <option value="">1</option>
                                      <option value="">2</option>
                                      <option value="">3</option>
                                   </select>
                                  </li>
                                 </ul>

                                 <ul class="oder_name wt-00 wt-01">
                                  <li>상세사유 (선택)</li>
                                  <li><textarea name="" id="" cols="30" rows="10" placeholder="내용을 입력해 주세요"></textarea></li>
                                </ul>

                              </div>
                          </div>

                          <div class="pd-20">
                            <div class="oder">
                              <h4 class="cr_06">안내사항</h4>
                               <ul>
                                <li class="text">
                                  <span class="cr_06">
                                   관리자가 확인 후 조치 해 드리겠습니다.<br>
                                   경우에 따라 추가 배송비가 발생할 수 있습니다.
                                  </span>
                                </li>
                              </ul>
                            </div>
                        </div>
                      </div>

                      <div class="btn">
                        <a href=""><button class="btn-50-bg">등록</button></div>
                      </div>




                </div>
                <!-- 리스트 끝 -->


            </div>

        </div>
        <!-- 주문 배송 내역 끝  -->



    </div>
    <!-- 서브 컨테이너 끝 -->



@endsection
