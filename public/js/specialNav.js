$('#hamlgmenu').click(function() {
	$('#hmlgmenushow').slideToggle(400,"easeOutBounce");
	$('#hmlgmenushow').removeClass("d-md-none");
	$('#hmlgmenushow').addClass("hmbglg");
});
$(window).resize(function() {
 if ($(window).width() < 768) {
	 $('#hmlgmenushow').addClass("d-md-none");
	 $('#hmlgmenushow').removeClass("hmbglg");
 }
// else {
// }
});
