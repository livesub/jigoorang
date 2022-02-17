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
                            @php
                                $selected1 = "";
                                $selected2 = "";
                                $selected3 = "";
                                $selected4 = "";
                                $selected5 = "";

                                if($special == "all") $selected1 = "selected";
                                elseif($special == "noregi") $selected2 = "selected";
                                elseif($special == "item_special") $selected3 = "selected";
                                elseif($special == "item_special2") $selected4 = "selected";
                                elseif($special == "item_new_arrival") $selected5 = "selected";
                            @endphp
                            <select name="special" id="special">
                                <option value="all" {{ $selected1 }}>전체</option>
                                <option value="noregi" {{ $selected2 }}>미등록</option>
                                <option value="item_special" {{ $selected3 }}>기획전1</option>
                                <option value="item_special2" {{ $selected4 }}>기획전2</option>
                                <option value="item_new_arrival" {{ $selected5 }}>New Arrivals</option>
                            </select>
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
                <form name="itemlist" id="itemlist" method="post" action="{{ route('shop.item.choice_del') }}">
                {!! csrf_field() !!}
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
                                <th><input type="checkbox" class="mg00" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);"></th>
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
                                <td><input type="checkbox" class="mg00" name="chk_id[]" value="{{ $item_info->id }}" id="chk_id_{{ $item_info->id }}"></td>
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
                            @endforeach


<!--
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
-->
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
                </form>
                </div>
                <!-- 보드 끝 -->
        </div>
        <!-- 컨텐츠 영역 끝 -->


<script>
    function all_checked(sw) {
        var f = document.itemlist;

        for (var i=0; i<f.length; i++) {
            if (f.elements[i].name == "chk_id[]")
                f.elements[i].checked = sw;
        }
    }
</script>

<script>
    function choice_del(){
        var chk_count = 0;
        var f = document.itemlist;

        for (var i = 0; i < f.length; i++) {
            if (f.elements[i].name == "chk_id[]" && f.elements[i].checked)
                chk_count++;
        }

        if (!chk_count) {
            alert("삭제할 상품을 하나 이상 선택하세요.");
            return false;
        }

        if (confirm("선택 하신 상품을 삭제 하시겠습니까?\n삭제된 상품은 복구 되지 않습니다.") == true){    //확인
            f.submit();
        }else{
            return;
        }
    }
</script>

<!-- validate 하기 위해선 get 방식으로 던져야 함 -->
<form name="item_modi_form" id="item_modi_form" method="get" action="{{ route('shop.item.modify') }}">
    <input type="hidden" name="id" id="id">
    <input type="hidden" name="sca_id" id="sca_id">
    <input type="hidden" name="page" id="page" value="{{ $page }}">
    <input type="hidden" name="item_search" id="item_search" value="{{ $item_search }}">
    <input type="hidden" name="keyword" id="keyword" value="{{ $keyword }}">
</form>

<script>
    function item_modi(id, sca_id){
        $("#id").val(id);
        $("#sca_id").val(sca_id);

        $("#item_modi_form").submit();
    }
</script>

<script>
    $("#ca_id").change(function(){
        location.href = "{{ route('shop.item.index') }}?ca_id="+$(this).val();
    });
</script>









@endsection
