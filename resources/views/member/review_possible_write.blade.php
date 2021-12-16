@extends('layouts.head')

@section('content')


<div class='page-header'>
      <h4>
            마이페이지save
      </h4>
</div>

<style>

.row {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    width: 100%;
    min-height: 80px;
    border-bottom: 1px solid #f0f0f0;
}

.community-container .sub-title {
    background: url("../resources/background-sample/community.png") center no-repeat;
    background-size: cover;
}

.community-container .contents .board > .btns {
    margin-top: 50px;
    text-align: right;
}
.community-container .contents .board > .btns button {
    width: 100px;
    height: 50px;
    font-size: 20px;
    border: none;
    background-color: #0070bf;
    color: #fff;
}
.community-container .contents .board.write .write-form {
    border-top: solid 4px #000000;
}
.community-container .contents .board.write .write-form .row {
    align-items: center;
    justify-content: center;
}
.community-container .contents .board.write .write-form .col {
    line-height: unset;
}
.community-container .contents .board.write .write-form .row {
    align-items: stretch;
}
.community-container .contents .board.write .write-form .col:first-child {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 200px;
    font-size: 22px;
    font-weight: bold;
    text-align: center;
    color: #000000;
    background-color: #f7f7f7;
}
.community-container .contents .board.write .write-form .col:not(:first-child) {
    flex: 1;
    padding: 16px 30px;
    font-size: 0;
}
.community-container .contents .board.write .write-form .col input {
    min-width: 355px;
    font-size: 20px;
    line-height: 1.5;
    color: #000000;
}
.community-container .contents .board.write .write-form .col input[type=password] {
    width: 240px;
    min-width: 240px;
}

.community-container .contents .board.write .write-form .col *.full {
    width: 100%;
}
.community-container .contents .board.write .write-form .col textarea {
    height: 560px;
    border: solid 1px #999999;
    padding: 20px;
    font-size: 20px;
    line-height: 1.5;
    color: #000000;
}
.community-container .contents .board.write .write-form .col input::placeholder,
.community-container .contents .board.write .write-form .col textarea::placeholder {
    color: #bbbbbb;
}
.community-container .contents .board.write .write-form .col .file_uploader {
    width: 105px;
    height: 30px;
    font-size: 17px;
    font-weight: 500;
    letter-spacing: -1px;
    text-align: center;
    color: #ffffff;
    background-color: #0070bf;
    padding-top: 7px;
}
.community-container .contents .board.write .write-form .col .file_uploader.hide {
    display: none;
}
.community-container .contents .board.write .write-form .col .file_uploader > label {
    padding: 8px 20px;
    cursor: pointer;
}
.community-container .contents .board.write .write-form .col .file_uploader > label > input {
    display: none;
}
.community-container .contents .board.write .write-form .col .files > div {
    font-size: 20px;
    line-height: 1.5;
    color: #000000;
    text-decoration: underline;
    margin-top: 5px;
}
.community-container .contents .board.write .write-form .col .files > div:first-child {
    margin-top: 10px;
}

.community-container .img {
    width: 80px;
    height: 80px;
}

.community-container .contents .board.write .write-form .col .files > div > div.remove {
    display: inline-block;
    font-size: 0;
    width: 24px;
    height: 24px;
    margin: 13px;
    background-image: url("./img/btn-ui-24-close-gray.png");
    background-repeat: no-repeat;
    background-size: cover;
}
</style>


<div class="community-container ">
    <div class="contents">
<form class="board write" name="review_form" id="review_form" method="post" action="{{ route('mypage.review_possible_save') }}" enctype='multipart/form-data'>
{!! csrf_field() !!}
<!-- 쇼핑몰 관련 -->
<input type="hidden" name="cart_id" id="cart_id" value="{{ $cart_id }}">
<input type="hidden" name="content_length" id="content_length">
<input type="hidden" name="order_id" id="order_id" value="{{ $order_id }}">
<input type="hidden" name="item_code" id="item_code" value="{{ $item_code }}">
<input type="hidden" name="temporary_yn" id="temporary_yn">
<input type="hidden" name="average" id="average">

<!-- 체험단 관련 -->
<input type="hidden" name="exp_id" id="exp_id" value="{{ $exp_id }}">
<input type="hidden" name="exp_app_id" id="exp_app_id" value="{{ $exp_app_id }}">
<input type="hidden" name="sca_id" id="sca_id" value="{{ $sca_id }}">

<table>

    <tr>
        <td>정량평가(필수)</td>
    </tr>
    <tr>
        <td>
            <table border=1>
                @for($i = 1; $i <= 5; $i++)
                @php
                    $tmp = "item_name".$i;
                    $dip_name = $rating_item_info->$tmp;
                @endphp
                <tr>
                    <td>{{ $rating_item_info->$tmp }}</td>
                    <td>
                        <input type="radio" name="score{{ $i }}" value="1">1점
                        <input type="radio" name="score{{ $i }}" value="1.5">1.5점
                        <input type="radio" name="score{{ $i }}" value="2">2점
                        <input type="radio" name="score{{ $i }}" value="2.5">2.5점
                        <input type="radio" name="score{{ $i }}" value="3">3점
                        <input type="radio" name="score{{ $i }}" value="3.5">3.5점
                        <input type="radio" name="score{{ $i }}" value="4">4점
                        <input type="radio" name="score{{ $i }}" value="4.5">4.5점
                        <input type="radio" name="score{{ $i }}" value="5">5점
                    </td>
                </tr>
                @endfor
            </table>
        </td>
    <tr>
    <tr>
        <td>
            <textarea name="review_content" id="review_content"></textarea>
        </td>
    </tr>

