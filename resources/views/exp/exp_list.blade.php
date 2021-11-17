@extends('layouts.head')

@section('content')
<table>
        @foreach($expAllLists as $expAllList)
        <tr>
            <td>
                <a href="{{ route('exp.list.detail', $expAllList -> id) }}"><img src="{{asset('/storage/exp_list/'.$expAllList->main_image_name)}}" alt="1" style="width: 50%; height: 50%"></a>
            </td>
            <tr>
                <td>
                    각 아이디 : {{ $expAllList -> id }}  <br>
                    제목 : {{ $expAllList-> title }} <br>
                    
                    체험단 모집 인원 : {{ $expAllList->exp_limit_personnel }}<br>
                    모집기간 : {{ $expAllList->exp_date_start }}  ~ {{ $expAllList->exp_date_end }}<br>
                    평가가능기간 : {{ $expAllList->exp_review_start }} ~ {{ $expAllList->exp_review_end }}<br>
                    <a href="{{ route('exp.list.detail', $expAllList -> id) }}"><button>알아보기</button></a>
                </td>
            </tr>
        </tr>
        @endforeach
    </table>
    {!! $pnPage !!}
@endsection