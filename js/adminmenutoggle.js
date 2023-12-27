$(document).ready(function () {
	$("ul.admin_menu li:even").addClass("alt");
	$('div.button.admintoggle').click(function () {
		$('ul.admin_menu').slideToggle('medium');
	}); 
});