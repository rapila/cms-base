jQuery(document).ready(function() {
	Widget.create('page_type', function(page_type) {
		page_type.settings.page_id = window.PreviewInterface.current_page_id;
	}, function(page_type) {
		page_type.handle_preview();
	}, window.PreviewInterface.page_type_widget);
});