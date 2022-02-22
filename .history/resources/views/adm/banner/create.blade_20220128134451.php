@extends('layouts.admhead')

@section('content')



<table>
    <tr>
        <td>
            <h4>{{ $title_ment }} 배너 등록</h4>
        </td>
    </tr>
</table>

<table border=1>
<form name="b_form" id="b_form" method="post" action="{{ route('adm.banner.createsave') }}" enctype='multipart/form-data'>
{!! csrf_field() !!}
<input type="hidden" name="type" id="type" value="{{ $type }}">
    <tr>
        <td>제목</td>
        <td><input type="text" name="b_name" id="b_name"></td>
        <td>출력여부</td>
        <td>
            <input type="radio" name="b_display" id="b_display_yes" value="Y" checked>출력
            <input type="radio" name="b_display" id="b_display_no" value="N">출력안함
        </td>
    </tr>
    <tr>
        <td>배너경로</td>
        <td><input type="text" name="b_link" id="b_link"></td>
        <td>타겟</td>
        <td>
            <input type="radio" name="b_target" id="b_target_no" value="N" checked>현재창
            <input type="radio" name="b_target" id="b_target_yes" value="Y">새창
        </td>
    </tr>
    <tr>
        <td>pc 이미지</td>
        <td>
            <input type="file" name="b_pc_img" id="b_pc_img">
            @error('b_pc_img')
                <strong><p>{{ $message }}</p></strong>
            @enderror
        </td>
        <td>mobile 이미지</td>
        <td>
            <input type="file" name="b_mobile_img" id="b_mobile_img">
            @error('b_mobile_img')
                <strong><p>{{ $message }}</p></strong>
            @enderror
        </td>
    </tr>
</table>

<table>
    <tr>
        <td>
            <button type="button" onclick="b_save();">저장</button>
        </td>
    </tr>
</table>


<script>
    function b_save(){
        if($.trim($("#b_name").val()) == ""){
            alert("제목을 입력 하세요.");
            $("#b_name").focus();
            return false;
        }

        if($("#b_pc_img").val() == ""){
            alert("pc 이미지를 등록 하세요.");
            $("#b_pc_img").focus();
            return false;
        }

        if($("#b_mobile_img").val() == ""){
            alert("mobile 이미지를 등록 하세요.");
            $("#b_mobile_img").focus();
            return false;
        }

        $("#b_form").submit();
    }
</script>




@endsection
