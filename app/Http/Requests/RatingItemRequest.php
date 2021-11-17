<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RatingItemRequest extends FormRequest
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
            'last_choice_ca_id' => ['required','min:4', 'unique:App\Models\RatingItem,sca_id'],
            //pw 정규식 패턴 추가 최소 8자 이상 한개의 문자,한개의 숫자, 한개의 특수문자 포함
            'item_name1' => ['required', 'alpha'],
            //'user_phone' => ['required', 'numeric', 'unique:App\Models\User,user_phone', 'regex:/^01([0|1|6|7|8|9])([0-9]{3,4})([0-9]{4})$/'],
            'item_name2' => ['required', 'alpha'],
            'item_name3' => ['required', 'alpha'],
            'item_name4' => ['required', 'alpha'],
            'item_name5' => ['required', 'alpha'],
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
            'last_choice_ca_id' => '카테고리',
            'item_name1' => '항목1',
            'item_name2' => '항목2',
            'item_name3' => '항목3',
            'item_name4' => '항목4',
            'item_name5' => '항목5',
        ];
    }
}
