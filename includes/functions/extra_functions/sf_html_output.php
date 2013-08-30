<?php
/*
 * 购物数量下拉菜单
 * */
function sf_draw_pull_down_cart_qty($name,$max_qty,$default=1,$parameters='',$required = false){
	if ($max_qty<0) {
		$max_qty = 10;
	}
	$value = array();
	for ($i=1;$i<=$max_qty;$i++){
		$value[] = array('id'=>$i,'text'=>$i);
	}
	
	return zen_draw_pull_down_menu($name,$value,$default,$parameters,$required);
}