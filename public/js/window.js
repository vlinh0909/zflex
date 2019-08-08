jQuery(document).ready(function($) {
	sidebarCollapse = function()
	{
		if($("html").width() < 576){
			$("body").addClass("sidebar-collapse");
		}
		$(window).resize(function(){
			if($("html").width() < 576){
				$("body").addClass("sidebar-collapse");
			}
		});
	}
})