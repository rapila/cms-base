jQuery.fn.extend({
	tooltip: function(text) {
		var tooltip = null;
		var offsetParent = null;
		var _this = this;
		var set_position = function(event) {
			var offset = offsetParent.offset();
			offset.left = event.pageX + 3 - offset.left;
			offset.top = event.pageY + 3 - offset.top;
			tooltip.css(offset);
		};
		this.hover(function(event) {
			if(!tooltip) {
				offsetParent = _this.offsetParent();
				tooltip = offsetParent.children("div.global_tooltip");
				if(!tooltip.length) {
					tooltip = jQuery('<div/>').addClass('global_tooltip tooltip ui-widget ui-widget-content ui-corner-all').appendTo(offsetParent);
				}
			}
			tooltip.text(text);
			tooltip.show();
			set_position(event);
		}, function() {
			tooltip.hide();
		}).mousemove(set_position);
	}
});

jQuery.extend(Widget, {
	tooltip: function(element, text) {
		jQuery(element).tooltip(text);
	},

	confirm: function(title, message, callback, cancelButtonText, okButtonText) {
		if(cancelButtonText === undefined) {
			cancelButtonText = AdminInterface.translations.cancelButtonText;
		}
		if(okButtonText === undefined) {
			okButtonText = AdminInterface.translations.okButtonText;
		}
		var dialog = Widget.parseHTML('<div class="rapila_alert"><p><span class="ui-icon ui-icon-alert"></span><span class="text"></span></p></div>').attr('title', title).find('.ui-icon').css('float', 'left').end().find('.text').text(message || ' ').end();
		var destroy = function(result) {
			callback(!!result);
			dialog.dialog('destroy').remove();
		};
		var dialog_opts = {
			resizable: false,
			modal: true,
			buttons: [],
			appendTo: document.body,
			close: destroy.bind(dialog, false)
		};
		if(okButtonText) {
			dialog_opts.buttons.push({
				text: okButtonText,
				'class': 'primary ui-state-highlight',
				click: destroy.bind(dialog, true)
			});
		}
		if(cancelButtonText) {
			dialog_opts.buttons.push({
				text: cancelButtonText,
				'class': 'secondary',
				click: destroy.bind(dialog, false)
			});
		}
		dialog.dialog(dialog_opts);
	},

	load: function() {
		window.AdminInterface.loader.data('loadCount', (window.AdminInterface.loader.data('loadCount')||0)+1).show();
	},

	end_load: function() {
		window.AdminInterface.loader.data('loadCount', (window.AdminInterface.loader.data('loadCount')||0)-1);
		if(window.AdminInterface.loader.data('loadCount') <= 0) {
			window.AdminInterface.loader.hide();
		}
	},

	activity: function() {
		if(Widget.singletons.admin_menu !== undefined) {
			Widget.singletons.admin_menu.activity();
		}
	},

	end_activity: function() {
		if(Widget.singletons.admin_menu !== undefined) {
			Widget.singletons.admin_menu.end_activity();
		}
	}
});
