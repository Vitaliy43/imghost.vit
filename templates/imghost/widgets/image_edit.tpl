
<div id="edit_image" style="padding: 20px;">
{if $is_guest}
	<form action="{site_url('images_guest/edit')}/{$id}" method="post" onsubmit="update_image(this,{$id});return false;">
{else:}
	<form action="{site_url('images/edit')}/{$id}" method="post" onsubmit="update_image(this,{$id});return false;">
{/if}
<input type="hidden" name="is_update" value="1"/>
<table width="100%" height="100%">
	<tr>
		<td rowspan="3" width="{$max_size}" height="{$max_size}" valign="middle" align="center">
			<span class="fade">
				<img src="{$src}" width="{$width}" height="{$height}"/>		
			</span>
		</td>
		<td>
			<a class="hcSwitcherModal" href="#" onclick="show_field(this,'col1');">{$language['RESIZE_TO']}</a>
						<div class="hcAreaModal col_1">
						<input type="hidden" class="proportion" value="{$proportion}"/>
							<table>
								<tr>
									<td><label>{$language.RESIZE_TO}:</label></td>
									<td></td>
								</tr>
								<tr>
									<td><label>{$language.WIDTH}</label></td>
									<td>
									<div class="input">
										<input class="edit" type="text" name="RESIZE_TO_WIDTH" value="{$full_width}" size="5" onchange="constrain_proportions(this,'width');" id="resize_to_width"/>
									</div>
									</td>
								</tr>
								<tr>
									<td>
										<label>{$language.HEIGHT}</label></td>
										<td>
										<div class="input">
											<input class="edit" type="text" name="RESIZE_TO_HEIGHT" value="{$full_height}" size="5" onchange="constrain_proportions(this,'height');" id="resize_to_height"/>
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<label>{$language.CONSTRAIN_PROPORTIONS}</label></td>
										<td>
										<div class="input">
											<input class="edit" type="checkbox" id="constrain" checked=""/>
										</div>
									</td>
								</tr>
							</table>
							<a class="black-button hcCloseModal" href="#" onclick="hide_field(this,'col1');">OK</a>
						</div>
						<input type="hidden" value="37" class="add_to_modal_width"/>
		</td>
		<td>
			<a class="hcSwitcherModal" href="#" onclick="show_field(this,'');">{$language['TURN']}</a>
			<a class="left90" href="#" title="{$language['LEFT90']}"></a>
				<a class="right90" href="#" title="{$language['RIGHT90']}"></a>
			<input type="hidden" name="ROTATE" value="0" id="rotate"/>
		</td>
	<td>
		<a class="hcSwitcherModal" href="#" onclick="show_field(this,'col3');">{$language['TINY_URL']}</a>
			<div class="hcAreaModal col_3 maxwidth3">
				<div class="input">
				<div>
					<table cellpadding="0" cellspacing="0" >
						<tr>
							<td>tinyURL</td>
							<td><input type="checkbox" name="TINYURL" {if isset($checked)} checked="checked" {/if} id="tiny_url"/></td>
							<td class="container_tiny_url"><a class="black-button hcCloseModal" href="#" style="margin-left: -6px;" onclick="hide_field(this,'col3');">OK</a></td>	
							<input type="hidden" id="hidden_tiny" value="{if isset($checked)}1{else:}0{/if}" />
						</tr>
					</table>
				</div>
				</div>
			</div>	
			<!--a class="hcSwitcherModal" href="#" onclick="show_field(this,'col3');">{$language['TINY_URL']}</a>
			<div class="hcAreaModal col_1">
				<table>
					<tr>
						<td><label>tinyURL</label>&nbsp;&nbsp;</td>
						<td><input class="edit" type="checkbox" name="TINYURL" {if isset($checked)} checked="checked" {/if}/></td>
					</tr>
				</table>
					
					<a class="black-button hcCloseModal" href="#" onclick="hide_field(this,'col3');">OK</a>
			</div-->

			<input type="hidden" value="90" class="add_to_modal_width"/>
		</td>
	</tr>
	<tr>
		<td>
				<a class="hcSwitcherModal" href="#" onclick="show_field(this,'col1');">{$language['NAME']}</a>
				<div class="hcAreaModal col_1">
					<input class="edit" type="text" name="NAME" value="" size="16" id="name"/>
					<a class="black-button hcCloseModal" href="#" onclick="hide_field(this,'col1');">OK</a>
			</div>
				<input type="hidden" value="32" class="add_to_modal_width"/>

		</td>
		<td>
				<a class="hcSwitcherModal" href="#" onclick="show_field(this,'col2');">{$language['CONVERT']}</a>
				<div class="hcAreaModal col_2 max_width2">
				<select class="combobox" name="CONVERT_TO" id="convert_to">
					<option value=""></option>
					<option value="jpg">JPG</option>
					<option value="png">PNG</option>
					<option value="gif">GIF</option>
				</select>
					<a class="black-button hcCloseModal" href="#" onclick="hide_field(this,'col2');">OK</a>

			</div>
				<input type="hidden" value="32" class="add_to_modal_width"/>

		</td>
		<td>
			{if !$is_guest}
			<a class="hcSwitcherModal" href="#" onclick="show_field(this,'col3');">{$language['ALBUM']}</a>
			<div class="hcAreaModal col_3 max_width3">
				<div class="input">
					{$albums}
				</div>
					<a class="black-button hcCloseModal" href="#" onclick="hide_field(this,'col3');">OK</a>
			</div>
				<input type="hidden" value="90" class="add_to_modal_width"/>
			{else:}	
				<a class="hcSwitcherModal" href="#" onclick="show_field(this,'col3');">{$language['ACCESS']}</a>
			<div class="hcAreaModal col_3 max_width3">
				<div class="input">
					{$access}
				</div>
				<a class="black-button hcCloseModal" href="#" onclick="hide_field(this,'col3');">OK</a>

			</div>
			<input type="hidden" value="90" class="add_to_modal_width"/>
			{/if}
		</td>
	</tr>
	<tr>
		<td>
			<a class="hcSwitcherModal" href="#" onclick="show_field(this,'col1');">{$language['COMMENTS']}</a>
					<div class="hcAreaModal col_1 max_width1">
						<textarea class="memo" name="DESCRIPTION" cols="35" rows="2" id="description"></textarea>
						<a class="black-button hcCloseModal" href="#" onclick="hide_field(this,'col1');">OK</a>
					</div>
			<input type="hidden" value="145" class="add_to_modal_width"/>

		</td>
		<td>
			<a class="hcSwitcherModal" href="#" onclick="show_field(this,'col2');">{$language['WATERMARK']}</a>
			<div class="hcAreaModal col_2">
				<div class="input"><input class="edit" type="text" name="WATERMARK" value="" size="16" maxlength="16" id="watermark"/></div>
				<a class="black-button hcCloseModal" href="#">OK</a>
			</div>		
		</td>
		<td>
		
			{if !$is_guest}
			<a class="hcSwitcherModal" href="#" onclick="show_field(this,'col3');">{$language['TAGS']}</a>
				<div class="hcAreaModal col_3 max_width3">
					<!--input class="edit" type="text" name="PREVIEW_WIDTH" value="" size="5" placeholder="Ш" id="preview_width"/>
					<input class="edit" type="text" name="PREVIEW_HEIGHT" value="" size="5" placeholder="В" id="preview_height"/-->
					<div class="input">
								{$tags}
							</div>
								<div class="input">

							{if !$children_tags}
									<div class="field children_tags" style="display: none;">
							{else:}
								<div class="field children_tags">
							{/if}
									{$children_tags}
								</div>
							</div>
						<a class="black-button hcCloseModal" href="#" onclick="hide_field(this,'col3');">OK</a>
			</div>
			<input type="hidden" value="90" class="add_to_modal_width"/>
			{/if}
		</td>

	</tr>

</table>


			<div class="submit" style="text-align: right;margin-top: 5px;">
				<input class="black-button" type="submit" value="{$language['FINISH']}"/>
			</div>
		{if isset($current_album)}
			<input type="hidden" id="current_album" value="{$current_album}"/>
		{/if}
			<input type="hidden" id="current_access" value="{$current_access}"/>
{form_csrf()}
</form>
</div>
