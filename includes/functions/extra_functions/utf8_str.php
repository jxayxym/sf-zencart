<?php
 /*将字符以指定的字符数跟开，范围字符串数组
 * 在php中, utf8编码的中文是占3个字节，
 * 一个非英文字符的3-bytes utf8 编码, 总是以224-239之间的char code开头
 * 先用substr截取, 判断截取结果的最后一位是不是在224-239之间, 
 * 如果是, 就说明目前取到了3-byte utf8编码的第一位, 那么只需要把计划截取的长度-1即可.
 *如果截取结果的最后一位之前一位在224-239之间, 
 *就说明目前取到了3-byte utf8编码的第二位, 只需要将计划截取的长度-2即可. 
 * */
function explode_utf8_str($str,$len,&$return=array()){
	$strlen = strlen($str);//字符串长度
	while ($strlen>0){
		$char_num = 0;//实际分割字符长度
		$index = 0;//字符索引
		while ($char_num<$len&&$index<$strlen){
			$char = substr($str,$index,1);
			$ascii = ord($char);
			if ($ascii>224 && $ascii<239){
				$index = $index+3;
				$char_num++;
			}else {
				$index++;
				$char_num++;
			}
		}
		$return[] = substr($str,0,$index);
		$str = substr($str,$index);
		$strlen = strlen($str);//字符串长度
	}	
}