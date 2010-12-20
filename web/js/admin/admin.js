jQuery.fn.extend({
	tooltip: function(text) {
		var tooltip = jQuery("#global_tooltip");
		if(!tooltip.length) {
			tooltip = jQuery('<div/>').attr('id', 'global_tooltip').addClass('tooltip ui-widget ui-widget-content ui-corner-all').appendTo(document.body);
		}
		this.hover(function(event) {
			tooltip.text(text);
			tooltip.show();
			tooltip.css({left: (event.pageX+3)+"px", top: (event.pageY+3)+"px"});
		}, function() {
			tooltip.hide();
		}).mousemove(function(event) {
			tooltip.css({left: (event.pageX+3)+"px", top: (event.pageY+3)+"px"});
		});
	},
});

jQuery('.cmos-button:not(.ui-state-disabled), .cmos-clickable').live("mouseover", function() {
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

jQuery.extend(Widget, {
	notifyUser: function(severity, message) {
		var options = {
			closeDelay: 5000,
			identifier: null,
			isHTML: false,
			closable: false,
			searchInfo: false
		};
		jQuery.extend(options, arguments[2] || {});
		
		var admin_message = jQuery('#admin_message');
		
		//Handle messages with identical identifier
		if(options.identifier) {
			var prev_message = Widget.notificationWithIdentifier(options.identifier);
			if(prev_message) {
				prev_message.data('functions').increase_badge_count();
				prev_message.data('functions').set_message(message);
				return;
			}
		}
		var highlight = severity == 'info' ? 'highlight' : 'error';
		if(options.searchInfo) {
			var display = jQuery.parseHTML('<div class="ui-widget ui-notify search_info"><div class="ui-state-'+highlight+' ui-corner-all"><div class="ui-icon ui-icon-circle-close close-handle"></div><div><span class="message"></span></div></div></div>');
		} else {
			var display = jQuery.parseHTML('<div class="ui-widget ui-notify search_info"><div class="ui-state-'+highlight+' ui-corner-all"><div class="ui-badge">1</div><div class="ui-icon ui-icon-circle-close close-handle"></div><div><span class="ui-icon ui-icon-'+severity+'"></span><span class="message"></span></div></div></div>');
		}
		display.hide().appendTo(admin_message).data('identifier', options.identifier);
		
		var badge = display.find('.ui-badge').hide();
		var close_button = display.find('.close-handle').hide();
		var message_container = display.find('.message');
		
		var functions = {
			element: display,
			options: options,
			close: function() {
				if(options.searchInfo) {
					display.hide('blind', function() {display.remove();});
				} else {
					display.hide('blind', function() {display.remove();});
				}
			},
			set_severity: function(severity) {
				var new_highlight = severity == 'info' ? 'highlight' : 'error';
				display.find('.ui-state-'+highlight).removeClass('ui-state-'+highlight).addClass('ui-state-'+new_highlight);
			},
			increase_badge_count: function() {
				var count = parseInt(badge.text());
				if(isNaN(count)) {
					count = 0;
				}
				count++;
				badge.show().text(count);
				this.reset_timeout();
			},
			reset_timeout: function(closeDelay) {
				if(closeDelay !== undefined) {
					this.options.closeDelay = closeDelay;
				}
				this.clear_timeout();
				if(this.options.closeDelay) {
					this.options.timeout = window.setTimeout(this.close, this.options.closeDelay);
				}
			},
			clear_timeout: function() {
				if(this.options.timeout) {
					window.clearTimeout(this.options.timeout);
				}
			},
			set_message: function(message) {
				if(message.constructor === String) {
					if(this.options.isHTML) {
						message_container.html(message);
					} else {
						message_container.text(message);
					}
				} else {
					message_container.empty().append(message);
				}
			},
			enable_close_button: function() {
				close_button.show().click(function() {
					this.close();
				}.bind(this));
			}
		};
		functions.set_message(message);
		display.data('functions', functions).show('blind');
		functions.reset_timeout();
		if(options.closable) {
			functions.enable_close_button();
		}
		return functions;
	},
	
	notificationWithIdentifier: function(identifier) {
		var admin_message = jQuery('#admin_message');
		var result = null
		admin_message.find('div.ui-notify').each(function() {
			var notification = jQuery(this);
			if(notification.data('identifier') === identifier) {
				result = notification;
				return false;
			}
		});
		return result;
	},
	
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
		var dialog = jQuery.parseHTML('<div class="cmos_alert"><p><span class="ui-icon ui-icon-alert"></span><span class="text"></span></p></div>').attr('title', title).find('.ui-icon').css('float', 'left').end().find('.text').text(message).end();
		var destroy = function(result) {
			callback(!!result)
			dialog.dialog('destroy').remove();
		};
		var dialog_opts = {
			resizable: false,
			modal: true,
			buttons: [{
				text: okButtonText,
				className: 'primary ui-state-highlight',
				click: destroy.bind(dialog, true)
			}, {
				text: cancelButtonText,
				className: 'secondary',
				click: destroy.bind(dialog, false)
			}],
			close: destroy.bind(dialog, false)
		};
		dialog.dialog(dialog_opts);
	},
	
	load: function() {
		window.AdminInterface.loader.data('load-count', window.AdminInterface.loader.data('load-count')+1).show();
	},
	
	end_load: function() {
		window.AdminInterface.loader.data('load-count', window.AdminInterface.loader.data('load-count')-1);
		if(window.AdminInterface.loader.data('load-count') <= 0) {
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