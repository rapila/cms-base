jQuery(document).ready(function() {
	jQuery('<div/>', {'id': 'widget-notifications'}).appendTo(document.body);
	
	var link_rewriter = function() {
		if(this.href.indexOf('/widget_resource/css/') > -1) {
			this.href = this.href.replace('/widget_resource/css/', '/namespaced_preview_resource/css/');
		}
	};
	jQuery('head link').each(link_rewriter);
	Widget.handle('loadInfo-resources', function(event, resources) {
		resources.filter('link').each(link_rewriter);
	});
	
	var loader = jQuery(document.createElement('div')).addClass('ui-loading').attr('id', 'activity-indicator').appendTo(document.body);
	
	jQuery.extend(Widget, {
		activity: function() {
			loader.data('usage', (loader.data('usage')||0)+1);
			loader.show();
		}, 
	
		end_activity: function() {
			loader.data('usage', (loader.data('usage')||0)-1);
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
	
	Widget.createWithElement('admin_menu', function(widget) {
		widget._element.appendTo(document.body);
	}, PreviewInterface.admin_menu_widget);
});

Widget.tooltip = jQuery.noop;