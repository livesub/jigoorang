@extends('layouts.admhead')

@section('content')


<table>
    <tr>
        <td>
            <h4>체험단 승인</h4>
        </td>
    </tr>
</table>

<table>
    <tr>
        <td>체험단 리스트</td>
        <td>
            <select name="exp_id" id="exp_id">
                @foreach($exp_lists as $exp_list)
                @php
                    $exp_selected = '';
                    if($exp_list->id == $exp_id) $exp_selected = "selected";
                @endphp
                <option value="{{ $exp_list->id }}" {{ $exp_selected }}>{{ $exp_list->title }}</option>
                @endforeach
            </select>
        </td>
    </tr>
</table>

<table border=1>
    <tr>
        <td>선택</td>
        <td>번호</td>
        <td>체험단명</td>
        <td>아이디</td>
        <td>이름</td>
        <td>비고</td>
    </tr>

    @foreach($exp_app_lists as $exp_app_list)
    <tr>
        <td><input type="checkbox" name="" id=""></td>
        <td>{{ $virtual_num-- }}</td>
    </tr>
    @endforeach
</table>


<script>
    $("#exp_id").change(function(){
alert($(this).val());
        location.href = "{{ route('adm.approve.index') }}?exp_id="+$(this).val();
    });
</script>








@endsection