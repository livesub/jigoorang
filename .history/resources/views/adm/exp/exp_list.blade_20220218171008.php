@extends('layouts.admhead')

@section('content')



    <table border=1>
        @foreach($expAllLists as $expAllList)
            @php
            //이미지 처리
            if($expAllList->main_image_name == "") {
                $main_image_name_disp = asset("img/no_img.jpg");
            }else{
                $main_image_name_cut = explode("@@",$expAllList->main_image_name);
                $main_image_name_disp = "/data/exp_list/".$main_image_name_cut[2];
            }

            $exp_app_cnt = DB::table('exp_application_list')->where('exp_id', $expAllList->id)->count();
            @endphp

        <tr>
            <td>
                <img src="{{ $main_image_name_disp }}">
            </td>
            <tr>
                <td>
                    <table border=1>
                        <tr>
                            <td>
                                제목 : {{ stripslashes($expAllList->title) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                체험단 모집 인원 : {{ $expAllList->exp_limit_personnel }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                모집기간 : {{ $expAllList->exp_date_start }}  ~ {{ $expAllList->exp_date_end }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                평가가능기간 : {{ $expAllList->exp_review_start }} ~ {{ $expAllList->exp_review_end }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button type="button" onclick="exp_modi({{ $expAllList->id }});">수정</button>
                                @if($exp_app_cnt == 0)
                                <!-- 신청자가 없을때 삭제 가능 -->
                                <button type="button" onclick="exp_del({{ $expAllList->id }});">삭제</button>
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tr>
        @endforeach
        <tr>
            <td><button onclick="location.href='{{ route('adm_exp_view_create') }}'">체험단 등록</button></td>
        </tr>
    </table>
    {!! $pnPage !!}




<script>
    function exp_modi(num){
        var url = "{{ route('adm_exp_view_restore', ':num') }}";
        url = url.replace(':num', num);
        location.href = url;
    }

    function exp_del(num){
        if (confirm("정말 삭제하시겠습니까?") == true){    //확인
            var url = "{{ route('adm_exp_view_delete', ':num') }}";
            url = url.replace(':num', num);
            location.href = url;
        }else{   //취소
            return false;
        }
    }
</script>


@endsection