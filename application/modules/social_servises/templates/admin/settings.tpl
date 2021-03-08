<script type="text/javascript">
	{literal}
	function switch_net(hash){
		if($('#social_services').length < 1)
			return false;
		if(hash == '')	
			var hash = document.location.hash;
//			alert(hash);
			if(!hash || hash == 'VK'){
				$('#VK').addClass('active');
				$('#link_VK').addClass('active');
			}
			else{
				$('#'+hash).addClass('active');
				$('#link_'+hash).addClass('active');
			}
	}
			
	{/literal}
</script>

<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">{lang("Integration with social servises module settings", 'social_servises')}</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="{$BASE_URL}admin/components/modules_table" class="t-d_n m-r_15 pjax"><span class="f-s_14">←</span> <span class="t-d_u">{lang("Go back", 'social_servises')}</span></a>
                <button type="button" class="btn btn-small btn-primary formSubmit" data-form="#social_servises" data-submit><i class="icon-ok icon-white"></i>{lang("Save", 'social_servises')}</button>
            </div>
        </div>                            
    </div>
    <div class="btn-group myTab m-t_10" data-toggle="buttons-radio">
	    <a href="{$BASE_URL}admin/components/init_window/social_servises?net=vk" class="btn btn-small {if $net == 'vk'}active{/if}">VKontakte</a>
        <a href="{$BASE_URL}admin/components/init_window/social_servises?net=fb" class="btn btn-small {if $net == 'fb'}active{/if}" >Facebook</a>
        <a href="{$BASE_URL}admin/components/init_window/social_servises?net=ok" class="btn btn-small {if $net == 'ok'}active{/if}">{$ok_settings.name}</a>
        <a href="{$BASE_URL}admin/components/init_window/social_servises?net=pic" class="btn btn-small {if $net == 'pic'}active{/if}">{$pic_settings.name}</a>
		 
    </div>        
    <form method="post" action="/admin/components/cp/social_servises/update_settings" class="form-horizontal" id="social_servises">
        <div class="tab-content">
			{$vk}
			{$fb}
			{$ok}
			{$pic}
        </div>
        {form_csrf()}
    </form>
</section>
<input type="hidden" id="social_services"/>