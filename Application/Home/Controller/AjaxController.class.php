<?php
namespace Home\Controller;
use Think\Controller;
class AjaxController extends Controller {
	public function addCart(){
		if(session('?logineduserid')){
			$gid = I('post.gid');//intval
			$cnum = I('post.cnum');//strip_tags
			$uid = session('logineduserid');
			$cprice = D('goods')->where('gid='.$gid)->getField('gprice');
			$cartmsg = D('cart')->where(array('gid'=>$gid,'uid'=>$uid))->select();
			if($cartmsg = D('cart')->where(array('gid'=>$gid,'uid'=>$uid))->select())
			{
				$r = D('cart')->updateC($gid, $uid ,$cartmsg[0]['cnum'], $cnum);
			}
			else{
				$r = D('cart')->insertC($gid, $uid ,$cnum, $cprice, date('Y-m-d H:i:s'));
			}
			if($r)
				$this->ajaxReturn(true);
			else{
				$this->ajaxReturn(false);
			}
		}
		else {
			$this->ajaxReturn('Nouser');
		}
	}
	public function seeCart(){
		$uid = session('logineduserid');
		$cartnum = D('vcart')->where(array('uid'=>session('logineduserid')))->count();
		$cartmsg = D('vcart')->where(array('uid'=>session('logineduserid')))->select();
		$sumPrice = D('vcart')->sum('gprice');
		$data['cartnum'] = $cartnum;
		$data['cartmsg'] = $cartmsg;
		$data['sumPrice'] = $sumPrice;
		$this->ajaxReturn($data);
	}
}