</table>


                <div class="write-form">
                    <div class="row">
                        <div class="col">파일첨부</div>
                        <div class="col">
                            <div class="file_uploader">
                                <label>파일첨부<input type="file" name="review_img[]" id="review_img_0" accept="image/*" onchange="changeWriteFile(event)"/></label>
                                @error('review_img[]')
                                    <strong>{{ $message }}</strong>
                                @enderror
                            </div>
                            <div class="files">
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

</form>



<table border=1>
    <tr>
        <td><button name="button" onclick="history.back(-1);">취소</button></td>
        <td><button name="button" onclick="review_save('y');">임시저장</button></td>
        <td><button name="button" onclick="review_save('n');">등록</button></td>
    </tr>
</table>

<script>
    function review_save(review_type){
        var hap = 0;
        for(var k = 1; k <= 5; k++)
        {
            var obj_name = "score" + k;
            var chk = $(":radio[name="+obj_name+"]:checked");
            if(chk.length == 0) {
                alert("정량평가를 입력하세요.");
                $('[name="'+ obj_name + '"]').focus();
                return false;
            }

            hap = hap + parseFloat(chk.val());
        }
        var average = hap / 5;

        if($.trim($("#review_content").val()) == ""){
            alert("리뷰를 작성하세요\n(최소20자 이상)");
            $("#review_content").focus();
            return false;
        }

        if(getTextLength($("#review_content").val()) < 20){
            alert("리뷰를 작성하세요\n(최소20자 이상)");
            $("#review_content").focus();
            return false;
        }

        $("#temporary_yn").val(review_type);
        $("#average").val(average);
        $("#review_form").submit();
    }
</script>

<script>
    $('#review_content').on('keyup', function() {
        var content = $(this).val();
        var srtlength = getTextLength(content);
        $("#content_length").val(srtlength);
    });

    function getTextLength(str) {
        var len = 0;

        for (var i = 0; i < str.length; i++) {
            if (escape(str.charAt(i)).length == 6) {
                len++;
            }
            len++;
        }
        return len;
    }
</script>

<script>
    function changeWriteFile(evnt){
        const parentEl = evnt.target.parentElement.parentElement;
        const filesEl = parentEl.parentElement.lastElementChild;
        let cnt = Number(filesEl.childElementCount);
        const attatchedFiles = evnt.target.files;

        if(cnt < 5){
            parentEl.classList.add("hide");
        }
        else {
            //alert("파일 첨부는 최대 5개까지 가능합니다.");
            alert("파일 첨부는 최대 5개까지 가능합니다.");
            evnt.target.value = "";
            return;
        }
        if(attatchedFiles.length > 0){

            for(let i=0; i< attatchedFiles.length; i++) {
                const childEl = document.createElement("div");
                childEl.id = "file_show_" + cnt;
                // childEl.innerText = attatchedFiles[i].name;
                const image = document.createElement('img');
                image.src = URL.createObjectURL(attatchedFiles[i]);
                image.classList.add("img");

                childEl.id = "file_img_" + cnt;

                childEl.setAttribute('bf-file-id', evnt.target.id);

                const childRemoveEl = document.createElement("div");
                // childRemoveEl.classList.add("remove");
                childRemoveEl.onclick = function(event) {
                    attached_file_del(event);
                };
                childRemoveEl.innerText = "remove";
                childEl.append(childRemoveEl);
                childEl.append(image);

                filesEl.append(childEl);
                cnt++;
            }

            const fileInputBoxEl = document.createElement("div");
            fileInputBoxEl.classList.add("file_uploader");
            const fileInputLabel = document.createElement("label");
            fileInputLabel.innerText = "파일첨부";
            const fileInputEl = document.createElement("input");
            fileInputEl.type = "file";
            fileInputEl.name = "review_img[]";
            fileInputEl.id = "review_img_"+document.querySelectorAll(".file_uploader").length;
            fileInputEl.onchange = function(event) {
                changeWriteFile(event);
            };
            fileInputLabel.append(fileInputEl);
            fileInputBoxEl.append(fileInputLabel);

            parentEl.parentElement.insertBefore(fileInputBoxEl, filesEl);
        }
    }


    function attached_file_del(evnt){
        var con_test = confirm("첨부파일을 삭제 하시겠습니까?");

        if(con_test == true){
            const parentEl = evnt.target.parentElement;
            const inputEl = parentEl.parentElement.parentElement.querySelector("#"+parentEl.getAttribute('bf-file-id'))

            parentEl.remove();
            inputEl.remove();
        }
        else if(con_test == false){
            return false;
        }
    }
</script>



@endsection
