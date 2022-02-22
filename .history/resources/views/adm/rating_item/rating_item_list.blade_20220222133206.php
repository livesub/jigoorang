@extends('layouts.admhead')

@section('content')



        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>정량평가 항목 관리</h2>
                <div class="button_box">
                    <button type="button" onclick="view_create()">정량평가 항목 생성</button>
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area review">

                <!-- 검색창 시작 -->
                <div class="box_search">
                <form name="search_form" id="search_form" method="get" action="{{ route('admRating.index') }}">
                    <ul>
                        <li>카테고리</li>
                        <li>
                        @php
                            $search_selectboxs = DB::table('shopcategorys')->where('sca_display', 'Y')->orderby('sca_id','ASC')->orderby('sca_rank','ASC')->get();
                        @endphp
                            <select name="ca_id" id="ca_id">
                                <option value="">전체분류</option>
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
                            @php
                                if($keyword){
                                    $key = $keyword;
                                }else{
                                    $key = "";
                                }
                            @endphp
                            <input class="wd250" type="text" name="keyword" id="keyword" value="{{ $keyword }}">
                        </li>
                    </ul>
                    <button type="submit">검색</button>
                </form>
                </div>
                <!-- 검색창 끝-->

                <!-- 보드 시작 -->
                <div class="board">

                    <!-- 평가단 선정 리스트 시작 -->
                    <table>
                        <colgroup>
                            <col style="width: auto;">
                            <col style="width: 15%;">
                            <col style="width: 15%;">
                            <col style="width: 15%;">
                            <col style="width: 15%;">
                            <col style="width: 15%;">
                            <col style="width: 100px;">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>카테고리명</th>
                                <th>항목1</th>
                                <th>항목2</th>
                                <th>항목3</th>
                                <th>항목4</th>
                                <th>항목5</th>
                                <th>관리</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rating_items_rows as $rating_item)
                            @php
                                $cate_info = DB::table('shopcategorys')->select('sca_name_kr')->where('sca_id', $rating_item->sca_id)->first();
                            @endphp
                            <tr>
                                <td>{{ $cate_info->sca_name_kr }}</td>
                                <td>{{ $rating_item->item_name1 }}</td>
                                <td>{{ $rating_item->item_name2 }}</td>
                                <td>{{ $rating_item->item_name3 }}</td>
                                <td>{{ $rating_item->item_name4 }}</td>
                                <td>{{ $rating_item->item_name5 }}</td>
                                <td><button type="button" class="btn-sm-ln" onclick="location.href='{{ route('admRating.modi_view', $rating_item->id) }}'">수정</button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- 평가단 선정 리스트 끝 -->

                    <!-- 페이지네이션 시작 -->
                    <div class="paging_box">
                        <div class="paging">
                            {!! $pnPage !!}
                        </div>
                    </div>
                    <!-- 페이지네이션 끝 -->

                </div>
                <!-- 보드 끝 -->

            </form>

        </div>
        <!-- 컨텐츠 영역 끝 -->

<script>
    function view_create(){
        location.href="{{ route('admRating.create_view') }}"
    }
</script>

<script>
    $("#ca_id").change(function(){
        location.href = "{{ route('admRating.index') }}?ca_id="+$(this).val();
    });
</script>
@endsection