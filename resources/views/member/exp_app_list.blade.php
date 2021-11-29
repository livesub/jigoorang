@extends('layouts.head')

@section('content')


<div class='page-header'>
      <h4>
            평가단 신청 결과 확인
      </h4>
</div>

<table border=1>
    @foreach($exp_app_rows as $exp_app_row)
    @php
        $exp_ok = false;
        $exp_ment = '';
        $exp_app_cnt = '';
        $exp_list = DB::table('exp_list')->where('id', $exp_app_row->exp_id)->first();
        $now_date = date("Y-m-d", time());
        $exp_app_cnt = DB::table('exp_application_list')->where([['exp_id', $exp_list->id], ['access_yn', 'y']])->count();

        if($exp_app_cnt > 0){   //승인 난 상태
            if($exp_app_row->access_yn == 'y') $exp_ment = '확정';
            else $exp_ment = '다음에 만나요';
        }else{
            if($now_date <= $exp_list->exp_release_date) $exp_ment = '신청중';
            else $exp_ment = "<span onclick=\"alert('기간이 만료되어 확인이 불가합니다');\">다음에 만나요</span>";
        }
    @endphp
    <tr>
        <td>{{ stripslashes($exp_list->title) }}&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{!! $exp_ment !!}</td>
    </tr>
    <tr>
        <td>{{ substr($exp_list->created_at, 0, 10) }}</td>
    </tr>
    @endforeach
    <tr>
        <td>{!! $pnPage !!}</td>
    </tr>
</table>


<script>
</s



@endsection
