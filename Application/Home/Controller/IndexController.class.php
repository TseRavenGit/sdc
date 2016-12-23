<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function index(){

        $this->display();
    }


	public function signin(){
        
        $this->display();
    }


    public function signup(){
    	
    	
        $this->display();
    }
    
	public function buy(){

    	$sdcPrice = C('THINK_SDC.SDC_PRICE'); 	 //SDC购买价格
        $sdcPrice = number_format($sdcPrice, 2, '.', '');
    	$ewDiscount = C('THINK_SDC.EW_DISCOUNT');//1万以上折扣
    	$wwDiscount = C('THINK_SDC.WW_DISCOUNT');//5万以上折扣
    	$swDiscount = C('THINK_SDC.SW_DISCOUNT');//10万以上折扣

    	$this->assign('sdcPrice',$sdcPrice);
        $this->display();
    }
}