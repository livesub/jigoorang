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
                        <div class="col">블랙리스트</div>
                        <div class="col">
                            <p>평가단 블랙리스트는 체험단 이용이 불가하고 사이트 블랙리스트는 강제 탈퇴 후 사이트 로그인, 재가입 이 불가 합니다</p>
                            <div class="dp">
                                <label>
                                    <input type="checkbox" id="">평가단 블랙리스트
                                </label>
                            </div>
                            <div class="dp">
                                <label>
                                    <input type="checkbox" id="">사이트 블랙리스트
                                </label>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

            </form>

        </div>
        <!-- 컨텐츠 영역 끝 -->




@endsection
