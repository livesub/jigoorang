@extends('layouts.admhead')

@section('content')


  <form action='{{ route('adm.member.regi.store') }}' method='POST' enctype='multipart/form-data' role='form' class='form__auth'>
    {!! csrf_field() !!}
    <input type="hidden" name="mode" id="mode" value="{{ $mode }}">
    <input type="hidden" name="num" id="num" value="{{ $num }}">
    <div class='page-header'>
      <h4>
      회원 {{ $title_ment }}
      </h4>
    </div>


    <div class='form-group'>
      아이디 :

        @if ($mode == 'regi')
            <input name='user_id' id='user_id' type='email' class='form-control @error('user_id') is-invalid @enderror' value='{{ old('user_id') }}' placeholder='{{ $user_id }}'>
        @else
            {{ $user_id }}
        @endif


    @error('user_id')
        <br>
        <span role='alert'>{{ $message }}</span>
    @enderror
    </div>



    <div class='form-group'>
      이름 :
      @if ($mode == 'regi')
        <input name='user_name' id='user_name' type='text' class='form-control @error('user_name') is-invalid @enderror' value='{{ old('user_name') }}' placeholder='{{ $user_name }}'>
      @else
        <input name='user_name' id='user_name' type='text' class='form-control @error('user_name') is-invalid @enderror' value='{{ $user_name }}' placeholder='{{ $user_name }}'>
      @endif
    @error('user_name')
        <br>
        <span role='alert'>{{ $message }}</span>
    @enderror
    </div>


@if($user_platform_type != 'kakao' && $user_platform_type != 'naver')
    <div class='form-group'>
      비밀번호 : <input name='user_pw' id='user_pw' type='password' class='form-control @error('user_pw') is-invalid @enderror' value='{{ old('user_pw') }}' placeholder='{{ $user_pw }}'> 영문, 숫자, 특수문자 조합 8~20자(%$?^()제외)
    @error('user_pw')
        <br>
        <span role='alert'>{{ $message }}</span>
    @enderror
    </div>


    <div class='form-group'>
      비밀번호 확인 : <input name='user_pw_confirmation' id='user_pw_confirmation' type='password' class='form-control @error('user_pw_confirmation') is-invalid @enderror' placeholder='{{ $user_pw_confirmation }}'> 영문, 숫자, 특수문자 조합 8~20자(%$?^()제외)
    @error('user_pw_confirmation')
        <br>
        <span role='alert'>{{ $message }}</span>
    @enderror

    @if ($mode == 'modi')
      <input type='button' value='{{ $pw_change }}' onclick='pw_change();'>
    @endif
@endif
    </div>



    <div class='form-group'>
      휴대폰번호 :

      @if ($mode == 'regi')
        <input name='user_phone' id='user_phone' type='text' class='form-control @error('user_phone') is-invalid @enderror' value='{{ old('user_phone') }}' maxlength="11" placeholder='{{ $user_phone }}' onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
      @else
        <input name='user_phone' id='user_phone' type='text' class='form-control @error('user_phone') is-invalid @enderror' value='{{ $user_phone }}' maxlength="11" placeholder='{{ $user_phone }}' onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
      @endif
    @error('user_phone')
        <br>
        <span role='alert'>{{ $message }}</span>
    @enderror
    </div>

    <div class='form-group'>
      레벨 : {!! $select_disp !!}
    </div>

    <div class='form-group'>
      @php
        $user_gender_M_chk = '';
        $user_gender_W_chk = '';
        if($user_gender == "M") $user_gender_M_chk = "checked";
        else if($user_gender == "W" || $user_gender == "") $user_gender_W_chk = "checked";
      @endphp
      성별 : <input type='radio' name="user_gender" id="user_gender_M" value="M" {{ $user_gender_M_chk }}> 남 <input type='radio' name="user_gender" id="user_gender_W" value="W" {{ $user_gender_W_chk }}> 여
    </div>
    <div class='form-group'>
      생년월일 : <input type="text" name="user_birth" id="user_birth" value="{{ $user_birth }}" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="6"> 예)앞자리 2자리 제외 220101
    @error('user_birth')
        <br>
        <span role='alert'>{{ $message }}</span>
    @enderror
    </div>

    @if ($mode == 'modi')
    <div class='form-group'>
      가입일 : {{ $created_at }}
    </div>
    <div class='form-group'>
      회원 상태 : {{ $user_status }}
    </div>
    <div class='form-group'>
      포인트 : {{ number_format($user_point) }}P <button type="button" class="btn blk-ln ht34" onclick="location.href='{{ route('adm.member.member_point','num='.$num) }}'">관리</button>
    </div>

    <div class='form-group'>
@php
    if($user_platform_type == '') $platform_type = '회원가입';
    else if($user_platform_type == 'kakao') $platform_type = '카카오';
    else if($user_platform_type == 'naver') $platform_type = '네이버';
