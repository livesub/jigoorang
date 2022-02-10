@extends('layouts.head')

@section('content')

<script src="{{ asset('/design/js/button.js') }}"></script> <!-- 배송지 입력버튼 js -->
<script src="{{ asset('/design/js/modal-back02.js') }}"></script>

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="{{ asset('/js/zip.js') }}"></script>

<!-- iamport.payment.js -->
<script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.8.js"></script>

@php
 echo "aaaaaaaaaaaaaa";   
@endphp




@endsection
