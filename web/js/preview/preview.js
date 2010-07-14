jQuery(document).ready(function() {
	var loader = jQuery(document.createElement('div')).addClass('ui-loading').attr('id', 'activity-indicator').appendTo(document.body);
	
	jQuery.extend(Widget, {
		activity: function() {
			loader.data('usage', loader.data('usage')+1);
			loader.show();
		}, 
	
		end_activity: function() {
			loader.data('usage', loader.data('usage')-1);
			if(loader.data('usage') <= 0) {
				loader.hide();
			}
		}
	});
	
	Widget.create('page_type', function(page_type) {
		page_type.settings.page_id = window.PreviewInterface.current_page_id;
	}, function(page_type) {
		page_type.handle_preview();
	}, window.PreviewInterface.page_type_widget);
});