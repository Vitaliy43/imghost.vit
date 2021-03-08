<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{$language.ADVERT_SETTINGS}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="{$BASE_URL}admin/components/modules_table" class="t-d_n m-r_15 pjax"><span class="f-s_14">←</span> <span class="t-d_u">{lang("Go back", 'social_servises')}</span></a>
                <button type="button" class="btn btn-small btn-primary formSubmit" data-form="#social_servises" data-submit><i class="icon-ok icon-white"></i>{lang("Save", 'social_servises')}</button>
            </div>
        </div>                            
    </div>
    <div class="btn-group myTab m-t_10" data-toggle="buttons-radio" style="margin-bottom: 15px;">
	   	 
		 {foreach $positions_names as $key=>$value}
		 	    <a href="{$BASE_URL}admin/components/init_window/advertisement" class="btn btn-small {if $position == $key}active{/if}" onclick="filter_position(this);return false;" data-position="{$key}">{$value}</a>

		 {/foreach}
    </div> 
	<div id="blocks_table">
<table width="80%" cellpadding="4" cellspacing="4" border="1" id="blocks_table">
	<tr>
		<th align="left">{$language.BLOCK}</th>
		<th align="left">{$language.POSITION}</th>
		<th align="left">{$language.DESCRIPTION}</th>
		<th align="left">{$language.NUMBER}</th>
		<th align="left">{$language.ACTIVE}</th>
		<th align="left">{$language.ACTIONS}</th>
	</tr>
	{foreach $blocks as $block}
	<tr data-id="{$block.id}" class="block">
		<td>{$block.name}</td>
		<td style="padding-top: 5px;">{$block.select_position}</td>
		<td>{$block.description}</td>
		<td>{$block.sortid}</td>
		<td>
			<input type="checkbox" {if $block.active} checked="checked"{/if} onclick="set_active(this);return false;"/>
		</td>
		
		<td class="span2">
			<table>
					<tr>
													<td>
														<a href="{$BASE_URL}admin/components/init_window/advertisement/edit" title="{$language.EDIT_ADVERT_CONTENT}" onclick="edit_advert_content(this,{$block.id});return false;">
														<img src="/templates/administrator/images/icon_edit.png" width="15" height="15"/></a>
													</td>
													<td>
												<a href="{$BASE_URL}admin/components/init_window/advertisement/delete" onclick="delete_advert(this,,'{$language.CONFIRM_DELETE}');return false;" style="margin-left: 5px;">
													<img src="/templates/administrator/images/icon_delete.png" width="15" height="15"/>
												</a>
													</td>
												</tr>
			</table>
		</td>
	</tr>
	{/foreach}
</table>
</div>
</section>
