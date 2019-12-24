	<!-- End Page -->


	<!-- Core  -->
	<script src="$ThemeDir/global/vendor/babel-external-helpers/babel-external-helpers.js"></script>
	<script src="$ThemeDir/global/vendor/jquery/jquery.js"></script>
	<script src="$ThemeDir/global/vendor/popper-js/umd/popper.min.js"></script>
	<script src="$ThemeDir/global/vendor/bootstrap/bootstrap.js"></script>
	<script src="$ThemeDir/global/vendor/animsition/animsition.js"></script>
	<script src="$ThemeDir/global/vendor/mousewheel/jquery.mousewheel.js"></script>
	<script src="$ThemeDir/global/vendor/asscrollbar/jquery-asScrollbar.js"></script>
	<script src="$ThemeDir/global/vendor/asscrollable/jquery-asScrollable.js"></script>
	<script src="$ThemeDir/global/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>
	<script src="$ThemeDir/global/vendor/waves/waves.js"></script>

	<!-- Plugins -->
	<script src="$ThemeDir/global/vendor/switchery/switchery.js"></script>
	<script src="$ThemeDir/global/vendor/intro-js/intro.js"></script>
	<script src="$ThemeDir/global/vendor/screenfull/screenfull.js"></script>
	<script src="$ThemeDir/global/vendor/slidepanel/jquery-slidePanel.js"></script>
	<script src="$ThemeDir/global/vendor/jquery-placeholder/jquery.placeholder.js"></script>

	<!-- Scripts -->
	<script src="$ThemeDir/global/js/Component.js"></script>
	<script src="$ThemeDir/global/js/Plugin.js"></script>
	<script src="$ThemeDir/global/js/Base.js"></script>
	<script src="$ThemeDir/global/js/Config.js"></script>

	<script src="$ThemeDir/assets/js/Section/Menubar.js"></script>
	<script src="$ThemeDir/assets/js/Section/GridMenu.js"></script>
	<script src="$ThemeDir/assets/js/Section/Sidebar.js"></script>
	<script src="$ThemeDir/assets/js/Section/PageAside.js"></script>
	<script src="$ThemeDir/assets/js/Plugin/menu.js"></script>

	<script src="$ThemeDir/global/js/config/colors.js"></script>
	<script src="$ThemeDir/assets/js/config/tour.js"></script>
	<script>Config.set('assets', '$ThemeDir/assets');</script>

	<!-- Page -->
	<script src="$ThemeDir/assets/js/Site.js"></script>
	<script src="$ThemeDir/global/js/Plugin/asscrollable.js"></script>
	<script src="$ThemeDir/global/js/Plugin/slidepanel.js"></script>
	<script src="$ThemeDir/global/js/Plugin/switchery.js"></script>
	<script src="$ThemeDir/global/js/Plugin/jquery-placeholder.js"></script>
	<script src="$ThemeDir/global/js/Plugin/material.js"></script>

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