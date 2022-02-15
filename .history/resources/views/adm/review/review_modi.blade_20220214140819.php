@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td><h4>리뷰 수정</h4></td>
    </tr>
</table>

<form name="review_form" id="review_form" method="post" action="{{ route('shop.item.modifysave') }}" enctype='multipart/form-data'>
{!! csrf_field() !!}
<table border=1>
    <tr>
        <td>아이디</td>
        <td>{{ $review_save->user_id }}</td>
    </tr>
    <tr>
        <td>이름</td>
        <td>{{ $review_save->user_name }}</td>
    </tr>
    <tr>
        <td>체험단명</td>
        <td>{{ $title_ment }}</td>
    </tr>
    <tr>
        <td>상품명</td>
        <td>{{ $item_name }}</td>
    </tr>
    <tr>
        <td>블라인드처리여부</td>
        <td>{{ $review_blind }}</td>
    </tr>
    <tr>
        <td>정량평가</td>
        <td>{{ $dip_name }}</td>
    </tr>
    <tr>
        <td>리뷰내용</td>
        <td><textarea name="review_content" id="review_content">{{ $review_content }}</textarea></td>
    </tr>
    <tr>
        <td>포토리뷰</td>
        <td>
            <table border=1>
                @foreach($review_save_imgs as $review_save_img)
                    @php
                        $img_cut = '';
                        if($review_save_img->review_img != ""){
                            $img_cut = explode("@@",$review_save_img->review_img);
                            $img_src = $img_cut[2];
                        }
                    @endphp
                <tr>
                    <td>
                        <input type="file" name="review_img" id="review_img_{{ $review_save_img->id }}" value="{{ $review_save_img->id }}">
                        <br><img src="{{ asset('/data/review/'.$img_src) }}">
                        <br><input type='checkbox' name="file_chk" id="file_chk_{{ $review_save_img->id }}" value='1'>수정,삭제,새로 등록시 체크 하세요.
                    </td>
                </tr>
                @endforeach

                @for($i = count($review_save_imgs)+1; $i <= 5; $i++)
                <tr>
                    <td>
                        <input type="file" name="review_img" id="review_img_{{ $i }}">
                        <br>
                        <br><input type='checkbox' name="file_chk{{ $i }}" id="file_chk{{ $i }}" value='1'>수정,삭제,새로 등록시 체크 하세요.
                    </td>
                </tr>
                @endfor
            </table>
        </td>
    </tr>
</table>



@endsection
