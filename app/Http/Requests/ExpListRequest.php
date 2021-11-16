<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpListRequest extends FormRequest
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
            'exp_title' => ['required'],
            'exp_item_code' => ['required'],
            'exp_item_name' => ['required'],
            'exp_limit_personnel' => ['numeric'],
            'exp_date_start' => ['required'],
            'exp_date_end' => ['required'],
            'exp_review_start' => ['required'],
            'exp_review_end' => ['required'],
            'exp_release_date' => ['required'],
            'exp_main_image' => [''],
            'exp_content' => ['required'],
            
        ];
    }

    public function messages(){
        
        return [
            //유효성 검사 에러메시지를 정의한다.
            'required' => ':attribute 은(는) 필수입력 사항입니다.',
            'min' => ':attribute 은(는) 최소 :min 글자 이상이 필요합니다.',
            'confirmed' => ':attribute 가 일치하지 않습니다.',
            'alpha' => ':attribute 은(는)(숫자나 기호가 아닌) 알파벳[자음과 모음] 문자 또는 한글로 이루어져야 합니다.',
            'regex' => '원하는 형식이 아닙니다.',
            'numeric' => '숫자만 입력해주세요',
            'unique' => '이미 등록된 :attribute 입니다. 다시 한번 확인해주세요',
        ];
    }

    public function attributes(){

        return [
            //attribute 에 보여줄 값을 정의한다.
            'exp_title' => '제목',
            'exp_item_code' => '상품 선택',
            'exp_item_name' => '상품 이름',
            'exp_limit_personnel' => '체험단 인원',
            'exp_date_start' => '모집기간 시작일',
            'exp_date_end' => '모집기간 종료일',
            'exp_review_start' => '평가 가능 기간 시작일',
            'exp_review_end' => '평가 가능 기간 종료일',
            'exp_release_date' => '당첨자 발표일',
            'exp_main_image' => '메인 이미지',
            'exp_content' => '체험단 설명',
        ];
    }
}
