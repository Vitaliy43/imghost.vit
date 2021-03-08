 <div class="tr template-upload fade in">
        {if $file.error}
			{if isset($file.name)}
            	<div class="td name"><span>{$file.name}</span></div>
			{/if}
			{if isset($file.size)}
            	<div class="td size"><span>{formatFileSize($file.size)}</span></div>
			{/if}
			{if isset($file.url)}
			    <div class="td error">{$file.url}: {$file.error}</div>
			{else:}
            	<div class="td error">{$file.error}</div>
			{/if}
        {else:}
			{if $file.thumbnail_url }
            <div class="td preview" style="width:100px;"><span class="fade"><a href="{$file.imglink}" onclick="show_image(this);return false;"><img src="{$file.thumbnail_url}" width="{$file.thumbnail_width}" height="{$file.thumbnail_height}"></a></span></div>
			{/if}
			
            <div class="td name" style="margin-left: -20px;">
				<span class="fade"><a class="jsAction" href="javascript:void(0);" onclick="show_links_multiply(this);">{$language.SHOW_LINKS}</a></span>
				<div class="modal-wnd inplace">
					{block_links($file,$language,$tiny_static)}
					<!--div class="popup-links">
						<ul>
							<li>
								<em>{$language.SHOW_LINK}</em>
								<input class="edit autoselect main_url" type="text" value="{$file.imglink_html}" size="75" readonly style="text-transform: lowercase;" id="show_link"/>
							</li>
							<li>
								<em>{$language.DIRECT_LINK}</em>
								<input class="edit autoselect imgurl" type="text" value="{$file.imglink}" size="75" readonly style="text-transform: lowercase;" id="direct_link"/>
							</li>
							<li>
								<em>{$language.PREVIEW_LINK_BB}</em>
								<input class="edit autoselect imgurl" type="text" value="{$file.imglink_preview_bb}" size="75" readonly id="preview_link_bb"/>
							</li>
							<li>
								<em>{$language.PREVIEW_LINK_HTML}</em>
								<input class="edit autoselect imgurl" type="text" value="{$file.imglink_preview_html}" size="75" readonly style="text-transform: lowercase;" id="preview_link_html"/>
							</li>
							<li>
								<em>{$language.BB_CODE_LINK}</em>
								<input class="edit autoselect" type="text" value="[IMG]{$file.imglink}[/IMG]" size="75" readonly id="bb_code"/>
							</li>
							{if isset($file.tiny_url)}
							<li>
								<em>{$language.TINY_URL}</em>
								<input class="edit autoselect" type="text" value="{$file.tiny_url}" size="75" readonly id="tiny_url"/>
							</li>
							{/if}
						</ul>
						<a class="black-button close-wnd" href="javascript:void(0);" onclick="nd();">{$language.SHUT}</a>
					</div-->
				</div>
			</div>
            <div class="td size" style="margin-left: -20px;"><span class="fade" style="width:100px;">{formatFileSize($file.size)}</span></div>
			<div class="td" style="margin-left: -10px;">
                <span class="fade"><div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:100%;"></div></div></span>
            </div>
			<div class="td">
					<ul class="hidden-controls">
						<li></li>
						<li><a href="/images/delete/{$file.id}" onclick="delete_from_multiupload(this,'{$lang_image.CONFIRM_DELETE}');return false;" style="color:red;" title="{$lang_main.DELETE}"><img src="/templates/imghost/images/icon_delete.png" width="15" height="15" /></a></li>
						<li></li>
					</ul>
			</div>
			<div class="td">
				<span class="progress_percent"></span>
			</div>
        {/if}
    </div>