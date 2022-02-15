<table border=1>
    <tr>
        <td>검색 결과 : {{ number_format($total_record) }}건</td>
    </tr>
</table>

<table border="1">
    <tr>
        <td><button type="button">주문취소</button></td>
        <td><button type="button">주문확인</button></td>
        <td><button type="button">엑셀다운로드</button></td>
        <td>
            <select name="">
                <option value="desc">주문일순(최신순)</option>
                <option value="asc">주문일순(역)순)</option>
            </select>
            </td>
    </tr>
</table>

<table border=1>
    <thead>
    <tr>
        <td><input type="checkbox" name="ct_all" id="ct_all" value="1"></td>
        <td>주문일</td>
        <td>주문번호</td>
        <td>운송장번호</td>
        <td>상품명</td>
        <td>주문건</td>
        <td>주문상태</td>
        <td>
            <table border=1>
                <tr>
                    <td>교환</td>
                </tr>
                <tr>
                    <td>요청건</td>
                    <td>완료건</td>
                </tr>
            </table>
        </td>
        <td>주문자</td>
        <td>주문합계</td>
        <td>실결제금액</td>
        <td>취소금액</td>
    </tr>
    <t/>head>




    <tr>
        <td><input type="checkbox" name="ct_chk" id="ct_chk"></td>
        <td>주문일</td>
        <td>주문번호</td>
        <td>운송장번호</td>
        <td>상품명</td>
        <td>주문건</td>
        <td>주문상태</td>
        <td>
            <table border=1>
                <tr>
                    <td>요청건</td>
                    <td>완료건</td>
                </tr>
            </table>
        </td>
        <td>주문자</td>
        <td>주문합계</td>
        <td>실결제금액</td>
        <td>취소금액</td>
    </tr>
    <tr>
        <td></td>
        <td>배송지정보 </td>
        <td colspan=10>이름</td>
    </tr>

    <tr>
        <td><input type="checkbox" name="ct_chk" id="ct_chk"></td>
        <td>주문일</td>
        <td>주문번호</td>
        <td>운송장번호</td>
        <td>상품명</td>
        <td>주문건</td>
        <td>주문상태</td>
        <td>
            <table border=1>
                <tr>
                    <td>요청건</td>
                    <td>완료건</td>
                </tr>
            </table>
        </td>
        <td>주문자</td>
        <td>주문합계</td>
        <td>실결제금액</td>
        <td>취소금액</td>
    </tr>
    <tr>
        <td></td>
        <td>배송지정보 </td>
        <td colspan=10>이름</td>
    </tr>



        <tr>
        <td><input type="checkbox" name="ct_chk" id="ct_chk"></td>
        <td>주문일</td>
        <td>주문번호</td>
        <td>운송장번호</td>
        <td>상품명</td>
        <td>주문건</td>
        <td>주문상태</td>
        <td>
            <table border=1>
                <tr>
                    <td>요청건</td>
                    <td>완료건</td>
                </tr>
            </table>
        </td>
        <td>주문자</td>
        <td>주문합계</td>
        <td>실결제금액</td>
        <td>취소금액</td>
    </tr>
    <tr>
        <td></td>
        <td>배송지정보 </td>
        <td colspan=10>이름</td>
    </tr>








</table>


<script>
    $(function() {
        $("input[name=ct_all]").click(function() {
            if($("#ct_all").is(":checked")) $("input[name^=ct_chk]").prop("checked", true);
            else $("input[name^=ct_chk]").prop("checked", false);
        });

        $("#deposit_num").html('{{ number_format($total_record) }}');
    });
</script>

