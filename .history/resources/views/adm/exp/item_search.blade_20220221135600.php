

                @php
                    $search_selectboxs = DB::table('shopcategorys')->where('sca_display', 'Y')->orderby('sca_id','ASC')->orderby('sca_rank','ASC')->get();
                @endphp

                <div class="modal-background" onclick="closemodal_002()"></div>
                <div class="modal-dialog">
                    <div class="top_close" onclick="closemodal_002()"></div>
                    <div class="modal_area">
                        <div>
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
                            <select name="item_search" id="item_search" >
                                @php
                                    if($item_search == "item_name" || $item_search == "") $item_name_selected = "selected";
                                    else $item_name_selected = "";

                                    if($item_search == "item_code") $item_code_selected = "selected";
                                    else $item_code_selected = "";
                                @endphp
                                <option value="item_name" {{ $item_name_selected }}>상품명</option>
                                <option value="item_code" {{ $item_code_selected }}>상품코드</option>
                            </select>
                            <input type="text" name="item_keyword" id="item_keyword" value="{{ $item_keyword }}">
                            <button type="button" class="btn-ln blk-ln" onclick="open_pop()">검색</button>
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
                                @php
                                    $virtual_num = count($item_infos);
                                @endphp
                                @foreach($item_infos as $item_info)
                                @php
                                    //이미지 처리
                                    if($item_info->item_img1 == "") {
                                        $item_img_disp = asset("img/no_img.jpg");
                                    }else{
                                        $item_img_cut = explode("@@",$item_info->item_img1);
                                        $item_img_disp = "/data/shopitem/".$item_img_cut[3];
                                    }

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

                                    if($item_info->item_manufacture == "") $item_manufacture = "";
                                    else $item_manufacture = "[".$item_info->item_manufacture."] ";
                                @endphp

                                    <tr>
                                        <td><input type="checkbox" name="chk_id[]" value="{{ $item_info->id }}" id="chk_id_{{ $item_info->id }}" class="mg00" onclick="click_ck({{ $item_info->id }},'{{ $item_info->item_name }}')"></td>
                                        <td>{{ $virtual_num }}</td>
                                        <td class="cate_name">
                                            <div>{{$ca_name_hap}}
                                            </div>
                                        </td>
                                        <td>
                                            {{ $item_info->item_code }}
                                        </td>
                                        <td class="prod_name">
                                            <div>
                                                <div>
                                                    <img src="{{ $item_img_disp }}">
                                                </div>
                                                <div>
                                                    {{ $item_manufacture }}{{ stripslashes($item_info->item_name) }}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @php
                                        $virtual_num--;
                                    @endphp
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- 보드 끝 -->
                    </div>
                </div>
</form>


<script>
    function click_ck(id, item_name){
        alert(id);
        alert(item_name);
        var ment = "선택한 상품명 : " + item_name;
        $("#choice_name").html(ment);
        closemodal_002();
        //opener.document.getElementById("exp_item_code").value = document.getElementById("chk_id_"+$id).value;
        //opener.document.getElementById("exp_item_show_name").innerText = document.getElementById("item_name_"+$id).value;
        //opener.document.getElementById("exp_item_name").value = document.getElementById("item_name_"+$id).value;
        //window.close();
    }

</script>