@endphp
      가입경로 : {{ $platform_type }}
    </div>

    <div class='form-group'>
    @php
        $blacklist_chk = '';
        $site_access_no_chk = '';
        if($blacklist == 'y') $blacklist_chk = 'checked';
        if($site_access_no == 'y') $site_access_no_chk = 'checked';
    @endphp

      블랙리스트 : <input type="checkbox" name="blacklist" id="blacklist" value="y" {{ $blacklist_chk }}>
    </div>
    <div class='form-group'>
      사이트 접근 불가 : <input type="checkbox" name="site_access_no" id="site_access_no" value="y" {{ $site_access_no_chk }}>
    </div>

    <div class='form-group'>
    탈퇴 사유 : {{ $withdraw_type }}
    </div>

    <div class='form-group'>
    탈퇴 내용 : {{ $withdraw_content }}
    </div>
    @endif


    <div class='form-group' style='margin-top: 2em;'>
      <button type='submit'>
        {{ $title_ment }}
      </button>

    @if ($mode != 'regi')
      <button style="margin-top:20px;" type="button" onclick="mem_out();">회원 탈퇴/가입 처리</button>
    @endif

    </div>


  </form>


<form action="{{ route('adm.member.out') }}" name="mem_out_form" id="mem_out_form" method="POST">
{!! csrf_field() !!}
    <input type="hidden" name="chk_id[]" id="chk_id" value="{{ $num }}">
</form>

<script>
  function pw_change()
  {
    if($('#user_pw').val() == '')
    {
      alert('{{ $alert_pw }}');
      $('#user_pw').focus();
      return false;
    }

    if($('#user_pw_confirmation').val() == '')
    {
      alert('{{ $alert_pw_confirmation }}');
      $('#user_pw_confirmation').focus();
      return false;
    }

    if($('#user_pw').val().length < 6 || $('#user_pw').val().length > 16)
    {
      alert('비밀번호는 6자 이상 16이하로 입력 하세요.');
      $('#user_pw').focus();
      return false;
    }

    if($('#user_pw_confirmation').val().length < 6 || $('#user_pw_confirmation').val().length > 16)
    {
      alert('비밀번호는 6자 이상 16이하로 입력 하세요.');
      $('#user_pw_confirmation').focus();
      return false;
    }

    if($('#user_pw').val() != $('#user_pw_confirmation').val())
    {
      alert('{{ $user_pw_same }}');
      $('#user_pw_confirmation').focus();
      return false;
    }
//alert($('input[name=_token]').val());
    $.ajax({
          headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
          type: 'post',
          url: '{{ route('adm.member.pw_change') }}',
          dataType: 'json',
          data: {
            'user_pw' : $('#user_pw').val(),
            'user_pw_confirmation' : $('#user_pw_confirmation').val(),
            'num' : $('#num').val()
          },
          success: function(data) {
            //console.log(data);
            if(data.status == 'false'){
              alert(data.status_ment);
            }else{
              alert(data.status_ment);
              location.href = '/adm';
            }
          },
          error: function(data) {
            //console.log("error==> " + data);
            //초기화
            $(document).find('[name=user_pw]').val('');
            $(document).find('[name=user_pw_confirmation]').val('');
            $('#reset_user_pw').remove();
            $('#reset_user_pw_confirmation').remove();

            $.each(data.responseJSON.errors,function(field_name,error){
              $(document).find("[name='+field_name+']").after("<span class='text-strong textdanger' id='reset_'+field_name>' +error+ '</span>");
            })
          }
    });
  }
</script>

<script>
  function img_del(){
    if (confirm("회원 이미지를 삭제하시겠습니까??") == true){    //확인
      $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
            type: 'post',
            url: '{{ route('adm.member.imgdel') }}',
            dataType: 'json',
            data: {
              'num' : $('#num').val()
            },
            success: function(data) {
              console.log(data);
              if(data.status == 'false'){
                alert(data.status_ment);
              }else{
                alert(data.status_ment);
                location.href = '/adm';
              }
            },
            error: function(data) {
              console.log("error==> " + data);
              //초기화
              $(document).find('[name=user_pw]').val('');
              $(document).find('[name=user_pw_confirmation]').val('');
              $('#reset_user_pw').remove();
              $('#reset_user_pw_confirmation').remove();

              $.each(data.responseJSON.errors,function(field_name,error){
                $(document).find("[name='+field_name+']").after("<span class='text-strong textdanger' id='reset_'+field_name>' +error+ '</span>");
              })
            }
      });
    }else{   //취소
        return;
    }
  }
</script>

<script>
    function mem_out(){
        if (confirm("탈퇴 회원은 가입 처리 되며, 가입자는 탈퇴 처리 됩니다.\n회원 정보는 삭제 되지 않습니다.\n선택 하신 회원을 탈퇴/가입 하시겠습니까?") == true){    //확인
          document.mem_out_form.submit();
        }else{
            return;
        }
    }
</script>


@endsection
