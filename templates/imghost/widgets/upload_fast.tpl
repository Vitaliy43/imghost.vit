<script type="text/javascript">
	
{literal}
$(document).ready(function() {
			
	var browser = get_browser();

	if(browser == 'Google Chrome' || browser == 'Opera'){
			
		$('.item:first').before('<div style="margin: -10px 0px 10px 10px;font-weight:bold;">Для вставки картинки из буфера обмена нажмите CTRL + V</div>');
	}
			
});

{/literal}
	
</script>

<span id="comp-wrapper">

<div class="upload-splash">
	<a class="button switch-upload" href="#"><span>{$language.SELECT_FILE}</span></a>
	<div class="hint">{$language.ENABLE_OPTIONS_EDIT}</div>
	<div class="warning">
		{$language.MAX_SIZE_PHOTO_MSG}		
	</div>
</div>
<div class="upload-form hidden">
	<div class="upload-fields">
		{$form}
	</div>
	<div>

	<!--div id="all_submit"><button value="Submit">Submit</button></div-->
	</div>
	<div class="submit" id="all_submit">
		<input class="black-button" type="submit" value="{$language.UPLOAD}"/>
	</div>	
	<div class="more-options link_summary" style="display: none;">
		<a class="jsAction" href="#" onclick="show_summary_links(this);return false;" style="text-transform: lowercase;margin-top: 10px;">{$language.SUMMARY_LINKS}</a>
	</div>
		<div id="summary_links" class="modal-wnd inplace" style="padding: 10px; display: none;">
		<div class="popup-links">
			<ul style="list-style-type: none;">
				<li>
					<em>{$language.SHOW_LINK}</em>
					<textarea class="edit autoselect" readonly="" id="show_link" cols="65" rows="2" style="border: 1px solid #010101;"></textarea>
				</li>
				<li>
					<em>{$language.DIRECT_LINK}</em>
					<textarea class="edit autoselect" readonly="" id="direct_link" cols="65" rows="2" style="border: 1px solid #010101;"></textarea>
				</li>
				
				<li>
					<em>{$language.PREVIEW_LINK_BB}</em>
					<textarea class="edit autoselect" readonly="" id="preview_link_bb" cols="65" rows="2" style="border: 1px solid #010101;"></textarea>
				</li>
				<li>
					<em>{$language.PREVIEW_LINK_HTML}</em>
					<textarea class="edit autoselect" readonly="" id="preview_link_html" cols="65" rows="2" style="border: 1px solid #010101;"></textarea>
				</li>
				<li>
					<em>{$language.BB_CODE_LINK}</em>
					<textarea class="edit autoselect" readonly="" id="bb_code" cols="65" rows="2" style="border: 1px solid #010101;"></textarea>

				</li>
				
				
					<li style="display: none;">
						<em>{$language.TINY_URL}</em>
						<textarea class="edit autoselect" readonly="" id="tiny_url" cols="65" rows="2" style="border: 1px solid #010101;"></textarea>

					</li>
				
			</ul>
			<a class="black-button" href="javascript:void(0);" onclick="nd();">Закрыть</a>
		</div>
	</div>		
	<div class="five-more"><a class="more add-upload-fields" href="{site_url('upload/fast/add_fields')}">{$language.ADD_PHOTO}</a></div>
</div>
</span>