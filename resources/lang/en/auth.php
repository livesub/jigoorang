<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',

    //form 관련 언어팩 설정
    'form' => [
        'gender_m' => 'Man',
        'gender_w' => 'Woman',
        'cerfitication_btn' => 'en인증번호 받기',
        'register_btn' => 'register',
    ],

    //회원가입 및 아디 찾기등 관한 언어팩
    'findIdPw' => 'ID /PW find',

    'not_found_phone' => '일치하는 핸드폰 번호가 없습니다. 가입 후 이용해주세요',

    'success_found_phone' => '해당 번호로 아이디를 보냈습니다. \n확인해 주세요',

    'failed_to_limit_time' => '잘못된 접근입니다!',

    'success_change_pw' => '비밀번호 변경이 완료 되었습니다.',

    'failed_change_pw' => '잘못된 접근입니다. \n다시 시도해주세요',

    'not_login_user' => '회원만 이용가능한 메뉴입니다. \n로그인 후 이용해주세요!',

    'certification_number' => '인증번호를 입력해주세요',

    'repeat_access' => '다시 진행해주시기 바랍니다.',

    'welcome' => '환영합니다.',

    'success_sms_send' => '인증문자발송완료 확인 필요합니다.',

    'already_reg_number' => '이미 등록된 번호입니다. \n아이디 / 비밀번호 찾기를 이용해주세요',
    
    'empty_phone_number' => '휴대폰 번호가 비어있습니다. \n확인해주세요',

    //ajax 문자 전송 실패
    'failed_send_sms' => '인증문자전송실패. \n다시시도해주세요',

    //정보 입력을 안했을 시 멘트(전송 클릭 시)
    'insert_all_info' => '모든 정보를 입력해주세요!',

    //인증 번호 불일치 시
    'faild_cerfitication_number' => '인증번호가 일치하지 않습니다.',

];
