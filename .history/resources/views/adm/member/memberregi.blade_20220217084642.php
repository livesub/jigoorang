@extends('layouts.admhead')

@section('content')


        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>회원 등록</h2>
                <div class="button_box">
                    <button type="button" onclick="location.href='../../page/member/member.html'">등록</button>
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area member">

            <form action='{{ route('adm.member.regi.store') }}' method='POST' enctype='multipart/form-data' role='form' class='form__auth'>
                {!! csrf_field() !!}
                <input type="hidden" name="mode" id="mode" value="{{ $mode }}">
                <input type="hidden" name="num" id="num" value="{{ $num }}">

                <div class="box_cont">

                    <div class="row">
                        <div class="col">아이디(이메일)</div>
                        <div class="col">
                        @if ($mode == 'regi')
                            <input name='user_id' id='user_id' type='email' value='{{ old('user_id') }}' placeholder='{{ $user_id }}'>
                            @error('user_id')
                                <br><span role='alert'>
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        @else
                            {{ $user_id }}
                        @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">이름</div>
                        <div class="col">
                        @if ($mode == 'regi')
                            <p>10자 이내로 입력하세요</p>
                            <input name='user_name' id='user_name' type='text' value='{{ old('user_name') }}' placeholder='{{ $user_name }}'>
                        @else
                            <input name='user_name' id='user_name' type='text' value='{{ $user_name }}' placeholder='{{ $user_name }}'>
                        @endif
                        @error('user_name')
                            <br><span role='alert'>
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                    </div>

                    @if($user_platform_type != 'kakao' && $user_platform_type != 'naver')
                    <div class="row">
                        <div class="col">비밀번호</div>
                        <div class="col">
                            <p>영문, 숫자, 특수문자 조합 8~20자(%$?^()제외)</p>
                            <input name='user_pw' id='user_pw' type='password' value='{{ old('user_pw') }}' placeholder='{{ $user_pw }}'>
                            @error('user_pw')
                                <br><span role='alert'>
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">비밀번호 확인</div>
                        <div class="col">
                            <p>위 비밀번호를 입력하세요</p>
                            <input name='user_pw_confirmation' id='user_pw_confirmation' type='password' placeholder='{{ $user_pw_confirmation }}'>
                            @error('user_pw_confirmation')
                                <br><span role='alert'>
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            @if ($mode == 'modi')
                            <button type="button" class="btn blk-ln ht34" onclick='pw_change();'>비밀번호 변경</button>
                            @endif
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col">휴대폰 번호</div>
                        <div class="col">
                            <p>'-' 제외</p>
                            @if ($mode == 'regi')
                                <input name='user_phone' id='user_phone' type='text' value='{{ old('user_phone') }}' maxlength="11" placeholder='{{ $user_phone }}' onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                            @else
                                <input name='user_phone' id='user_phone' type='text' value='{{ $user_phone }}' maxlength="11" placeholder='{{ $user_phone }}' onKeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                            @endif
                            @error('user_phone')
                                <br><span role='alert'>
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">레벨</div>
                        <div class="col">
                            {!! $select_disp !!}
                        </div>
                    </div>
                    <div class="row">
                    @php
                        $user_gender_M_chk = '';
                        $user_gender_W_chk = '';
                        if($user_gender == "M") $user_gender_M_chk = "checked";
                        else if($user_gender == "W" || $user_gender == "") $user_gender_W_chk = "checked";
                    @endphp
                        <div class="col">성별</div>
                        <div class="col">
                            <div class="prt">
                                <label>
                                    <input type='radio' name="user_gender" id="user_gender_M" value="M" {{ $user_gender_M_chk }}> 남
                                </label>
                                <label>
                                    <input type='radio' name="user_gender" id="user_gender_W" value="W" {{ $user_gender_W_chk }}> 여
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">생년월일</div>
                        <div class="col">
                            <p>예)840705</p>
                            <input type="text" name="user_birth" id="user_birth" value="{{ $user_birth }}" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="6">
                            @error('user_birth')
                                <br><span role='alert'>
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>


                    @if ($mode == 'modi')
                    <div class="row">
                        <div class="col">가입일</div>
                        <div class="col">
                            {{ $created_at }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">상태</div>
                        <div class="col">
                            {{ $user_status }} 만들어야 함!!!!!
                            <select>
                                <option>가입</option>
                                <option>탈퇴</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">포인트</div>
                        <div class="col">
                            {{ number_format($user_point) }}P
                            <button type="button" class="btn blk-ln ht34" onclick="location.href='{{ route('adm.member.member_point','num='.$num) }}'">관리</button>
                        </div>
                    </div>
                    <div class="row">
                    @php
                        if($user_platform_type == '') $platform_type = '회원가입';
                        else if($user_platform_type == 'kakao') $platform_type = '카카오';
                        else if($user_platform_type == 'naver') $platform_type = '네이버';
                    @endphp
                        <div class="col">가입경로</div>
                        <div class="col">
                           {{ $platform_type }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">탈퇴일자</div>
                        <div class="col">
                            {{ $withdraw_date }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">탈퇴사유</div>
                        <div class="col">
                            {{ $withdraw_type }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">탈퇴내용</div>
                        <div class="col">
                            {{ $withdraw_content }}
                        </div>
                    </div>
                    <div class="row">
                    @php
                        $blacklist_chk = '';
                        $site_access_no_chk = '';
                        if($blacklist == 'y') $blacklist_chk = 'checked';
                        if($site_access_no == 'y') $site_access_no_chk = 'checked';
                    @endphp
                        <div class="col">블랙리스트</div>
                        <div class="col">
                            <p>평가단 블랙리스트는 체험단 이용이 불가하고 사이트 블랙리스트는 강제 탈퇴 후 사이트 로그인, 재가입 이 불가 합니다</p>
                            <div class="dp">
                                <label>
                                    <input type="checkbox" name="blacklist" id="blacklist" value="y" {{ $blacklist_chk }}>평가단 블랙리스트
                                </label>
                            </div>
                            <div class="dp">
                                <label>
                                    <input type="checkbox" name="site_access_no" id="site_access_no" value="y" {{ $site_access_no_chk }}>사이트 블랙리스트
                                </label>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

            </form>

        </div>
        <!-- 컨텐츠 영역 끝 -->



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
