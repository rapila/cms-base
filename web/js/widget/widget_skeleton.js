(function() {
	jQuery('.rapila-button:not(.ui-state-disabled), .rapila-clickable').live("mouseover", function() {
		jQuery(this).addClass('ui-state-hover');
	}).live("mouseout", function() {
		jQuery(this).removeClass('ui-state-hover');
	}).live("mousedown", function() {
		jQuery(this).parents('.fg-buttonset-single:first').find(".fg-button.ui-state-active").removeClass("ui-state-active");
		if(jQuery(this).is('.ui-state-active.fg-button-toggleable, .fg-buttonset-multi .ui-state-active')){
			jQuery(this).removeClass("ui-state-active");
		}
		else {
			jQuery(this).addClass("ui-state-active");
		}
	}).live('mouseup', function() {
		if(!jQuery(this).is('.fg-button-toggleable, .fg-buttonset-single .fg-button, .fg-buttonset-multi .fg-button')) {
			jQuery(this).removeClass("ui-state-active");
		}
	});

	var win = jQuery(window);
	var doc = jQuery(document);

	//Initialize all widgets present as html elements on document.ready
	doc.ready(function() {
		jQuery(document.body).widgetElements().each(function() {
			jQuery(this).prepareWidget();
		});
	
		var head = jQuery('head');
		var style = jQuery('<style/>');
		head.append(style);
		var resize_handler = function() {
			var height = win.height()*0.8;
			style.text('.ui-dialog {max-height: '+(height)+'px;} .ui-dialog-content {max-height: '+(height-107)+'px;}');
		};
	
		win.resize(resize_handler);
		resize_handler();
	});

	//Handle unsaved changes gracefully
	win.bind('beforeunload', function(event) {
		if(UnsavedChanges.global > 0) {
			event.returnValue = '';
			return '';
		}
	});
	
	win.bind('unload', function(event) {
		var ids = [];
		jQuery.each(Widget.seenWidgets, function(id) {
			ids.push(id);
		});
		Widget.widgetJSON('-', ids, 'destroy');
	});
	
	// Inline documentation display
	Widget.create('documentation_display', function(widget) {
		widget._element = jQuery(document.body);
	});
})();
