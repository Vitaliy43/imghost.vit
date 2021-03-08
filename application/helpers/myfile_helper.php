<?php

if(!function_exists('formatFileSize')):

function formatFileSize($size){
	
	if($size > 1000000000)
		return sprintf("%01.2f",$size/1000000000).' GB';
	if($size > 1000000)
		return sprintf("%01.2f",$size/1000000).' MB';
	
	return sprintf("%01.2f",$size/1000).' KB';
}

endif;

function splitterWord($word,$maxlength){

	$step = $maxlength;	
	
	$buffer = explode(' ',$word);
	if(count($buffer) > 1){
		$word_end = mb_strlen($buffer[count($buffer) - 1]);
		if($word_end < $maxlength)
			return $word;
	}
	else{
		$word_end = mb_strlen($word);
		if($word_end < $maxlength)
			return $word;
	}
	$new_word = '';
	for($i = 0; $i < $word_end; ++$i){
		$new_word .= mb_substr($word,$i,1);
		if($i == $maxlength){
			$new_word .= '<br>';
			$maxlength += $step;
		}
	}
	return $new_word;
}

function briefWord($word){
	
	if(mb_strlen($word) > 10){
		$new_word = mb_substr($word,0,10).str_repeat('.',3);
		return $new_word;
	}
	return $word;
}

function briefWordTitle($word){
	if(mb_strlen($word) > 10){
		return ' title="'.$word.'" ';
	}
	return '';
}

?>