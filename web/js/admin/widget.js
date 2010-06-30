// jQuery 1.3 compliance
if(!jQuery.noop) {
	jQuery.noop = function() {};
}

var Widget = function(widgetId, widgetType) {
	this.widgetId = widgetId;
	this.widgetType = widgetType;
};

jQuery.extend(Widget.prototype, {
	_widgetJSON: function(action, callback, async) {
		var attributes = arguments[arguments.callee.length] || {};
		return Widget.widgetJSON(this.widgetType, this.widgetId, action, callback, async, attributes);
	},
	
	_callMethod: function(name) {
		var args = jQuery.makeArray(arguments).slice(1);
		var callback = args.slice(-1)[0];
		if(jQuery.isFunction(callback)) {
			args = args.slice(0, -1);
		} else {
			callback = Widget.defaultMethodHandler;
		}
		var params = {};
		if(args.length > 0) {
			params['method_parameters'] = args;
		}
		var result = null;
		var error = null;
		//Make getters and setter synchronous, Char after set or get must be uppercase
		var is_async = !((name.indexOf('get') === 0 || name.indexOf('set') === 0) && /[A-Z]/.test(name[3])); 
		var widget = this;
		this._widgetJSON(['methodCall', name], function(response, exception) {
			if(callback.length<2 && exception) {
				Widget.notifyUser('alert', exception.message);
			}
			callback.call(widget, response.result, exception);
			result = response.result;
			error = exception;
		}, is_async, params);
		if(error && !is_async) {
			throw error;
		}
		return result;
	},
	
	fire: function(eventName, realEvent) {
		event = jQuery.Event("widget."+eventName);
		var has_real_event = (realEvent instanceof jQuery.Event);
		var args = jQuery.makeArray(arguments).slice(has_real_event ? 2 : 1);
		this._pastEvents[eventName] = [event].concat(args);
		jQuery(this).trigger(event, args);
		if(has_real_event) {
			if(event.isDefaultPrevented()) {
				realEvent.preventDefault();
			}
			if(event.isImmediatePropagationStopped()) {
				realEvent.stopImmediatePropagation();
			}
			if(event.isPropagationStopped()) {
				realEvent.stopPropagation();
			}
		}
		return !event.isDefaultPrevented() && !event.isPropagationStopped();
	},
	
	handle: function(event, handler, isOnce, fireIfPast) {
		if(fireIfPast && this._pastEvents[event]) {
			handler.apply(this, this._pastEvents[event]);
			if(isOnce) {
				return this;
			}
		}
		jQuery(this)[isOnce ? 'one' : 'bind']("widget."+event, handler.bind(this));
		return this;
	},
	
	_pastEvents: {},
	_widgetInformation: {},
	_instanceInformation: {}
});

