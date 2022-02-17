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
                            <select>
                                <option value="">전체</option>
                                @foreach($search_selectboxs as $search_selectbox)
                                    @php
                                        $len = strlen($search_selectbox->sca_id) / 2 - 1;
                                        $nbsp = '';
                                        for ($i=0; $i<$len; $i++) $nbsp .= '└ ';
                                        if($search_selectbox->sca_id == $ca_id) $cate_selected = "selected";
                                        else $cate_selected = "";
                                    @endphp

                                    <option value="{{ $search_selectbox->sca_id }}" {{ $cate_selected }}>{!! $nbsp !!}{{ $search_selectbox->sca_name_kr }}</option>
                                @endforeach
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










<table>
    <tr>
        <td><h4>쇼핑몰 상품 리스트</h4></td>
    </tr>
</table>

<table>
<form name="search_form" id="search_form" method="get" action="{{ route('shop.item.index') }}">
    <tr>
        <td>
            <select name="ca_id" id="ca_id">
                <option value="">전체분류</option>
                @foreach($search_selectboxs as $search_selectbox)
                    @php
                        $len = strlen($search_selectbox->sca_id) / 2 - 1;
                        $nbsp = '';
                        for ($i=0; $i<$len; $i++) $nbsp .= '&nbsp;&nbsp;&nbsp;';
                        if($search_selectbox->sca_id == $ca_id) $cate_selected = "selected";
                        else $cate_selected = "";
                    @endphp

                    <option value="{{ $search_selectbox->sca_id }}" {{ $cate_selected }}>{!! $nbsp !!}{{ $search_selectbox->sca_name_kr }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select name="item_search" id="item_search">
                @php        //if($item_search == "") $item_search = "item_name";
                    if($item_search == "item_name" || $item_search == "") $item_name_selected = "selected";
                    else $item_name_selected = "";

                    if($item_search == "item_code") $item_code_selected = "selected";
                    else $item_code_selected = "";
                @endphp
                <option value="item_name" {{ $item_name_selected }}>상품명</option>
                <option value="item_code" {{ $item_code_selected }}>상품코드</option>
            </select>
        </td>
        <td>
            <input type="text" name="keyword" id="keyword" value="{{ $keyword }}"><button type="">검색</button>
        </td>
    </tr>
</form>
</table>

<table border=1>
<form name="itemlist" id="itemlist" method="post" action="{{ route('shop.item.choice_del') }}">
{!! csrf_field() !!}
    <tr>
        <td>선택<br><input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);" class="selec_chk"></td>
        <td>번호</td>
        <td>이미지</td>
        <td>분류</td>
        <td>상품코드</td>
        <td>상품명</td>
        <td>출력순서</td>
        <td>상품유형</td>
        <td>기획전1<br>등록여부</td>
        <td>기획전2<br>등록여부</td>
        <td>New Arrival</td>
        <td>관리</td>
    </tr>

    @foreach($item_infos as $item_info)
        @php
            //단계명 가져 오기
            $cut_hap = "";
            $item_ca_name = "";
            $ca_name_hap = "";
            $ca_id_len = 0;

            for($i = 0; $i < 10; $i += 2)
            {
                $sign = "";
                $ca_id_len = strlen($item_info->sca_id) - 2;
                $tmp_cut = substr($item_info->sca_id, $i, 2);
                if($tmp_cut != ""){
                    $cut_hap = $cut_hap.$tmp_cut;
                    $item_ca_name = DB::table('shopcategorys')->select('sca_name_kr', 'sca_name_en')->where('sca_id',$cut_hap)->first();

                    if($ca_id_len > $i){
                        $sign = " > ";
                    }

                    if($item_ca_name->sca_name_kr != ""){
                        $ca_name_hap .= $item_ca_name->sca_name_kr.$sign;
                    }
                }
            }

            //이미지 처리
            if($item_info->item_img1 == "") {
                $item_img_disp = asset("img/no_img.jpg");
            }else{
                $item_img_cut = explode("@@",$item_info->item_img1);
                $item_img_disp = "/data/shopitem/".$item_img_cut[3];
            }

            //상품유형 등록 여부
            $item_type1_ment = '';
            switch($item_info->item_type1) {
                case 1:
                    $item_type1_ment = 'NEW';
                    break;
                case 2:
                    $item_type1_ment = 'SALE';
                    break;
                case 3:
                    $item_type1_ment = 'BIG SALE';
                    break;
                case 4:
                    $item_type1_ment = 'HOT';
                    break;
                default:
                    break;
            }

            //기획전1 등록 여부
            $item_special_ment = "";
            if($item_info->item_special == "1") {
                $item_special_ment = "등록";
            }
            //기획전2 등록 여부
            $item_special_ment2 = "";
            if($item_info->item_special2 == "1") {
                $item_special_ment2 = "등록";
            }
            //new_arrival
            $item_new_arrival_ment = "";
            if($item_info->item_new_arrival == "1") {
                $item_new_arrival_ment = "등록";
            }
        @endphp
    <tr>
        <td><input type="checkbox" name="chk_id[]" value="{{ $item_info->id }}" id="chk_id_{{ $item_info->id }}" class="selec_chk"></td>
        <td>{{ $virtual_num-- }}</td>
        <td><img src="{{ $item_img_disp }}" style="width:100px;height:100px;"></td>
        <td>{{ $ca_name_hap }}</td>
        <td>{{ $item_info->item_code }}</td>
        <td>{{ stripslashes($item_info->item_name) }}</td>
        <td>{{ $item_info->item_rank }}</td>
        <td>{{ $item_type1_ment }}</td>
        <td>{{ $item_special_ment }}</td>
        <td>{{ $item_special_ment2 }}</td>
        <td>{{ $item_new_arrival_ment }}</td>
        <td>
            <button type="button" onclick="item_modi('{{ $item_info->id }}','{{ $item_info->sca_id }}');">수정</button>
        </td>
    </tr>
    @endforeach

</form>
</table>



<table>
    <tr>
        <td>
           {!! $pnPage !!}
        </td>
    </tr>
</table>












@endsection
