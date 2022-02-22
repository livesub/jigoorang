@extends('layouts.admhead')

@section('content')

        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>리뷰 수정</h2>
                <div class="button_box">
                    <button type="button" onclick="review_modi_save()">수정<!-- 수정 --></button>
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area review">
            <h3 class="line">리뷰수정</h3>
            <form name="review_form" id="review_form" method="post" action="{{ route('adm.review.review_modi_save') }}" enctype='multipart/form-data'>
            {!! csrf_field() !!}
            <input type="hidden" name="num" value="{{ $num }}">
            <input type="hidden" name="page_move" value="{!! $page_move !!}">

                <div class="box_cont">
                    <div class="row">
                        <div class="col">아이디</div>
                        <div class="col">
                            {{ $review_save->user_id }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">이름</div>
                        <div class="col">
                            {{ $review_save->user_name }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">상품명</div>
                        <div class="col">
                            {{ $item_name }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">체험단명</div>
                        <div class="col">
                            {{ $title_ment }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">정량평가</div>
                        <div class="col">
                            {{ $dip_name }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">리뷰</div>
                        <div class="col">
                            <textarea name="review_content" id="review_content" style="width:100%" rows="10">{{ $review_content }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">포토리뷰</div>
                        <div class="col">
                        @php
                            $k = 1;
                        @endphp
                        @foreach($review_save_imgs as $review_save_img)
                            @php
                                $img_cut = array();
                                $img_src = "";
                                if($review_save_img->review_img != ""){
                                    $img_cut = explode("@@", $review_save_img->review_img);
                                    $img_src = $img_cut[2];
                                }
                            @endphp

                            <div class="file_att">
                                <div class="btn_file">
                                    <input type="hidden" name="review_id_{{ $k }}" value="{{ $review_save_img->id }}">
                                    <label>
                                        파일선택
                                        <input type="file" name="review_img_{{ $k }}" id="review_img{{ $k }}" accept="image/*" onchange="file_name('review_img{{ $k }}')">
                                    </label>
                                    <span id="review_img{{ $k }}_name"></span>
                                    <p><img src="{{ asset('/data/review/'.$img_src) }}"></p>
                                    <!-- 선택된 파일이 없습니다. -->
                                </div>
                                <div class="file">
                                    <label>
                                        <input type="checkbox" name="file_chk_{{ $k }}" id="file_chk_{{ $k }}" value='1'>수정, 삭제, 새로등록시 체크
                                    </label>
                                </div>
                           </div>
                            @php
                                $k++;
                            @endphp
                        @endforeach


                        @for($i = count($review_save_imgs)+1; $i <= 5; $i++)
                        <div class="file_att">
                            <div class="btn_file">
                                <label>
                                    파일선택
                                    <input type="file" name="review_img_{{ $i }}" id="review_img{{ $i }}" accept="image/*" onchange="file_name('review_img{{ $k }}')">
                                </label>
                                <span id="review_img{{ $i }}_name"></span>
                                <!-- 선택된 파일이 없습니다. -->
                            </div>
                            <div class="file">
                                <label>
                                    <input type="checkbox" name="file_chk_{{ $i }}" id="file_chk_{{ $i }}" value='1'>수정, 삭제, 새로등록시 체크
                                </label>
                            </div>
                        </div>
                        @endfor

                        </div>
                    </div>
                </div>

            </form>

        </div>
        <!-- 컨텐츠 영역 끝 -->

<script>
    function review_modi_save(){
        if (confirm("리뷰를 수정 하시겠습니까?") == true){    //확인
            $("#review_form").submit();
        }else{   //취소
            return false;
        }
    }
</script>

<script>
    function file_name(id_val){
        flies = document.getElementById(id_val);

        fileList = "";
        for(i = 0; i < flies.files.length; i++){
            fileList += flies.files[i].name;
        }
        flies_name = document.getElementById(id_val+'_name');
        flies_name.innerHTML = fileList;
    }
</script>

@endsection
