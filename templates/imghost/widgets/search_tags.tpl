
<form action="{site_url('gallery')}" onsubmit="search_by_tags();return false;" method="POST">
<h3 align="center">{$language.SELECT_RUBRIC}</h3>
<table width="85%" style="margin-top: 20px;">
	<tr>
		<td>
		<table>
			<tr>
				<td>{$language.TAG}:&nbsp;</td>
				<td>{$tags_box}</td>
			</tr>
		</table>
		</td>
		<td>
			<table>
				<tr>
					<td>{$language.CHILDREN_TAG}:&nbsp;</td>
					<td>{$children_tags_box}</td>
				</tr>
			</table>
		</td>
		<td align="left">
			<div class="submit">
				<input class="black-button" type="submit" value="{$language.SEARCH}"/>
			</div>
		</td>
	</tr>
</table>
<div class="hr" style="margin-bottom: 10px;"></div>
<div id="genres_list" style="display: none;width: 100%;margin-top: -10px;">
	
</div>
{if count($popular_tags) > 0}
	<h3 align="center">{$language.TOP_RUBRICS}</h3>

<div id="popular_tags" style="width: 100%;">
	{$counter = 0}
	{foreach $popular_tags as $tag}
		<div>
		<!--button value="{$tag.id}" id="popular_{$tag.id}" onclick="set_popular(this);return false;" >{$tag.value}</button-->
		
		<button value="{$tag.id}" id="popular_{$tag.id}" onclick="open_popular(this);return false;" {if $curr_tag.id == $tag.id} style="background: grey; color: #fff;" disabled="" {else:} style="cursor: pointer;"{/if}>{$tag.value}</button>
		</div>
		<input type="hidden" id="hiddenpopular_{$tag.id}" value="0" class="hiddenpopular"/>
		<input type="hidden" id="textpopular_{$tag.id}" value="{$tag.value}"/>
		{$counter++}
		
		{if $counter == 5}
			<!--div style="clear: both;margin-bottom: 10px;"></div-->
			{$counter = 0}
		{/if}
	{/foreach}
</div>
<div style="clear: both;margin-bottom: 10px;"></div>

<!--table width="100%">
	<tr>
		<td align="center">
			<div class="submit">
				<input class="black-button" type="submit" value="{$language.SEARCH}"/>
			</div>
		</td>
	</tr>
</table-->
<div class="hr" style="margin-top: 15px;"></div>
{/if}
{form_csrf()}
</form>


