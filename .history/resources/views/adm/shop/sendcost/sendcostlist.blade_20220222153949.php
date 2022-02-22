@extends('layouts.admhead')

@section('content')

        <!-- 타이틀 영역 -->
        <div class="top">
            <div class="title">
                <h2>추가 배송비 관리</h2>
                <div class="button_box">
                    <button type="button" id="btn" onclick="sendcost_regi();">등록</button>
                    <button type="button" class="gray" onclick="choice_del()">선택 삭제</button>
                </div>
            </div>
        </div>

        <!-- 컨텐츠 영역 시작 -->
        <div class="contents_area setting">

            <form name="send_form" id="send_form" method="post" action="">
                {!! csrf_field() !!}
                <input type="hidden" name="act" id="act">
                <input type="hidden" name="num" id="num">

                <h3 class="line">추가 배송비 지역 추가</h3>
                <div class="box_cont">
                    <div class="row">
                        <div class="col">지역명</div>
                        <div class="col">
                            <input type="text" name="sc_name" id="sc_name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">우편번호 시작</div>
                        <div class="col">
                            <p>예)01239</p>
                            <input class="aln_left" type="text" name="sc_zip1" id="sc_zip1" size=5 maxlength="5">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">우편번호 끝</div>
                        <div class="col">
                            <p>예)01239</p>
                            <input class="aln_left" type="text" name="sc_zip2" id="sc_zip2" size=5 maxlength="5">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">추가 배송비</div>
                        <div class="col">
                            <input type="text" name="sc_price" id="sc_price" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" style="text-align:right;"> 원
                        </div>
                    </div>
                </div>

                <h3 class="line">추가 배송비 지역 리스트</h3>
                <table class="delivery_prc">
                    <colgroup>
                        <col style="width: 40px">
                        <col style="width: 80px">
                        <col style="width: auto">
                        <col style="width: 400px">
                        <col style="width: 100px">
                        <col style="width: 100px">
                    </colgroup>
                    <thead>
                        <tr>
                            <th><input type="checkbox" class="mg00" name="chkall" value="1" id="chkall" onclick="check_all(this.form)"></th>
                            <th>번호</th>
                            <th>지역명</th>
                            <th>우편번호</th>
                            <th>추가 배송비</th>
                            <th>관리</th>
                        </tr>
                    </thead>
                    <tbody>

                    @php
                        $i = 0;
                    @endphp
                    @foreach($sendcosts as $sendcost)
                        <tr>
                            <td><input type="checkbox" class="mg00" id="chk_{{ $i }}" name="chk[]" value="{{ $sendcost->id }}"></td>
                            <td>{{ $virtual_num-- }}</td>
                            <td class="add">{{ $sendcost->sc_name }}</td>
                            <td>{{ $sendcost->sc_zip1 }} ~ {{ $sendcost->sc_zip2 }}</td>
                            <td>{{ number_format($sendcost->sc_price) }}</td>
                            <td>
                                <button type="button" class="btn-sm-ln" onclick="sendcost_modi({{ $sendcost->id }});">수정</button>
                            </td>
                        </tr>
                    @php
                        $i++;
                    @endphp
                    @endforeach
                    </tbody>
                </table>

                <!-- 페이지네이션 시작 -->
                <div class="paging_box">
                    <div class="paging">
                        {!! $pnPage !!}
                    </div>
                </div>
                <!-- 페이지네이션 끝 -->

            </form>

        </div>
        <!-- 컨텐츠 영역 끝 -->


<script>
    function sendcost_regi(){
        if($("#sc_name").val() == ""){
            alert("지역명을 입력 하세요.");
            $("#sc_name").focus();alert(result);
            return false;
        }

        if($("#sc_zip1").val() == ""){
            alert("우편번호 시작을 입력 하세요.");
            $("#sc_zip1").focus();
            return false;
        }

        if($("#sc_zip2").val() == ""){
            alert("우편번호 끝을 입력 하세요.");
            $("#sc_zip2").focus();
            return false;
        }

        if($("#sc_price").val() == ""){
            alert("추가 배송비를 입력 하세요.");
            $("#sc_price").focus();
            return false;
        }

        var form_var = $("#send_form").serialize();
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
            type : 'post',
            url : '{{ route('shop.sendcost.ajax_regi_sendcost') }}',
            data : form_var,
            dataType : 'text',
            success : function(result){
//alert(result);
//return false;
                if(result == "ok"){
location.href='{{ route('sitem','ca_id='.$page.') }}';
                    location.href = '{{ route('shop.sendcost.index','page='.$page) }}';
                }
            },
            error: function(result){
                console.log(result);
            },
        });
    }
</script>

<script>
    function check_all(f)
    {
        var chk = document.getElementsByName("chk[]");

        for (i=0; i<chk.length; i++)
            chk[i].checked = f.chkall.checked;
    }
</script>


<script>
    function choice_del(){
        var chk_count = 0;
        var f = document.send_form;

        for (var i = 0; i < f.length; i++) {
            if (f.elements[i].name == "chk[]" && f.elements[i].checked)
                chk_count++;
        }

        if (!chk_count) {
            alert("삭제할 지역을 하나 이상 선택하세요.");
            return false;
        }

        if (confirm("선택 하신 지역을 삭제 하시겠습니까?") == true){    //확인
            var form_var = $("#send_form").serialize();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type : 'post',
                url : '{{ route('shop.sendcost.ajax_del_sendcost') }}',
                data : form_var,
                dataType : 'text',
                success : function(result){
                    if(result == "ok"){
                        alert('삭제 되었습니다.');
                        location.href = "{{ route('shop.sendcost.index') }}";
                    }
                },
                error: function(result){
                    console.log(result);
                },
            });
        }else{
            return;
        }
    }
</script>

<script>
    function sendcost_modi(num){
        $.ajax({
            type : 'get',
            url : '{{ route('shop.sendcost.ajax_modi_sendcost') }}',
            data : {
                'num'   : num
            },
            dataType : 'text',
            success : function(result){
                var json = JSON.parse(result);
                $("#act").val("modi");
                $("#num").val(json.id);
                $("#sc_name").val(json.sc_name);
                $("#sc_zip1").val(json.sc_zip1);
                $("#sc_zip2").val(json.sc_zip2);
                $("#sc_price").val(json.sc_price);
                $("#send_form").attr("action", "{{ route('shop.sendcost.ajax_regi_sendcost') }}");
                $("#btn").html('수정');
            },
            error: function(result){
                console.log(result);
            },
        });
    }
</script>






@endsection
