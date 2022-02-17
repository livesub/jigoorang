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
                            <p>10자 이내로 입력하세요</p>
                            <input type="text" name="" placeholder="" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">비밀번호</div>
                        <div class="col">
                            <p>영문, 숫자, 특수문자 조합 8~20자(%$?^()제외)</p>
                            <input type="password" name="" placeholder="" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">비밀번호 확인</div>
                        <div class="col">
                            <p>위 비밀번호를 입력하세요</p>
                            <input type="password" name="">
                            <button type="button" class="btn blk-ln ht34" onclick="">비밀번호 변경</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">휴대폰 번호</div>
                        <div class="col">
                            <p>'-' 제외</p>
                            <input class="aln_left" type="number" name="" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">레벨</div>
                        <div class="col">
                            <select>
                                <option>회원</option>
                                <option>관리자</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">성별</div>
                        <div class="col">
                            <div class="prt">
                                <label>
                                    <input type="radio" id="" name="gender" checked="checked" > 남
                                </label>
                                <label>
                                    <input type="radio" id="" name="gender" > 여
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">생년월일</div>
                        <div class="col">
                            <p>예)840705</p>
                            <input class="aln_left" type="number" name="" placeholder="">
                        </div>
                    </div>

                </div>

            </form>

        </div>
        <!-- 컨텐츠 영역 끝 -->




@endsection
