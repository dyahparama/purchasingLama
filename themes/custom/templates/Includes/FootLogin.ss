	<!-- End Page -->


	<!-- Core  -->
	<script src="/_resources/themes/custom/global/vendor/babel-external-helpers/babel-external-helpers.js"></script>
	<script src="/_resources/themes/custom/global/vendor/jquery/jquery.js"></script>
	<script src="/_resources/themes/custom/global/vendor/popper-js/umd/popper.min.js"></script>
	<script src="/_resources/themes/custom/global/vendor/bootstrap/bootstrap.js"></script>
	<script src="/_resources/themes/custom/global/vendor/animsition/animsition.js"></script>
	<script src="/_resources/themes/custom/global/vendor/mousewheel/jquery.mousewheel.js"></script>
	<script src="/_resources/themes/custom/global/vendor/asscrollbar/jquery-asScrollbar.js"></script>
	<script src="/_resources/themes/custom/global/vendor/asscrollable/jquery-asScrollable.js"></script>
	<script src="/_resources/themes/custom/global/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>
	<script src="/_resources/themes/custom/global/vendor/waves/waves.js"></script>

	<!-- Plugins -->
	<script src="/_resources/themes/custom/global/vendor/switchery/switchery.js"></script>
	<script src="/_resources/themes/custom/global/vendor/intro-js/intro.js"></script>
	<script src="/_resources/themes/custom/global/vendor/screenfull/screenfull.js"></script>
	<script src="/_resources/themes/custom/global/vendor/slidepanel/jquery-slidePanel.js"></script>
	<script src="/_resources/themes/custom/global/vendor/jquery-placeholder/jquery.placeholder.js"></script>

	<!-- Scripts -->
	<script src="/_resources/themes/custom/global/js/Component.js"></script>
	<script src="/_resources/themes/custom/global/js/Plugin.js"></script>
	<script src="/_resources/themes/custom/global/js/Base.js"></script>
	<script src="/_resources/themes/custom/global/js/Config.js"></script>

	<script src="/_resources/themes/custom/assets/js/Section/Menubar.js"></script>
	<script src="/_resources/themes/custom/assets/js/Section/GridMenu.js"></script>
	<script src="/_resources/themes/custom/assets/js/Section/Sidebar.js"></script>
	<script src="/_resources/themes/custom/assets/js/Section/PageAside.js"></script>
	<script src="/_resources/themes/custom/assets/js/Plugin/menu.js"></script>

	<script src="/_resources/themes/custom/global/js/config/colors.js"></script>
	<script src="/_resources/themes/custom/assets/js/config/tour.js"></script>
	<script>Config.set('assets', '/_resources/themes/custom/assets');</script>

	<!-- Page -->
	<script src="/_resources/themes/custom/assets/js/Site.js"></script>
	<script src="/_resources/themes/custom/global/js/Plugin/asscrollable.js"></script>
	<script src="/_resources/themes/custom/global/js/Plugin/slidepanel.js"></script>
	<script src="/_resources/themes/custom/global/js/Plugin/switchery.js"></script>
	<script src="/_resources/themes/custom/global/js/Plugin/jquery-placeholder.js"></script>
	<script src="/_resources/themes/custom/global/js/Plugin/material.js"></script>

	<script>
		(function (document, window, $) {
			'use strict';

			var Site = window.Site;
			$(document).ready(function () {
				Site.run();
				if($("#MemberLoginForm_LoginForm_error").attr("style") != "display: none"){
					$(".alert.dark.alert-danger.alert-dismissible").removeClass("d-none");
				}
				$(".code").val($("#MemberLoginForm_LoginForm_SecurityID").val());
				$(".temp-form").remove();
				$(".code").attr("id", "MemberLoginForm_LoginForm_SecurityID");

			});
		})(document, window, jQuery);
	</script>

</body>

</html>