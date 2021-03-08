

    <div class="tr template-upload fade in">

            <div class="td preview" ><span class="fade in"></span></div>
			
         <div class="td hide-on-submit">
				<ul class="hidden-controls">
					<li>
						<a class="hcSwitcher" href="#">{$language.RESIZE_TO}</a>
						<div class="hcArea">
							<input class="edit" type="text" name="RESIZE_TO[]" value="" size="5" />
							<select class="combobox" name="RESIZE_WHAT[]">
								<option value="none"></option>
								<option value="height">{$language.HEIGHT}</option>
								<option value="width">{$language.WIDTH}</option>
							</select>
							<a class="black-button hcClose" href="#">OK</a>
						</div>
					</li>
					<li>
						<a class="hcSwitcher" href="#">{$language.NAME}</a>
						<div class="hcArea">
							<input class="edit" type="text" name="NAME[]" value="" size="16" />
							<a class="black-button hcClose" href="#">OK</a>
						</div>
					</li>
					<li>
						<a class="hcSwitcher" href="#">{$language.COMMENTS}</a>
						<div class="hcArea">
							<textarea class="memo" name="DESCRIPTION[]" cols="35" rows="2"></textarea>
							<div class="center"><a class="black-button hcClose" href="#">OK</a></div>
						</div>
					</li>
				</ul>
			</div>
			<div class="td hide-on-submit">
				<ul class="hidden-controls">
					<li>
						<span>{$language.TURN}</span>
						<a class="left90" href="#" title="{$language.LEFT90}"></a>
						<a class="right90" href="#" title="{$language.RIGHT90}"></a>
						<input type="hidden" name="ROTATE[]" value="0" class="ROTATE"/>
					</li>
					<li>
						<a class="hcSwitcher" href="#">{$language.CONVERT}</a>
						<div class="hcArea">
							<select class="combobox CONVERT_TO" name="CONVERT_TO[]">
								<option value=""></option>
								<option value="jpg">JPG</option>
								<option value="png">PNG</option>
								<option value="gif">GIF</option>
							</select>
							<a class="black-button hcClose" href="#">OK</a>
						</div>
					</li>
					<li><a class="hcSwitcher" href="#">{$language.PREVIEW}</a>
						<div class="hcArea">
							<input class="edit PREVIEW_WIDTH" type="text" placeholder="Ш" size="5" value="" name="PREVIEW_WIDTH[]">
							<input class="edit PREVIEW_HEIGHT" type="text" placeholder="В" size="5" value="" name="PREVIEW_HEIGHT[]">
							<a class="black-button hcClose" href="#">OK</a>
						</div>
						
					</li>
				</ul>
		
			</div>
			<div class="td hide-on-submit">
				<ul class="hidden-controls">
					<li><a class="hcSwitcher" href="#">{$language.ACCESS}</a>
					<div class="hcArea">
						<div class="input">
							<select class="combobox ACCESS" name="ACCESS[]" id="ACCESS" style="width:100px;">
								<option value="public">{$lang_albums.ALBUM_PUBLIC}</option>
								<option value="private">{$lang_albums.ALBUM_PRIVATE}</option>
							</select>
						</div>
						<a class="black-button hcClose" href="#">OK</a>
					</div>
					</li>
					<?php if(!$is_guest):?>
					<li>
						<a class="hcSwitcher" href="#">{$language.ALBUM}</a>
						<div class="hcArea">
							<div class="input">{$albums}</div>
							<a class="black-button hcClose" href="#">OK</a>
						</div>
					</li>
					<?php endif;?>
					<li>
						<a class="hcSwitcher" href="#">{$language.TAGS}</a>
						<div class="hcArea">
							<div class="input">{$tags}</div>
							<div class="field children_tags" style="display: none;">
								<div class="input"></div>
							</div>
							<a class="black-button hcClose" href="#">OK</a>
						</div>
					</li>
				</ul>
			</div>
           <div class="td">
				<ul class="hidden-controls">
				<li></li>
				<li><a href="javascript:void(0);" onclick="delete_preupload(this);return false;" style="color:red;">{$lang_main.DELETE}</a></li>
				<li></li>
				</ul>
			</div>
			<div class="td progressbar" style="display: none;">
                <span class="fade"><div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div></span>
            </div>
        
    </div>