jQuery.extend(Widget, {
	loadInfo: function(widgetType) {
		if(!Widget.widgetInformation[widgetType]) {
			Widget.widgetJSON(widgetType, null, 'widgetInformation', function(widgetInformation, error) {
				Widget.widgetInformation[widgetType] = widgetInformation;
				if(!Widget.types[widgetType]) {
					if(widgetInformation.resources !== '') {
						var resources = jQuery(widgetInformation.resources);
						var head = jQuery('head');
						//Add scripts
						resources.filter('script').each(function() {
							var script = jQuery(this);
							if(!script.attr('src')) {
								head.append(this.cloneNode(true));
							} else if(head.find('script[src="'+script.attr('src')+'"]').length == 0) {
								jQuery.ajax({
									url: script.attr('src'),
									dataType: 'script',
									async: false
								});
							}
						});
						//Add styles
						head.append(resources.find('style'));
						//Add linked elements (mostly CSS)
						resources.filter('link').each(function() {
							if(head.find('link[href="'+this.getAttribute('href')+'"]').length == 0) {
								head.append(this);
							}
						});
					}
				}
			}, false);
		}
		return Widget.widgetInformation[widgetType];
	},
	
	create: function(widgetType, finishCallback, session) {
		var intermediateCallback = jQuery.noop;
		if(jQuery.isFunction(session)) {
			//intermediate callback given → shift session
			intermediateCallback = finishCallback;
			finishCallback = session;
			session = arguments[3];
		}
		if(Widget.singletons[widgetType]) {
			if(intermediateCallback) {
				intermediateCallback(Widget.singletons[widgetType]);
			}
			if(finishCallback) {
				finishCallback(Widget.singletons[widgetType]);
			}
			return Widget.singletons[widgetType];
		}
		Widget.widgetJSON(widgetType, session, 'instanciateWidget', function(instanceInformation, error) {
			if(error) {
				Widget.notifyUser('alert', error.message);
				return;
			}
			var widgetInformation = Widget.loadInfo(widgetType)
			var widget = new Widget(instanceInformation.session_id, widgetType);
			//Add php-methods
			jQuery.each(widgetInformation.methods, function(i, method) {
				widget[method] = widget._callMethod.bind(widget, method);
			});
			//Add js-methods and other members
			jQuery.extend(true, widget, Widget.types[widgetType] || {});
			if(!widget.settings) {
				widget.settings = {};
			}
			if(widgetInformation.is_singleton) {
				Widget.singletons[widgetType] = widget;
			}
			widget._widgetInformation = widgetInformation;
			widget._instanceInformation = instanceInformation;
			if(intermediateCallback) {
				intermediateCallback(widget)
			}
			if(widget.initialize) {
				widget.initialize();
			}
			if(finishCallback) {
				finishCallback(widget);
			}
			if(widget.prepare) {
				widget.prepare();
			}
			widget.fire('prepared', widget, widgetInformation, instanceInformation);
		});
	},
	
	createWithElement: function(widgetType, finishCallback, session) {
		Widget.create(widgetType, function(widget) {
			widget._element = jQuery.parseHTML(widget._instanceInformation.content);
			widget.handle('prepared', finishCallback);
		}, session, arguments[3]);
	},
	
	notifyUser: function(severity, message) {
		alert("Message of severity "+severity+": "+message);
	},
	
	tooltip: function(element, text) {
		jQuery(element).bind('mouseenter', alert.bind(window, text));
	},
	
	confirm: function(title, message, callback, cancelButtonText, okButtonText) {
		message = title+' '+message;
		if(cancelButtonText === null) {
			Widget.notifyUser('info', message);
			return callback(true);
		}
		callback(confirm(message));
	},
	
	widgetJSON: function(widgetType, widgetId, action, callback, async) {
		async = !!async;
		var attributes = arguments[arguments.callee.length] || {};
		if(!jQuery.isArray(action)) {
			action = [action];
		}
		action.unshift('widget_json', widgetType);
		var url = FILE_PREFIX;
		jQuery.each(action, function(i, urlPart) {
			url += '/'+encodeURIComponent(urlPart);
		});
		if(widgetId) {
			attributes['session_key'] = widgetId;
		}
		var attr_str = JSON.stringify(attributes);
		console.log(attr_str);
		jQuery.ajax({
			url: url,
			data: attr_str,
			type: 'POST',
			dataType: 'json',
			async: async,
			contentType: 'application/json',
			cache: true,
			success: function(result) {
				callback = (callback || Widget.defaultJSONHandler);
				var error = null;
				if(result && result.exception) {
					error = result.exception;
					if(callback.length<2) {
						Widget.notifyUser('alert', error.message);
					}
				}
				callback.call(this, result, error);
			},
			error: function(request, statusCode, error) {
				if(statusCode === 'parsererror') {
					var text = jQuery.parseHTML(jQuery.trim(request.responseText));
					//This is most likely a PHP error… 
					Widget.notifyUser('error', text);
				} else {
					Widget.notifyUser('error', error);
				}
			}
		});
	},
	
	callStaticWidgetMethod: function(widgetType, methodName) {
		var parameters = jQuery.makeArray(arguments).slice(2);
		if(!Widget.types[widgetType]) {
			Widget.loadInfo(widgetType);
		}
		return Widget.types[widgetType][methodName].apply(window, parameters);
	},
	
	fire: function(event) {
		jQuery(Widget).triggerHandler("Widget."+event, jQuery.makeArray(arguments).slice(1));
	},
	
	handle: function(event, handler, isOnce) {
		jQuery(Widget)[isOnce ? 'one' : 'bind']("Widget."+event, handler.bind(this));
	},
	
	defaultJSONHandler: jQuery.noop,
	
	defaultMethodHandler: jQuery.noop,
	
	log: jQuery.noop,
	
	types: {},
	singletons: {},
	widgetInformation: {}
});

if(window.console && window.console.log) {
	Widget.log = function() {
		window.console.log.apply(console, jQuery.makeArray(arguments));
	};
} else {
	Widget.log = function() {
		var args = jQuery.makeArray(arguments);
		args.unshift('info');
		Widget.notifyUser.apply(Widget, args);
	};
}

jQuery.extend(jQuery, {
	widgetElements: function(type) {
		if(type) {
			return jQuery('*[data-widget-type='+type+']');
		} else {
			return jQuery('*[data-widget-type]');
		}
	},
	
	parseHTML: function(html, instanciateWidgets) {
		var element = document.createElement('div');
		element.innerHTML = html;
		var result = jQuery(element.childNodes);
		if(instanciateWidgets) {
			result.find('*[data-widget-type]').each(function() {
				jQuery(this).prepareWidget();
			});
		}
		return result;
	}
});

jQuery.fn.extend({
	getWidget: function() {
		return this.data('widget');
	},
	
	prepareWidget: function() {
		var callback = arguments[0] || jQuery.noop;
		if(this.getWidget()) {
			callback(this.getWidget());
			return this;
		}
		var waiting_callbacks = this.data('waiting_prepare_callbacks');
		if(waiting_callbacks !== null) {
			waiting_callbacks[waiting_callbacks.length] = callback;
			return;
		}
		waiting_callbacks = [callback];
		this.data('waiting_prepare_callbacks', waiting_callbacks);
		var widget_type = this.attr('data-widget-type');
		var widget_session = this.attr('data-widget-session');
		var widget_element = this;
		Widget.create(widget_type, function(widget) {
			widget_element.data('widget', widget);
			widget._element = widget_element;
			jQuery.each(widget_element.data('waiting_prepare_callbacks'), function(i, callback) {
				callback(widget);
			});
			widget_element.removeData('waiting_prepare_callbacks');
		}, widget_session);
		return this;
	}
});

//Initialize all widgets present as html elements on document.ready
jQuery(document).ready(function() {
	jQuery.widgetElements().each(function() {
		jQuery(this).prepareWidget();
	});
});
