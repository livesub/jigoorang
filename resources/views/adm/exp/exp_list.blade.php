@extends('layouts.admhead')

@section('content')
    <button onclick="location.href='{{ route('adm_exp_view_create') }}'">체험단 등록</button>
@endsection