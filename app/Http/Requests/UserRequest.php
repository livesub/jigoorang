<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //유효성 검사 항목들 및 조건을 정의한다.
            'user_id' => ['required','email'],
            //pw 정규식 패턴 추가 최소 8자 이상 한개의 문자,한개의 숫자, 한개의 특수문자 포함
            'user_pw' => ['required', 'confirmed', 'regex:^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$'],
            'user_name' => ['required', 'alpha'],
            'user_phone' => ['required', 'numeric'],
        ];
    }

    public function messages(){
        
        return [
            //유효성 검사 에러메시지를 정의한다.
            'required' => ':attribute 은(는) 필수입력 사항입니다.',
            'min' => ':attribute 은(는) 최소 :min 글자 이상이 필요합니다.',
            'confirmed' => ':attribute 두개가 일치하지 않습니다.',
            'alpha' => ':attribute 은(는)(숫자나 기호가 아닌) 알파벳[자음과 모음] 문자 또는 한글로 이루어져야 합니다.',
        ];
    }

    public function attributes(){

        return [
            //attribute 에 보여줄 값을 정의한다.
            'user_id' => '아이디로 사용할 이메일',
            'user_pw' => '비밀번호',
            'user_name' => '이름',
        ];
    }
}
