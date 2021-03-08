<?php

function set_declension($word,$number){
	
	
	$number_int = $number;
	$number = (string)$number;
	$last_symbol = mb_substr($number,-1);
	
	if($number == '2' || in_array($last_symbol,array('2','3','4'))){
		$suffix = 'а';
	}
	elseif($number == '11'){
		$suffix = 'ов';
	}
	elseif($number == '1' || $last_symbol == '1'){
		$suffix = '';
	}
	else{
		$suffix = 'ов';
	}
	return $word.$suffix;
}

?>