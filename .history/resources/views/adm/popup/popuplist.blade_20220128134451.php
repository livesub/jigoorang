@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td><h4>팝업 관리 리스트</h4></td>
    </tr>
</table>

<table border=1>
    <tr>
        <td>순번</td>
        <td>이미지</td>
        <td>제목</td>
        <td>경로</td>
        <td>타겟</td>
        <td>출력유무</td>
        <td>등록일</td>
        <td>관리</td>
    </tr>

    @foreach($pop_infos as $pop_info)
        @php
            if($pop_info->pop_display == "Y") $pop_display = "출력";
            else $pop_display = "비출력";

            //이미지 구하기
            $pop_img = explode("@@", $pop_info->pop_img);

            //타겟
            if($pop_info->pop_target == "Y") $target_ment = "새창";
            else $target_ment = "현재";
        @endphp
    <tr>
        <td>{{ $virtual_num-- }}</td>
        <td><img src="{{ asset('/data/popup/'.$pop_img[3]) }}"></td>
        <td>{{ $pop_info->pop_subject }}</td>
        <td>{{ $pop_info->pop_url }}</td>
        <td>{{ $target_ment }}</td>
        <td>{{ $pop_display }}</td>
        <td>{{ $pop_info->created_at }}</td>
        <td>
            <button type="button" onclick="pop_modi('{{ $pop_info->id }}')">수정</button>
            <button type="button" onclick="pop_del('{{ $pop_info->id }}')">삭제</button>
        </td>
    </tr>
    @endforeach
</table>

<table>
    <tr>
        <td>
           {!! $pnPage !!}
        </td>
    </tr>
</table>

<table>
    <tr>
        <td>
            <button type="button" onclick="location.href='{{ route('adm.pop.create') }}'">등록</button>
        </td>
    </tr>
</table>

<form name="pop_form" id="pop_form" action="{{ route('adm.pop.modify') }}" method="POST">
{!! csrf_field() !!}
    <input type="hidden" name="num" id="num" value="">
    <input type="hidden" name="page" id="page" value="{{ $page }}">
</form>

<script>
    function pop_modi(num){
        $("#num").val(num);
        $("#pop_form").submit();
    }

    function pop_del(num){
        if (confirm("팝업을 삭제하시겠습니까?") == true){
            $("#num").val(num);
            $("#pop_form").attr("action", "{{ route('adm.pop.destroy') }}");
            $("#pop_form").submit();
        }else{
            return false;
        }
    }
</script>



@endsection
