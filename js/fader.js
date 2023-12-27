$(document).ready(function() {
	$(".button").fadeTo("slow", 0.3);
	$(".button").hover(function() {
		$(this).fadeTo("slow", 1.0);
	},function(){
		$(this).fadeTo("slow", 0.3);
	});
	$("#colorchanger").fadeTo("slow", 0.3);
	$("#colorchanger").hover(function(){
		$(this).fadeTo("slow", 1.0);
	},function(){
	$(this).fadeTo("slow", 0.3);
	});
});
