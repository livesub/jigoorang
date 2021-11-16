@extends('layouts.admhead')

@section('content')
    정량 평가 항목 리스트 뷰
    <table>
<form name="search_form" id="search_form" method="get" action="{{ route('admRating.index') }}">
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
            <!-- <select name="item_search" id="item_search">
                @php
                    
                @endphp
                <option value="item_name" >카테고리</option>
                <option value="item_code" >상품코드</option>
            </select> -->
        </td>
        <td>
            @php
                if($keyword){
                    $key = $keyword;
                }else{
                    $key = "";
                }
            @endphp
            <input type="text" name="keyword" id="keyword" value="{{ $key }}"><button type="">검색</button>
        </td>
    </tr>
</form>
</table>
<table>
    @foreach($rating_items_rows as $rating_item)
    <tr>
        <td>
            카테고리 코드 : {{ $rating_item->sca_id }}
        </td>
        <td>
            항목 1 : {{ $rating_item->item_name1 }}
        </td>
        <td>
            항목 2 : {{ $rating_item->item_name2 }}
        </td>
        <td>
            항목 3 : {{ $rating_item->item_name3 }}
        </td>
        <td>
            항목 4 : {{ $rating_item->item_name4 }}
        </td>
        <td>
            항목 5 : {{ $rating_item->item_name5 }}
        </td>
        <td>
            <a href="{{ route('admRating.modi_view', $rating_item->id) }}">수정</a>
        </td>
    </tr>
    @endforeach
    <tr>
        <td>
            {!! $pnPage !!}
        </td>
    </tr>
</table>
    <button type="button" onclick="view_create()">정량 평가 항목 생성</button>

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