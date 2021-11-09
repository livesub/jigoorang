@extends('layouts.head')

@section('content')
 <h1>비밀번호 재설정</h1>
 비밀번호 변경 페이지 기간이 만료 되었습니다........

 <button type="button" onclick="page_move()">아이디 / 비번 찾기 페이지 이동</button>

 <script>
     function page_move(){

        location.href="{{ route('findIdPwView') }}";

     }
 </script>
@endsection