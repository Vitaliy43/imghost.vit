{if $is_ajax == 0}
<div class="blocktop">
	<table class="table_top">
		<tr>
			<td align="center">
				<div class="header_blocktop">
					{$language.MOST_POPULAR}
				</div>
			</td>
		</tr>
		<tr>
			<td>
			<div class="container_slider">	
				<div class="slider views">
				<table>
				<tr>
				<td>
				{if $cur_page > 0 && $show_links == 1}
					<div class="link_prev">
						<a href="{$prev_link}" onclick="get_top('views',this);return false;">
							<img src="{$THEME}images/top_left_arrow.png"/>
						</a>
					</div>
					{/if}
				</td>
					{foreach $images as $image}
					<td width="75" align="center" class="cell">
						<div class="file_item" style="width:100%;height:100%;">
							<!--a class="shadowbox" title="{$image.show_filename} - {$image.views} {set_declension($language.VOTE,$image.views)}" href="{$image.url}" rel="shadowbox[mygallery]"-->
							<!--a title="{$image.show_filename} - {$image.views} {set_declension($language.VOTE,$image.views)}" href="{$image.url}" target="_blank" class="cloud-zoom" rel="adjustX:78,adjustY:2,position: 'bottom', zoomWidth: '400', zoomHeight: '300', showTitle: 'true', softFocus: 'true'" data-href="{$image.main_url}" -->
							<a title="{$image.show_filename} - {$image.views} {set_declension($language.VOTE,$image.views)}" href="{$image.main_url}" target="_blank" onmouseout="return nd();" onmouseover=" return overlib('<img src={$image.url} width={$image.zoom_width} border=0>', RIGHT);">
								<img src="{$image.url_preview}" style="position: absolute:width:100%;z-index: 3;top:0px;left:0px;"/>
								{if isset($image.point)}
								<div class="place_{$image.point}">
				
								</div>
							{/if}
							</a>
							
						</div>
					</td>
						
					{/foreach}
					<td>
					{if $show_links == 1}
						<div class="link_next">
							<a href="{$next_link}" onclick="get_top('views',this);return false;">
								<img src="{$THEME}images/top_right_arrow.png"/>
							</a>
						</div>
						{/if}
					</td>
					</tr>
				</table>
				</div>
				
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<div class="top_description">
					{$language.MOST_POPULAR_DESCRIPTION}
				</div>
			</td>
		</tr>
	</table>	
</div>
{else:}

<table class="table_top">

				<tr>
				<td>
				{if $show_prev == 1}
					<div class="link_prev">
						<a href="{$prev_link}" onclick="get_top('views',this);return false;">
							<img src="{$THEME}images/top_left_arrow.png"/>
						</a>
					</div>
					{/if}
				</td>
					{foreach $images as $image}
					<td width="75" class="cell" align="center">
						<div class="file_item">
							<!--a class="shadowbox" title="{$image.show_filename}" href="{$image.url}" rel="shadowbox[mygallery]"-->
							<!--a title="{$image.show_filename} - {$image.views} {set_declension($language.VOTE,$image.views)}" href="{$image.url}" target="_blank" class="cloud-zoom" rel="adjustX:78,adjustY:2,position: 'bottom', zoomWidth: '{$image.zoom_width}', zoomHeight: '{$image.zoom_height}', showTitle: 'true'"-->
							<a title="{$image.show_filename} - {$image.views} {set_declension($language.VOTE,$image.views)}" href="{$image.main_url}" target="_blank"  onmouseout="return nd();" onmouseover=" return overlib('<img src={$image.url} width={$image.zoom_width} border=0>', RIGHT);">
								<img src="{$image.url_preview}" style="position: absolute:width:100%;z-index: 3;top:0px;left:0px;"/>
								{if isset($image.point)}
								<div class="place_{$image.point}">
				
								</div>
							{/if}
							</a>
						</div>
					</td>
						
					{/foreach}
					<td>
					{if $show_next == 1}
						<div class="link_next">
							<a href="{$next_link}" onclick="get_top('views',this);return false;">
								<img src="{$THEME}images/top_right_arrow.png"/>
							</a>
						</div>
						{/if}
					</td>
					</tr>
				</table>

{/if}