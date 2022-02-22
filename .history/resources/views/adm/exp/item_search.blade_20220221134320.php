

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
                                @foreach($item_infos as $item_info)
                                    <tr>
                                        <td><input type="radio" class="mg00" id=""></td>
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
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- 보드 끝 -->
                    </div>
                </div>
</form>
