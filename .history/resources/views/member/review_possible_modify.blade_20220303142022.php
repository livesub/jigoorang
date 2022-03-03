@extends('layouts.head')

@section('content')

<script src="{{ asset('/design/js/onclick_star.js') }}"></script>

<script>
//수정 별 출력 함수 시작
function star_modi(num) {
    const range = document.querySelector('#range'+num);
    document.querySelector('#star_0'+num).style.width = `${range.value * 20}%`; //값만큼 칠해줌
    document.getElementById('value_0'+num).innerHTML = range.value; //1번 별
    document.getElementById('score'+num).value = range.value; //1번 별
}
</script>

    <!-- 서브 컨테이너 시작 -->
    <div class="sub-container">

        <!-- 위치 시작 -->
        <div class="location">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="{{ route('mypage.index') }}">마이페이지</a></li>
                <li><a href="">리뷰작성</a></li>
            </ul>
        </div>
        <!-- 위치 끝 -->

        <!-- 타이틀 시작 -->
        <div class="title_area list">
            <h2>리뷰작성</h2>
            <img src="{{ asset('/design/recources/imgs/review_wt.png') }}" alt="" class="block">
            <img src="{{ asset('/design/recources/imgs/review_wt_m@3x.png') }}" alt="" class="none">
            <div class="line_14-100"></div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 리뷰작성 시작  -->
        <div class="eval">

            <div class="board mypage_list">
                <!-- 리스트 시작 -->
                <div class="board_wrap">
<form name="review_form" id="review_form" method="post" action="" enctype='multipart/form-data' autocomplete="off">
{!! csrf_field() !!}
<input type="hidden" name="review_save_id" id="review_save_id" value="{{ $review_saves_info->id }}">
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
<input type="hidden" name="img_id" id="img_id" value="">
<input type="hidden" name="form_route" id="form_route" value="{{ route('mypage.review_possible_modi_save') }}">

                       <div class="information review">
                          <div class="tt_sub">
                            <h4>정량평가</h4>
                            <span class="point">(필수)</span>
                          </div>
                          <div class="tt_sub_02">별점은 0.5점(반별)씩 평가 가능합니다</div>



                            @for($i = 1; $i <= 5; $i++)
                            @php
                                $tmp = "item_name".$i;
                                $score_tmp = "score".$i;
                            @endphp

                              <input type="hidden" name="score{{ $i }}" id="score{{ $i }}">

                              <div class="bg_05 pdl-20">
                                <div class="review_star">
                                  <ul class="rs_0{{ $i }}">
                                    <li class="cr_04" id="ment{{ $i }}">{{ $rating_item_info->$tmp }}</li>
                                    <li>
                                      <span class="star cr_01">
                                        ★★★★★
                                        <span id="star_0{{ $i }}">★★★★★</span>
                                        <input type="range" oninput="drawStar{{ $i }}(this);" id="range{{ $i }}" value="{{ $review_saves_info->$score_tmp }}" step="0.5" min="0" max="5"><!--value에 출력할 값 넣기-->
                                      </span>
                                    </li>
                                    <li>
                                      <p id="value_0{{ $i }}">0</p><p>/5</p>
                                    </li>
                                  </ul>
                                </div>
                              </div>
                              <script>
                                star_modi({{ $i }});
                              </script>
                            @endfor




                      </div>


                      <div class="information review">
                          <div class="tt_sub">
                            <h4>리뷰작성</h4>
                            <span class="point">(필수)</span>
                          </div>

                          <div class="wt_text">
                                <textarea name="review_content" id="review_content" cols="30" rows="10" placeholder="최소 20자 이상 작성해주세요
                                &#13;&#10;- 좋았던 점과 아쉬운 점을 포함하여 최대한 자세하게 작성해 주세요
                                &#13;&#10;- 상품과 무관한 리뷰나 악의적 비방,욕설이 포함된  리뷰는 통보 없이 삭제되며 적립 혜택이 회수됩니다">{{ $review_saves_info->review_content }}</textarea>
                          </div>
                          <span id="textLengthCheck" class="textLengthCheck"></span>
                      </div>

                        <div class="information review">
                          <div class="tt_sub">
                            <h4>포토리뷰</h4>
                            <span class="point">(선택)</span>

                            <div class="file_uploader">
                              <!-- <label>사진첨부 + <input type="file" id="file_uploader" accept="image/*" onchange="changeWriteFile()" multiple /></label> -->
                              <label>사진첨부 + <input type="file" id="file_uploader" accept="image/*" onchange="changeWriteFile()" /></label>
                            </div>
                          </div>


                          <div class="upload pdb-20">
                            <p>- 최소 1개 이상의 사진을 등록해주세요</p>
                            <p>- 상품과 무관한 사진을 첨부한 리뷰는  통보 없이 삭제 및 적립 혜택이 회수됩니다.</p>
                          </div>

                          <div class="flies" id="photo_img"></div>
                         </div>


                </div>
                <!-- 리스트 끝 -->

            </div>

            <div class="btn-3ea">
                <button type="button" class="btn-50 sol-g" onclick="history.back(-1);">취소</button>
                <button type="button" class="btn-50" id="tmp_save_y" onclick="review_save('y'); loadshow();">임시저장</button>
                <button type="button" class="btn-50 bg-01" id="tmp_save_n" onclick="review_save('n'); loadshow();">등록</button>
            </div>
        </div>
        </form>
        <!-- 리뷰 작성 끝  -->



    </div>
    <!-- 서브 컨테이너 끝 -->

    <div id="load" style="display: none;">
        <img src="{{ asset('/design/recources/icons/loder03.svg') }}" alt="loading">
        <p>업로드중...</p>
      </div>

