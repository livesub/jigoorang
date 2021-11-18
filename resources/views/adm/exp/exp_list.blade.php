@extends('layouts.admhead')

@section('content')
    <table>
        @foreach($expAllLists as $expAllList)
        <tr>
            <td>
                <img src="{{'/data/exp_list/'.$expAllList->main_image_name}}" alt="1" style="width: 50%; height: 50%">
            </td>
            <tr>
                <td>
                    각 아이디 : {{ $expAllList -> id }}  <br>
                    제목 : {{ $expAllList-> title }} <br>
                    수정 링크  : <a href="{{ route('adm_exp_view_restore', $expAllList -> id) }}">수정하기</a>
                    체험단 모집 인원 : {{ $expAllList->exp_limit_personnel }}<br>
                    모집기간 : {{ $expAllList->exp_date_start }}  ~ {{ $expAllList->exp_date_end }}<br>
                    평가가능기간 : {{ $expAllList->exp_review_start }} ~ {{ $expAllList->exp_review_end }}<br>
                    삭제 링크  : <a href="{{ route('adm_exp_view_delete', $expAllList -> id) }}">삭제하기</a>
                </td>
            </tr>
        </tr>
        @endforeach
    </table>
    {!! $pnPage !!}
    <button onclick="location.href='{{ route('adm_exp_view_create') }}'">체험단 등록</button>
@endsection