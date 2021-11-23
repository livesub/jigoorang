@extends('layouts.head')

@section('content')
<table border=1>
        @foreach($expAllLists as $expAllList)
            @php
            //이미지 처리
            if($expAllList->main_image_name == "") {
                $main_image_name_disp = asset("img/no_img.jpg");
            }else{
                $main_image_name_cut = explode("@@",$expAllList->main_image_name);
                $main_image_name_disp = "/data/exp_list/".$main_image_name_cut[1];
            }
            @endphp
        <tr>
            <td>
                <a href="{{ route('exp.list.detail', $expAllList -> id) }}">
                <img src="{{ $main_image_name_disp }}">
                </a>
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
                                <a href="{{ route('exp.list.detail', $expAllList -> id) }}"><button>알아보기</button></a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tr>
        @endforeach
    </table>
    {!! $pnPage !!}
@endsection