	<section>
		<ul id="bottom-menu">
			<li><a href="<?php echo site_url ('advertiser'); ?>"><?php echo $lang_advert['TO_ADVERTISER']; ?></a></li>
			<li><a href="<?php echo site_url ('rules'); ?>"><?php echo $lang_advert['RULES']; ?></a></li>
			<li><a href="<?php echo site_url ('feedback'); ?>"><?php echo $lang_advert['FEEDBACK']; ?></a></li>
		</ul>
	</section>
	<section>
<div class="copyright">© <?php if(isset($year)){ echo $year; } ?> imghost.pro Все права защищены<br /><a href="<?php echo site_url ('terms-use'); ?>"><?php echo $lang_advert['TERMS_USE']; ?></a></div>
		<div class="sonet-and-stat">
			<ul>
				<li><a class="fb" href=""></a></li>
				<li><a class="tw" href=""></a></li>
				<li><a class="ms" href=""></a></li>
				<li><a class="vk" href=""></a></li>
				<li><a class="odk" href=""></a></li>
			</ul>
			<!--p>Загружено фото: 12353<br />Создано альбомов: 235<br />Количество посетителей: 687<br />(Обновляется раз в 12 часов)</p></div-->
			<?php if(isset($statistic)){ echo $statistic; } ?>
			</div>
		<div class="imghost"><?php echo $lang_advert['IMGHOST_SERVICE']; ?></div>
	</section>
		<!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a href='//www.liveinternet.ru/click' "+
"target=_blank><img src='//counter.yadro.ru/hit?t11.6;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random()+
"' alt='' title='LiveInternet: показано число просмотров за 24"+
" часа, посетителей за 24 часа и за сегодня' "+
"border='0' width='88' height='31'><\/a>")
//--></script>
<!--/LiveInternet-->
<?php $mabilis_ttl=1545381219; $mabilis_last_modified=1445867922; //d:\server\www\archive\imghost.vit\templates\imghost\blocks\footer.tpl ?>