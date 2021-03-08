<script type="text/javascript">


</script>

<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">Картинки</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <div class="dropdown d-i_b">
                    <button type="button" class="btn btn-small dropdown-toggle disabled action_on" data-toggle="dropdown">
                        <i class="icon-tag"></i>
                        Все картинки
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#" class="to_pspam">Картинки юзеров</a></li>
                        <li><a href="#" class="to_wait">Картинки гостей</a></li>
                    </ul>
                </div>
                <a class="btn btn-small pjax" href="/admin/components/cp/imghost/show_settings"><i class="icon-wrench"></i>Настройки</a>
            </div>
        </div>    
    </div>
    <div class="btn-group myTab m-t_20">
        <a class="btn btn-small pjax {if $selected == 'all' }active{/if}" href="/admin/components/cp/imghost/index">Все картинки
            {if $total_all}
                <span style="top:-13px;" class="badge badge-important">
                    {$total_all}
                </span>
            {/if}
        </a>
        <a class="btn btn-small pjax {if $selected == 'tags'}active{/if}" href="/admin/components/cp/imghost/index/tags">По тегам
            {if $total_tag>0}
                <span style="top:-13px;" class="badge badge-important">{$total_tag}</span>
            {/if}
        </a>
        <a class="btn btn-small pjax {if $selected == 'users'}active{/if}" href="/admin/components/cp/imghost/index/users">По юзерам
            {if $total_user>0}
                <span style="top:-13px;" class="badge badge-important">
                    {$total_user}
                </span>
            {/if}
        </a>
    </div>
    <div class="tab-content">
        {if count($images) > 0 AND is_array($images)}
            <div class="tab-pane active" id="modules">
                <div class="row-fluid">
                    <table class="table table-striped table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
    
                                <th class="span2">{$language.PREVIEW}</th>
                                <th class="span5">{$language.FILENAME}</th>
                                <th class="span2">{$language.TAG}</th>
                                <th class="span2">{$language.ALBUM}</th>
                                <th class="span5">{$language.DESCRIPTION}</th>
                                <th class="span3">{$language.DATA_UPLOADED}</th>
                                <th class="span2">{$language.FILESIZE}</th>
                                <th class="span2">{$language.FILETYPE}</th>
                                <th class="span5">{$lang_auth.USER}</th>
                                <th class="span2">{$lang_upload.ACCESS}</th>
                                <th class="span2">{$lang_main.ACTIONS}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach $images as $file}
                                    <tr data-id="{$file.id}" data-type="{$file.type}" id="row_{$file.id}">
                                        <td class="span2">
                                            <span>
												<a href="{$file.url}" class="file_preview" rel="url" onclick="show_image(this);return false;">{$file.preview}</a>
                                            </span>
                                        </td>
										<td class="span5">
                                            <span>
												<a href="{$file.main_url}" target="_blank">{splitterWord($file.show_filename,30)}</a>
											 </span>
                                        </td>   
										<td class="span2">
                                            <span>
												{if $file.tag_name}
													<a href="{site_url('gallery/tags')}/{$file.tag_id}" target="_blank">{splitterWord($file.tag_name,25)}</a>
												{/if}                                           
											 </span>
                                        </td>    
										<td class="span2">
                                            <span>
												{if $file.album_name}
													<a href="{site_url('albums')}/{$file.album_id}" target="_blank">{splitterWord($file.album_name,25)}</a>
												{/if}                                           
											 </span>
                                        </td>
										<td class="span5">
											{$file.comment}
										</td>    
										<td class="span2">
											{extract_date($file.added)}
										</td>
										<td class="span2">
											{formatFileSize($file.size)}
										</td>
										<td class="span2">
											{$file.ext}
										</td>
										<td class="span5">
											{if $file.type == 'guest' }
												{$language.GUEST}
											{else:}
												<a href="{site_url('user')}/{$file.uid}" target="_blank">{$file.username}</a>
		
											{/if}
										</td>
										<td class="span2">
											<img src="/templates/imghost/images/access_{$file.access}.png" width="15" height="15" title="{$file.access_text}"/>
										</td>
										<td class="span2">
											<table>
												<tr>
													<td>
														<a href="{site_url('images/edit')}/{$file.id}" title="{$lang_main.EDIT}" onclick="edit_image(this,'{$file.id}');return false;" id="edit_{$file.id}">
														<img src="/templates/administrator/images/icon_edit.png" width="15" height="15"/></a>
													</td>
													<td>
													{if $file.type == 'guest'}
														<a href="{site_url('images_guest/delete')}/{$file.id}" title="{$lang_main.DELETE}" onclick="delete_image_admin(this,'{$file.id}','{$language.CONFIRM_DELETE}');return false;" id="delete_{$file.id}" style="margin-left: 5px;">
													{else:}
														<a href="{site_url('images/delete')}/{$file.id}" title="{$lang_main.DELETE}" onclick="delete_image_admin(this,'{$file.id}','{$language.CONFIRM_DELETE}');return false;" id="delete_{$file.id}" style="margin-left: 5px;">
													{/if}
												
													<img src="/templates/administrator/images/icon_delete.png" width="15" height="15"/>
												</a>
													</td>
												</tr>
											</table>
										</td>
                                    </tr>
                              
                        {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    {else:}
        </br>
        <div class="alert alert-info">
            Нет данных
        </div>
    {/if}
</div>
<div class="clearfix">
    {$paginator}
</div>
</section>