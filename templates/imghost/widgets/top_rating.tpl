{if $is_ajax == 0}
<div class="blocktop">
	<table width="100%">
		<tr>
			<td align="center">
				<div class="header_blocktop">
					{$language.MOST_RATING}
				</div>
			</td>
		</tr>
		<tr>
			<td>
			<div class="container_slider">
			
				<div class="slider rating">
				<table>
				<tr>
				<td>
				{if $cur_page > 0 && $show_links == 1}
					<div class="link_prev">
						<a href="{$prev_link}" onclick="get_top('rating',this);return false;">
							<img src="{$THEME}images/top_left_arrow.png"/>
						</a>
					</div>
					{/if}
				</td>
					{foreach $images as $image}
					<td width="75" align="center" class="cell">
						<div class="file_item">
							<!--a class="shadowbox" title="{$image.show_filename} - {$image.rating} {set_declension($language.BALL,floor($image.rating))}" href="{$image.url}" rel="shadowbox[mygallery]"-->
							<a title="{$image.show_filename} - {$image.rating} {set_declension($language.VOTE,$image.rating)}" href="{$image.main_url}" target="_blank"  onmouseout="return nd();" onmouseover=" return overlib('<img src={$image.url} width={$image.zoom_width} border=0>', RIGHT);">
								<img src="{$image.url_preview}" />
							</a>
						</div>
					</td>
						
					{/foreach}
					<td>
						{if $show_links == 1}
						<div class="link_next">
							<a href="{$next_link}" onclick="get_top('rating',this);return false;">
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
					{$language.MOST_RATING_DESCRIPTION}
				</div>
			</td>
		</tr>
	</table>
</div>
{else:}
	<table>

				<tr>
				<td>
				{if $show_prev == 1}
					<div class="link_prev">
						<a href="{$prev_link}" onclick="get_top('rating',this);return false;">
							<img src="{$THEME}images/top_left_arrow.png"/>
						</a>
					</div>
					{/if}
				</td>
					{foreach $images as $image}
					<td width="75" align="center" class="cell">
						<div class="file_item">
							<!--a class="shadowbox" title="{$image.show_filename}" href="{$image.url}" rel="shadowbox[mygallery]"-->
							<a title="{$image.show_filename} - {$image.rating} {set_declension($language.VOTE,$image.rating)}" href="{$image.main_url}" target="_blank"  onmouseout="return nd();" onmouseover=" return overlib('<img src={$image.url} width={$image.zoom_width} border=0>', RIGHT);">
								<img src="{$image.url_preview}" style="position: absolute:width:100%;z-index: 3;top:0px;left:0px;"//>
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
							<a href="{$next_link}" onclick="get_top('rating',this);return false;">
								<img src="{$THEME}images/top_right_arrow.png"/>
							</a>
						</div>
						{/if}
					</td>
					</tr>
				</table>

{/if}