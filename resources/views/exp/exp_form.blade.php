@extends('layouts.head')

@section('content')
    신청 폼입니다.
    <br>
    이름 : {{ auth()->user()->user_name }}
    <br>
    핸드폰 : {{ auth()->user()->user_phone }} <a href="{{ route('member_info_index') }}"><button>변경</button></a>
    <br>
    이메일 : {{ auth()->user()->user_id }}
    <br>
    평가단 참여이유 (필수)<br>
    <textarea id="form_text" name="form_text" placeholder="30자 이상 ~ 300자이내로 작성하도록 해주세요(띄어쓰기 포함)"></textarea>
    <!-- 글자수 표현 -->
    <div id="textLengthCheck"></div>



    <hr>
    <h2>배송지</h2>
    <form name="forderform" id="forderform">
    {!! csrf_field() !!}
    <table border=1>
                <!-- 받으시는 분 입력 시작  -->
                <tr>
                    <button type="button" onclick="baesongji()">배송지입력</button>
                    <div id="disp_baesongi"></div>
                </tr>
    </table>
    </form>
                @if(empty($address))
                    <div id="none_address">등록된 배송지가 없습니다. '배송지 입력' 버튼을 눌러 배송지를 추가해 주세요</div>
                    <div id="show_address" style="display : none">
                        <div><span id="ad_name"></span>        <span id="ad_hp"></span></div>
                        <div>주소<span id="ad_addr"></span></div>
                        <input type="hidden" id="ad_jibeon_view" name="ad_jibeon_view">
                        <label for="ship_memo">배송 메모</label>
                        <input type="text" id="ship_memo" name="ship_memo" placeholder="입력하세요">
                    </div>
                @else
                    <div id="show_address">
                        <div><span id="ad_name">{{ $address->ad_name}}</span>        <span id="ad_hp">{{ $address->ad_hp }}</span></div>
                        <div>주소<span id="ad_addr">{{ $address->ad_zip1 }} {{ $address->ad_addr1 }} {{ $address->ad_addr2 }} {{ $address->ad_addr3 }}</span></div>
                        <label for="ship_memo">배송 메모</label>
                        <input type="hidden" id="ad_jibeon_view" name="ad_jibeon_view" value="{{ $address->ad_jibeon }}">
                        <input type="text" id="ship_memo" name="ship_memo" placeholder="입력하세요">
                    <div>
                @endif
                <!-- <div>아아디 : {{ $id }}</div> -->

                <form action="{{ route('exp.list.form_create') }}" method="post" onsubmit="return check_submit()">
                    {!! csrf_field() !!}
                    <input type="hidden" id="exp_id" name="exp_id" value="{{ $id }}">
                    <input type="hidden" id="user_id" name="user_id" value="{{ auth()->user()->user_id }}">
                    <input type="hidden" id="sca_id" name="sca_id" value="{{ $result->sca_id }}">
                    <input type="hidden" id="item_id" name="item_id" value="{{ $result->item_id }}">
                    <input type="hidden" id="user_name" name="user_name" value="{{ auth()->user()->user_name }}">
                    @if(empty($address))
                        <input type="hidden" id="od_b_name" name="ad_name">
                        <input type="hidden" id="od_b_hp" name="ad_hp">
                        <input type="hidden" id="od_b_zip" name="ad_zip1">
                        <input type="hidden" id="od_b_addr1" name="ad_addr1">
                        <input type="hidden" id="od_b_addr2" name="ad_addr2">
                        <input type="hidden" id="od_b_addr3" name="ad_addr3">
                        <input type="hidden" id="od_b_addr_jibeon" name="ad_jibeon">
                    @else
                        <input type="hidden" id="od_b_name" name="ad_name" value="{{ $address->ad_name }}">
                        <input type="hidden" id="od_b_hp" name="ad_hp" value="{{ $address->ad_hp }}">
                        <input type="hidden" id="od_b_zip" name="ad_zip1" value="{{ $address->ad_zip1 }}">
                        <input type="hidden" id="od_b_addr1" name="ad_addr1" value="{{ $address->ad_addr1 }}">
                        <input type="hidden" id="od_b_addr2" name="ad_addr2" value="{{ $address->ad_addr2 }}">
                        <input type="hidden" id="od_b_addr3" name="ad_addr3" value="{{ $address->ad_addr3 }}">
                        <input type="hidden" id="od_b_addr_jibeon" name="ad_jibeon" value="{{ $address->ad_jibeon }}">
                    @endif
                    <input type="hidden" id="shipping_memo" name="shipping_memo">
                    <input type="hidden" id="reason_memo" name="reason_memo">
                    <label for="promotion_agree">약관동의</label>
                    <input type="checkbox" id="promotion_agree" name="promotion_agree" value="y">
                    <br>
                    <button>평가단 신청</button>
                </form>


<script>
	$('#form_text').on('keyup', function() {
		var content = $(this).val();
        var srtlength = getTextLength(content);
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
    function baesongji(){
        $.ajax({
            type : 'get',
            url : '{{ route('ajax_baesongji') }}',
            data : {
            },
            dataType : 'text',
            success : function(result){
                if(result == "no_mem"){
                    alert("회원이시라면 회원로그인 후 이용해 주십시오.");
                    return false;
                }

                $("#disp_baesongi").html(result);
            },
            error: function(result){
                console.log(result);
            },
        });
    }

    function calculate_sendcost(){
        //히든 값으로 가져온 값을 해당 태그에 html이나 text로 넣어준다.
        $('#ad_name').text($("#od_b_name").val());
        $('#ad_hp').text($("#od_b_hp").val());
        let $ad_addrs = $("#od_b_zip").val()+" "+$("#od_b_addr1").val()+" "+$("#od_b_addr2").val()+" "+$("#od_b_addr3").val();
        $('#ad_addr').text($ad_addrs);
        //창닫기
        lay_close();

        //보여주던 부분을 숨기고 display none 값들을 보여준다.
        $("#show_address").show();
        $("#none_address").hide();
    }

    //보내기 전 예외처리
    function check_submit(){
        let form_text = $('#form_text').val();
        let od_b_name = $("#od_b_name").val();
        let od_b_hp = $("#od_b_hp").val();
        let od_b_zip = $("#od_b_zip").val();
        let od_b_addr1 = $("#od_b_addr1").val();
        let od_b_addr2 = $("#od_b_addr2").val();
        let od_b_addr3 = $("#od_b_addr3").val();
        let od_b_addr_jibeon = $("#od_b_addr_jibeon").val();

        if(form_text == null || form_text == ""){
            alert('참여이유를 작성해 주세요.');
            return false;
        }

        if(form_text.length < 30 || form_text.length >= 300){
            alert('평가단 참여이유를 30자 이상~ 300자 이내로 작성해 주세요.');
            return false;
        }
        //주소가 없을 경우 예외처리 하나라도 없을 경우 나오게
        if((od_b_name == null || od_b_name == "") || (od_b_hp == null || od_b_hp == "") || (od_b_zip == null || od_b_zip == "")
        || (od_b_addr1 == null || od_b_addr1 == "") || (od_b_addr2 == null || od_b_addr2 == "")){
            alert('배송지가 입력되지 않았습니다.');
            return false;
        }

        if(!$('#promotion_agree').is(":checked")){
            alert('약관에 동의 후 평가단 신청이 가능합니다.');
            return false;
        }

        //참여이유 및 배송메모 값 옮기기
        $("#reason_memo").val(form_text);
        $("#shipping_memo").val($("#ship_memo").val());

        return true;
    }
</script>
@endsection