<script>
    var load_content = $("#review_content").val().length;
    $("#textLengthCheck").html("(" + load_content + " 자 / 최대 300자)"); //실시간 글자수 카운팅

	$('#review_content').on('keyup', function() {
		var content = $(this).val();
        //var srtlength = getTextLength(content);
        var srtlength = content.length;

        $("#textLengthCheck").html("(" + srtlength + " 자 / 최대 300자)"); //실시간 글자수 카운팅

		if (srtlength > 300) {
			alert("최대 300자까지 입력 가능합니다.");
			$(this).val(content.substring(0, 300));
            $('#textLengthCheck').html("(300 자 / 최대 300자)");
		}
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
let imageMap = {};
var tt = 0;

let showimage = [{!! $imgs_tmp !!}];
var img_key = '{!! $img_key !!}';

changeWriteFile(showimage); //수정 함수 호출

function review_save(review_type){
    var hap = 0;

    for(var k = 1; k <= 5; k++)
    {
        var obj_name = "score" + k;

        if($("#"+obj_name).val() == "" || $("#"+obj_name).val() == "0"){
            alert($("#ment" + k).text() + "를 평가 하세요.");
            return false;
        }

        hap = hap + parseFloat($("#"+obj_name).val());
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

    let formData = new FormData(document.getElementById('review_form'));    //이미지와 form 값을 다 넘길때

    for (let key in imageMap) {
        //console.log(imageMap[key]);
        formData.append("review_img[]", imageMap[key], imageMap[key].name);
    }

    const target = document.getElementById('tmp_save_y');
    target.disabled = true;
    const target2 = document.getElementById('tmp_save_n');
    target2.disabled = true;

    $.ajax({
        headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
        type : 'post',
        url: $("#form_route").val(),
        processData: false,
        contentType: false,
        cache : false,
        data: formData,
        dataType : 'json',
        success : function(data){
//alert(data);
//return false;
            if(data.status == "img_error"){
                alert("이미지 용량이 큽니다\n용량을 줄여서 올려 주세요.");
                location.reload();
            }

            if(data.status == "temp_save"){
                alert("리뷰가 수정 되었습니다.");
                location.href = data.route;
            }

            if(data.status == "save_ok"){
                if (confirm("리뷰가 등록되었습니다.\n해당페이지에서 확인하시겠습니까?") == true){    //확인
                    location.href = data.my_page;
                }else{   //취소
                    location.href = data.route;
                }
            }

            if(data.status == "error"){
                alert("잠시 시스템 장애가 발생 하였습니다. 관리자에게 문의 하세요.");
                location.href = data.route;
            }
        },
        error: function(result){
            console.log(result);
        },
    });

}

function changeWriteFile(uploadedUrls) {

    const view = document.querySelector(".flies");
    const fileUploaderEl = document.querySelector("#file_uploader");
    const parentEl = fileUploaderEl.parentElement.parentElement;
    const filesEl = view.parentElement.lastElementChild;
    let cnt = Number(filesEl.childElementCount);
    const attatchedFiles = fileUploaderEl.files;

    if (cnt + attatchedFiles.length > 5) {
        alert("파일 첨부는 최대 5개까지 가능합니다.");
        fileUploaderEl.value = "";
        return;
    }

    if (uploadedUrls != undefined) {
        for (const url of uploadedUrls) {
            makePreviewDiv(filesEl, url);
        }
    } else if (attatchedFiles.length > 0) {
        for (const file of attatchedFiles) {
            makePreviewDiv(filesEl, file);
        }
    }

    fileUploaderEl.value = "";
}


function makePreviewDiv(filesEl, fileOrUrl) {
    const childEl = document.createElement("div");
    childEl.classList.add("img_files");
    const image = document.createElement('img');
    childEl.id = "file_img_" + Date.now();
    if (fileOrUrl instanceof File) {
        image.src = URL.createObjectURL(fileOrUrl);
        imageMap[childEl.id] = fileOrUrl;

    } else if (typeof fileOrUrl === 'string') {
        //console.log(fileOrUrl);
        image.src = '/data/review/' + fileOrUrl;

        //image.src = fileOrUrl;
    }

    var key_arr = img_key.split('@@');

    var key_val = key_arr[tt];
    //imageMap[key_val] = key_val;

    image.classList.add("img");

    const childRemoveEl = document.createElement("div");
    childRemoveEl.classList.add("remove");
    childRemoveEl.onclick = function (event) {
//alert("FFF===>"+gg);
//return false;
        attached_file_del(event, typeof fileOrUrl === 'string' ? fileOrUrl : null, key_val);
    };
    childRemoveEl.innerText = "remove";
    childEl.append(image);
    childEl.append(childRemoveEl);

    filesEl.append(childEl);
    tt++;
}

function attached_file_del(evnt, url, key_val) {
    var con_test = confirm("첨부파일을 삭제 하시겠습니까?");

    if (url != null) {
        //console.log(url);
        //ajax file delete code (ajax 삭제 코드 넣는곳)
    }

    if (con_test == true) {

        if(url == null){
            const parentEl = evnt.target.parentElement;
            parentEl.remove();
            delete imageMap[parentEl.id];
        }else{
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type: 'post',
                url: '{{ route('mypage.ajax_review_possible_img_del') }}',
                dataType: 'text',
                data: {
                    'num'   : key_val,
                    'rs_id' : '{{ $review_saves_info->id }}',
                },
                success: function(result) {
                    const parentEl = evnt.target.parentElement;
                    parentEl.remove();
                    delete imageMap[parentEl.id];
                },error: function(result) {
                    console.log(result);
                }
            });
        }
    }
    else if (con_test == false) {
        return false;
    }
}
</script>



<script src="{{ asset('/design/js/loder.js') }}"></script>


@endsection
