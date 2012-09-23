<?php
class ViewNew {

	public function render($datas)
	{
		$data = $GLOBALS['DATA'];

		include(VIEW.'/header.php');
		include(VIEW.'/banner.php');

		$html = '<div class="container"><div clsaa="well">';
		$html .= <<<HTML
			
		<div class="box">
			<div class="pro_tools" id="testSaveButtons"></div>
			<div id="frame" class="enty-editor">
				<textarea id="frameToText" class="se_textarea"></textarea>
			</div>
		</div>

		$html .='</div></div>';
HTML;
		echo $html;
			
		include(VIEW.'/footer.php');
	}


}
?>
