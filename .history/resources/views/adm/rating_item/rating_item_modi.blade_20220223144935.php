@extends('layouts.admhead')

@section('content')

    <form action="{{ route('admRating.modi', $result->id) }}" method="post" onsubmit="return form_check()">
    {!! csrf_field() !!}
    <input type="hidden" name="last_choice_ca_id" id="last_choice_ca_id" value="{{ $result->sca_id }}">
        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>정량평가 항목 수정</h2>
                <div class="button_box">
                    <button type="submit">수정</button><!-- 수정 -->
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area review">
                <div class="box_cont">
                    <div class="row">
                        <div class="col">카테고리 선택</div>
                        <div class="col">
                            <div class="cate_sel">
                            <ul class="cate_sel_01">
                                <li id="cate1">
                                    <select name="ca_id" id="caa_id" class="cid" >
                                    @foreach($one_step_infos as $one_step_info)
                                        @php
                                            if($one_str_cut == $one_step_info->sca_id) $one_selected = "selected";
                                            else $one_selected = "";
                                        @endphp

                                        <option value="{{ $one_step_info->sca_id }}" {{ $one_selected }}>{{ $one_step_info->sca_name_kr }}</option>
                                    @endforeach
                                    </select>
                                </li>

                            <li>
                                <ul id="cate2_tt">
                                <li id="cate2" style="display:block"></li>
                                <li class="none">
                                @if($ca_id && strlen($ca_id) >= 4)
                                    <select name="ca_id" id="caa_id2" class="cid" >
                                    @foreach($two_step_infos as $two_step_info)
                                        @php
                                            if($two_str_cut == $two_step_info->sca_id) $two_selected = "selected";
                                            else $two_selected = "";
                                        @endphp
                    
                                        <option value="{{ $two_step_info->sca_id }}" {{ $two_selected  }}>{{ $two_step_info->sca_name_kr }}</option>
                                    @endforeach
                                    </select>
                                @endif
                                </li>
                            `</ul>
                            </li>
                            </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">정량평가 항목1</div>
                        <div class="col">
                            <p>15자 이내로 입력하세요</p>
                            <input type="text" id="item_name1" name="item_name1" value="{{ $result->item_name1 }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">정량평가 항목2</div>
                        <div class="col">
                            <p>15자 이내로 입력하세요</p>
                            <input type="text" id="item_name2" name="item_name2" value="{{ $result->item_name2 }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">정량평가 항목3</div>
                        <div class="col">
                            <p>15자 이내로 입력하세요</p>
                            <input type="text" id="item_name3" name="item_name3" value="{{ $result->item_name3 }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">정량평가 항목4</div>
                        <div class="col">
                            <p>15자 이내로 입력하세요</p>
                            <input type="text" id="item_name4" name="item_name4" value="{{ $result->item_name4 }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">정량평가 항목5</div>
                        <div class="col">
                            <p>15자 이내로 입력하세요</p>
                            <input type="text" id="item_name5" name="item_name5" value="{{ $result->item_name5 }}">
                        </div>
                    </div>
                </div>
        </div>
    </form>
        <!-- 컨텐츠 영역 끝 -->




<script>
    $(document).ready(function() {
        $(document).on("click", "#caa_id", function() {
			var cate_is = $('#caa_id').val();

            if(cate_is != null){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                    type: 'post',
                    url: '{{ route('shop.cate.ajax_select') }}',
                    dataType: 'text',
                    data: {
                        'ca_id'   : $('#caa_id').val(),
                        'length'  : $('#caa_id').val().length,
                    },
                    success: function(result) {
                        var data = JSON.parse(result);
    //alert(data.ca_name_kr);
                        if(data.success == 0) {
                            console.log(data.msg);
                        }else{
                            $('#last_choice_ca_id').val(data.ca_id);
                            $('#cate2').css('display', 'block');
                            $('.ct_none').css('display', 'none');
                            $('#cate2').html(data.data);
                            $('#cate3').html('');
                            $('#cate4').html('');
                            $('#cate5').html('');
                        }

                    },error: function(result) {
                        console.log(result);
                    }
                });
            }
		});

		$(document).on("click", "#caa_id2", function() {
			var cate_is = $('#caa_id2').val();

            if(cate_is != null){
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                    url: '{{ route('shop.cate.ajax_select') }}',
                    type: 'post',
                    dataType: 'text',
                    data: {
                        ca_id   : $('#caa_id2').val(),
                        length  : $('#caa_id2').val().length,
                    },
                    success: function(result) {
                        var data = JSON.parse(result);
                        if(data.success == 0) {
                            console.log(data.msg);
                        }else{
                            $('#last_choice_ca_id').val(data.ca_id);
                            $('#cate3').css('display', 'block');
                            $('#cate3').html(data.data);
                            $('#cate4').html('');
                            $('#cate5').html('');
                        }
                    },error: function(result) {
                        console.log(result);
                    }
                });
            }
		});
    });
    //예외처리 함수
    function form_check(){

        var item_name1 = $('#item_name1').val();
        var item_name2 = $('#item_name2').val();
        var item_name3 = $('#item_name3').val();
        var item_name4 = $('#item_name4').val();
        var item_name5 = $('#item_name5').val();
        var last_choice_ca_id = $("#last_choice_ca_id").val();

        //5개 다 체크
        if((item_name1 == "" || item_name1 == null) || (item_name2 == "" || item_name2 == null) || (item_name3 == "" || item_name3 == null) ||
        (item_name4 == "" || item_name4 == null) || (item_name5 == "" || item_name5 == null)){
            alert('모든 항목을 입력하셔야 합니다.');
            return false;
        }

        //카테고리를 선택안했을 경우
        if(last_choice_ca_id == "" || last_choice_ca_id == null){
            alert("단계를 선택 하세요.");
            $("#caa_id").focus();
            return false;
        }

        //1차 카테는 불가
        if(last_choice_ca_id.length < 4){
            alert('2차 카테코리만 설정할 수 있습니다.');
            return false;
        }

        return true;
    }
</script>


@endsection