@php
header ('Pragma: no-cache');
header('Cache-Control: no-store, private, no-cache, must-revalidate');
header('Cache-Control: pre-check=0, post-check=0, max-age=0, max-stale = 0', false);
header('Pragma: public');
@endphp



<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, minimum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta property="og:title" content="지구랭">
    <meta property="og:description" content="지구랭">
    <meta property="og:image" content="{{ asset('/design/resources/logo.png') }}">

    <title>지구랭</title>
    <link rel="icon" href="{{ asset('/design/adm/img/sym.png') }}">

    <!-- css-->
    <link rel="stylesheet" href="{{ asset('/design/adm/css/reset_adm.css') }}">
    <link rel="stylesheet" href="{{ asset('/design/adm/css/layout_adm.css') }}">
    <link rel="stylesheet" href="{{ asset('/design/adm/css/style_adm.css') }}">


</head>
<body>
<div class="wrap log_wrap">
<form action='{{ route('adm.login.store') }}' method='POST' role='form'>
{!! csrf_field() !!}
    <!-- login 시작 -->
    <div class="log_box">
        <div class="logo"></div>
        <div class="title">관리자 로그인</div>
        <form>
            <div>
            <input name='user_id' id='user_id' type='email' value='{{ old('user_id') }}' placeholder='아이디' autofocus>

            </div>
            <div>
                <input name='user_pw' id='user_pw' type='password' value='{{ old('user_pw') }}' placeholder='비밀번호'>

            </div>
            <button type="button" class="btn wd-100" type='submit'>{{ $submit_login }}</button>
        </form>
    </div>
    <!-- login 끝 -->
</form>
</div>


</body>
</html>












<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8'>
    <title>ADIMISTRATOR</title>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
</head>
<body>


<table border=1>
<form action='{{ route('adm.login.store') }}' method='POST' role='form' class='form__auth'>
{!! csrf_field() !!}
    <tr>
        <td>
            <h4>
                {{ $title_login }}
            </h4>
        </td>
    </tr>
    <tr>
        <td>
            <input name='user_id' id='user_id' type='email' class='form-control @error('user_id') is-invalid @enderror' value='{{ old('user_id') }}' placeholder='{{ $user_id }}' autofocus>
            @error('user_id')
                <span class='invalid-feedback' role='alert'>
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </td>
    </tr>
    <tr>
        <td>
            <input name='user_pw' id='user_pw' type='password' class='form-control @error('user_pw') is-invalid @enderror' value='{{ old('user_pw') }}' placeholder='{{ $user_pw }}'>
            @error('user_pw')
                <span class='invalid-feedback' role='alert'>
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </td>
    </tr>
    <tr>
        <td>
            <button class='btn btn-primary btn-lg btn-block' type='submit'>
                {{ $submit_login }}
            </button>
        </td>
    </tr>
</form>
</table>


    {{-- alert_messages Error --}}
    @if (Session::has('alert_messages'))
    <script>
        alert('{!! Session::get('alert_messages') !!}');
    </script>
    @endif


</body>
</html>
