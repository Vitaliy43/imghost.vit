<script type="text/javascript">
{literal}
$(document).ready(function() {

	$("#tags_tree").treeview({
		persist: "location",
		collapsed: true
	});
	

});
{/literal}
</script>
<h2>Дерево тегов</h2>
<div id="container_tree" style="margin-left: 30px;margin-top:25px;">
	{$tree}
</div>
