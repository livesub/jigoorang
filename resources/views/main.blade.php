@extends('layouts.head')

@section('content')



<table>
  <tr>
    <td>상단배너</td>
  </tr>
@foreach($topbanner_infos as $topbanner_info)
  @php
    //이미지 처리
    if($topbanner_info->b_pc_img == "") {
        $b_pc_img_disp = asset("img/no_img.jpg");
    }else{
        $b_pc_img_cut = explode("@@",$topbanner_info->b_pc_img);
        $b_pc_img_disp = "/data/banner/".$b_pc_img_cut[1];
    }

    $target = '';
    if($topbanner_info->b_target == 'N') $target = '_self';
    else $target = '_blank';

    if($topbanner_info->b_mobile_img == "") {
        $b_mobile_img_disp = asset("img/no_img.jpg");
    }else{
        $b_mobile_img_cut = explode("@@",$topbanner_info->b_mobile_img);
        $b_mobile_img_disp = "/data/banner/".$b_mobile_img_cut[1];
    }

    if($CustomUtils->is_mobile()) {
      $top_img = $b_pc_img_disp;
      // 모바일에서 작동
    } else {
      $top_img = $b_mobile_img_disp;
      // pc에서 작동
    }
  @endphp
  <tr>
    <td>
      <a href="{{ $topbanner_info->b_link }}" target="{{ $target }}"><img src="{{ $top_img }}"></a>
    </td>
  </tr>
@endforeach
</table>




<table>
  <tr>
    <td>하단배너</td>
  </tr>
@foreach($bottombanner_infos as $bottombanner_info)
  @php
    //이미지 처리
    if($bottombanner_info->b_pc_img == "") {
        $bott_b_pc_img_disp = asset("img/no_img.jpg");
    }else{
        $bott_b_pc_img_cut = explode("@@",$bottombanner_info->b_pc_img);
        $bott_b_pc_img_disp = "/data/banner/".$bott_b_pc_img_cut[1];
    }

    $target = '';
    if($bottombanner_info->b_target == 'N') $bott_target = '_self';
    else $bott_target = '_blank';

    if($bottombanner_info->b_mobile_img == "") {
        $bott_b_mobile_img_disp = asset("img/no_img.jpg");
    }else{
        $bott_b_mobile_img_cut = explode("@@",$bottombanner_info->b_mobile_img);
        $bott_b_mobile_img_disp = "/data/banner/".$bott_b_mobile_img_cut[1];
    }

    if($CustomUtils->is_mobile()) {
      $bott_top_img = $bott_b_pc_img_disp;
      // 모바일에서 작동
    } else {
      $bott_top_img = $bott_b_mobile_img_disp;
      // pc에서 작동
    }
  @endphp
  <tr>
    <td>
      <a href="{{ $bottombanner_info->b_link }}" target="{{ $bott_target }}"><img src="{{ $bott_top_img }}"></a>
    </td>
  </tr>
@endforeach
</table>




    <div class="page-header">
      <h4>
      {{ $title_main }}
      </h4>
    </div>


@endsection
