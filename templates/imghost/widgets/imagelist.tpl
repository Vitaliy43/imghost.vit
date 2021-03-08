<div id="upload-multiple" style="display: block;">
	<a class="close close-multiupload" href="#">Закрыть</a>
	<div class="choose-source">
		<a class="black-button active" href="#upload-multi-files">Загрузка с компьютера</a>
		<a class="black-button" href="#upload-multi-links">Загрузка из Интернета</a>
	</div>
	<div class="workarea">
		<form id="upload-multi-files" action="<?php echo site_url('upload/multiple');?>" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="ACTION" value="upload-files" />
			<input type="hidden" name="__AJAX" value="Y" />
			<div class="toolbar fileupload-buttonbar">
				<span class="toolbutton fileinput-button">
					<span>Выбрать файлы</span>
					<input type="file" name="files[]" multiple />
				</span>
				<button type="submit" class="toolbutton start">Загрузить на сервер</button>
				<button class="btn-abs sort" type="button"></button>
				<button type="reset" class="btn-abs cancel delete"></button>
			</div>
			<div id="upload-drop-zone" class="listbox files"></div>
		</form>
		
		<form id="upload-multi-links" class="ajaxForm" action="<?php echo site_url('upload/multiple');?>" method="POST">
			<input type="hidden" name="ACTION" value="upload-links" />
			<input type="hidden" name="__AJAX" value="Y" />
			<div class="toolbar fileupload-buttonbar">
				<button type="submit" class="toolbutton start">Загрузить на сервер</button>
				<button type="reset" class="btn-abs cancel delete"></button>
			</div>
			<div id="upload-result">
				<div class="caption-text">Результат загрузки</div>
				<textarea class="memo" name="FILE_URL" placeholder="http://somesite.com/some_picture.jpg"></textarea>
			</div>
		</form>
	</div>
</div>