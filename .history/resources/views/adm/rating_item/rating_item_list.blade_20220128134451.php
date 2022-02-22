@extends('layouts.admhead')

@section('content')
    정량 평가 항목 리스트 뷰
    <table border=1>
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
            @php
                if($keyword){
                    $key = $keyword;
                }else{
                    $key = "";
                }
            @endphp
            <input type="text" name="keyword" id="keyword" value="{{ $keyword }}"><button type="">검색</button>
        </td>
    </tr>
</form>
</table>
<table border=1>
    <tr>
        <td>
            카테고리명
        </td>
        <td>항목1</td>
        <td>항목2</td>
        <td>항목3</td>
        <td>항목4</td>
        <td>항목5</td>
        <td>비고</td>
    </tr>
    @foreach($rating_items_rows as $rating_item)
        @php
            $cate_info = DB::table('shopcategorys')->select('sca_name_kr')->where('sca_id', $rating_item->sca_id)->first();
        @endphp
    <tr>
        <td>
            {{ $cate_info->sca_name_kr }}
        </td>
        <td>
            {{ $rating_item->item_name1 }}
        </td>
        <td>
            {{ $rating_item->item_name2 }}
        </td>
        <td>
            {{ $rating_item->item_name3 }}
        </td>
        <td>
            {{ $rating_item->item_name4 }}
        </td>
        <td>
            {{ $rating_item->item_name5 }}
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