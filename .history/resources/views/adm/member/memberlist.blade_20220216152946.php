@extends('layouts.admhead')

@section('content')


<table border=1>
    <tr>
        <td>총 회원 : <?= $totalCount ?>명</td>
    </tr>
    <tr>
        <td>탈퇴 회원 : <?= $member_draw ?>명</td>
    </tr>
    <tr>
        <td>블랙리스트 회원 : <?= $member_blacklist ?>명</td>
    </tr>
<tr>
        <td>사이트 접근 불가 회원 : <?= $member_site_access_no ?>명</td>
    </tr>
</table>


<table border=1>
    <form name="memsearchlist" id="memsearchlist" method="get" action="{{ route('adm.member.index') }}">
    <h4>회원 리스트</h4>
    <tr>
        <td colspan="5">
            @php
                $tmp = '';
                $tmp2 = '';
                $tmp3 = '';
                $tmp4 = '';
                $tmp5 = '';
                $tmp6 = '';
                $tmp10 = '';
                $tmp11 = '';

                if($user_type_selected == '') $tmp = 'selected';
                else if($user_type_selected == 'N') $tmp2 = 'selected';
                else if($user_type_selected == 'Y') $tmp3 = 'selected';
                else if($user_type_selected == 'blacklist') $tmp10 = 'selected';
                else if($user_type_selected == 'site_no') $tmp11 = 'selected';

                if($user_type2 == "") $tmp4 = "selected";
                else if($user_type2 == "user_id") $tmp5 = "selected";
                else if($user_type2 == "user_name") $tmp6 = "selected";
            @endphp
            <select name="user_type" id="user_type" onchange="user_type_change(this.value);">
                <option value="" {{ $tmp }}>전체</option>
                <option value="N" {{ $tmp2 }}>회원</option>
                <option value="Y" {{ $tmp3 }}>탈퇴회원</option>
                <option value="blacklist" {{ $tmp10 }}>블랙리스트회원</option>
                <option value="site_no" {{ $tmp11 }}>사이트접근불가회원</option>
            </select>
            <select name="user_type2" id="user_type2">
                <option value="user_id" {{ $tmp5 }}>아이디</option>
                <option value="user_name" {{ $tmp6 }}>이름</option>
            </select>
            <input type="text" name="keyword" id="keyword" value="{{ $keyword }}"><button type="submit">검색</button>
        </td>
    </form>
    </tr>

    <form name="memlist" id="memlist" method="post" action="{{ route('adm.member.out') }}">
    {!! csrf_field() !!}
    <tr>
        <td><input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);" class="selec_chk"></td>
        <td>번호</td>
        <td>이름</td>
        <td>아이디</td>
        <td>가입일</td>
        <td>휴대폰번호</td>
        <td>가입경로</td>
        <td>포인트</td>
        <td>탈퇴여부</td>
        <td>블랙리스트</td>
        <td>사이트 접근 불가</td>
    </tr>
    @foreach($members as $member)
        @php
            $user_type = "";
            if($member->user_type == 'Y') $user_type = '탈퇴';
            else $user_type = '가입';

            $blacklist_chk = '';
            if($member->blacklist == 'y') $blacklist_chk = '블랙리스트';

            $site_access_no_chk = '';
            if($member->site_access_no == 'y') $site_access_no_chk = '사이트 접근 불가';


            if($member->user_platform_type == '') $platform_type = '회원가입';
            else if($member->user_platform_type == 'kakao') $platform_type = '카카오';
            else if($member->user_platform_type == 'naver') $platform_type = '네이버';
        @endphp
    <tr>
        <td><input type="checkbox" name="chk_id[]" value="{{ $member->id }}" id="chk_id_{{ $member->id }}" class="selec_chk"></td>
        <td>{{ $virtual_num-- }}</td>
        <td><a href="javascript:mem_regi('modi',{{ $member->id }});">{{ $member->user_name }}</a></td>
        <td>{{ $member->user_id }}</td>
        <td>{{ $member->created_at }}</td>
        <td>{{ $member->user_phone }}</td>
        <td>{{ $platform_type }}</td>
        <td>{{ number_format($member->user_point) }}P</td>
        <td>{{ $user_type }}</td>
        <td>{{ $blacklist_chk }}</td>
        <td>{{ $site_access_no_chk }}</td>
    </tr>

    @endforeach

    </form>

</table>



<table>
    <tr>

        <td>
            <button style="margin-top:20px;" onclick="mem_regi('regi');">회원등록</button>
        </td>

        <td>
            <button style="margin-top:20px;" onclick="mem_out();">회원 선택 탈퇴/가입 처리</button>
        </td>
    </tr>
</table>

<table>
    <tr>
        <td>
           {!! $pnPage !!}
        </td>
    </tr>
</table>

<form action="" id="mem_form" method="GET">
    <input type="hidden" name="mode" id="mode">
    <input type="hidden" name="num" id="num">
</form>

<script>
    function mem_regi(value, num=''){
        $("#mode").val(value);
        $("#num").val(num);
        $("#mem_form").attr("action", "member/member_regi");
        $("#mem_form")[0].submit();
    }
</script>

<script>
    function all_checked(sw) {
        var f = document.memlist;

        for (var i=0; i<f.length; i++) {
            if (f.elements[i].name == "chk_id[]")
                f.elements[i].checked = sw;
        }
    }

    function mem_out(){
        var chk_count = 0;
        var f = document.memlist;

        for (var i = 0; i < f.length; i++) {
            if (f.elements[i].name == "chk_id[]" && f.elements[i].checked)
                chk_count++;
        }

        if (!chk_count) {
            alert("탈퇴/가입 할 회원을 한명 이상 선택하세요.");
            return false;
        }
        if (confirm("탈퇴 회원은 가입 처리 되며, 가입자는 탈퇴 처리 됩니다.\n회원 정보는 삭제 되지 않습니다.\n선택 하신 회원을 탈퇴/가입 하시겠습니까?") == true){    //확인
            f.submit();
        }else{
            return;
        }
    }
</script>

<script>
    function user_type_change(val){
        location.href = "{{ route('adm.member.index') }}?user_type="+val;
    }
</script>


@endsection
