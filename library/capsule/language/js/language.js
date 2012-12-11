jQuery.noConflict()(function($){
$(document).ready(function() {

$('#languageSelectMain').change(function() {
	var id = $(this).val();
	$.post('library/capsule/language/language.ajax.php', 
	{id:id,method:'setDefaultLanguage',control:'setDefaultLanguage'}, function(data) {
	window.location.reload();
	});

});

});
});