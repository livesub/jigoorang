@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td><h4>리뷰 수정</h4></td>
    </tr>
</table>


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
        <td><textarea name="review_content" id="review_content">{{ $review_content }}</td>
    </tr>
    <tr>
        <td>포토리뷰</td>
        <td>
            <table border=1>
                <tr>
                    <td><input type="file"></td>
                </tr>
            </table>
        </td>
    </tr>
</table>



@endsection
