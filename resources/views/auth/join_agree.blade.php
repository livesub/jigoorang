@extends('layouts.head')

@section('content')
    지구랭 서비스 약관 동의
    <input type="checkbox" id="promotion">
    <button type="button" onclick="onNext()">다음</button>
    <script>
        //체크 박스 관련 작업들이 필요하다.
        function onNext(){
            //페이지 이동하자
            var check_promotion = $("#promotion").prop("checked");
            if(check_promotion == true){
                location.href="{{ route('join.create', 'Y') }}"
            }else{
                location.href="{{ route('join.create', 'N') }}"
            }     
        }
    </script>
@endsection