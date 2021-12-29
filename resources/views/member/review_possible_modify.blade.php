@extends('layouts.head')

@section('content')

<script src="{{ asset('/design/js/star.js') }}"></script>
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
            <img src="{{ asset('/design/recources/imgs/review_wt_m.png') }}" alt="" class="none">
            <div class="line_14-100"></div>
        </div>
        <!-- 타이틀 끝 -->

        <!-- 리뷰작성 시작  -->
        <div class="eval">

            <div class="board mypage_list">
                <!-- 리스트 시작 -->
                <div class="board_wrap">
<form class="board write" name="review_form" id="review_form" method="post" action="{{ route('mypage.review_possible_modi_save') }}" enctype='multipart/form-data'>
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

                       <div class="information review">
                          <div class="tt_sub">
                            <h4>정량평가</h4>
                            <span class="point">(필수)</span>
                          </div>
                          <div class="tt_sub_02">별점은 0.5점(반별)씩 평가 가능합니다</div>



                @for($i = 1; $i <= 5; $i++)
                @php
                    $tmp = "item_name".$i;
                    $dip_name = $rating_item_info->$tmp;
                    $score_tmp = "score".$i;

                    $score_chk1 = '';
                    $score_chk1_5 = '';
                    $score_chk2 = '';
                    $score_chk2_5 = '';
                    $score_chk3 = '';
                    $score_chk3_5 = '';
                    $score_chk4 = '';
                    $score_chk4_5 = '';
                    $score_chk5 = '';

                    switch($review_saves_info->$score_tmp) {
                        case '1':
                            $score_chk1 = "checked";
                            break;
                        case '1.5':
                            $score_chk1_5 = "checked";
                            break;
                        case '2':
                            $score_chk2 = "checked";
                            break;
                        case '2.5':
                            $score_chk2_5 = "checked";
                            break;
                        case '3':
                            $score_chk3 = "checked";
                            break;
                        case '3.5':
                            $score_chk3_5 = "checked";
                            break;
                        case '4':
                            $score_chk4 = "checked";
                            break;
                        case '4.5':
                            $score_chk4_5 = "checked";
                            break;
                        case '5':
                            $score_chk5 = "checked";
                            break;
                    }
                @endphp

                          <div class="bg_05 pdl-20">
                            <div class="review_star">
                              <ul class="rs_01"><script src="{{ asset('/design/js/flieupload.js') }}"></script>
                                <li class="cr_04">{{ $rating_item_info->$tmp }}</li>

                                <li>
                                  <div class="cot_star_01" id="project_{{ $i }}">
                                      <div class="stars-outer">
                                      <div class="stars-inner"></div>
                                      <p class="number"></p>
                                  </div>
                                </div>
                                </li>

                              </ul>
                            </div>
                          </div>
                          <script>
                            star({{ $review_saves_info->$score_tmp }}, {{ $i }});// rating = 별점 값 , value = 순번
                          </script>
                @endfor




                      </div>


                      <div class="information review">
                          <div class="tt_sub">
                            <h4>리뷰작성</h4>
                            <span class="point">(필수)</span>
                          </div>

                          <div class="wt_text">
                                <textarea name="" id="" cols="30" rows="10" placeholder="최소 20자 이상 작성해주세요
                                &#13;&#10;- 좋았던 점과 아쉬운 점을 포함하여 최대한 자세하게 작성해 주세요
                                &#13;&#10;- 상품과 무관한 리뷰나 악의적 비방,욕설이 포함된  리뷰는 통보 없이 삭제되며 적립 혜택이 회수됩니다"></textarea>
                          </div>
                      </div>

                        <div class="information review">
                          <div class="tt_sub">
                            <h4>포토리뷰</h4>
                            <span class="point">(필수)</span>

                            <div class="file_uploader">
                              <label>사진첨부 + <input type="file" id="file_uploader" accept="image/*" onchange="changeWriteFile()"
                                      multiple /></label>
                            </div>
                          </div>


                          <div class="upload pdb-40">
                            <p>- 최소 1개 이상의 사진을 등록해주세요</p>
                            <p>- 상품과 무관한 사진을 첨부한 리뷰는  통보 없이 삭제 및 적립 혜택이 회수됩니다.</p>
                          </div>

                          <div class="flies" id="photo_img"></div>
                         </div>


                </div>
                <!-- 리스트 끝 -->

            </div>

            <div class="btn-3ea">
                <button type="button" class="btn-50 sol-g">취소</button>
                <button type="button" class="btn-50">임시저장</button>
                <button type="submit" class="btn-50 bg-01">등록</button>
            </div>
        </div>
        <!-- 리뷰 작성 끝  -->



    </div>
    <!-- 서브 컨테이너 끝 -->







<script>
let imageMap = {};
var tt = 0;

let showimage = [{!! $imgs_tmp !!}];
var img_key = '{!! $img_key !!}';

changeWriteFile(showimage); //수정 함수 호출

function imageFormData() {
    let formData = new FormData();

    for (let key in imageMap) {
        //console.log(imageMap[key]);
        formData.append("review_img[]", imageMap[key], imageMap[key].name);
    }

    // for (let value of formData.entries()) {
    //   console.log(value);
    // }
    return formData;
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
    imageMap[key_val] = key_val;

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
    //alert(result);
    //return false;
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



<!--
<script src="{{ asset('/design/js/flieupload.js') }}"></script>
-->



@endsection
