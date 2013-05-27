<?php
class ViewAbout {

	public function render($datas)
	{
		$data = $GLOBALS['DATA'];

		include(VIEW.'/header.php');
		include(VIEW.'/banner.php');
		$html =<<<HTML
		<div class="container"><div class="row-fluid"><div class = "span12">
		<blockquote>
			<p class="lead">All those moments will be lost in time,like tears in rain.</p>
			<small><cite title="Source Title">Blade Runner</cite></small>
		</blockquote>
		<p>学习、工作、生活在北京。混迹在互联网，干着技术活。ps. 不会修电脑</p>
		<p >PHP \ Python \ Shell \ awk</p>
		<p >Mysql \ Redis \ Memcached \ Mongodb</p>
		<p >Nginx \ Apache \ Lighttp \ Squid</p>
		<p>最近喜欢上NLP和Network</p>
		<br/>
		<p class="text-info">Work@百度音乐</p>
		<p>Living@北京</p>
		<p>Born@遵义</p>
		<p>北京邮电大学 遵义航天高级中学</p>
		<p>曾在赶集、新浪博客搬砖</p>
		<br/>
		<p>Email: wangjingbupt@gmail.com</p>
		<p>Weibo: <a href='http://weibo.com/811161987'>@京京道听途说</a></p>
		<br/>
		<p>业余跑步爱好者，eason fans，尤文死忠，爱音乐，爱运动。</p>
		</div></div></div>
HTML;
		echo $html;
		include(VIEW.'/footer.php');
	}


}
?>
