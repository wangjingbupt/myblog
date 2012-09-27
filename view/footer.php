
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/assets/js/jquery.js"></script>
    <script src="/assets/js/bootstrap-transition.js"></script>
    <script src="/assets/js/bootstrap-alert.js"></script>
    <script src="/assets/js/bootstrap-modal.js"></script>
    <script src="/assets/js/bootstrap-dropdown.js"></script>
    <script src="/assets/js/bootstrap-scrollspy.js"></script>
    <script src="/assets/js/bootstrap-tab.js"></script>
    <script src="/assets/js/bootstrap-tooltip.js"></script>
    <script src="/assets/js/bootstrap-popover.js"></script>
    <script src="/assets/js/bootstrap-button.js"></script>
    <script src="/assets/js/bootstrap-collapse.js"></script>
    <script src="/assets/js/bootstrap-carousel.js"></script>
    <script src="/assets/js/bootstrap-typeahead.js"></script>
		<?php echo $data['script']?>
		<script type="text/javascript">
		WB.core.load(['connect', 'client', 'widget.base', 'widget.atWhere'], function() {
				var cfg = {
							key: '628803579',
									xdpath: 'http://lxsnow.me/weibo/xd.html'
										};
											WB.connect.init(cfg);
												WB.client.init(cfg);
													
														//放置具体的组件代码
														WB.widget.base.connectButton(document.getElementById("connectBtn"));
		});
		</script>

  </body>
</html>
