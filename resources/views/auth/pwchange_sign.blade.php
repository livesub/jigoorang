@extends('layouts.head')

@section('content')
    비밀번호 변경 뷰입니다.<br>
    확인해주세요
    <form form name="chagePw" id="changePw" method='POST' action='{{ route('resetPw') }}' role='form' class='form__auth'>
        {!! csrf_field() !!}
        <div class='form-group'>
        <input name='user_pw' id='user_pw' type='password' class='form-control @error('user_pw') is-invalid @enderror' value='{{ old('user_pw') }}' placeholder='@lang('validation.change_pw.common')'>
        </div>
        @error('user_pw')
            <span class='invalid-feedback' role='alert'>
                <strong>{{ $message }}</strong>
            </span>
        @enderror


        <div class='form-group'>
        <input name='user_pw_confirmation' id='user_pw_confirmation' type='password' class='form-control @error('user_pw_confirmation') is-invalid @enderror' placeholder='@lang('validation.change_pw.confirmed')'>
        </div>
        @error('user_pw_confirmation')
            <span class='invalid-feedback' role='alert'>
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <input type="hidden" value="{{ $code }}" id="code" name="code">
        <button type="submit">변경하기</button>
    </form>
    
@endsection