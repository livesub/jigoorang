<script src="{{ asset('/design/js/modal-back02.js') }}"></script>


    <div class="modal-background" onclick="addressclosemodal_001()"></div>

        <div class="modal-container">
            <div class="modal-container-body">

                <div class="modal-container-title">
                    <h4>배송지 주소</h4>
                    <div class="btn-close" onclick="addressclosemodal_001()">
                </div>
            <div class="scroll">
                @if(count($baesongjis) > 0)
                    @php
                        $sep = chr(30);
                        $i = 0;
                        $addr = '';
                    @endphp

                    @foreach($baesongjis as $baesongji)
                        @php
                        $addr = $baesongji->ad_name.$sep.$baesongji->ad_tel.$sep.$baesongji->ad_hp.$sep.$baesongji->ad_zip1.$sep.$baesongji->ad_addr1.$sep.$baesongji->ad_addr2.$sep.$baesongji->ad_addr3.$sep.$baesongji->ad_jibeon.$sep.$baesongji->ad_subject;

                        $checked = "";
                        if($baesongji->ad_default == 1) $checked = "checked";
                        @endphp

                <div class="modal-container-box">
                  <input type="hidden" name="id_ori[{{ $i }}]" id="id_ori[{{ $i }}]" value="{{ $baesongji->id }}">
                    <h3>{{ $baesongji->ad_name }}
                    @if($baesongji->ad_default == 1)
                    <span>(기본 배송지)</span>
                    @endif
                    </h3>
                    <p>{{ $baesongji->ad_addr1 }}
                        <br>{{ $baesongji->ad_addr2 }} {{ $baesongji->ad_addr3 }}</p>
                        <input type="hidden" id="addr{{ $i }}" value="{{ $addr }}">
                        <button type="button" class="btn-3ea-01" onclick="del_addr('{{ $baesongji->id }}');">삭제</button>
                        <button type="button" class="btn-3ea-02" onclick="modi_addr('{{ $baesongji->id }}');">수정</button>
                        @if($b_addr != 'mypage')
                        <button type="button" class="btn-3ea-03" onclick="return_addr('{{ $i }}');">선택</button>
                        @endif
                </div>
                        @php
                            $i++;
                        @endphp
                    @endforeach

                @else
                  <p class="adress_none">등록된 배송지가 없습니다</p>
                @endif
            </div>
        </div>
    </div>
            <div class="btn btn_2ea">
                <button class="modal_btn01" type="button" onclick="addressclosemodal_001()">
                    닫기
                </button>
                <button class="modal_btn02" type="button" onclick="baesongji_regi();">
                    배송지 추가
                </button>
            </div>


</div>

<script>
    function return_addr(num){
        var addr = $("#addr"+num).val().split(String.fromCharCode(30));

        $("#od_b_name").val(addr[0]);
        $("#od_b_tel").val(addr[1]);
        $("#od_b_hp").val(addr[2]);
        $("#od_b_zip").val(addr[3]);
        $("#od_b_addr1").val(addr[4]);
        $("#od_b_addr2").val(addr[5]);
        $("#od_b_addr3").val(addr[6]);
        $("#od_b_addr_jibeon").val(addr[7]);
        $("#ad_subject").val(addr[8]);

        calculate_sendcost(addr[3]);
    }

    function lay_close(){
        $("#disp_baesongi").html("");
    }
</script>

<script>
    function baesongji_regi(){
        $.ajax({
            type : 'get',
            url : '{{ route('ajax_baesongji_regi') }}',
            data : {
            },
            dataType : 'text',
            success : function(result){
                $("#disp_baesongi").html(result);
            },
            error: function(result){
                console.log(result);
            },
        });
    }

    function modi_addr(num){
        $.ajax({
            type : 'get',
            url : '{{ route('ajax_baesongji_modify') }}',
            data : {
                'num' : num,
            },
            dataType : 'text',
            success : function(result){
                $("#disp_baesongi").html(result);
            },
            error: function(result){
                console.log(result);
            },
        });
    }

    function del_addr(num){
        if (confirm("배송지를 삭제하시겠습니까?") == true){    //확인
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                type : 'post',
                url : '{{ route('ajax_baesongji_del') }}',
                data : {
                    'num' : num,
                },
                dataType : 'text',
                success : function(result){
//alert(result);
//return false;
                    if(result == "ok"){
                        baesongji();
                    }

                },
                error: function(result){
                    console.log(result);
                },
            });
        }else{   //취소
            return false;
        }
    }

    function ad_default_chk(num){
        $.ajax({
            type : 'get',
            url : '{{ route('ajax_baesongji_change') }}',
            data : {
                'id'    : num,
            },
            dataType : 'text',
            success : function(result){
                if(result == "ok"){
                    baesongji();
                }
            },
            error: function(result){
                console.log(result);
            },
        });

    }
</script>