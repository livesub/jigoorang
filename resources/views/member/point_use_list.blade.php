@extends('layouts.head')

@section('content')


<div class='page-header'>
      <h4>
            적립금 현황
      </h4>
</div>

<table border="1">
    <tr>
        <td>보유 적립금</td>
    </tr>
    <tr>
        <td>{{ number_format(Auth::user()->user_point) }}P</td>
    </tr>
</table>

<table border=1>
    <tr>
        <td><a href="{{ route('mypage.user_point_list') }}">적입금 누적</a></td>
        <td><a href="{{ route('mypage.user_use_point_list') }}">적입금 사용</a></td>
    </tr>
</table>

<table border=1>
    @foreach($shoppoint_rows as $shoppoint_row)
    <tr>
        <td>{{ $shoppoint_row->po_content }}</td>
        <td>{{ number_format($shoppoint_row->po_point) }}p</td>
    </tr>
    <tr>
        <td colspan=2>{{ substr($shoppoint_row->created_at, 0, 10) }}</td>
    </tr>
    @endforeach
</table>

<table>
    <tr>
        <td>{!! $pnPage !!}</td>
    </tr>
</table>




@endsection
