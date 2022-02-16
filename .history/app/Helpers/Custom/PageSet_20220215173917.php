<?php

namespace App\Helpers\Custom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageSet extends Controller
{
	var $page; //현재 페이지
	var $perinfo; //페이지별 변수값 총체
	var $pageScale; //한페이지당 라인수
	var $block; //현재 블럭
	var $blockScale; //출력할 블럭의 갯수
	var $totalRecord; //총갯수
	var $totalPage;  //총 페이지수
	var $totalBlock; //총 블럭수
	var $first = 0;      //페이지당 출력할 게시물 범위의 처음
	var $last  = 1;      //페이지당 출력할 게시물 범위의 마지막
	var $isNext;	    //다음 페이지가 있는냐?
	var $tails = '';   //인자를 받는 문자열변수
	var $firstPage;   //첫페이지
	var $lastPage;   //마지막페이지
    var $pShowPage = '';

	public function pageSet($totalpage,$page,$pageScale,$blockScale,$totalRecord,$arr='',$perinfo='')
	{
		$this->page = !$page ? 1 : $page;
		$this->perinfo = $perinfo;
		$this->pageScale = $pageScale;
		$this->blockScale = $blockScale;
		$this->totalRecord = $totalRecord;
		$this->totalPage  = $totalpage;

		$this->totalBlock = ceil($this->totalPage/$this->blockScale);
		$this->block = ceil($this->page/$this->blockScale);

		$this->firstPage  = ($this->block-1)*$this->blockScale;
		$this->lastPage   = $this->block*$this->blockScale;

		if($this->totalBlock <= $this->block) $this->lastPage=$this->totalPage;

		if(is_array($arr)) {
            foreach($arr as $key=>$val)
            {
                $this->tails.="$key=$val&";
            }
		}
	}

	public function getPageList() {
        $pShowPage = '';

		for($dPage=$this->firstPage+1; $dPage <= $this->lastPage; $dPage++)
		{
			if($this->page == $dPage)
			{
                //블록의 갯수로 디자인 바꿈(211104)
                if($this->blockScale > 1){
                    $pShowPage .= "<div>$dPage</div>";
                }else{
                    $pShowPage = "<div>$dPage / $this->totalPage</div>";
                }
			}
			else
			{
				if($this->perinfo)
				{
					$pShowPage .= "<a href='?$this->perinfo&page=$dPage&$this->tails'>$dPage</a>";
				}
				else
				{
					$pShowPage .= "<a href='?$this->tails&page=$dPage'>$dPage </a>";
				}
			}

			//if($this->lastPage != $dPage) $pShowPage .= "&nbsp;<img src='/images/board/page_line.gif' align='absmiddle' border='0' alt=''>&nbsp;";
			if($this->lastPage != $dPage) $pShowPage .= "";
		}

		return $pShowPage;
	}

	public function pre10($img){
        $pShowPage = '';
		$firstPage = $this->firstPage - 9;
		//이전페이지 블럭..
		if($this->block > 1) {
			$pShowPage = "<a href='?$this->perinfo&$this->tails&page=$firstPage'>$img</a>";
		} else {
			//$pShowPage = "[이전 $this->blockScale]&nbsp;";
			$pShowPage = $img;
		}
		return $pShowPage;
	}

	public function next10($img){
        $pShowPage = '';
		//다음 페이지 블럭
		if($this->block < $this->totalBlock) {
			$mPage = $this->lastPage + 1;
			//$pShowPage .= "&nbsp;<a href='$_SERVER[PHP_SELF]?$this->perinfo&page=$mPage&$this->tails'>[다음 $this->blockScale]</a>";
			$pShowPage .= "&nbsp;<a href='?$this->perinfo&$this->tails&page=$mPage'>$img</a>";
		} else {
			//$pShowPage .= "&nbsp;[다음 $this->blockScale]";
			$pShowPage .= $img;
		}
		return $pShowPage;
	}


	public function pre5($img){
        $pShowPage = '';
		$firstPage = $this->firstPage - 4;
		//이전페이지 블럭..
		if($this->block > 1) {
			$pShowPage = "<a href='?$this->perinfo&$this->tails&page=$firstPage'>$img</a>";
		} else {
			//$pShowPage = "[이전 $this->blockScale]&nbsp;";
			$pShowPage = $img;
		}
		return $pShowPage;
	}

	public function next5($img){
        $pShowPage = '';
		//다음 페이지 블럭
		if($this->block < $this->totalBlock) {
			$mPage = $this->lastPage + 1;
			//$pShowPage .= "&nbsp;<a href='$_SERVER[PHP_SELF]?$this->perinfo&page=$mPage&$this->tails'>[다음 $this->blockScale]</a>";
			$pShowPage .= "&nbsp;<a href='?$this->perinfo&$this->tails&page=$mPage'>$img</a>";
		} else {
			//$pShowPage .= "&nbsp;[다음 $this->blockScale]";
			$pShowPage .= $img;
		}
		return $pShowPage;
	}

	public function preFirst($img){
        $pShowPage = '';
		$firstPage = 1;
		//첫페이지 블럭..
		if($this->block > 1) {
			$pShowPage = "<a href='?$this->perinfo&page=$firstPage&$this->tails'>$img</a>";
		} else {
			//$pShowPage = "[이전 $this->blockScale]&nbsp;";
			$pShowPage = $img;
		}
		return $pShowPage;
	}

	public function nextLast($img){
var_dump("FFFFFFFFFFFFFFFFFFFF");
        $pShowPage = '';
		//맨 마지막 페이지 블럭
		if($this->block < $this->totalBlock) {
			$mPage = $this->totalPage;
			//$pShowPage .= "&nbsp;<a href='$_SERVER[PHP_SELF]?$this->perinfo&page=$mPage&$this->tails'>[다음 $this->blockScale]</a>";
			$pShowPage .= "&nbsp;<a href='?$this->perinfo&page=$mPage&$this->tails' class='wide'>$img</a>";
		} else {
			//$pShowPage .= "&nbsp;[다음 $this->blockScale]";
			$pShowPage .= $img;
		}
		return $pShowPage;
	}

	public function getPrevPage($text)
	{
var_dump("svsvsvsdvsd");
        $pShowPage = '';
		if($this->page > 1)
		{
			$ppage = $this->page - 1;
			if($this->perinfo)
			{
				$pShowPage .= "<a href='?$this->perinfo&page=$ppage&$this->tails'>$text</a>";
			}
			else
			{
				$pShowPage .= "<a href='?$this->tails&page=$ppage'>$text</a>";
			}
		}
		else
		{
			$pShowPage .= "<a href='javascript:void(0);'>$text</a>";
		}
		return $pShowPage;
	}

	function getNextPage($text)
	{
        $pShowPage = '';
		if($this->page >= 1 && $this->page < $this->totalPage)
		{
			$npage = $this->page + 1;
			if($this->perinfo){
			$pShowPage .= "<a href='?$this->perinfo&page=$npage&$this->tails'>$text</a>";
			}else{

			$pShowPage .= "<a href='?$this->tails&page=$npage'>$text</a>";
			}
		} else {
			$pShowPage .= "<a href='javascript:void(0);'>$text</a>";
		}
		return $pShowPage;
	}

}
