@extends('layouts.head')

@section('content')
    상세보기 뷰입니다.<br>
    <hr>
    {{ $result -> title }}
    <hr>
    체험단 모집인원 : {{ $result->exp_limit_personnel }}                            평가 가능 기간 : {{ $result->exp_review_start }} ~ {{ $result->exp_review_end }}
    <br>
    모집기간 : {{ $result->exp_date_start }}  ~ {{ $result->exp_date_end }}         당첨자 발표일 : {{ $result->exp_release_date}}
    <br>
    <!-- <img src="{{asset('/storage/exp_list/'.$result->main_image_name)}}" alt="1" style="width: 50%; height: 50%"> -->
    <br>
    {!! $result->exp_content !!}

    <a href="{{ route('exp.list.form', $result->id) }}"><button>체험단 신청하기</button></a>

@endsection