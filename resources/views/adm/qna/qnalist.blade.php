@extends('layouts.admhead')

@section('content')





<table border=1>
    <tr>
        <td>1:1 문의 내역 답변</td>
   </tr>
</table>

<table>
<form name="qna_search" id="qna_search" action="{{ route('adm.qna_list') }}" method="get">
    <tr><input type="text" name="keyword" id="keyword" value="{{ $keyword }}"><button type="submit">검색</button></tr>
</form>
</table>

<table border=1>
    @foreach($qna_rows as $qna_row)
    <tr>
        <td>{{ $qna_row->qna_cate }}</td>
    </tr>
    <tr>
        <td><a href="{{ route('adm.qna_answer','id='.$qna_row->id.'&page='.$page.'&keyword='.$keyword) }}">{{ stripslashes($qna_row->qna_subject) }}</a></td>
        <td>
        @if($qna_row->qna_answer == "")
            답변대기
        @else
            답변완료
        @endif
        </td>
    </tr>
    <tr>
        <td>{{ substr($qna_row->created_at, 0, 10) }}</td>
    </tr>
    @endforeach
</table>

<table>
    <tr>
        <td>{!! $pnPage !!}</td>
    </tr>
</table>







@endsection
