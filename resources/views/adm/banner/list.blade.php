@extends('layouts.admhead')

@section('content')



<table>
    <tr>
        <td>
            <h4>{{ $title_ment }}배너 관리</h4>
        </td>
    </tr>
</table>

<table border=1>
<form name="b_list_form" id="b_list_form" method="post" action="{{ route('adm.banner.choice_del') }}">
{!! csrf_field() !!}
<input type="hidden" name="type" id="type" value="{{ $type }}">
<input type="hidden" name="num" id="num">
<input type="hidden" name="page" id="page" value="{{ $page }}">
    <tr>
        <td>선택<br><input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);"></td>
        <td>번호</td>
        <td>제목</td>
        <td>출력여부</td>
        <td>배너경로</td>
        <td>타겟</td>
        <td>pc이미지</td>
        <td>mobile이미지</td>
        <td>관리</td>
    </tr>
    @foreach($banners as $banner)
        @php
            if($banner->b_display == "Y") $b_display_ment = "출력";
            else $b_display_ment = "비출력";

            if($banner->b_target == "Y") $b_target_ment = "새창";
            else $b_target_ment = "현재창";

            //이미지 처리
            if($banner->b_pc_img == "") {
                $b_pc_img_disp = asset("img/no_img.jpg");
            }else{
                $b_pc_img_cut = explode("@@",$banner->b_pc_img);
                $b_pc_img_disp = "/data/banner/".$b_pc_img_cut[2];
            }

            if($banner->b_mobile_img == "") {
                $b_mobile_img_disp = asset("img/no_img.jpg");
            }else{
                $b_mobile_img_cut = explode("@@",$banner->b_mobile_img);
                $b_mobile_img_disp = "/data/banner/".$b_mobile_img_cut[2];
            }
        @endphp
    <tr>
        <td><input type="checkbox" name="chk_id[]" value="{{ $banner->id }}" id="chk_id_{{ $banner->id }}"></td>
        <td>{{ $virtual_num-- }}</td>
        <td>{{ stripslashes($banner->b_name) }}</td>
        <td>{{ $b_display_ment }}</td>
        <td>{{ stripslashes($banner->b_link) }}</td>
        <td>{{ $b_target_ment }}</td>
        <td><img src="{{ $b_pc_img_disp }}" style="width:100px;height:100px;"></td>
        <td><img src="{{ $b_mobile_img_disp }}" style="width:100px;height:100px;"></td>
        <td><button type="button" onclick="b_modi('{{ $banner->id }}', {{ $page }});">수정</button></td>
    </tr>
    @endforeach
</form>
</table>
<table>
    <tr><td>{!! $pnPage !!}</td></tr>
</table>
<table>
    <tr>
        <td><button type="button" onclick="location.href='{{ route('adm.banner.create', $type) }}'">등록</button></td>
        <td><button type="button" onclick="choice_del();">선택 삭제</button></td>
    </tr>

</table>

<script>
    function all_checked(sw) {
        var f = document.b_list_form;

        for (var i=0; i<f.length; i++) {
            if (f.elements[i].name == "chk_id[]")
                f.elements[i].checked = sw;
        }
    }
</script>

<script>
    function choice_del(){
        var chk_count = 0;
        var f = document.b_list_form;

        for (var i = 0; i < f.length; i++) {
            if (f.elements[i].name == "chk_id[]" && f.elements[i].checked)
                chk_count++;
        }

        if (!chk_count) {
            alert("삭제할 배너를 하나 이상 선택하세요.");
            return false;
        }

        if (confirm("선택 하신 배너를 삭제 하시겠습니까?") == true){    //확인
            f.submit();
        }else{
            return;
        }
    }
</script>

<script>
    $("#b_list_form").attr("action", "{{ route('adm.banner.choice_del') }}");
    function b_modi(id, page){
        $("#num").val(id);
        $("#page").val(page);

        $("#b_list_form").attr("action", "{{ route('adm.banner.modify') }}");
        $("#b_list_form").submit();
    }

</script>



@endsection
