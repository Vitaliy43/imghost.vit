<?php

function block_links($arr,$language,$short_links=false){
		
	$html = '';
	$buffer_ext = explode('.',$arr['url']);
	$ext = $buffer_ext[count($buffer_ext) - 1];
	$imglink_html = SITE_URL.'/image/'.$arr['id'];
	$imglink = IMGURL.'/b/'.$arr['id'].'.'.$ext;
	$imglink_preview = IMGURL.'/p/'.$arr['id'].'.'.$ext;
	$imgliink_preview_html = htmlspecialchars('<a href="'.$imglink_html.'" target="_blank"><img src="'.$imglink_preview.'" border="0" /></a>');
	$imglink_preview_bb = '[URL='.$imglink_html.'][IMG]'.$imglink_preview.'[/IMG][/URL]';

	$html .= '<div class="popup-links" style="background: white;">';
		
	if($short_links)
		$html .= '<div style="margin-bottom:15px; font-size: 14px;"><span  class="tiny_links" onclick="set_links(this,\'tiny\');return false;">Короткие ссылки</span><span class="standard_links links-tabs" onclick="set_links(this,\'standard\');return false;" style="margin-left:20px;">Стандартные ссылки</span></div>';
	else
		$html .= '<div style="margin-bottom:15px; font-size: 14px;"><span class="standard_links" onclick="set_links(this,\'standard\');return false;">Стандартные ссылки</span><span style="margin-left:20px;" class="tiny_links links-tabs" onclick="set_links(this,\'tiny\');return false;">Короткие ссылки</span></div>';	
		
	
	$html .= '		<ul style="list-style-type: none; ">';
	
	if($short_links)			
		$html .= '			<li>
					<em>'.$language['SHOW_LINK'].'</em>
					<input class="edit autoselect" type="text" value="'.$imglink_html.'" size="75" style="text-transform: lowercase;" readonly id="show_link" data-position="0" data-value="'.$arr['imglink_html'].'"/>
				</li>';
	else
		$html .= '			<li>
					<em>'.$language['SHOW_LINK'].'</em>
					<input class="edit autoselect" type="text" value="'.$arr['imglink_html'].'" size="75" style="text-transform: lowercase;" readonly id="show_link" data-position="0" data-value="'.$imglink_html.'"/>
				</li>';
		
	if($short_links)		
		$html .= '
				<li>
					<em>'.$language['DIRECT_LINK'].'</em>
					<input class="edit autoselect" type="text" value="'.$imglink.'" size="75" style="text-transform: lowercase;" readonly id="direct_link"  data-position="0" data-value="'.$arr['imglink'].'"/>
				</li>';
	else
		$html .= '
				<li>
					<em>'.$language['DIRECT_LINK'].'</em>
					<input class="edit autoselect" type="text" value="'.$arr['imglink'].'" size="75" style="text-transform: lowercase;" readonly id="direct_link"  data-position="0" data-value="'.$imglink.'"/>
				</li>';
				
	
	if($short_links)			
		$html .= '	<li>
					<em>'.$language['PREVIEW_LINK_BB'].'</em>
					
					<input class="edit autoselect" type="text" value="'.$imglink_preview_bb.'" size="75" readonly id="preview_link_bb"  data-position="2" data-value="'.$arr['imglink_preview_bb'].'"/><br>
					
				</li>';
	else
		$html .= '	<li>
					<em>'.$language['PREVIEW_LINK_BB'].'</em>
					
					<input class="edit autoselect" type="text" value="'.$arr['imglink_preview_bb'].'" size="75" readonly id="preview_link_bb"  data-position="2" data-value="'.$imglink_preview_bb.'"/><br>
					
				</li>';				
				
		if($short_links)		
			$html .= '
				<li>
					<em>'.$language['PREVIEW_LINK_HTML'].'</em>
					<input class="edit autoselect" type="text" value="'.$imgliink_preview_html.'" size="75" style="text-transform: lowercase;" readonly id="preview_link_html" data-value="'.$arr['imglink_preview_html'].'"/>
				</li>';
		else
			$html .= '
				<li>
					<em>'.$language['PREVIEW_LINK_HTML'].'</em>
					<input class="edit autoselect" type="text" value="'.$arr['imglink_preview_html'].'" size="75" style="text-transform: lowercase;" readonly id="preview_link_html" data-value="'.$imgliink_preview_html.'"/>
				</li>';
		
		if($short_links)		
			$html .= '
				<li>
					<em>'.$language['BB_CODE_LINK'].'</em>
					<input class="edit autoselect" type="text" value="[IMG]'.$imglink.'[/IMG]" size="75" style="text-transform: lowercase;" readonly id="bb_code" data-position="2" data-value="[IMG]'.$arr['imglink'].'[/IMG]"/></li>';
		else
			$html .= '
				<li>
					<em>'.$language['BB_CODE_LINK'].'</em>
					<input class="edit autoselect" type="text" value="[IMG]'.$arr['imglink'].'[/IMG]" size="75" style="text-transform: lowercase;" readonly id="bb_code" data-position="2" data-value="[IMG]'.$imglink.'[/IMG]"/></li>';
				
				if (isset($arr['tiny_url']) && $arr['tiny_url']):
				$html .= '
					<li>
						<em>'.$language['TINY_URL'].'</em>
						<input class="edit autoselect" type="text" value="'.$arr['tiny_url'].'" size="75" readonly id="tiny_url"  data-position="0" data-value="'.$arr['tiny_url'].'"/>
					</li>';
				endif;
			$html .= '	
			</ul>
			<a class="black-button" href="javascript:void(0);" onclick="nd();">Закрыть</a>';

			$html .= '
		</div>';
	

	return $html;
	
}

function browse_gallery($list,$tiny_static=false){
	
	if(count($list) < 1)
		return '';
	  $html = "<div class=\"es-carousel-wrapper \" style=\"max-width:570px; overflow: hidden;\">
					<div class=\"es-carousel\"><ul id=\"carousel\" class=\"elastislide-list browser_pictures\">";
		$counter = 0;
	foreach($list as $key=>$value)	{
		
	}
	
	  foreach($list as $item){
		if(empty($item['url']))
			continue;

	  	list($empty,$ext) = explode('.',$item['url']);
	  	if($tiny_static){
			$preview = IMGURL.'/p/'.$item['id'].'.'.$ext;
		}
		else{
			$buffer_url = $item['url'];
			$preview = IMGURL.str_replace('big','preview',$item['url']);
		}
	  	$html .= '<li>';
		if(isset($item['current'])){
			$html .= '<a href="'.SITE_URL.$item['main_url'].'"><img src="'.$preview.'" class="current_image pic" height="50"/></a>';

		}
		else{
			$html .= '<a href="'.SITE_URL.$item['main_url'].'" onclick="hash_change_image(this.href,\''.$item['direct'].'\');return false;"><img src="'.$preview.'" class="pic" height="50"/></a>';

		}

	  	$html .= '</li>';
	  }
	  
	  unset($item);
	  $html .= '</ul></div></div>';

	return $html;
}

?>