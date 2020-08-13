/*
 *	Fix - dropdown menu raised by hover disappears when moving mouse slowly into list
 *	Fix - menu raised with click does not close when mouse moves to another top level item
 */

$( document ).ready(function() {
	$(".dropdown").each(function(i,obj) {
		$(this).on("mouseenter mouseleave", () => {
			$(".dropdown-menu").each(function(i,obj) {
				$(this).removeClass("show");
			})
			$(this).toggleClass("open");
		});
	});
});
