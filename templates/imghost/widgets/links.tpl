<div class="popup-links" style="background: white;">
			<ul style="list-style-type: none; ">
				<li>
					<em>{$language.SHOW_LINK}</em>
					<input class="edit autoselect" type="text" value="{$imglink_html}" size="75" style="text-transform: lowercase;" readonly id="show_link" data-position="0"/>
				</li>
				<li>
					<em>{$language.DIRECT_LINK}</em>
					<input class="edit autoselect" type="text" value="{$imglink}" size="75" style="text-transform: lowercase;" readonly id="direct_link"  data-position="0"/>
				</li>
				
				<li>
					<em>{$language.PREVIEW_LINK_BB}</em>
					
					<input class="edit autoselect" type="text" value="{$imglink_preview_bb}" size="75" readonly id="preview_link_bb"  data-position="2"/><br>
					
				</li>
				<li>
					<em>{$language.PREVIEW_LINK_HTML}</em>
					<input class="edit autoselect" type="text" value="{$imglink_preview_html}" size="75" style="text-transform: lowercase;" readonly id="preview_link_html"/>
				</li>
				<li>
					<em>{$language.BB_CODE_LINK}</em>
					<input class="edit autoselect" type="text" value="[IMG]{$imglink}[/IMG]" size="75" style="text-transform: lowercase;" readonly id="bb_code" data-position="2"/></li>
				
				{if isset($tiny_url)}
					<li>
						<em>{$language.TINY_URL}</em>
						<input class="edit autoselect" type="text" value="{$tiny_url}" size="75" readonly id="tiny_url"  data-position="0"/>
					</li>
				{/if}
				
			</ul>
			<a class="black-button" href="javascript:void(0);" onclick="nd();">Закрыть</a>
		</div>