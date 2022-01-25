@extends('layouts.admhead')

@section('content')



<table>
    <tr>
        <td>
            <h4>지구록 관리</h4>
        </td>
    </tr>
</table>

<table>
    <tr>
        <td><button type="button" onclick="location.href='{{ route('adm.notice_write') }}'">글 작성</button></td>
    </tr>
</table>


<table border=1>
    <tr>
        <td>번호</td>
        <td>이미지</td>
        <td>제목</td>
        <td>설명글</td>
        <td>관리</td>
    </tr>

    @foreach($notices as $notice)
        @php
            $n_img = explode("@@", $notice->n_img);
        @endphp

    <tr>
        <td>{{ $virtual_num }}</td>
        <td><img src="{{ asset('/data/notice/'.$n_img[3]) }}"></td>
        <td>{{ stripslashes($notice->n_subject) }}</td>
        <td>{{ stripslashes($notice->n_explain) }}</td>
        <td>
            <table border=1>
                <tr>
                    <td><button type="button" onclick="noti_modi('{{ $notice->id }}')">수정</button></td>
                    <td><button type="button" onclick="noti_del('{{ $notice->id }}')">삭제</button></td>
                </tr>
            </table>
        </td>
    </tr>
    @endforeach

</table>

<table>
    <tr>
        <td>{!! $pnPage !!}</td>
    </tr>
</table>


<form name="noti_form" id="noti_form" action="{{ route('adm.notice_modify') }}" method="POST">
{!! csrf_field() !!}
    <input type="hidden" name="num" id="num" value="">
    <input type="hidden" name="page" id="page" value="{{ $page }}">
</form>



<script>
    function noti_modi(num){
        $("#num").val(num);
        $("#noti_form").submit();
    }

    function noti_del(num){
        if (confirm("선택된 게시글을 삭제합니다.") == true){
            $("#num").val(num);
            $("#noti_form").attr("action", "{{ route('adm.notice_write_del') }}");
            $("#noti_form").submit();
        }else{
            return false;
        }
    }
</script>


@endsection

